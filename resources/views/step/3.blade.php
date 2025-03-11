@extends('layouts.main')

@section('content')
<!-- Step 3: Update Harga -->
<div class="">
    <div class="row">
        <div class="col-md-10 mx-auto mt-5">
            <div class="card shadow-none">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 text-white">Set Up Harga Produk</h3>
                    <span class="badge bg-light text-success">2/3</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Silahkan update harga untuk setiap produk lalu klik icon "Simpan"
                    </div>
                    <div id="success-alert" class="alert alert-info d-none"></div> 
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
                    <div class="table-responsive">
                        <table id="datatablesSimple"  class="table table-light table-hover">
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
                                            <img src="{{ asset('storage/' . ($product->image_path ?? 'img/no-image.jpg')) }}" width="60" height="60" class="img-thumbnail">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <form action="{{ route('produk.update.price', $product->id) }}" method="POST" class="price-form">
                                                @csrf
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control price-input" name="price" required value="{{ $product->price }}" min="0">
                                                    <button type="submit" class="btn btn-outline-primary save-btn" data-id="{{ $product->id }}">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <span id="status-{{ $product->id }}" class="badge {{ $product->price ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->price ? 'Tersimpan' : 'Belum disimpan' }}
                                            </span>
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
                        <a href="{{ route('step2') }}" class="btn btn-outline-dark me-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="{{ route('step4') }}" class="btn btn-primary">
                            Lanjut ke Set UP Stok <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.price-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah reload halaman
            
            let formData = new FormData(this);
            let submitButton = this.querySelector('.save-btn');
            let productId = submitButton.dataset.id;
            let statusBadge = document.getElementById('status-' + productId);
            
            submitButton.disabled = true; // Disable tombol saat request
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'; // Loading animation

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('success-alert').textContent = 'Harga produk berhasil diperbarui!';
                    document.getElementById('success-alert').classList.remove('d-none');

                    // Update status menjadi 'Tersimpan'
                    statusBadge.classList.remove('bg-secondary');
                    statusBadge.classList.add('bg-success');
                    statusBadge.textContent = 'Tersimpan';
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save"></i>'; // Kembali ke ikon normal
            });
        });
    });
</script>
@endpush
