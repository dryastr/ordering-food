@extends('layouts.main')

@section('title', 'Dashboard Pelayan')

@section('content')
    <div class="row justify-content-center align-items-center" style="height: 75vh">
        <div class="col-12 text-center">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Selamat Datang, {{Auth::user()->name}}!</h4>
                </div>
                <div class="card-body">
                    <p class="lead">Ini adalah dashboard utama Anda. Silakan klik tombol di bawah untuk melihat daftar pesanan yang ada.</p>
                    <a href="{{ url('/list-orders-waitress') }}" class="btn btn-primary">Lihat Pesanan</a>
                </div>
            </div>
        </div>
    </div>
@endsection
