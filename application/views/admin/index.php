<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- PHP Title: Kept intact -->
    <title><?= $title; ?></title>

    <!-- 1. Bootstrap CSS (PENTING untuk Sidebar Collapse dan Modals) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- 2. Tailwind CSS CDN for modern styling (Dibuat setelah Bootstrap) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <!-- Custom Tailwind Configuration and Overrides -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        /* Background gradient */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            /* biru → cyan */
            color: #1e293b;
            /* slate-800 (teks utama) */
        }

        /* Container utama */
        .main-container {
            background-color: #ffffff;
            /* putih bersih */
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
            margin: 2rem auto;
            max-width: 95%;
            width: 100%;
            color: #1e293b;
        }

        /* DataTables Controls */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #1e293b !important;
            /* teks gelap */
        }

        /* Input search & dropdown */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background-color: #f1f5f9 !important;
            /* slate-100 */
            border: 1px solid #cbd5e1 !important;
            /* slate-300 */
            color: #1e293b !important;
            /* teks gelap */
            border-radius: 0.5rem;
            padding: 0.5rem;
            margin: 0 0.5rem;
        }

        /* Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #2563eb !important;
            /* biru utama */
            border-radius: 0.5rem !important;
            margin: 0 0.25rem !important;
            padding: 0.5rem 0.75rem !important;
            transition: all 0.2s;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background: linear-gradient(90deg, #3b82f6, #06b6d4) !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.4);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: #94a3b8 !important;
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ===== TABEL ===== */

        /* Header tabel (gradient lembut biru → cyan) */
        #data-tabel thead {
            display: table-header-group !important;
            background: linear-gradient(90deg, #3b82f6, #06b6d4) !important;
            color: #ffffff !important;
        }

        #data-tabel thead th {
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.75rem;
            border-bottom: 2px solid #0ea5e9;
        }

        /* Isi tabel */
        #data-tabel tbody tr {
            background-color: #f8fafc;
            /* putih keabu-abuan */
        }

        #data-tabel tbody tr:hover {
            background-color: #e0f2fe !important;
            /* biru muda hover */
        }

        #data-tabel td {
            color: #1e293b !important;
            /* teks gelap */
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
        }

        /* Column ke-4 agar wrap teks */
        #data-tabel th:nth-child(4),
        #data-tabel td:nth-child(4) {
            max-width: 200px;
            min-width: 200px;
            white-space: normal;
        }

        /* Judul & heading */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #1e293b !important;
        }

        /* ====== BUTTONS CERAH ====== */

        /* Base style */
        .btn-3d {
            position: relative;
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            top: 0;
            color: #fff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            border: none;
        }

        /* Teal button */
        .btn-3d.btn-teal {
            background-color: #14b8a6;
            /* teal-500 */
            box-shadow: 0 3px 0 #0f766e;
            /* lebih gelap */
        }

        .btn-3d.btn-teal:hover {
            background-color: #0d9488;
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #0f766e;
        }

        /* Indigo button */
        .btn-3d.btn-indigo {
            background-color: #4f46e5;
            /* indigo-600 */
            box-shadow: 0 3px 0 #3730a3;
        }

        .btn-3d.btn-indigo:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #3730a3;
        }

        /* Active state */
        .btn-3d:active {
            top: 2px;
            transform: translateY(0);
            box-shadow: none !important;
        }
    </style>
</head>

<div class="content-wrapper">
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-black-800">Dashboard Kontrak</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary">Total Kontrak</h6>
                            <h3><?= $kontrak_stats['total_kontrak']; ?></h3>
                        </div>
                        <i class="fas fa-file-contract fa-3x text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success">Total Perusahaan</h6>
                            <h3><?= $kontrak_stats['total_perusahaan']; ?></h3>
                        </div>
                        <i class="fas fa-building fa-3x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card border-success shadow-sm">
                    <div class="card-body">
                        <h6 class="text-success">Jumlah BAST 1</h6>
                        <h3><?= $summary_counts['total_bast1']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-warning shadow-sm">
                    <div class="card-body">
                        <h6 class="text-warning">Jumlah BAST 2</h6>
                        <h3><?= $summary_counts['total_bast2']; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-danger shadow-sm">
                    <div class="card-body">
                        <h6 class="text-danger">Final Account</h6>
                        <h3><?= $summary_counts['total_final_account']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header text-primary">Grafik Kontrak per Perusahaan</div>
            <div class="card-body" style="height: 400px;">
                <canvas id="kontrakChart"></canvas>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('kontrakChart').getContext('2d');
        var kontrakData = {
            labels: <?= json_encode(array_column($kontrak_summary, 'nama_pt')); ?>,
            datasets: [{
                label: 'Jumlah Kontrak',
                data: <?= json_encode(array_column($kontrak_summary, 'total_kontrak')); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: kontrakData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

</html>