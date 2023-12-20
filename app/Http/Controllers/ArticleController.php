<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use App\Models\ArticleCategory;
class ArticleController extends Controller
{
    function list(Request $request)
    {
        $articles = Article::get();

        // $articles = $request->session()->get('articles') ?? [];
        return view('article.list', [
            'articles' => $articles
        ]);
    }
    function create(Request $request)
    {
        $article_categories = ArticleCategory::orderBy('name')->get();

        if ($request->isMethod('post')) {
            $article = Article::create([
                'slug' => Str::slug($request->title),
                'title' => $request->title,
                'content' => $request->content,
                'article_category_id' => $request->article_category_id,
            ]);

            if ($article) {
                return redirect()->route('article.list')->withSuccess('Artikel berhasil dibuat');
            }

            return back()->withInput()->withErrors(['alert' => 'Gagal menyimpan artikel']);
        }

        return view('article.form', ['article_categories' => $article_categories]);
    }

    function single(string $slug, Request $request)
    {
        $article = Article::where('slug', $slug)->first();
        if (!$article)
            return abort(404);
        return view('article.single', [
            'article' => $article
        ]);
    }
    function edit(string $id, Request $request)
    {
        $article = Article::where('id', $id)->first();
        if (!$article)
            return abort(404);
        if ($request->isMethod('post')) {
            $article->slug = $request->slug;
            $article->title = $request->title;
            $article->content = $request->content;
            $article->article_category_id = $request->article_category_id;
            $article->save();
            if ($article) {
                return redirect()->route('article.single', ['slug' =>
                    $article->slug])
                    ->withSuccess('Artikel berhasil diubah');
            }
            return back()->withInput()
                ->withErrors([
                    'alert' => 'Gagal menyimpan artikel'
                ]);
        }
        return view('article.form', [
            'article' => $article,
            'article_categories' => ArticleCategory::orderBy('name')->get()
        ]);
    }
    function delete(string $id, Request $request)
    {
        $article = Article::where('id', $id)->first();
        if (!$article)
            return abort(404);
        if ($article->delete()) {
            return redirect()->route('article.list')
                ->withSuccess('Artikel telah dihapus');
        }
        return back()->withInput()
            ->withErrors([
                'alert' => 'Gagal menghapus artikel'
            ]);
    }
    function comment(string $id, Request $request)
    {
        $article = Article::where('id', $id)->first();
        if (!$article)
            return abort(404);
        $comment = ArticleComment::create([
            'article_id' => $article->id,
            'content' => $request->comment
        ]);
        if ($comment) {
            return redirect()->route('article.single', ['slug' => $article->slug])
                ->withSuccess('Komentar berhasil ditambahkan');
        }
        return back()->withInput()
            ->withErrors([
                'message' => 'Gagal menambahkan komentar'
            ]);
    }
}
;
