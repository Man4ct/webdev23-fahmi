<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use App\Models\ArticleCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    function list(Request $request)
    {
        $articles = Article::paginate(20);

        // $articles = $request->session()->get('articles') ?? [];
        return view('article.list', [
            'articles' => $articles
        ]);
    }
    function create(Request $request)
    {
        $article_categories = $request->articleCategories;
        $article_categories = ArticleCategory::orderBy('name')->get();

        if ($request->isMethod('post')) {
            $request->validate([
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('articles')
                ],
                'content' => ['required', 'string', 'max:2000'],
                'article_category_id' => [
                    'required',
                    'integer',

                    Rule::in($article_categories->pluck('id'))
                ],
                'image' => [File::image()->max('10mb')]
            ]);
            $slug = Str::slug($request->title);
            if (Article::where('slug', $slug)->exists())
                $slug .= '-' . uniqid();

            $article = Article::create([
                'slug' => $slug,
                'title' => $request->title,
                'content' => $request->content,
                'article_category_id' => $request->article_category_id,
            ]);

            if ($article) {
                if ($request->file('image')) {
                    $path = $request->file('image')->store('articles');
                    $article->image = $path;
                    $article->save();
                }

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
        $articleCategories = $request->articleCategories;
        $articleCategories = ArticleCategory::orderBy('name')->get();
        if ($request->isMethod('post')) {
            $request->validate([
                'slug' => [
                    'required',
                    'string',
                    Rule::unique('articles')->ignore($article->id)
                ],
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('articles')->ignore($article->id)
                ],
                'content' => ['required', 'string', 'max:2000'],
                'article_category_id' => [
                    'required',
                    'integer',
                    Rule::in($articleCategories->pluck('id'))
                ]
            ]);

            $article->slug = $request->slug;
            $article->title = $request->title;
            $article->content = $request->content;
            $article->article_category_id = $request->article_category_id;
            $article->save();
            if ($article) {
                return redirect()->route('article.single', [
                    'slug' =>
                        $article->slug
                ])
                    ->withSuccess('Artikel berhasil diubah');
            }
            return back()->withInput()
                ->withErrors([
                    'alert' => 'Gagal menyimpan artikel'
                ]);
        }
        return view('article.form', [
            'article' => $article,
            'article_categories' => $articleCategories,
            'allow_edit_slug' => Gate::allow('isAdmin')
        ]);
    }
    function delete(string $id, Request $request)
    {
        $article = Article::where('id', $id)->first();
        if (!$article)
            return abort(404);
        $image = $article->image;
        if ($article->delete()) {
            if ($image) {
                Storage::delete($image);
            }
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
        $request->validate([
            'comment' => ['required', 'string', 'max:2000'],
        ]);
        $comment = ArticleComment::create([
            'article_id' => $article->id,
            'content' => $request->comment
        ]);
        if ($comment) {
            // Mengirimkan notifikasi ke semua user dengan role author dan admin
            $authors = User::where('role', \App\Enums\UserRoleEnum::Author)->get();
            Notification::send($authors, new
                \App\Notifications\ArticleCommented($comment));
            // Mengirimkan notifikasi ke user yang sedang login (penulis komentar)
            $request->user()->notify(new \App\Notifications\ArticleCommented($comment));

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
