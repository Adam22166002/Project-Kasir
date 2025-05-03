@extends('layouts.laporan')

@section('content')
<section>
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
                                    Laporan Modal
                                </h1>
                                <div class="page-header-subtitle">
                                    Monitor Mengelola Modal Akhir dan Modal Awal
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
            <!-- tabel -->
            <div class="container py-4 mt-n10">
                <div class="card">
                    <div class="card-header border-bottom bg-light d-flex justify-content-between align-items-center">
                        <div class="h3 text-primary card-title">Tabel Laporan Modal</div>
                        <a href="{{ route('laporan.modal.pdf') }}" class="btn btn-warning mb-2" target="_blank">Cetak Laporan Perubahan Modal</a>
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Modal Awal</td>
                                        <td>Rp {{ number_format($modalAwal, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Laba Bersih</td>
                                        <td>Rp {{ number_format($labaBersih, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pendapatan Akhir</strong></td>
                                        <td><strong>Rp {{ number_format($modalAkhir, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</main>
</section>
@endsection
