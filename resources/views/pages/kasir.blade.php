@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Transaksi Kasir</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pilih Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row" id="product-list">
                        @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 product-card">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('img/no-image.jpg') }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="card-text text-muted">Stok: {{ $product->stock }}</p>
                                    <div class="d-flex align-items-center mt-2">
                                        <button class="btn btn-sm btn-outline-secondary btn-quantity-minus" data-id="{{ $product->id }}">-</button>
                                        <input type="number" class="form-control mx-2 text-center product-quantity" 
                                               value="0" min="0" max="{{ $product->stock }}" data-id="{{ $product->id }}" 
                                               data-price="{{ $product->price }}" data-name="{{ $product->name }}">
                                        <button class="btn btn-sm btn-outline-secondary btn-quantity-plus" data-id="{{ $product->id }}">+</button>
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
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Keranjang Belanja</h5>
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

@section('scripts')
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
                    <span>${item.name}</span>
                    <span>Rp ${item.price.toLocaleString()}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Jumlah: ${item.quantity}</span>
                    <span>Rp ${item.price * item.quantity}</span>
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
    function updateCartQuantity(id, quantity, price, name) {
        // Cari produk yang sudah ada di keranjang
        const existingProduct = cart.find(item => item.id === id);

        if (existingProduct) {
            // Update jumlah produk di keranjang
            existingProduct.quantity = quantity;
        } else {
            // Jika belum ada, tambahkan produk baru ke keranjang
            cart.push({ id, name, price, quantity });
        }

        // Update tampilan keranjang
        updateCart();
    }

    // Event listener untuk tombol tambah dan kurang jumlah produk
    productQuantityInputs.forEach(input => {
        const productId = input.dataset.id;
        const productPrice = parseInt(input.dataset.price);
        const productName = input.dataset.name;

        input.addEventListener('input', (e) => {
            const quantity = parseInt(e.target.value);
            if (quantity >= 0 && quantity <= parseInt(input.max)) {
                updateCartQuantity(productId, quantity, productPrice, productName);
            } else {
                // Reset quantity ke nilai sebelumnya jika input tidak valid
                e.target.value = 0;
                updateCartQuantity(productId, 0, productPrice, productName);
            }
        });

        // Tombol tambah dan kurang
        const btnPlus = document.querySelector(`.btn-quantity-plus[data-id="${productId}"]`);
        const btnMinus = document.querySelector(`.btn-quantity-minus[data-id="${productId}"]`);

        btnPlus.addEventListener('click', () => {
            let currentQuantity = parseInt(input.value);
            if (currentQuantity < parseInt(input.max)) {
                input.value = currentQuantity + 1;
                updateCartQuantity(productId, currentQuantity + 1, productPrice, productName);
            }
        });

        btnMinus.addEventListener('click', () => {
            let currentQuantity = parseInt(input.value);
            if (currentQuantity > 0) {
                input.value = currentQuantity - 1;
                updateCartQuantity(productId, currentQuantity - 1, productPrice, productName);
            }
        });
    });

    // Event listener untuk tombol checkout
    checkoutButton.addEventListener('click', () => {
        if (cart.length > 0) {
            // Melakukan checkout dan proses pembayaran
            alert('Checkout berhasil! Total pembayaran: ' + totalPaymentElement.textContent);
            // Reset keranjang setelah checkout
            cart = [];
            updateCart();
        }
    });
</script>
@endsection
