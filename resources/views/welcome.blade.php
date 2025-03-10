@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div id="kasir-setup" class="setup-wizard" style="display: {{ $setupComplete ? 'none' : 'block' }}">
        <!-- Step 1: Tombol Start -->
        <div class="setup-step" id="step-start" style="display: block;">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body py-5">
                            <h1 class="display-4 mb-4">Aplikasi Kasir</h1>
                            <p class="lead">Selamat datang! Klik tombol di bawah untuk memulai pengaturan kasir.</p>
                            <button id="btn-start" class="btn btn-light btn-lg mt-4 px-5 py-3" onclick="showStep('step-product')">
                                START <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Update Produk -->
        <div class="setup-step" id="step-product" style="display: none;">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">Update Produk</h3>
                        </div>
                        <div class="card-body">
                            <form id="add-product-form" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label for="product-name" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" id="product-name" name="name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="product-image" class="form-label">Foto Produk</label>
                                        <input type="file" class="form-control" id="product-image" name="image_path">
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-success w-100">Tambah Produk</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Produk</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . ($product->image_path ?? 'img/no-image.jpg')) }}" width="50" height="50" class="img-thumbnail">
                                                </td>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-4">
                                <button class="btn btn-outline-secondary me-2" onclick="showStep('step-start')">Kembali</button>
                                <button class="btn btn-primary" onclick="showStep('step-price')">Lanjut ke Update Harga</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Update Harga -->
        <div class="setup-step" id="step-price" style="display: none;">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h3 class="mb-0">Update Harga Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Produk</th>
                                            <th>Harga (Rp)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . ($product->image_path ?? 'img/no-image.jpg')) }}" width="50" height="50" class="img-thumbnail">
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    <form action="{{ route('produk.update.price', $product->id) }}" method="POST" class="price-form">
                                                        @csrf
                                                        <input type="number" class="form-control" name="price" value="{{ $product->price }}">
                                                        <button type="submit" class="btn btn-outline-primary mt-2">Simpan</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info view-product" data-id="{{ $product->id }}">Detail</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-4">
                                <button class="btn btn-outline-secondary me-2" onclick="showStep('step-product')">Kembali</button>
                                <button class="btn btn-success" onclick="showStep('step-stock')">Lanjut ke Update Stok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Update Stok -->
        <div class="setup-step" id="step-stock" style="display: none;">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h3 class="mb-0">Update Stok Produk</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Produk</th>
                                            <th>Harga (Rp)</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . ($product->image_path ?? 'img/no-image.jpg')) }}" width="50" height="50" class="img-thumbnail">
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>Rp. {{ number_format($product->price ?? 0, 0, ',', '.') }}</td>
                                                <td>
                                                    <form action="{{ route('produk.update.stock', $product->id) }}" method="POST" class="stock-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="number" class="form-control" name="stock" value="{{ $product->stock }}">
                                                        <button type="submit" class="btn btn-outline-primary mt-2">Simpan</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info view-product" data-id="{{ $product->id }}">Detail</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-4">
                                <button class="btn btn-outline-secondary me-2" onclick="showStep('step-price')">Kembali</button>
                                <button class="btn btn-primary" onclick="finishSetup()">Selesai Setup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tampilan setelah kasir dimulai -->
    <div id="kasir-active" style="display: {{ $setupComplete ? 'block' : 'none' }}">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Penjualan Hari Ini</h5>
                        <h2 class="card-text">Rp. {{ number_format($totalPenjualan, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Produk Terjual</h5>
                        <h2 class="card-text">{{ number_format($totalProdukTerjual, 0, ',', '.') }} item</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi Baru</h5>
                        <a href="{{ route('kasir.transaksi') }}" class="btn btn-light btn-lg mt-2 w-100">Buka Kasir</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header border-bottom bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Penjualan Terakhir</h5>
                        <div>
                            <button class="btn btn-warning me-2" onclick="showSetup()">Kembali ke Setup</button>
                            <form action="{{ route('kasir.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mereset kasir? Semua data transaksi hari ini akan dihapus.')">
                                @csrf
                                <button type="submit" id="btn-reset-kasir" class="btn btn-danger">Reset Kasir</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-datatable">
                            <table class="dt-responsive table" id="sales-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Waktu</th>
                                        <th>Total Items</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todaySales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->created_at->format('H:i:s') }}</td>
                                        <td>{{ $sale->total_quantity }}</td>
                                        <td>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('transaction.show', $sale->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @if (session('setup_complete'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Kasir Siap Digunakan!',
                text: "{!! session('setup_complete') !!}",
                confirmButtonText: 'Ok'
            });
        </script>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to show only the specified step and hide all others
    window.showStep = function(stepId) {
        // Hide all steps
        document.querySelectorAll('.setup-step').forEach(step => {
            step.style.display = 'none';
        });
        
        // Show the specified step
        document.getElementById(stepId).style.display = 'block';
        
        // Scroll to top of the step for better UX
        window.scrollTo(0, 0);
    };

    // Function to finish setup and show dashboard
    window.finishSetup = function() {
        // Hide the setup wizard
        document.getElementById('kasir-setup').style.display = 'none';
        
        // Show the dashboard
        document.getElementById('kasir-active').style.display = 'block';
        
        // Save setup status via AJAX
        fetch('{{ route("kasir.complete-setup") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error saving setup status:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };

    // Function to show setup again from dashboard
    window.showSetup = function() {
        // Hide the dashboard
        document.getElementById('kasir-active').style.display = 'none';
        
        // Show the setup wizard and go to product step
        document.getElementById('kasir-setup').style.display = 'block';
        showStep('step-product');
    };

    // Check if URL has a step parameter and show that step
    const urlParams = new URLSearchParams(window.location.search);
    const stepParam = urlParams.get('step');
    if (stepParam && document.getElementById(stepParam)) {
        showStep(stepParam);
    }

    // Ajax for price forms (update price)
    const priceForms = document.querySelectorAll('.price-form');
    if (priceForms.length > 0) {
        priceForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const url = this.getAttribute('action');

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert('Harga berhasil diperbarui!');
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui harga.');
                });
            });
        });
    }

    // Ajax for stock forms (update stock)
    const stockForms = document.querySelectorAll('.stock-form');
    if (stockForms.length > 0) {
        stockForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const url = this.getAttribute('action');

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert('Stok berhasil diperbarui!');
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui stok.');
                });
            });
        });
    }
});
</script>

<style>
.setup-wizard {
    min-height: 70vh;
}
.setup-step {
    padding: 20px 0;
}
</style>
@endpush