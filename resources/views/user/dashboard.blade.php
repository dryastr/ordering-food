@extends('layouts.main')

@section('title', 'Dashboard Pengguna')

@section('content')
    <div class="row">
        <!-- Card for Total Orders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Total Orderan</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalOrders }}</h5>
                    <p class="card-text">Total orderan yang telah Anda lakukan.</p>
                </div>
            </div>
        </div>

        <!-- Card for Total Purchase -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Total Pembelian</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($totalPurchase, 2, ',', '.') }}</h5>
                    <p class="card-text">Total pembelian yang telah Anda lakukan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik (misalnya menggunakan Chart.js) -->
    <div class="row">
        <div class="col-md-12">
            <canvas id="orderChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('orderChart').getContext('2d');
        var orderChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Orderan', 'Total Pembelian'],
                datasets: [{
                    label: 'Statistik Pengguna',
                    data: [{{ $totalOrders }}, {{ $totalPurchase }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
