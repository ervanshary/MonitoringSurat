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

    <!-- === ALERT INFO UNTUK ADMIN === -->
    <?php if ($this->session->userdata('role') == 'admin') : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle mr-2"></i>
        <strong>Admin Tools:</strong>
        <button type="button" class="btn btn-sm btn-warning" id="btnFillCreatedBy">
            <i class="fas fa-edit mr-1"></i> Isi Created By Data Lama
        </button>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- === NAVIGASI SHEET === -->
    <ul class="nav nav-tabs mb-3" id="sheetTabs">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-url="<?= base_url('user/finalaccount_table'); ?>">Kontrak Tokyo
                Riverside</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-url="<?= base_url('user/finalaccount_milenial_table'); ?>">Kontrak
                Milenial</a>
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

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

<!-- === MODAL UNTUK FILL CREATED BY === -->
<div class="modal fade" id="fillCreatedByModal" tabindex="-1" role="dialog" aria-labelledby="fillCreatedByModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="fillCreatedByModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Isi Created By Data Lama
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong>Perhatian!</strong> Tindakan ini akan mengisi semua data kosong di kolom
                    <code>created_by</code> dengan "Admin". <br>
                    <strong>Tindakan ini TIDAK BISA DIBATALKAN!</strong>
                </div>

                <form id="fillCreatedByForm">
                    <div class="form-group">
                        <label class="font-weight-bold">Pilih Tabel untuk Diupdate:</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chkBast1" name="tables"
                                value="user_bast" checked>
                            <label class="custom-control-label" for="chkBast1">
                                <i class="fas fa-file mr-1"></i> BAST 1 (Asbuilt)
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chkBast2" name="tables"
                                value="user_bast2" checked>
                            <label class="custom-control-label" for="chkBast2">
                                <i class="fas fa-file mr-1"></i> BAST 2 (Tanda Tangan)
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chkFinalAccount" name="tables"
                                value="user_final_account" checked>
                            <label class="custom-control-label" for="chkFinalAccount">
                                <i class="fas fa-file mr-1"></i> Final Account
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chkMilenial" name="tables"
                                value="user_final_account_milenial" checked>
                            <label class="custom-control-label" for="chkMilenial">
                                <i class="fas fa-file mr-1"></i> Final Account Milenial
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">User yang Akan Diisi:</label>
                        <input type="text" class="form-control" value="Admin" readonly>
                        <small class="text-muted">Semua data kosong akan diisi dengan user "Admin"</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmFill">
                    <i class="fas fa-check mr-1"></i> Ya, Isi Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // ===== HANDLE FILL CREATED BY BUTTON =====
    $('#btnFillCreatedBy').on('click', function() {
        $('#fillCreatedByModal').modal('show');
    });

    // ===== CONFIRM FILL CREATED BY =====
    $('#btnConfirmFill').on('click', function() {
        var tables = [];
        $('input[name="tables"]:checked').each(function() {
            tables.push($(this).val());
        });

        if (tables.length === 0) {
            Swal.fire('Error', 'Pilih minimal satu tabel!', 'error');
            return;
        }

        // Konfirmasi final
        Swal.fire({
            title: 'Konfirmasi Final',
            html: 'Anda yakin ingin mengisi <strong>created_by</strong> dengan "Admin" untuk:<br>' +
                tables.join(', ') +
                '<br><br><strong class="text-danger">Tindakan ini TIDAK bisa dibatalkan!</strong>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proses fill
                $.ajax({
                    url: '<?= base_url('user/fill_created_by_all') ?>',
                    type: 'POST',
                    data: {
                        tables: tables
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#fillCreatedByModal').modal('hide');
                        Swal.fire({
                            title: 'Berhasil!',
                            html: response.message,
                            icon: 'success',
                            timer: 3000
                        });
                        // Reload halaman setelah 3 detik
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    error: function(xhr) {
                        var errorMsg = xhr.responseJSON?.message ||
                            'Terjadi error saat memproses data';
                        Swal.fire('Error', errorMsg, 'error');
                    }
                });
            }
        });
    });

    // Inisialisasi tab-sheet loader
    $('#sheetTabs .nav-link').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        $('#sheetTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        $('#sheetContent').html(
            '<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x text-blue-500"></i><p class="mt-2">Memuat halaman...</p></div>'
        );

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
                $('#sheetContent').html(
                    '<div class="text-center text-danger p-5">Gagal memuat halaman.</div>');
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