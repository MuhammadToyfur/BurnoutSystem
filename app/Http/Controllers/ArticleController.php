<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('author')->latest();

        // Filter by kategori jika ada
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $articles = $query->paginate(9)->withQueryString();

        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::published()->with('author')->where('slug', $slug)->firstOrFail();

        // Artikel terkait: kategori sama, bukan artikel ini sendiri
        $related = Article::published()
            ->with('author')
            ->where('kategori', $article->kategori)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}
