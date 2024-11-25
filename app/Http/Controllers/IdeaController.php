<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IdeaController extends Controller
{
    public function index(): View
    {
        $ideas = Idea::get();
        return view('ideas.index',['ideas'=>$ideas]);
    }

    public function create(): View
    {
        return view('ideas.create_or_edit');
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request ->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:300',
        ]);

        Idea::create([
            'user_id' => $request->user()->id,
            'title' => $validate['title'],
            'description' => $validate['description'],
        ]);

        session()->flash('message', 'Idea creada correctamente!');

        return redirect()->route('idea.index');
    }

    public function edit(Idea $idea): View
    {
        return View('ideas.create_or_edit')->with('idea', $idea);
    }

    public function update(Request $request, Idea $idea): RedirectResponse
    {
        $validate = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:300',
        ]);

        $idea->update($validate);

        session()->flash('message', 'Idea actualizada correctamente!');

        return redirect(route('idea.index'));
    }

    public function show(Idea $idea): View
    {
        return view('ideas.show')->with('idea', $idea);
    }

    public function delete(Idea $idea): RedirectResponse
    {
        $idea->delete();

        session()->flash('message', 'Idea eliminada correctamente!');

        return redirect()->route('idea.index');
    }

    public function synchronizeLikes(Request $request, Idea $idea): RedirectResponse
    {
        $request->user()->ideasLiked()->toggle([$idea->id]);

        $idea->update(['likes' => $idea->users()->count()]);

        return redirect()->route('idea.show', $idea);
    }
}

