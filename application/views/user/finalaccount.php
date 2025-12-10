<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menggunakan variabel PHP untuk judul -->
    <title><?= $title; ?></title>

    <!-- Pemuatan CSS dan Library -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tailwind CSS (Script, digunakan untuk beberapa kelas responsif) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <style>
        /* Menggunakan font Inter */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            min-height: 100vh;
            color: #1e293b;
        }

        .main-container {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 95%;
        }

        /* ===== DataTables Styling ===== */
        #data-tabel thead {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #fff;
        }

        #data-tabel thead th {
            padding: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        #data-tabel tbody tr {
            background: #f8fafc;
        }

        #data-tabel tbody tr:hover {
            background: #e0f2fe;
        }

        #data-tabel td {
            padding: 0.75rem;
            color: #1e293b;
        }

        /* ===== 3D Button Styling ===== */
        .btn-3d {
            padding: 0.45rem 0.9rem;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 0.5rem;
            text-transform: uppercase;
            color: #fff !important;
            transition: 0.2s;
            border: none;
            /* Box-shadow memberikan efek 3D */
            box-shadow: 0 3px 0 rgba(0, 0, 0, 0.2);
        }

        .btn-3d:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 rgba(0, 0, 0, 0.25);
        }

        /* Warna Tombol */
        .btn-primary {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
        }

        .btn-success {
            background: #10b981;
        }

        .btn-warning {
            background: #f59e0b;
        }

        .btn-danger {
            background: #ef4444;
        }

        /* ===== Modals Styling ===== */
        .modal-header {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #fff;
        }

        .modal-content {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-body {
            background: #f8fafc;
        }

        .modal-footer {
            background: #f1f5f9;
            border-top: none;
        }

        /* ===== Optimasi Tampilan Kolom Tabel ===== */
        #data-tabel th,
        #data-tabel td {
            padding: 0.4rem 0.5rem !important;
            /* lebih kecil dari default */
            font-size: 0.85rem !important;
            vertical-align: middle !important;
            text-align: left;
            border-color: #e2e8f0 !important;
        }

        /* Batasi tinggi baris agar tabel lebih rapat */
        #data-tabel tbody tr {
            line-height: 1.2rem;
        }

        /* Batasi lebar kolom dan tambahkan ellipsis */
        #data-tabel td {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        /* Saat hover tampilkan teks penuh (tanpa tooltip) */
        #data-tabel td:hover {
            white-space: normal;
            overflow: visible;
            background-color: #e0f2fe !important;
            z-index: 10;
            position: relative;
        }

        /* Header table lebih ringkas dan elegan */
        #data-tabel thead th {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #fff;
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.4px;
            white-space: nowrap;
        }

        /* Supaya tabel tetap responsif */
        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
        }

        /* Baris ganjil genap agar mudah dibaca */
        #data-tabel tbody tr:nth-child(odd) {
            background-color: #f8fafc;
        }

        #data-tabel tbody tr:nth-child(even) {
            background-color: #f1f5f9;
        }

        #data-tabel tbody tr:hover {
            background-color: #e0f2fe !important;
        }

        .nav-tabs .nav-link {
            background: #e9ecef;
            border: none;
            color: #333;
            font-weight: 600;
            border-radius: 6px 6px 0 0;
            margin-right: 3px;
        }

        .nav-tabs .nav-link.active {
            background: #007bff;
            color: #fff;
        }

        .nav-tabs .nav-link {
            background: #e9ecef;
            border: none;
            color: #333;
            font-weight: 600;
            border-radius: 6px 6px 0 0;
            margin-right: 3px;
            transition: all 0.2s ease-in-out;
        }

        .nav-tabs .nav-link.active {
            background: #ffffff;
            color: #007bff;
            border-bottom: 3px solid #007bff;
            box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs .nav-link:hover {
            background: #f8fafc;
            color: #007bff;
        }
    </style>
</head>

<div class="container-fluid p-3">

    <h4 class="mb-3">Kontrak</h4>

    <!-- === NAVIGASI SHEET === -->
    <ul class="nav nav-tabs mb-3" id="sheetTabs">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-url="<?= base_url('user/finalaccount_table'); ?>">Kontrak Tokyo Riverside</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-url="<?= base_url('proyek/milenial/kontrak'); ?>">Kontrak Milenial</a>
        </li>
    </ul>

    <!-- === KONTEN YANG BERGANTI TANPA RELOAD === -->
    <div id="sheetContent" class="bg-white rounded shadow-sm p-3">
        <div class="text-center text-secondary p-5">
            <i class="fas fa-spinner fa-spin fa-2x mb-2"></i><br>
            Memuat data...
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<script>
    $(document).ready(function() {
        // Inisialisasi tab-sheet loader
        $('#sheetTabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            $('#sheetTabs .nav-link').removeClass('active');
            $(this).addClass('active');

            $('#sheetContent').html('<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x text-blue-500"></i><p class="mt-2">Memuat halaman...</p></div>');

            $('#sheetContent').load(url, function(response, status, xhr) {
                if (status === "success") {
                    // Setelah halaman selesai dimuat, aktifkan DataTables
                    if ($('#data-tabel').length) {
                        $('#data-tabel').DataTable({
                            responsive: true,
                            autoWidth: false,
                            language: {
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ data",
                                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                                paginate: {
                                    next: "›",
                                    previous: "‹"
                                }
                            }
                        });
                    }
                } else {
                    $('#sheetContent').html('<div class="text-center text-danger p-5">Gagal memuat halaman.</div>');
                }
            });
        });

        // Inisialisasi awal untuk halaman pertama
        if ($('#data-tabel').length) {
            $('#data-tabel').DataTable({
                responsive: true,
                autoWidth: false
            });
        }
    });
</script>