<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
            ->latest('published_at')
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        if (!$news->is_published) {
            abort(404);
        }

        return view('news.show', compact('news'));
    }
}
