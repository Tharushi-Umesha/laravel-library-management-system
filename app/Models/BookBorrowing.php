<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBorrowing extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'returned_at'
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // Relationship: Borrowing belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Borrowing belongs to a book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
