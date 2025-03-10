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