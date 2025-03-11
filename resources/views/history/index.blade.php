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
                                    History Kasir
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
<div class="container py-4 mt-n10">
    <div class="card">
        <div class="h3 px-4 pt-3 text-primary card-title">History Transaksi</div>
            <div class="px-4 d-flex justify-content-between align-items-center">
                <form action="{{ route('kasir.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mereset kasir? Semua data transaksi hari ini akan dihapus.')">
                    @csrf
                    <button type="submit" id="btn-reset-kasir" class="btn btn-danger">Reset Kasir</button>
                </form>
                <form action="{{ route('history') }}" method="GET" class="d-flex">
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="form-control me-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <div class="alert alert-info">
                    Tidak ada transaksi pada periode yang dipilih.
                </div>
            @else
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Tanggal & Waktu</th>
                                <th>Jumlah Item</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $transaction->total_quantity }}</td>
                                <td>Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info view-detail" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailTransaksiModal"
                                            data-id="{{ $transaction->id }}">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Total Transaksi:</strong> {{ $transactions->count() }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Total Produk Terjual:</strong> {{ $transactions->sum('total_quantity') }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Total Penjualan:</strong> Rp. {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="detailTransaksiModal" tabindex="-1" aria-labelledby="detailTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTransaksiModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailTransaksiContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="printDetailTransaksi">Cetak</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil detail transaksi
        document.querySelectorAll('.view-detail').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const detailContent = document.getElementById('detailTransaksiContent');
                
                // Tampilkan loading
                detailContent.innerHTML = `
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;
                
                // Ambil data dari server
                fetch(`/transaksi/${id}/detail`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Format tanggal
                            const date = new Date(data.transaction.created_at);
                            const formattedDate = new Intl.DateTimeFormat('id-ID', { 
                                dateStyle: 'full', 
                                timeStyle: 'medium'
                            }).format(date);
                            
                            // Render detail transaksi
                            detailContent.innerHTML = `
                                <div class="receipt-container p-3 border">
                                    <div class="text-center mb-3">
                                        <h4>Toko Anda</h4>
                                        <p>Jl. Contoh No. 123</p>
                                        <p>${formattedDate}</p>
                                        <p>No. Transaksi: ${data.transaction.id}</p>
                                    </div>
                                    <hr>
                                    
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th class="text-end">Harga</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.items.map(item => `
                                                <tr>
                                                    <td>${item.product.name}</td>
                                                    <td class="text-end">Rp. ${parseInt(item.price).toLocaleString()}</td>
                                                    <td class="text-center">${item.quantity}</td>
                                                    <td class="text-end">Rp. ${parseInt(item.subtotal).toLocaleString()}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total</th>
                                                <th class="text-end">Rp. ${parseInt(data.transaction.total_price).toLocaleString()}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                    <hr>
                                    
                                    <div class="text-center mt-3">
                                        <p>Terima kasih telah berbelanja</p>
                                    </div>
                                </div>
                            `;
                        } else {
                            detailContent.innerHTML = `
                                <div class="alert alert-danger">
                                    ${data.message || 'Terjadi kesalahan saat mengambil data transaksi'}
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        detailContent.innerHTML = `
                            <div class="alert alert-danger">
                                Terjadi kesalahan saat mengambil data transaksi
                            </div>
                        `;
                    });
            });
        });
        
        // Cetak detail transaksi
        document.getElementById('printDetailTransaksi').addEventListener('click', function() {
            const printWindow = window.open('', '', 'width=600,height=600');
            const receiptHTML = document.querySelector('.receipt-container').innerHTML;
            
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Detail Transaksi</title>
                        <style>
                            body { font-family: Arial; font-size: 12px; }
                            .text-center { text-align: center; }
                            .text-end { text-align: right; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { padding: 8px; }
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
    });
</script>
@endpush