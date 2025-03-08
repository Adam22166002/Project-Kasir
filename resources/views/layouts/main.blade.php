<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Kasir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-2 bg-light sidebar">
                <div class="list-group">
                    <a href="{{ route('dashboard') }}" class="list-group-item">Dashboard</a>
                    <a href="{{ route('kasir') }}" class="list-group-item">Kasir</a>
                    <a href="{{ route('produk.index') }}" class="list-group-item">Stok Produk</a>
                    <a href="{{ route('history') }}" class="list-group-item">History Penjualan</a>
                </div>
            </div>
            
            <!-- Konten Utama -->
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>