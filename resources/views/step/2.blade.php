@extends('layouts.main')

@section('content')
<!-- Step 2: Update Produk -->
<div class="">
          <div class="row">
              <div class="col-md-10 mx-auto mt-5">
                  <div class="card shadow-none" style="box-shadow: none;">
                      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                          <h3 class="mb-0 text-white">Set Up Produk</h3>
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
                                      <input type="file" class="form-control" id="product-image" name="image_path" required accept="image/*">
                                  </div>
                                  <div class="col-md-3 d-flex align-items-end">
                                      <button type="submit" class="btn btn-success w-100">
                                          <i class="fas fa-plus-circle me-2"></i> Tambah Produk
                                      </button>
                                  </div>
                              </div>
                          </form>
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
                          <div class="table-responsive mt-4">
                              <table id="datatablesSimple" class="table table-light table-hover">
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
                                                  <img src="{{ asset('storage/' . ($product->image_path ?? 'img/no-image.jpg')) }}" width="60" height="60" class="img-thumbnail">
                                              </td>
                                              <td>{{ $product->name }}</td>
                                              <td>
                                                  <button class="btn btn-sm btn-info read-product" 
                                                        data-id="{{ $product->id }}"
                                                        data-name="{{ $product->name }}"
                                                        data-price="{{ $product->price }}"
                                                        data-stock="{{ $product->stock }}"
                                                        data-image_path="{{ $product->image_path }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#readProductModal">
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
                            <a href="{{ route('step1') }}" class="btn btn btn-outline-dark me-2">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <a href="{{ route('step3') }}" class="btn btn-primary">
                                Lanjut ke Set Up Harga <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Modal Show Produk -->
        <div class="modal fade" id="readProductModal" tabindex="-1" aria-labelledby="readProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="readProductModalLabel">Detail Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="show_name" class="form-label fw-bold">Nama Produk:</label>
                            <input type="text" id="show_name" class="form-control" value="" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar Produk:</label>
                            <img id="show_image" src="" class="img-thumbnail" width="150">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
@endsection


@push('scripts')
    <script>
        document.querySelectorAll('.read-product').forEach(button => {
        button.addEventListener('click', function() {
            const name = this.dataset.name;
            const image = this.dataset.image_path;
            document.getElementById('show_name').value = name;            
            document.getElementById('show_image').src = image ? `/storage/${image}` : 'https://via.placeholder.com/150';
        });
    });
    </script>
@endpush