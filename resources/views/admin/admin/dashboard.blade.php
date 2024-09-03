@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container">
        <h2>Total Karyawan: {{ $totalEmployees }}</h2>
        <h3>Total Pendapatan: Rp {{ number_format($totalRevenue, 2, ',', '.') }}</h3>

        <div class="card">
            <div class="card-header">
                <h4>Grafik Pendapatan per Hari</h4>
            </div>
            <div class="card-body">
                <canvas id="dailyRevenueChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('dailyRevenueChart').getContext('2d');

            var dailyRevenueChart = new Chart(ctx, {
                type: 'line', // Jenis grafik garis
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Pendapatan per Hari',
                        data: @json($dailyRevenue),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
