@extends('layouts.main')

@section('content')
    <section id="kasir-active" style="display: {{ $setupComplete ? 'block' : 'none' }}">
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mt-4">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon">
                                        <i data-feather="activity"></i>
                                    </div>
                                    Manajemen Kasir
                                </h1>
                                <div class="page-header-subtitle">
                                    Monitor transaksi dan produk toko Anda
                                </div>
                            </div>
                            <div class="col-12 col-xl-auto mt-4">
                                <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                    <span class="input-group-text"><i class="text-primary" data-feather="shopping-cart"></i></span>
                                    <a href="{{ route('kasir') }}" class="btn btn-light btn-md">Buka Kasir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="container-xl px-4 mt-n10">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-xl-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">
                                            Total Penjualan Hari Ini
                                        </div>
                                        <div class="text-lg fw-bold">Rp. {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="{{ route('history') }}">Lihat Laporan</a>
                                <div class="text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3 mb-4">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">Total Produk Terjual</div>
                                        <div class="text-lg fw-bold">{{ number_format($totalProdukTerjual, 0, ',', '.') }} item</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="shopping-bag"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" data-bs-target="#modalProdukTerjual" data-bs-toggle="modal">Lihat Laporan</a>
                                <div class="text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">Total Stock Produk</div>
                                        <div class="text-lg fw-bold">{{ $products->sum('stock') }} unit</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="package"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" data-bs-target="#modalTotalStockProduk" data-bs-toggle="modal">Lihat Inventory</a>
                                <div class="text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3 mb-4">
                        <div class="card bg-danger text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">Total Produk</div>
                                        <div class="text-lg fw-bold">{{ $products->count() }} produk</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="database"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="{{ route('produk.index') }}">Kelola Produk</a>
                                <div class="text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- table -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container-xl px-4 mt-4">
                <div class="card mb-4">
                    <div class="card-header border-bottom bg-light d-flex justify-content-between align-items-center">
                        <div class="card-title">Tabel Produk</div>
                        <div>
                            <button class="btn btn-warning me-2" onclick="showSetupWithConfirmation()">
                                <i class="fas fa-cog me-1"></i> Kembali ke Setup
                            </button>
                            <button type="button" class="btn btn-danger" onclick="confirmResetKasir()">
                                <i class="fas fa-sync-alt me-1"></i> Reset Kasir
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" width="50">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info edit-product" 
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}"
                                            data-stock="{{ $product->stock }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editProdukModal">
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-product" 
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada produk tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Modal Edit Produk -->
        <div class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editProdukForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProdukModalLabel">Edit Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_price" class="form-label">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" class="form-control" id="edit_price" name="price" min="0" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="edit_stock" name="stock" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_image" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="edit_image" name="image">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                <div class="mt-2">
                                    <img id="edit_image_preview" src="" alt="Preview Gambar" class="img-fluid rounded" style="max-width: 150px;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal total stockproduk -->
        <div class="modal fade" id="modalTotalStockProduk" tabindex="-1" aria-labelledby="modalTotalStockProdukLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary-to-secondary">
                        <h5 class="modal-title text-white" id="modalTotalStockProdukLabel">Total Stok Produk : <span class="text-white">{{ $products->sum('stock') }} </span></h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-white">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Stok</th>
                                    <th>Gambar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" width="50">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal total produk terjual -->
        <div class="modal fade" id="modalProdukTerjual" tabindex="-1" aria-labelledby="modalProdukTerjualLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary-to-secondary">
                        <h5 class="modal-title text-white" id="modalProdukTerjualLabel">Laporan Produk Terjual</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-white">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Terjual</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $index => $transaction)
                                    @foreach ($transaction->transaksiItem as $item)
                                    <tr>
                                        <td>{{ $loop->parent->index + 1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $transaction->total_harga_formatted }}</td>
                                        <td>{{ $transaction->transaction_date }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Reset Kasir Hidden -->
        <form id="resetKasirForm" action="{{ route('reset.kasir') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small">
                        Copyright &copy; Your Website 2021
                    </div>
                    <div class="col-md-6 text-md-end small">
                        <a href="#!">Privacy Policy</a>
                        &middot;
                        <a href="#!">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </section>
    @endsection
