@extends('layouts.main')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mt-4">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon">
                                        <i data-feather="activity"></i>
                                    </div>
                                    Kasir toko
                                </h1>
                                <div class="page-header-subtitle">
                                    Transactions and Product
                                </div>
                            </div>
                            <div class="col-12 col-xl-auto mt-4">
                                <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                    <span class="input-group-text"><i class="text-primary" data-feather="arrow-left"></i></span>
                                    <a href="{{ route('dashboard') }}" class="btn btn-light">Kembali ke Dashboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
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
<div class="container-xl py-5  mt-n10">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">Pilih Produk Anda</h5>
                </div>
                <div class="card-body">
                    <div class="row" id="product-list">
                        @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-none h-60 product-card">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('img/no-image.jpg') }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                @endif
                                <div class="card-body py-3">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="card-text text-muted">Stok: {{ $product->stock }}</p>
                                    <div class="d-flex align-items-center mt-2">
                                        <button class="btn btn-sm btn-outline-primary btn-quantity-minus" data-id="{{ $product->id }}">-</button>
                                        <input type="number" class="form-control mx-2 text-center product-quantity" 
                                            value="0" min="0" max="{{ $product->stock }}" data-id="{{ $product->id }}" 
                                            data-price="{{ $product->price }}" data-name="{{ $product->name }}">
                                        <button class="btn btn-sm btn-outline-primary btn-quantity-plus" data-id="{{ $product->id }}">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <div class="alert alert-warning">
                                <h4>Belum ada produk yang tersedia!</h4>
                                <p>Silahkan tambahkan produk terlebih dahulu di halaman dashboard.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">Keranjang Belanja</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3" id="cart-items">
                        <!-- Item keranjang akan ditampilkan di sini -->
                        <p class="text-center text-muted" id="empty-cart-message">Belum ada produk dipilih</p>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <h5>Total Pembayaran:</h5>
                        <h5 id="total-payment">Rp 0</h5>
                    </div>
                    
                    <button id="btn-checkout" class="btn btn-primary w-100 mt-3" disabled>Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Mengambil elemen yang diperlukan
    const productQuantityInputs = document.querySelectorAll('.product-quantity');
    const cartItemsContainer = document.getElementById('cart-items');
    const totalPaymentElement = document.getElementById('total-payment');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const checkoutButton = document.getElementById('btn-checkout');

    let cart = [];

    // Fungsi untuk memperbarui keranjang belanja
    function updateCart() {
        // Clear keranjang dan total pembayaran
        cartItemsContainer.innerHTML = '';
        let total = 0;
        let itemCount = 0;

        cart.forEach(item => {
            // Menambahkan item ke keranjang
            const cartItem = document.createElement('div');
            cartItem.classList.add('mb-2');
            cartItem.innerHTML = `
                <div class="d-flex justify-content-between">
                    <span>${item.name} (${item.quantity}x)</span>
                    <span>Rp ${(item.price * item.quantity).toLocaleString()}</span>
                </div>
            `;
            cartItemsContainer.appendChild(cartItem);

            total += item.price * item.quantity;
            itemCount += item.quantity;
        });

        if (itemCount === 0) {
            emptyCartMessage.style.display = 'block';
            checkoutButton.disabled = true;
        } else {
            emptyCartMessage.style.display = 'none';
            checkoutButton.disabled = false;
        }

        // Update total pembayaran
        totalPaymentElement.textContent = `Rp ${total.toLocaleString()}`;
    }

    // Fungsi untuk menambah jumlah produk di keranjang
    function updateCartQuantity(id, quantity, price, name, maxStock) {
        // Cari produk yang sudah ada di keranjang
        const existingProductIndex = cart.findIndex(item => item.id === id);

        if (existingProductIndex !== -1) {
            if (quantity <= 0) {
                // Hapus item jika kuantitasnya 0
                cart.splice(existingProductIndex, 1);
            } else {
                // Update jumlah produk di keranjang
                cart[existingProductIndex].quantity = quantity;
            }
        } else if (quantity > 0) {
            // Jika belum ada dan kuantitas > 0, tambahkan produk baru ke keranjang
            cart.push({ id, name, price, quantity, maxStock });
        }

        // Update tampilan keranjang
        updateCart();
    }

    // Event listener untuk tombol tambah dan kurang jumlah produk
    productQuantityInputs.forEach(input => {
        const productId = input.dataset.id;
        const productPrice = parseInt(input.dataset.price);
        const productName = input.dataset.name;
        const maxStock = parseInt(input.max);

        input.addEventListener('input', (e) => {
            const quantity = parseInt(e.target.value);
            if (quantity >= 0 && quantity <= maxStock) {
                updateCartQuantity(productId, quantity, productPrice, productName, maxStock);
            } else if (quantity > maxStock) {
                // Batasi input ke stok maksimum
                e.target.value = maxStock;
                updateCartQuantity(productId, maxStock, productPrice, productName, maxStock);
                alert(`Stok produk ${productName} hanya tersedia ${maxStock} unit`);
            } else {
                // Reset quantity ke nilai sebelumnya jika input tidak valid
                e.target.value = 0;
                updateCartQuantity(productId, 0, productPrice, productName, maxStock);
            }
        });

        // Tombol tambah dan kurang
        const btnPlus = document.querySelector(`.btn-quantity-plus[data-id="${productId}"]`);
        const btnMinus = document.querySelector(`.btn-quantity-minus[data-id="${productId}"]`);

        btnPlus.addEventListener('click', () => {
            let currentQuantity = parseInt(input.value);
            if (currentQuantity < maxStock) {
                input.value = currentQuantity + 1;
                updateCartQuantity(productId, currentQuantity + 1, productPrice, productName, maxStock);
            } else {
                alert(`Stok produk ${productName} hanya tersedia ${maxStock} unit`);
            }
        });

        btnMinus.addEventListener('click', () => {
            let currentQuantity = parseInt(input.value);
            if (currentQuantity > 0) {
                input.value = currentQuantity - 1;
                updateCartQuantity(productId, currentQuantity - 1, productPrice, productName, maxStock);
            }
        });
    });

    // Event listener untuk tombol checkout
    checkoutButton.addEventListener('click', () => {
        if (cart.length > 0) {
            // Tampilkan konfirmasi sebelum checkout
            if (confirm('Apakah Anda yakin ingin melakukan checkout?')) {
                // Tampilkan indikator loading
                checkoutButton.disabled = true;
                checkoutButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                
                // Persiapkan data untuk dikirim ke server
                const items = cart.map(item => {
                    return {
                        productId: item.id,
                        quantity: item.quantity,
                        subtotal: item.price * item.quantity
                    };
                });
                
                const totalAmount = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                
                // Kirim data ke server menggunakan fetch API
                fetch('/simpan-transaksi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        total: totalAmount,
                        items: items
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan pesan sukses
                        const alertHTML = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        
                        // Tambahkan alert di bagian atas container
                        const container = document.querySelector('.container-xl.py-5');
                        const existingAlert = container.querySelector('.alert');
                        if (existingAlert) {
                            existingAlert.remove();
                        }
                        container.insertAdjacentHTML('afterbegin', alertHTML);
                        
                        // Reset keranjang
                        cart = [];
                        updateCart();
                        
                        // Reset semua input quantity ke 0
                        productQuantityInputs.forEach(input => {
                            input.value = 0;
                        });
                        
                        // Update tampilan stok produk dan refresh halaman untuk mendapatkan data terbaru
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Tampilkan pesan error
                        alert('Terjadi kesalahan: ' + data.message);
                        checkoutButton.disabled = false;
                        checkoutButton.innerHTML = 'Checkout';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses transaksi');
                    checkoutButton.disabled = false;
                    checkoutButton.innerHTML = 'Checkout';
                });
            }
        }
    });
</script>
@endpush