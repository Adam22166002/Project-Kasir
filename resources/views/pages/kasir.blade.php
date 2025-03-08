@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h2>Pilih Produk</h2>
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p>Rp. {{ number_format($product->price) }}</p>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary minus-btn" type="button">-</button>
                            <input type="number" class="form-control text-center" value="0" min="0">
                            <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                        </div>
                        <button class="btn btn-primary mt-2 add-to-cart" data-id="{{ $product->id }}">Tambah</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="col-md-4">
        <h2>Keranjang</h2>
        <div id="cart">
            <!-- Isi keranjang akan dimuat secara dinamis -->
        </div>
        
        <div class="mt-3">
            <h4>Total: Rp. <span id="total-harga">0</span></h4>
            <button class="btn btn-success btn-lg" id="selesai-transaksi">Selesai</button>
            <button class="btn btn-danger btn-lg" id="reset-transaksi">Reset</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menangani tombol plus dan minus
        document.querySelectorAll('.plus-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input');
                input.value = parseInt(input.value) + 1;
            });
        });

        document.querySelectorAll('.minus-btn').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentNode.querySelector('input');
                const value = parseInt(input.value);
                if (value > 0) {
                    input.value = value - 1;
                }
            });
        });

        // Inisialisasi keranjang belanja
        const cart = {
            items: [],
            total: 0,

            // Menambahkan item ke keranjang
            addItem(productId, name, price, quantity) {
                // Cek apakah produk sudah ada di keranjang
                const existingItemIndex = this.items.findIndex(item => item.productId === productId);
                
                if (existingItemIndex !== -1) {
                    // Update quantity jika produk sudah ada
                    this.items[existingItemIndex].quantity += quantity;
                    this.items[existingItemIndex].subtotal = this.items[existingItemIndex].quantity * price;
                } else {
                    // Tambahkan produk baru ke keranjang
                    this.items.push({
                        productId,
                        name,
                        price,
                        quantity,
                        subtotal: quantity * price
                    });
                }

                this.updateCart();
            },

            // Menghapus item dari keranjang
            removeItem(productId) {
                this.items = this.items.filter(item => item.productId !== productId);
                this.updateCart();
            },

            // Update tampilan keranjang
            updateCart() {
                // Hitung total
                this.total = this.items.reduce((sum, item) => sum + item.subtotal, 0);
                
                // Update tampilan keranjang
                const cartElement = document.getElementById('cart');
                const totalElement = document.getElementById('total-harga');
                
                if (this.items.length === 0) {
                    cartElement.innerHTML = '<p>Keranjang kosong</p>';
                } else {
                    cartElement.innerHTML = this.items.map(item => `
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <h6 class="mb-1">${item.name}</h6>
                                <div class="d-flex justify-content-between">
                                    <div>${item.quantity} x Rp. ${item.price.toLocaleString()}</div>
                                    <div>Rp. ${item.subtotal.toLocaleString()}</div>
                                </div>
                                <button class="btn btn-sm btn-danger mt-1 remove-item" data-id="${item.productId}">Hapus</button>
                            </div>
                        </div>
                    `).join('');
                }

                totalElement.textContent = this.total.toLocaleString();

                // Tambah event listener untuk tombol hapus
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const productId = e.target.dataset.id;
                        this.removeItem(parseInt(productId));
                    });
                });
            },

            // Proses checkout
            checkout() {
                if (this.items.length === 0) {
                    alert('Keranjang belanja kosong!');
                    return;
                }

                // Kirim data transaksi ke backend
                fetch('/transaksi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        items: this.items,
                        total: this.total
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan struk
                        this.showReceipt(data.transaction);
                        this.reset();
                    } else {
                        alert('Transaksi gagal: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Transaksi gagal, silakan coba lagi');
                });
            },

            // Menampilkan struk belanja
            showReceipt(transaction) {
                const receiptModal = `
                <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Struk Pembelian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="receipt-container p-3 border">
                                    <div class="text-center mb-3">
                                        <h4>Toko Anda</h4>
                                        <p>Jl. Contoh No. 123</p>
                                        <p>Tanggal: ${new Date().toLocaleDateString('id-ID')}</p>
                                        <p>No. Transaksi: ${transaction.id}</p>
                                    </div>
                                    <hr>
                                    <div class="items-container">
                                        ${this.items.map(item => `
                                            <div class="d-flex justify-content-between mb-2">
                                                <div>${item.name} x ${item.quantity}</div>
                                                <div>Rp. ${item.subtotal.toLocaleString()}</div>
                                            </div>
                                        `).join('')}
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total</strong>
                                        <strong>Rp. ${this.total.toLocaleString()}</strong>
                                    </div>
                                    <div class="text-center mt-3">
                                        <p>Terima kasih telah berbelanja</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="print-receipt">Cetak</button>
                            </div>
                        </div>
                    </div>
                </div>`;

                // Tambahkan modal ke body
                document.body.insertAdjacentHTML('beforeend', receiptModal);
                
                // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('receiptModal'));
                modal.show();
                
                // Event listener untuk tombol cetak
                document.getElementById('print-receipt').addEventListener('click', function() {
                    const printWindow = window.open('', '', 'width=600,height=600');
                    const receiptHTML = document.querySelector('.receipt-container').innerHTML;
                    
                    printWindow.document.write(`
                        <html>
                            <head>
                                <title>Struk Pembelian</title>
                                <style>
                                    body { font-family: Arial; font-size: 12px; }
                                    .text-center { text-align: center; }
                                    .d-flex { display: flex; }
                                    .justify-content-between { justify-content: space-between; }
                                    .mb-2 { margin-bottom: 8px; }
                                    .mb-3 { margin-bottom: 12px; }
                                    .mt-3 { margin-top: 12px; }
                                    hr { border: 1px dashed #ccc; }
                                </style>
                            </head>
                            <body>
                                ${receiptHTML}
                            </body>
                        </html>
                    `);
                    
                    printWindow.document.close();
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();
                });
                
                // Hapus modal dari DOM saat ditutup
                document.getElementById('receiptModal').addEventListener('hidden.bs.modal', function () {
                    this.remove();
                });
            },

            // Reset keranjang
            reset() {
                this.items = [];
                this.total = 0;
                this.updateCart();
                
                // Reset juga semua input jumlah
                document.querySelectorAll('.input-group input').forEach(input => {
                    input.value = 0;
                });
            }
        };

        // Event listener untuk tombol tambah ke keranjang
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const card = this.closest('.card');
                const productId = parseInt(this.dataset.id);
                const name = card.querySelector('.card-title').textContent;
                const priceText = card.querySelector('.card-body p').textContent;
                const price = parseFloat(priceText.replace('Rp. ', '').replace(/\./g, '').replace(',', '.'));
                const quantity = parseInt(card.querySelector('input').value);
                
                if (quantity > 0) {
                    cart.addItem(productId, name, price, quantity);
                    // Reset input jumlah setelah ditambahkan ke keranjang
                    card.querySelector('input').value = 0;
                } else {
                    alert('Silakan masukkan jumlah produk!');
                }
            });
        });

        // Event listener untuk tombol selesai transaksi
        document.getElementById('selesai-transaksi').addEventListener('click', function() {
            cart.checkout();
        });

        // Event listener untuk tombol reset
        document.getElementById('reset-transaksi').addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus semua item dalam keranjang?')) {
                cart.reset();
            }
        });
    });
</script>
@endpush