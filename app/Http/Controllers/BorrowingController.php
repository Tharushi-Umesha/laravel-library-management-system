<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    // Show available books to borrow
    public function index()
    {
        $books = Book::with('category')->where('stock', '>', 0)->get();
        $users = User::all();
        return view('borrowings.index', compact('books', 'users'));
    }

    // Borrow a book
    public function borrow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id'
        ]);

        $book = Book::findOrFail($request->book_id);

        // Check if book is in stock
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'This book is OUT OF STOCK!');
        }

        // Reduce stock by 1
        $book->decrement('stock');

        // Create borrowing record
        BookBorrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'returned_at' => null
        ]);

        return redirect()->back()->with('success', 'Book borrowed successfully!');
    }

    // Show borrowed books
    public function borrowed()
    {
        $borrowings = BookBorrowing::with(['user', 'book.category'])
            ->whereNull('returned_at')
            ->get();

        return view('borrowings.borrowed', compact('borrowings'));
    }

    // Return a book
    public function return($id)
    {
        $borrowing = BookBorrowing::findOrFail($id);

        // Increase stock by 1
        $borrowing->book->increment('stock');

        // Update return date
        $borrowing->update([
            'returned_at' => now()
        ]);

        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
