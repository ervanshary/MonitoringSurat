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

    /* ===== CUSTOM SEARCH SUGGESTION ===== */
    .search-input-group {
        position: relative;
        width: 100%;
    }

    .search-input-group .form-control {
        border: 2px solid #e0e7ff;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafb;
    }

    .search-input-group .form-control:focus {
        border-color: #667eea;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .search-input-group .form-control::placeholder {
        color: #94a3b8;
        font-style: italic;
    }

    .suggestion-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
        margin-top: 8px;
        z-index: 1050;
        display: none;
    }

    .suggestion-dropdown.active {
        display: block;
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .suggestion-item {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #334155;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    .suggestion-item:hover {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        padding-left: 1.5rem;
    }

    .suggestion-item i {
        margin-right: 0.5rem;
        opacity: 0.7;
    }

    .suggestion-item:hover i {
        opacity: 1;
    }

    .suggestion-empty {
        padding: 2rem 1rem;
        text-align: center;
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .suggestion-empty i {
        display: block;
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .help-text-error {
        display: none;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #ef4444;
        animation: fadeIn 0.3s ease;
    }

    .help-text-error.active {
        display: flex;
        align-items: center;
    }

    .help-text-error i {
        margin-right: 0.5rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
    </style>
</head>

<body class="bg-gradient-to-r from-white via-cyan-100 to-cyan-400 min-h-screen">


    <div class="main-container mx-auto">
        <div class="row mb-3">
            <div class="col-lg-12">
                <!-- Flash Message (assuming CI session flashdata) -->
                <?= $this->session->flashdata('message'); ?>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#" class="btn btn-primary btn-3d mb-2 mr-2" data-toggle="modal" data-target="#newFaModal">
                        <i class="fas fa-plus mr-1"></i> Tambah Data
                    </a>
                    <div class="dropdown mb-2 mr-2">
                        <button class="btn btn-primary dropdown-toggle btn-3d" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown">
                            <i class="fas fa-file-import mr-1"></i> Import
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal-import-Fa">
                                <i class="fas fa-upload mr-1"></i> Upload File
                            </a>
                        </div>
                    </div>
                    <button id="backupButton" class="btn btn-primary btn-3d mb-2">
                        <i class="fas fa-database mr-1"></i> Backup Database
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabel Data Final Account -->
        <div class="table-responsive">
            <table class="table table-bordered" id="data-tabel" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Kontrak</th>
                        <th>Nama DC</th>
                        <th>Pekerjaan</th>
                        <th>Paket Pekerjaan</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP Looping untuk menampilkan data -->
                    <?php if (!empty($finalAccount)) : ?>
                    <?php $i = 1;
                        foreach ($finalAccount as $fa) : ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $fa['no_kontrak']; ?></td>
                        <td><?= $fa['nama_pt']; ?></td>
                        <td><?= $fa['pekerjaan']; ?></td>
                        <td><?= $fa['status']; ?></td>
                        <td><?= !empty($fa['created_by']) ? $fa['created_by'] : '-'; ?></td>
                        <td><?= !empty($fa['updated_by']) ? $fa['updated_by'] : '-'; ?></td>
                        <td>
                            <!-- Aksi: Detail, Edit, Delete -->
                            <div
                                class="flex flex-col md:flex-row items-center justify-center space-y-1 md:space-y-0 md:space-x-1">

                                <!-- Tombol Detail -->
                                <a href="#"
                                    class="btn-3d bg-teal-500 hover:bg-teal-600 text-white transition text-xs py-1 px-2 rounded-md btn-detail w-full md:w-auto"
                                    data-toggle="modal" data-target="#finalAccountDetailModal"
                                    data-id="<?= $fa['id']; ?>">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>

                                <!-- Tombol Edit (PENTING: Menggunakan class 'edit-btn' dan data-id) -->
                                <a href="#"
                                    class="btn-3d bg-indigo-500 hover:bg-indigo-600 text-white edit-btn transition text-xs py-1 px-2 rounded-md w-full md:w-auto"
                                    data-toggle="modal" data-target="#editFaModal" data-id="<?= $fa['id']; ?>">
                                    <i class="fas fa-pen mr-1"></i> Edit
                                </a>

                                <!-- Tombol Delete -->
                                <a href="#"
                                    class="btn-3d bg-red-500 hover:bg-red-600 text-white btn-delete transition text-xs py-1 px-2 rounded-md w-full md:w-auto"
                                    data-id="<?= $fa['id']; ?>">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </a>
                            </div>

                        </td>
                    </tr>
                    <?php $i++;
                        endforeach; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data yang tersedia</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal Import -->
        <div class="modal fade" id="Modal-import-Fa">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Final Account</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="<?= site_url('user/import') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="file_fa">File Excel</label>
                                <input type="file" class="form-control-file" name="file_fa" id="file_fa" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-3d">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editFaModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Final Account</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="editForm" action="<?= base_url('user/finalaccount_update'); ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="editId">
                            <input type="hidden" id="createdBy" name="created_by">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>No Kontrak</label>
                                    <!-- ID dan Name penting untuk pengisian data -->
                                    <input type="text" class="form-control" id="no_kontrak" name="no_kontrak">
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">
                                        <i class="fas fa-building"
                                            style="color: #667eea; margin-right: 0.5rem;"></i>Nama DC
                                    </label>
                                    <div class="search-input-group">
                                        <input type="text" class="form-control edit-nama-pt" id="nama_pt" name="nama_pt"
                                            placeholder="Ketik nama DC..." autocomplete="off">
                                        <div class="suggestion-dropdown edit-nama-pt-dropdown"></div>
                                    </div>
                                    <small class="help-text-error edit-nama-pt-help">
                                        <i class="fas fa-exclamation-circle"></i> Data tidak ditemukan
                                    </small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Paket Pekerjaan</label>
                                    <input type="text" class="form-control" id="status" name="status">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Created By</label>
                                    <input type="text" class="form-control" id="displayCreatedBy" readonly
                                        style="background-color: #e9ecef; cursor: not-allowed;">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Updated By</label>
                                    <input type="text" class="form-control" id="displayUpdatedBy" readonly
                                        style="background-color: #e9ecef; cursor: not-allowed;">
                                </div>
                            </div>
                            <!-- CATATAN: Karena modal body diganti oleh loading spinner, 
                                elemen form ini harus disalin di JS untuk mengembalikan state awal -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-3d">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="finalAccountDetailModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Kontrak Final Account</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Konten Detail akan diisi oleh AJAX atau JS terpisah (tidak ada di skrip ini) -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>No Kontrak</h6>
                                    <p id="modalNoKontrak" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Nama DC</h6>
                                    <p id="modalNamaPT" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Pekerjaan</h6>
                                    <p id="modalPekerjaan" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Paket Pekerjaan</h6>
                                    <p id="modalStatus" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Created By</h6>
                                    <p id="modalCreatedBy" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Updated By</h6>
                                    <p id="modalUpdatedBy" class="text-muted"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="newFaModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Baru</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="<?= base_url('user/finalaccount'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>No Kontrak</label>
                                <input type="text" class="form-control" name="no_kontrak">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">
                                    <i class="fas fa-building" style="color: #667eea; margin-right: 0.5rem;"></i>Nama DC
                                </label>
                                <div class="search-input-group">
                                    <input type="text" class="form-control add-nama-pt" name="nama_pt"
                                        placeholder="Ketik nama DC..." autocomplete="off">
                                    <div class="suggestion-dropdown add-nama-pt-dropdown"></div>
                                </div>
                                <small class="help-text-error add-nama-pt-help">
                                    <i class="fas fa-exclamation-circle"></i> Data tidak ditemukan
                                </small>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" name="pekerjaan">
                            </div>
                            <div class="form-group">
                                <label>Paket Pekerjaan</label>
                                <input type="text" class="form-control" name="status">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                <label class="form-check-label">Active?</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-3d">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Pemuatan JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- Script Utama (Gabungan Logika) -->
    <script>
    // Pastikan kode ini berjalan setelah DOM dimuat sepenuhnya
    $(document).ready(function() {

        // Klik tombol edit
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();

            const finalAccountId = $(this).data('id');
            const modal = $('#editFaModal');

            // Simpan konten modal asli
            const originalModalBodyContent = modal.find('.modal-body').html();

            // Tampilkan loading spinner
            modal.find('.modal-body').html(`
            <div class="text-center p-5">
                <i class="fas fa-spinner fa-spin fa-2x text-indigo-500"></i>
                <p class="mt-2">Memuat data...</p>
            </div>
        `);

            modal.modal('show');

            // AJAX GET data
            $.ajax({
                url: '<?= base_url('user/get_finalaccount_data'); ?>/' + finalAccountId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Kembalikan konten modal asli
                    modal.find('.modal-body').html(originalModalBodyContent);

                    if (response.status && response.status === 'success' && response.data) {
                        const data = response.data;

                        // Isi form modal
                        $('#editFaModal #editId').val(data.id || '');
                        $('#editFaModal #no_kontrak').val(data.no_kontrak || '');
                        $('#editFaModal #nama_pt').val(data.nama_pt || '');
                        $('#editFaModal #pekerjaan').val(data.pekerjaan || '');
                        $('#editFaModal #status').val(data.status || '');
                        $('#editFaModal #createdBy').val(data.created_by || '');
                        $('#editFaModal #displayCreatedBy').val(data.created_by || '-');
                        $('#editFaModal #displayUpdatedBy').val(data.updated_by || '-');
                    } else {
                        // Jika error dari server
                        alert(response.message || 'Data tidak ditemukan.');
                    }
                },
                error: function(xhr, status, error) {
                    // Kembalikan modal asli
                    modal.find('.modal-body').html(originalModalBodyContent);

                    // Cek apakah response berisi HTML (404) atau JSON
                    let msg = 'Terjadi kesalahan saat mengambil data.';
                    try {
                        const json = JSON.parse(xhr.responseText);
                        if (json.message) msg = json.message;
                    } catch (e) {
                        // Tetap tampilkan pesan default
                    }

                    alert(msg);
                    console.error('AJAX Error:', status, error, xhr.responseText);
                }
            });
        });


        // Tombol Detail
        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();

            const finalAccountId = $(this).data('id');
            const modal = $('#finalAccountDetailModal');

            // Tampilkan loading spinner
            modal.find('.modal-body').html(`
                    <div class="text-center p-5">
                        <i class="fas fa-spinner fa-spin fa-2x text-indigo-500"></i>
                        <p class="mt-2">Memuat data...</p>
                    </div>
                `);

            modal.modal('show');

            // AJAX GET data
            $.ajax({
                url: '<?= base_url('user/get_finalaccount_data'); ?>/' + finalAccountId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status && response.status === 'success' && response.data) {
                        const data = response.data;

                        // Isi modal detail
                        $('#finalAccountDetailModal #modalNoKontrak').text(data
                            .no_kontrak || '-');
                        $('#finalAccountDetailModal #modalNamaPT').text(data.nama_pt ||
                            '-');
                        $('#finalAccountDetailModal #modalPekerjaan').text(data.pekerjaan ||
                            '-');
                        $('#finalAccountDetailModal #modalStatus').text(data.status || '-');
                        $('#finalAccountDetailModal #modalCreatedBy').text(data
                            .created_by || '-');
                        $('#finalAccountDetailModal #modalUpdatedBy').text(data
                            .updated_by || '-');
                    } else {
                        alert(response.message || 'Data tidak ditemukan.');
                        modal.modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    let msg = 'Terjadi kesalahan saat mengambil data.';
                    try {
                        const json = JSON.parse(xhr.responseText);
                        if (json.message) msg = json.message;
                    } catch (e) {
                        // Tetap tampilkan pesan default
                    }
                    alert(msg);
                    modal.modal('hide');
                }
            });
        });


        // Tombol Backup Database
        $('#backupButton').on('click', function(e) {
            e.preventDefault();

            if (!confirm("Yakin ingin melakukan backup database?")) return;

            window.location.href = "<?= base_url('User/backup_database'); ?>";
        });

        // ===== CUSTOM SEARCH SUGGESTION UNTUK NAMA PT =====
        var finalAccountData = <?= json_encode(array_column($finalAccount, 'nama_pt')); ?>;
        var uniqueNamaPt = Array.from(new Set(finalAccountData));
        var ptOptions = uniqueNamaPt.map(function(item) {
            return {
                id: item,
                text: item
            };
        });

        // Function untuk render suggestions Edit
        function renderEditSuggestions(term) {
            var dropdown = $('.edit-nama-pt-dropdown');
            dropdown.empty();
            if (!term) {
                dropdown.removeClass('active');
                return;
            }

            var filtered = ptOptions.filter(function(item) {
                return item.text.toLowerCase().indexOf(term.toLowerCase()) !== -1;
            });

            if (filtered.length === 0) {
                dropdown.html(
                    '<div class="suggestion-empty"><i class="fas fa-search"></i><div>Tidak ada data yang cocok</div></div>'
                    );
                dropdown.addClass('active');
                $('.edit-nama-pt-help').addClass('active');
            } else {
                var html = '';
                filtered.forEach(function(item) {
                    html += '<div class="suggestion-item" data-value="' + item.text + '">' +
                        '<i class="fas fa-briefcase"></i>' + item.text +
                        '</div>';
                });
                dropdown.html(html);
                dropdown.addClass('active');
                $('.edit-nama-pt-help').removeClass('active');
            }
        }

        // Function untuk render suggestions Add
        function renderAddSuggestions(term) {
            var dropdown = $('.add-nama-pt-dropdown');
            dropdown.empty();
            if (!term) {
                dropdown.removeClass('active');
                return;
            }

            var filtered = ptOptions.filter(function(item) {
                return item.text.toLowerCase().indexOf(term.toLowerCase()) !== -1;
            });

            if (filtered.length === 0) {
                dropdown.html(
                    '<div class="suggestion-empty"><i class="fas fa-search"></i><div>Tidak ada data yang cocok</div></div>'
                    );
                dropdown.addClass('active');
                $('.add-nama-pt-help').addClass('active');
            } else {
                var html = '';
                filtered.forEach(function(item) {
                    html += '<div class="suggestion-item" data-value="' + item.text + '">' +
                        '<i class="fas fa-briefcase"></i>' + item.text +
                        '</div>';
                });
                dropdown.html(html);
                dropdown.addClass('active');
                $('.add-nama-pt-help').removeClass('active');
            }
        }

        // Event listener untuk Edit Modal
        $(document).on('input', '.edit-nama-pt', function() {
            var val = $(this).val().trim();
            renderEditSuggestions(val);
        });

        $(document).on('focus', '.edit-nama-pt', function() {
            if ($(this).val().trim()) {
                renderEditSuggestions($(this).val().trim());
            }
        });

        // Event listener untuk Add Modal
        $(document).on('input', '.add-nama-pt', function() {
            var val = $(this).val().trim();
            renderAddSuggestions(val);
        });

        $(document).on('focus', '.add-nama-pt', function() {
            if ($(this).val().trim()) {
                renderAddSuggestions($(this).val().trim());
            }
        });

        // Klik pada suggestion item Edit
        $(document).on('click', '.edit-nama-pt-dropdown .suggestion-item', function() {
            var value = $(this).data('value');
            $('.edit-nama-pt').val(value);
            $('.edit-nama-pt-dropdown').removeClass('active');
            $('.edit-nama-pt-help').removeClass('active');
        });

        // Klik pada suggestion item Add
        $(document).on('click', '.add-nama-pt-dropdown .suggestion-item', function() {
            var value = $(this).data('value');
            $('.add-nama-pt').val(value);
            $('.add-nama-pt-dropdown').removeClass('active');
            $('.add-nama-pt-help').removeClass('active');
        });

        // Close dropdown saat klik di luar
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-input-group').length) {
                $('.suggestion-dropdown').removeClass('active');
            }
        });

    });
    </script>
</body>

</html>