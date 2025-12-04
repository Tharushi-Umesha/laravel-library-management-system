<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'price',
        'stock',
        'book_category_id'
    ];

    // Relationship: A book belongs to a category
    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }
}
