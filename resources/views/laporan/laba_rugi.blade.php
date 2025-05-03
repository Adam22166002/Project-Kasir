@extends('layouts.laporan')

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
                                    Laporan Laba
                                </h1>
                                <div class="page-header-subtitle">
                                    Monitor Mengelola Laba
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
                        <div class="h3 text-primary card-title">Tabel Laporan Laba</div>
                        <a href="{{ route('laporan.laba.pdf') }}" class="btn btn-primary mb-2" target="_blank">Cetak Laporan Laba Rugi</a>
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Total Penghasilan</td>
                                <td>Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Beban</strong></td>
                                <td></td>
                            </tr>
                             <tr>
                                <td>Listrik</td>
                                <td>Rp. 150.000</td>
                             </tr>
                             <tr>
                                <td>Air</td>
                                <td>Rp. 80.000</td>
                             </tr>
                             <tr>
                                <td>Beban Lainnya</td>
                                <td>Rp. 0</td>
                             </tr>
                            <tr>
                                <td><strong>Laba Kotor</strong></td>
                                <td><strong>Rp {{ number_format($labaKotor, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Modal</strong></td>
                                <td>Rp {{ number_format($modal, 0, ',', '.') }}</td>
                             </tr>
                            <tr>
                                <td><strong>Laba Bersih</strong></td>
                                <td><strong>Rp {{ number_format($labaBersih, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
@endsection
