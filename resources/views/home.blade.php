<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>

        <div class="d-flex">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container mt-5">
    <h3>Selamat datang, {{ Auth::user()->name }}</h3>
    <ul class="list-group mt-3">
        <li class="list-group-item"><strong>Nama:</strong> {{ Auth::user()->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
        <li class="list-group-item"><strong>No HP:</strong> {{ Auth::user()->phone }}</li>
    </ul>
</div>

</body>
</html>
