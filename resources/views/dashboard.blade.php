@extends('layouts.villa')

@section('content')

    {{-- KRUSIAL: LOGIKA PEMISAH TAMPILAN BERDASARKAN PERAN PENGGUNA --}}
    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'Staff')

        {{-- TAMPILAN KHUSUS ADMIN/STAFF --}}
        <div class="dashboard-page-wrapper">
            <div class="content-wrapper">
                
                {{-- Bagian Judul (Tetap) --}}
                <h1 class="dashboard-title">
                    Selamat Datang di Dashboard Admin Villa Manayasa
                </h1>
                <p class="dashboard-subtitle">
                    Ringkasan cepat status villa dan pemesanan terbaru.
                </p>

                {{-- Bagian Statistik Utama (Tetap) --}}
                <div class="stats-grid">
                    
                    {{-- Kartu 1: Kamar Tersedia --}}
                    <div class="stat-card stat-card-available">
                        <span class="stat-value">{{ $statsKamar['available'] }}</span>
                        <span class="stat-label">Kamar Tersedia</span>
                        <span class="stat-meta">dari {{ $statsKamar['total_units'] }} Unit</span>
                        <i class="fas fa-check-circle stat-icon"></i>
                    </div>

                    {{-- Kartu 2: Pemesanan Hari Ini --}}
                    <div class="stat-card stat-card-booking">
                        <span class="stat-value">{{ $pemesananHariIni }}</span> 
                        <span class="stat-label">Pemesanan Check-in Hari Ini</span>
                        <span class="stat-meta">Siapkan Kamar Sesuai Jadwal</span>
                        <i class="fas fa-calendar-alt stat-icon"></i>
                    </div>

                    {{-- Kartu 3: Dalam Pembersihan --}}
                    <div class="stat-card stat-card-cleaning">
                        <span class="stat-value">{{ $statsKamar['cleaning'] }}</span>
                        <span class="stat-label">Dalam Pembersihan</span>
                        <span class="stat-meta">Beban Kerja Housekeeping</span>
                        <i class="fas fa-broom stat-icon"></i>
                    </div>
                    
                    {{-- Kartu 4: Total Akun Staff/Admin --}}
                    <div class="stat-card stat-card-staff">
                        <span class="stat-value">{{ $totalStaffAdmin }}</span>
                        <span class="stat-label">Total Akun Staff/Admin</span>
                        <span class="stat-meta">Pengguna Sistem</span>
                        <i class="fas fa-users stat-icon"></i>
                    </div>
                    
                </div>
                
                {{-- Bagian Detail (List & Chart) --}}
                <div class="detail-section">
                    
                    {{-- KARTU DETAIL LIST (CARD LAYOUT DENGAN PEWARNAAN) --}}
                    <div class="detail-card detail-card-booking-list">
                        <h3 class="detail-card-title">Detail Pemesanan Check-in Hari Ini ({{ \Carbon\Carbon::now()->format('d F Y') }})</h3>
                        
                        @if ($todayBookings->isEmpty())
                            <div class="booking-list-item no-booking">
                                <i class="fas fa-info-circle"></i>
                                Tidak ada pemesanan Check-in hari ini. Villa Siap!
                            </div>
                        @else
                            {{-- Container untuk Card Layout --}}
                            <div class="booking-card-container">
                                @foreach ($todayBookings as $booking)
                                    <div class="booking-card">
                                        {{-- Baris 1: Tipe Kamar & Nomor Kamar (Header) --}}
                                        <div class="card-header">
                                            <i class="fas fa-bed card-icon"></i>
                                            <span class="card-room-type">
                                                {{ $booking->kamar->tipe_kamar ?? 'Kamar Dihapus' }} 
                                                - ROOM {{ $booking->kamar->nomor_kamar ?? '' }}
                                            </span>
                                        </div>

                                        {{-- Baris 2: Detail Tamu & Check-in (Body) --}}
                                        <div class="card-body-grid">
                                            <div class="detail-item">
                                                <span class="label">Tamu Utama:</span>
                                                <span class="value">{{ $booking->user->name ?? $booking->guest_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Check-in:</span>
                                                <span class="value date date-highlight">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Durasi:</span>
                                                <span class="value duration duration-highlight">{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} Malam</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Kartu Distribusi Status Kamar (Chart) --}}
                    <div class="detail-card detail-card-chart">
                        <h3 class="detail-card-title">Distribusi Status Kamar</h3>
                        <div class="chart-container">
                            <canvas id="roomStatusChart"></canvas>
                        </div>
                        <div class="status-list">
                            <p><strong>Total Unit:</strong> {{ $statsKamar['total_units'] }}</p>
                            <p class="text-available">Tersedia: {{ $statsKamar['available'] }}</p>
                            <p class="text-occupied">Ditempati: {{ $statsKamar['occupied'] }}</p>
                            <p class="text-cleaning">Pembersihan: {{ $statsKamar['cleaning'] }}</p>
                            <p class="text-maintenance">Perbaikan: {{ $statsKamar['maintenance'] }}</p>
                            @if($statsKamar['other'] > 0)
                            <p class="text-other">Lain-lain: {{ $statsKamar['other'] }}</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div> 
        </div> 

    @else
        
        {{-- TAMPILAN KHUSUS TAMU/USER: Panggil file terpisah --}}
        @include('dashboard-guest')
        
    @endif

    {{-- KRUSIAL: BLOK STYLE DAN SCRIPT HANYA UNTUK ADMIN/STAFF --}}
    @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'Staff'))
        @push('styles')
        <style>
            /* ------------------------------------------------------------------- */
            /* GENERAL STYLES & LAYOUT */
            /* ------------------------------------------------------------------- */
            .dashboard-page-wrapper {
                padding: 20px;
                background-color: #f4f7f9;
                /* Hapus min-height: 100vh agar tidak bentrok dengan footer */
                font-family: 'Inter', sans-serif;
            }
            .content-wrapper {
                /* Perbaikan: Menggunakan max-width dan margin auto untuk membatasi lebar konten */
                max-width: 1200px;
                margin: 0 auto; 
                padding: 0 15px; /* Tambahkan padding agar tidak terlalu mepet ke tepi layar */
            }
            .dashboard-title {
                font-size: 2rem;
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 5px;
            }
            .dashboard-subtitle {
                color: #666;
                margin-bottom: 30px;
            }
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }
            .stat-card {
                padding: 20px;
                border-radius: 12px;
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: flex-start;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
                min-height: 120px;
            }
            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
                border-radius: 12px;
                z-index: 1;
            }
            .stat-value {
                font-size: 2.5rem;
                font-weight: 800;
                line-height: 1;
                z-index: 2;
            }
            .stat-label, .stat-meta {
                display: block;
                z-index: 2;
                margin-top: 5px;
            }
            .stat-icon {
                font-size: 3.5rem;
                opacity: 0.3;
                position: absolute;
                right: 20px;
                bottom: 10px;
                z-index: 0;
            }
            /* Colors */
            .stat-card-available { background-color: #1e6a41; } 
            .stat-card-booking { background-color: #4B0082; } 
            .stat-card-cleaning { background-color: #ffc107; color: #333; } 
            .stat-card-staff { background-color: #343a40; } 

            /* ------------------------------------------------------------------- */
            /* DETAIL SECTION (LIST & CHART) */
            /* ------------------------------------------------------------------- */
            .detail-section {
                display: grid;
                grid-template-columns: 2fr 1fr; 
                gap: 20px;
            }
            .detail-card {
                background-color: white;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }
            .detail-card-chart {
                display: flex;
                flex-direction: column;
            }
            .chart-container {
                flex-grow: 1;
                position: relative;
                min-height: 250px; 
            }
            .detail-card-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #333;
                border-bottom: 1px solid #eee;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }
            
            /* ------------------------------------------------------------------- */
            /* CARD LAYOUT STYLES (LIST PEMESANAN) */
            /* ------------------------------------------------------------------- */
            .booking-card-container {
                display: flex;
                flex-direction: column;
                gap: 15px; 
            }
            .booking-card {
                /* Menggunakan !important hanya jika benar-benar diperlukan untuk menimpa villa.css */
                border: 1px solid #cce5ff !important; 
                border-left: 5px solid #007bff !important; /* Garis Biru Kuat */
                border-radius: 8px !important;
                padding: 15px 20px !important;
                background-color: #e9f5ff !important; /* Latar Belakang Biru Muda */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05) !important;
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .booking-card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
                transform: translateY(-2px);
            }

            .card-header {
                display: flex;
                align-items: center;
                padding-bottom: 10px;
                border-bottom: 1px dashed #b8daff; 
                margin-bottom: 10px;
            }
            .card-icon {
                color: #007bff; 
                font-size: 1.2rem;
                margin-right: 10px;
            }
            .card-room-type {
                font-weight: 700;
                font-size: 1.1rem;
                color: #0056b3; 
            }

            .card-body-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 15px;
            }
            .detail-item {
                font-size: 0.85rem;
                padding: 5px 0;
            }
            .detail-item .label {
                display: block;
                font-weight: 500;
                color: #495057; 
                margin-bottom: 2px;
                font-size: 0.75rem;
                text-transform: uppercase;
            }
            .detail-item .value {
                font-weight: 700;
                color: #1a1a1a;
                display: block;
                font-size: 0.95rem;
            }
            
            /* Highlight khusus untuk Durasi dan Tanggal Check-in */
            .date-highlight {
                color: #28a745 !important; 
                background-color: #d4edda !important;
                padding: 3px 6px !important;
                border-radius: 4px !important;
                display: inline-block !important;
                font-weight: 700 !important;
            }
            .duration-highlight {
                color: #dc3545 !important; 
                background-color: #f8d7da !important;
                padding: 3px 6px !important;
                border-radius: 4px !important;
                display: inline-block !important;
                font-weight: 700 !important;
            }


            /* Status List Colors (Untuk Chart) */
            .status-list {
                margin-top: 20px;
                padding-top: 15px;
                border-top: 1px solid #eee;
                font-size: 0.85rem; 
            }
            .status-list p {
                margin-bottom: 5px;
            }
            .text-available { color: #1e6a41; } 
            .text-occupied { color: #4B0082; } 
            .text-cleaning { color: #ffc107; } 
            .text-maintenance { color: #dc3545; } 
            .text-other { color: #999; }

            /* ------------------------------------------------------------------- */
            /* RESPONSIVENESS */
            /* ------------------------------------------------------------------- */
            @media (max-width: 1024px) {
                .detail-section {
                    grid-template-columns: 1fr;
                }
                .detail-card-chart {
                    order: -1; 
                }
            }
            @media (max-width: 600px) {
                .stat-card-icon { display: none; }
                .stat-card { padding: 15px; }
                .dashboard-title { font-size: 1.5rem; }
                .card-body-grid {
                    /* Tumpuk detail di mobile */
                    grid-template-columns: 1fr; 
                }
            }
        </style>
        @endpush

        @push('scripts')
        <script>
            // Pastikan Chart.js dimuat sebelum skrip ini
            // Anda sudah memuatnya di layouts/villa.blade.php
            
            document.addEventListener('DOMContentLoaded', function () {
                // Data diambil dari PHP (tetap)
                const roomStats = {
                    available: {{ $statsKamar['available'] ?? 0 }},
                    occupied: {{ $statsKamar['occupied'] ?? 0 }},
                    cleaning: {{ $statsKamar['cleaning'] ?? 0 }},
                    maintenance: {{ $statsKamar['maintenance'] ?? 0 }},
                    other: {{ $statsKamar['other'] ?? 0 }},
                };
                const chartData = [
                    roomStats.available,
                    roomStats.occupied,
                    roomStats.cleaning,
                    roomStats.maintenance
                ];
                const totalUnitsInChart = chartData.reduce((a, b) => a + b, 0);
                const chartCanvas = document.getElementById('roomStatusChart');

                if (!chartCanvas) {
                    // Berhenti jika kanvas tidak ditemukan
                    return;
                }

                if (totalUnitsInChart === 0) {
                    chartCanvas.style.display = 'none';
                    const chartContainer = document.querySelector('.chart-container');
                    if (chartContainer) {
                        chartContainer.innerHTML = '<p class="text-center text-gray-500 mt-5">Tidak ada data unit yang tercatat untuk diagram ini.</p>';
                    }
                    return;
                }

                const ctx = chartCanvas.getContext('2d');
                const roomStatusChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Tersedia', 'Ditempati', 'Pembersihan', 'Perbaikan'],
                        datasets: [{
                            data: chartData,
                            backgroundColor: ['#1e6a41', '#4B0082', '#ffc107', '#dc3545'],
                            hoverBackgroundColor: ['#28a745', '#6f42c1', '#ffda6a', '#c82333'],
                            borderWidth: 0,
                            borderRadius: 5,
                            spacing: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%', 
                        plugins: {
                            legend: {
                                display: false // Legenda dinonaktifkan karena sudah ada di bawah chart
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        const total = chartData.reduce((a, b) => a + b, 0);
                                        const value = tooltipItem.raw;
                                        const percentage = ((value / total) * 100).toFixed(1) + '%';
                                        return tooltipItem.label + ': ' + value + ' Unit (' + percentage + ')';
                                    }
                                }
                            }
                        }
                    }
                });

                // Memperbaiki resize, gunakan method destroy jika ingin rebuild chart
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                         roomStatusChart.resize();
                    }, 250);
                });
            });
        </script>
        @endpush
    @endif

@endsection