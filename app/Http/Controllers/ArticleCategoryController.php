<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    // Method to list article categories
    public function index()
    {
        $categories = ArticleCategory::all();
        return view('article_category.list', compact('categories'));
    }

    // Method to display the form to create a new article category
    public function create()
    {
        return view('article_category.form');
    }

    // Method to store a new article category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:article_categories|max:255',
        ]);

        ArticleCategory::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('article_category.list')->with('success', 'Article category created successfully.');
    }

    // Method to display the form to edit an existing article category
    public function edit($id)
    {
        $category = ArticleCategory::findOrFail($id);
        return view('article_category.form', compact('category'));
    }

    // Method to update an existing article category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:article_categories|max:255',
        ]);

        $category = ArticleCategory::findOrFail($id);
        $category->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('article_category.list')->with('success', 'Article category updated successfully.');
    }

    // Method to delete an article category
    public function destroy($id)
    {
        $category = ArticleCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('article_category.list')->with('success', 'Article category deleted successfully.');
    }
}
