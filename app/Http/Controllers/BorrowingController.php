<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use App\Models\User;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{

    public function index()
    {
        $books = Book::with('category')->where('stock', '>', 0)->get();
        $users = User::all();
        return view('borrowings.index', compact('books', 'users'));
    }


    public function borrow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id'
        ]);

        $book = Book::findOrFail($request->book_id);


        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'This book is OUT OF STOCK!');
        }


        $book->decrement('stock');


        BookBorrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
            'returned_at' => null
        ]);

        return redirect()->back()->with('success', 'Book borrowed successfully!');
    }


    public function borrowed()
    {
        $borrowings = BookBorrowing::with(['user', 'book.category'])
            ->whereNull('returned_at')
            ->get();

        return view('borrowings.borrowed', compact('borrowings'));
    }


    public function return($id)
    {
        $borrowing = BookBorrowing::findOrFail($id);


        $borrowing->book->increment('stock');

        $borrowing->update([
            'returned_at' => now()
        ]);

        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
