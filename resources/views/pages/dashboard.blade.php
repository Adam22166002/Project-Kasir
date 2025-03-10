@extends('layouts.main')

@section('content')
    <section id="kasir-setup" style="display: {{ $setupComplete ? 'none' : 'block' }}">
      <!-- Step 1: Tombol Start -->
        <div class="setup-step text-white w-100" id="step-start" style="display: block;
            background: linear-gradient(rgba(255, 0, 0, 0.7), rgba(255, 0, 0, 0.7)), 
                        url('https://th.bing.com/th/id/OIP.IoTJj7z5CUgbzIgImc4YcQHaHa?w=1350&h=1350&rs=1&pid=ImgDetMain');
            background-size: cover;
            background-position: center;
            background-blend-mode: multiply;">
            
            <div class="row vh-100 d-flex align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <div class="container-fluid">
                        <div class="card-body py-5 d-flex flex-column align-items-center justify-content-center">
                            <h1 class="display-4 mb-4 text-white font-weight-bold">Aplikasi Kasir</h1>
                            <p class="lead">Selamat datang! Klik tombol di bawah untuk memulai pengaturan kasir.</p>
                            <button id="btn-start" class="btn btn-light btn-lg mt-4 px-5 py-3" onclick="showStep('step-product')">
                                <i class="fas fa-play me-2"></i> MULAI SETUP
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
                  <div class="card">
                      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                          <h3 class="mb-0 text-white">Step 1: Update Produk</h3>
                          <span class="badge bg-light text-primary">1/3</span>
                      </div>
                      <div class="card-body">
                          <form id="add-product-form" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="row g-3">
                                  <div class="col-md-5">
                                      <label for="product-name" class="form-label">Nama Produk</label>
                                      <input type="text" class="form-control" id="product-name" name="name" required placeholder="Masukkan nama produk">
                                  </div>
                                  <div class="col-md-4">
                                      <label for="product-image" class="form-label">Foto Produk</label>
                                      <input type="file" class="form-control" id="product-image" name="image_path" accept="image/*">
                                  </div>
                                  <div class="col-md-3 d-flex align-items-end">
                                      <button type="submit" class="btn btn-success w-100">
                                          <i class="fas fa-plus-circle me-2"></i> Tambah Produk
                                      </button>
                                  </div>
                              </div>
                          </form>

                          <div class="table-responsive mt-4">
                              <table class="table table-striped table-hover">
                                  <thead class="table-light">
                                      <tr>
                                          <th>No</th>
                                          <th>Foto</th>
                                          <th>Nama Produk</th>
                                          <th>Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @forelse($products as $index => $product)
                                          <tr>
                                              <td>{{ $index + 1 }}</td>
                                              <td>
                                                  <img src="{{ asset('storage/' . ($product->image_path ?? 'img/no-image.jpg')) }}" width="50" height="50" class="img-thumbnail">
                                              </td>
                                              <td>{{ $product->name }}</td>
                                              <td>
                                                  <button class="btn btn-sm btn-info view-product" data-id="{{ $product->id }}">
                                                      <i class="fas fa-eye"></i>
                                                  </button>
                                                  <button class="btn btn-sm btn-danger delete-product" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                                      <i class="fas fa-trash"></i>
                                                  </button>
                                              </td>
                                          </tr>
                                      @empty
                                          <tr>
                                              <td colspan="4" class="text-center py-3">Belum ada produk. Silahkan tambahkan produk terlebih dahulu.</td>
                                          </tr>
                                      @endforelse
                                  </tbody>
                              </table>
                          </div>

                          <div class="text-end mt-4">
                              <button class="btn btn-outline-secondary me-2" onclick="showStep('step-start')">
                                  <i class="fas fa-arrow-left me-1"></i> Kembali
                              </button>
                              <button class="btn btn-primary" onclick="showStep('step-price')">
                                  Lanjut ke Update Harga <i class="fas fa-arrow-right ms-1"></i>
                              </button>
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
                      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                          <h3 class="mb-0">Step 2: Update Harga Produk</h3>
                          <span class="badge bg-light text-success">2/3</span>
                      </div>
                      <div class="card-body">
                          <div class="alert alert-info">
                              <i class="fas fa-info-circle me-2"></i> Silahkan update harga untuk setiap produk lalu klik tombol "Simpan"
                          </div>
                          
                          <div class="table-responsive">
                              <table class="table table-striped table-hover">
                                  <thead class="table-light">
                                      <tr>
                                          <th>No</th>
                                          <th>Foto</th>
                                          <th>Nama Produk</th>
                                          <th>Harga (Rp)</th>
                                          <th>Status</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @forelse($products as $index => $product)
                                          <tr>
                                              <td>{{ $index + 1 }}</td>
                                              <td>
                                                  <img src="{{ asset('storage/' . ($product->image_path ?? 'img/no-image.jpg')) }}" width="50" height="50" class="img-thumbnail">
                                              </td>
                                              <td>{{ $product->name }}</td>
                                              <td>
                                                  <form action="{{ route('produk.update.price', $product->id) }}" method="POST" class="price-form">
                                                      @csrf
                                                      <div class="input-group">
                                                          <span class="input-group-text">Rp</span>
                                                          <input type="number" class="form-control" name="price" value="{{ $product->price }}" min="0">
                                                          <button type="submit" class="btn btn-outline-primary">
                                                              <i class="fas fa-save"></i>
                                                          </button>
                                                      </div>
                                                  </form>
                                              </td>
                                              <td>
                                                  <span class="price-status-{{ $product->id }} badge bg-secondary">Belum disimpan</span>
                                              </td>
                                          </tr>
                                      @empty
                                          <tr>
                                              <td colspan="5" class="text-center py-3">Belum ada produk. Silahkan kembali ke langkah sebelumnya.</td>
                                          </tr>
                                      @endforelse
                                  </tbody>
                              </table>
                          </div>

                          <div class="text-end mt-4">
                              <button class="btn btn-outline-secondary me-2" onclick="showStep('step-product')">
                                  <i class="fas fa-arrow-left me-1"></i> Kembali
                              </button>
                              <button class="btn btn-success" onclick="showStep('step-stock')">
                                  Lanjut ke Update Stok <i class="fas fa-arrow-right ms-1"></i>
                              </button>
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
                      <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                          <h3 class="mb-0">Step 3: Update Stok Produk</h3>
                          <span class="badge bg-light text-info">3/3</span>
                      </div>
                      <div class="card-body">
                          <div class="alert alert-info">
                              <i class="fas fa-info-circle me-2"></i> Silahkan update stok untuk setiap produk lalu klik tombol "Simpan"
                          </div>
                          
                          <div class="table-responsive">
                              <table class="table table-striped table-hover">
                                  <thead class="table-light">
                                      <tr>
                                          <th>No</th>
                                          <th>Foto</th>
                                          <th>Nama Produk</th>
                                          <th>Harga (Rp)</th>
                                          <th>Stok</th>
                                          <th>Status</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @forelse($products as $index => $product)
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
                                                      <div class="input-group">
                                                          <input type="number" class="form-control" name="stock" value="{{ $product->stock }}" min="0">
                                                          <button type="submit" class="btn btn-outline-primary">
                                                              <i class="fas fa-save"></i>
                                                          </button>
                                                      </div>
                                                  </form>
                                              </td>
                                              <td>
                                                  <span class="stock-status-{{ $product->id }} badge bg-secondary">Belum disimpan</span>
                                              </td>
                                          </tr>
                                      @empty
                                          <tr>
                                              <td colspan="6" class="text-center py-3">Belum ada produk. Silahkan kembali ke langkah pertama.</td>
                                          </tr>
                                      @endforelse
                                  </tbody>
                              </table>
                          </div>

                          <div class="text-end mt-4">
                              <button class="btn btn-outline-secondary me-2" onclick="showStep('step-price')">
                                  <i class="fas fa-arrow-left me-1"></i> Kembali
                              </button>
                              <button class="btn btn-primary" onclick="completeSetupWithConfirmation()">
                                  <i class="fas fa-check-circle me-1"></i> Selesai Setup
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>

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
                                    <a href="{{ route('kasir.transaksi') }}" class="btn btn-light btn-md">Buka Kasir</a>
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
                                <a class="text-white stretched-link" href="#modalProdukTerjual">Lihat Laporan</a>
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
                                <a class="text-white stretched-link" href="#modalTotalStockProduk">Lihat Inventory</a>
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
                              <label for="edit_image" class="form-label">Gambar Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                              <input type="file" class="form-control" id="edit_image" name="image">
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
        <!-- Form Reset Kasir Hidden -->
        <form id="resetKasirForm" action="/kasir/reset" method="POST" style="display: none;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
