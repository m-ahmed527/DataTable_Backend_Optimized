<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ["id"];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Direct children
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Recursive children
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    // Products directly under this category
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
