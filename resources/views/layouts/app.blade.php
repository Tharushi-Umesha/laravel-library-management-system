<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library Management System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <div class="container">
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="nav-brand">
                    <i class="fas fa-book-open"></i> Library System
                </div>
                <div class="d-flex gap-2 flex-wrap mt-2 mt-md-0">
                    <a href="{{ route('books.index') }}" class="nav-link-custom {{ request()->routeIs('books.index') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Books
                    </a>
                    <a href="{{ route('borrowings.index') }}" class="nav-link-custom {{ request()->routeIs('borrowings.index') ? 'active' : '' }}">
                        <i class="fas fa-book-reader"></i> Borrow
                    </a>
                    <a href="{{ route('borrowings.borrowed') }}" class="nav-link-custom {{ request()->routeIs('borrowings.borrowed') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> Borrowed
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="main-container">
            <!-- Success Alert -->
            @if(session('success'))
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Error Alert -->
            @if(session('error'))
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© {{ date('Y') }} Library Management System | Parallax Technologies Assessment</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>