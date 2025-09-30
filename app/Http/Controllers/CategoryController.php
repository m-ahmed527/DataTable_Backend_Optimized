<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('childrenRecursive')
            ->whereNull('parent_id')
            ->get();
        // dd( $categories);
        return view('categories.index', compact('categories'));
    }

    // Show category + its products
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with('childrenRecursive')
            ->firstOrFail();

        // get ids of this category + all its children
        $ids = $this->getCategoryIds($category);

        $products = Product::whereIn('category_id', $ids)->get();

        return view('categories.show', compact('category', 'products'));
    }

    private function getCategoryIds($category)
    {
        $ids = [$category->id];
        foreach ($category->children as $child) {
            $ids = array_merge($ids, $this->getCategoryIds($child));
        }
        return $ids;
    }
}
