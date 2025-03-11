@extends('layouts.main')

@section('content')
<!-- Step 1: Tombol Start -->
<div class="setup-step text-white w-100" id="step-start" style="display: block;
            background: linear-gradient(rgba(255, 0, 0, 0.7), rgba(255, 0, 0, 0.7)), 
                        url('https://th.bing.com/th/id/OIP.IoTJj7z5CUgbzIgImc4YcQHaHa?w=1350&h=1350&rs=1&pid=ImgDetMain');
            background-size: cover;
            background-position: center;
            background-blend-mode: multiply;">
            
            <div class="row vh-100 d-flex align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <div class="container-fluid">
                        <div class="card-body py-5 d-flex flex-column align-items-center justify-content-center">
                            <h1 class="display-4 mb-4 text-white font-weight-bold">Aplikasi Kasir</h1>
                            <p class="lead">Selamat datang! Klik tombol di bawah untuk memulai pengaturan kasir.</p>
                            <a href="{{ route('step2') }}" id="btn-start" class="btn btn-light btn-lg mt-4 px-5 py-3">
                                <i class="fas fa-play me-2"></i> MULAI SETUP
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection