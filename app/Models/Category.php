<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getCategoriesWithSublevels()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        // Loop through categories and their sublevels
        foreach ($categories as $category) {
            echo $category->name .'<br>';

            foreach ($category->children as $subcategory) {
                echo $subcategory->name .'<br>';
                // Access sub-subcategories and so on
            }
        }
        dd($categories);
        return $categories;
    }

}
