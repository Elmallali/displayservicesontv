<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    
    public function index()
    {
        $news = News::latest()->get();
        return view('news.index', compact('news'));
    }

    
    public function create()
    {
        return view('news.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'texte' => 'required|string|max:255',
            'duration' => 'nullable|integer|min:1',
        ]);

        News::create([
            'texte' => $request->texte,
            'duration' => $request->duration ?? 30,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('news.index')->with('success', '🆕 Nouveauté ajoutée avec succès.');
    }

    
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    
    public function update(Request $request, News $news)
    {
        $request->validate([
            'texte' => 'required|string|max:255',
            'duration' => 'nullable|integer|min:1',
        ]);

        $news->update([
            'texte' => $request->texte,
            'duration' => $request->duration ?? 30,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('news.index')->with('success', '✏️ Nouveauté mise à jour.');
    }

    
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('success', '🗑️ Nouveauté supprimée.');
    }
    public function toggleActive(News $news)
{
    $news->active = !$news->active;
    $news->save();

    return back()->with('success', 'État de la nouveauté mis à jour.');
}

}
