<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Planting Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 px-3">
        <a class="navbar-brand" href="#">Planting Calculator</a>
        
        @auth
        <div class="navbar-nav ms-auto">
            <span class="navbar-text me-3">
                Welcome, {{ auth()->user()->name }}!
            </span>
            <!-- <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    Logout
                </button>
            </form> -->
        </div>
        @endauth
    </nav>

    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
