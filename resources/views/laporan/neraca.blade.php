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
                                    LaporanNeraca
                                </h1>
                                <div class="page-header-subtitle">
                                    Monitor Mengelola Asset
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
                        <div class="h3 text-primary card-title">Tabel Neraca</div>
                        <a href="{{ route('laporan.neraca.pdf') }}" class="btn btn-success mb-2" target="_blank">Cetak Laporan Neraca</a>
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
                                        <th>Aset</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Kas</td>
                                        <td>Rp {{ number_format($kas, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tabungan Dompet Elektronik</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Giro</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Deposito</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Piutang Usaha</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Persediaan</td>
                                        <td>Rp {{ number_format($persediaan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Asset Lain</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah Aset</strong></td>
                                        <td><strong>Rp {{ number_format($totalAset, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Kewajiban</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>Utang Bank</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Utang Usaha</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Kewajiban Lain</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Utang Beban</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td>Utang Non Bank</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Modal</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Saldo Laba</td>
                                        <td>Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Modal</td>
                                        <td>Rp {{ number_format($modal, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection
