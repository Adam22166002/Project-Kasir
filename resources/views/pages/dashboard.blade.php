@extends('layouts.main')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Dashboard Kasir</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Penjualan Hari Ini</h5>
                    <h2 class="card-text">Rp. {{ number_format($totalPenjualan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Produk Terjual</h5>
                    <h2 class="card-text">{{ number_format($totalProdukTerjual, 0, ',', '.') }} item</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Mulai Kasir</h5>
                    <a href="{{ route('kasir') }}" class="btn btn-light btn-lg mt-2">Buka Kasir</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5>Penjualan Terakhir</h5>
                </div>
                <div class="card-body">
                    @if($todaySales->isEmpty())
                        <p class="text-center">Belum ada penjualan hari ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Waktu</th>
                                        <th>Total Items</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todaySales->take(5) as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->created_at->format('H:i:s') }}</td>
                                        <td>{{ $sale->total_quantity }}</td>
                                        <td>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($todaySales->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('history') }}" class="btn btn-outline-primary">Lihat Semua Transaksi</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection