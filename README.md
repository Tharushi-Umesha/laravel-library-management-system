# 📚 Library Management System

A comprehensive web-based Library Management System built with Laravel that manages books and tracks borrowing activities.

## 🌟 Features

### Part 01: Book Management (CRUD)
- ✅ **View All Books** - Display books in a clean table/grid format with title, author, price, stock, and category
- ✅ **Filter by Category** - Dropdown filter to view books by specific categories
- ✅ **Add New Books** - Form with validation for adding books with all details
- ✅ **Edit Books** - Update book information including stock levels
- ✅ **Delete Books** - Remove books with confirmation dialog
- ✅ **Form Validation** - Required fields and number validation for price and stock

### Part 02: Borrowing System
- ✅ **Borrow Books** - Issue books to users with automatic stock reduction
- ✅ **Return Books** - Process book returns with automatic stock increment
- ✅ **Stock Management** - Real-time stock tracking and out-of-stock notifications
- ✅ **Borrowing History** - Track who borrowed what and when
- ✅ **User Management** - Associate borrowings with specific users

## 🛠️ Technologies Used

- **Framework**: Laravel 11.x
- **Database**: MySQL
- **Frontend**: Blade Templates, Bootstrap 5.3
- **Server**: XAMPP (Apache + MySQL)
- **PHP Version**: 8.x

## 📋 Prerequisites

Before you begin, ensure you have the following installed:
- PHP >= 8.1
- Composer
- XAMPP (or any MySQL database)
- Git

## 🚀 Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/Tharushi-Umesha/laravel-library-management-system.git
cd book-management
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
copy .env.example .env
```

Update the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_management
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Create Database

1. Start XAMPP Control Panel
2. Start Apache and MySQL services
3. Open phpMyAdmin: `http://localhost/phpmyadmin`
4. Create a new database named: `book_management`

### 6. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

This will create all necessary tables and seed 5 book categories:
- Fiction
- Non-Fiction
- Science
- History
- Biography

### 7. Start the Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## 📁 Project Structure

```
book-management/
├── app/
│   ├── Http/Controllers/
│   │   ├── BookController.php         # Book CRUD operations
│   │   └── BorrowingController.php    # Borrowing logic
│   └── Models/
│       ├── Book.php                   # Book model
│       ├── BookCategory.php           # Category model
│       └── BookBorrowing.php          # Borrowing model
├── database/
│   ├── migrations/
│   │   ├── create_book_cate_table.php
│   │   ├── create_books_table.php
│   │   └── create_book_borrowings_table.php
│   └── seeders/
│       ├── BookCategorySeeder.php     # Seeds 5 categories
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── books/
│       │   ├── index.blade.php        # Book listing page
│       │   ├── create.blade.php       # Add book form
│       │   └── edit.blade.php         # Edit book form
│       └── borrowings/
│           ├── index.blade.php        # Borrow books page
│           └── borrowed.blade.php     # Currently borrowed books
└── routes/
    └── web.php                        # Application routes
```

## 🗄️ Database Schema

### Tables

**1. book_cate**
- `id` - Primary key
- `name` - Category name
- `created_at`, `updated_at` - Timestamps

**2. books**
- `id` - Primary key
- `title` - Book title
- `author` - Author name
- `price` - Book price (decimal)
- `stock` - Available copies (integer)
- `book_category_id` - Foreign key to book_cate
- `created_at`, `updated_at` - Timestamps

**3. users**
- `id` - Primary key
- `name` - User full name
- `email` - Unique email
- `password` - Hashed password
- `created_at`, `updated_at` - Timestamps

**4. book_borrowings**
- `id` - Primary key
- `user_id` - Foreign key to users
- `book_id` - Foreign key to books
- `borrowed_at` - Borrowing timestamp
- `returned_at` - Return timestamp (nullable)
- `created_at`, `updated_at` - Timestamps

## 🎯 Usage Guide

### Managing Books

1. **View All Books**: Navigate to homepage (`/`)
2. **Add Book**: Click "Add New Book" button, fill the form, submit
3. **Edit Book**: Click "Edit" button next to any book, modify details, update
4. **Delete Book**: Click "Delete" button, confirm deletion
5. **Filter Books**: Use category dropdown to filter by category

### Borrowing System

1. **Borrow a Book**:
   - Navigate to "Borrow Books" page
   - Click "Borrow" on any available book
   - Select a user from the dropdown
   - Confirm borrowing
   - Stock automatically decreases by 1

2. **Return a Book**:
   - Navigate to "Borrowed Books" page
   - Click "Return Book" button
   - Confirm return
   - Stock automatically increases by 1

3. **Out of Stock**:
   - When stock reaches 0, "OUT OF STOCK" badge appears
   - Borrow button becomes disabled
   - Error message shown if borrowing is attempted

## ✨ Key Features Implementation

### Automatic Stock Management
```php
// When borrowing a book
$book->decrement('stock');  // Stock - 1

// When returning a book
$book->increment('stock');  // Stock + 1
```

### Form Validation
- Title: Required, String
- Author: Required, String
- Price: Required, Numeric, Minimum 0
- Stock: Required, Integer, Minimum 0
- Category: Required, Must exist in database

### Relationships
- **Book** belongs to **Category**
- **Book** has many **Borrowings**
- **User** has many **Borrowings**
- **Borrowing** belongs to **User** and **Book**

## 🔐 Security Features

- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- Mass assignment protection with `$fillable`
- Password hashing for users
- Foreign key constraints with cascade delete

## 🎨 UI Features

- **Responsive Design** - Works on all device sizes
- **Bootstrap 5** - Modern, clean interface
- **Success/Error Messages** - User feedback for all actions
- **Confirmation Dialogs** - Prevent accidental deletions
- **Modal Windows** - Clean borrowing interface
- **Badge Indicators** - Visual stock status

## 🧪 Testing the Application

1. **Add Test Books**:
   - Add at least 3-5 books with different categories
   - Vary stock levels (some with stock, some without)

2. **Test CRUD Operations**:
   - Create, view, edit, and delete books
   - Test validation by submitting empty forms

3. **Test Borrowing**:
   - Borrow books and verify stock decreases
   - Try borrowing when stock = 0 (should fail)
   - Return books and verify stock increases

4. **Test Filtering**:
   - Use category filter on homepage
   - Verify only selected category books appear

## 📝 Routes Overview

```php
GET  /                          # Homepage - List all books
GET  /books/create              # Show add book form
POST /books                     # Store new book
GET  /books/{id}/edit           # Show edit form
PUT  /books/{id}                # Update book
DELETE /books/{id}              # Delete book
GET  /borrowings                # Borrow books page
POST /borrowings/borrow         # Process borrowing
GET  /borrowings/borrowed       # Currently borrowed books
POST /borrowings/return/{id}    # Return a book
```

## 🐛 Troubleshooting

### Database Connection Error
- Verify XAMPP MySQL is running
- Check `.env` database credentials
- Ensure `book_management` database exists

### Migration Errors
- Run `php artisan migrate:fresh --seed` to reset database
- Check database user permissions

### Blank Page
- Check Laravel logs: `storage/logs/laravel.log`
- Ensure Apache is running on port 80
- Clear cache: `php artisan cache:clear`

## 👨‍💻 Developer

**Mahipala Mudalige Tharushi Umesha**

## 📧 Contact

For questions or support, contact: hr@parallax.lk

## 📄 License

This project was developed as part of the Parallax Technologies Software Engineer Assessment.

## 🙏 Acknowledgments

- Laravel Framework Documentation
- Bootstrap Documentation
- Parallax Technologies for the assessment opportunity

---

**Built with ❤️ using Laravel**
