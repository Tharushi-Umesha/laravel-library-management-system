<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table = 'book_cate';

    protected $fillable = ['name'];

    // Relationship: A category has many books
    public function books()
    {
        return $this->hasMany(Book::class, 'book_category_id');
    }
}
