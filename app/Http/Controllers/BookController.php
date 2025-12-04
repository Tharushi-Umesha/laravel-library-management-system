<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display all books (Homepage)
    public function index(Request $request)
    {
        $categories = BookCategory::all();

        // Filter by category if selected
        $query = Book::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('book_category_id', $request->category);
        }

        $books = $query->get();

        return view('books.index', compact('books', 'categories'));
    }

    // Show create form
    public function create()
    {
        $categories = BookCategory::all();
        return view('books.create', compact('categories'));
    }

    // Store new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'book_category_id' => 'required|exists:book_cate,id'
        ]);

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book added successfully!');
    }

    // Show edit form
    public function edit(Book $book)
    {
        $categories = BookCategory::all();
        return view('books.edit', compact('book', 'categories'));
    }

    // Update book
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'book_category_id' => 'required|exists:book_cate,id'
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully!');
    }

    // Delete book
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
}
