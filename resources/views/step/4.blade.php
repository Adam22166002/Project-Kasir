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