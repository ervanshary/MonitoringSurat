<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Bootstrap & Tailwind -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: #1e293b;
    }

    .main-container {
        background-color: #ffffff;
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
        margin: 2rem auto;
        max-width: 95%;
        width: 100%;
        color: #1e293b;
    }

    /* ====== DataTables UI ====== */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
        color: #1e293b !important;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        background-color: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        color: #1e293b !important;
        border-radius: 0.5rem;
        padding: 0.5rem;
        margin: 0 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #2563eb !important;
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

    /* ====== OPTIMASI TABEL ====== */
    #asbuilt-data-tabel th,
    #asbuilt-data-tabel td {
        padding: 0.4rem 0.5rem !important;
        font-size: 0.85rem !important;
        vertical-align: middle !important;
        border-color: #e2e8f0 !important;
    }

    #asbuilt-data-tabel thead th {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: #fff;
        text-transform: uppercase;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    #asbuilt-data-tabel td {
        max-width: 160px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        position: relative;
    }

    #asbuilt-data-tabel td:hover {
        white-space: normal;
        overflow: visible;
        background-color: #e0f2fe !important;
        z-index: 10;
        position: relative;
    }

    #asbuilt-data-tabel tbody tr:nth-child(odd) {
        background-color: #f8fafc;
    }

    #asbuilt-data-tabel tbody tr:nth-child(even) {
        background-color: #f1f5f9;
    }

    #asbuilt-data-tabel tbody tr:hover {
        background-color: #e0f2fe !important;
    }

    .table-responsive {
        overflow-x: auto;
        max-width: 100%;
    }

    /* ====== BUTTONS CERAH ====== */
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

    .btn-3d.btn-teal {
        background-color: #14b8a6;
        box-shadow: 0 3px 0 #0f766e;
    }

    .btn-3d.btn-teal:hover {
        background-color: #0d9488;
        transform: translateY(-2px);
        box-shadow: 0 5px 0 #0f766e;
    }

    .btn-3d:active {
        top: 2px;
        transform: translateY(0);
        box-shadow: none !important;
    }

    /* ===== MODERN FORM STYLING ===== */
    .modal-body .form-control:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
        outline: none;
        transition: all 0.3s ease;
    }

    .modal-body .form-control {
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .modal-body textarea.form-control:focus {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
    }

    .modal-body input[type="date"].form-control:focus {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
    }

    /* Hover effects untuk input readonly */
    .modal-body input[readonly] {
        cursor: not-allowed;
        opacity: 0.75;
    }

    /* Modal smooth animation */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }

    /* Button hover effects */
    .modal-footer .btn-light:hover {
        background: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2) !important;
    }

    .modal-footer button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5) !important;
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
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary mb-3 btn-3d" data-toggle="modal"
                    data-target="#newAsBuiltDrawingModal">Tambah Data</button>
                <div class="table-responsive">
                    <table class="table table-bordered mb-3" id="asbuilt-data-tabel" width="100%">
                        <thead class="thead-light">
                            <tr>

                                <th scope="col">ID</th>
                                <th scope="col">No Kontrak</th>
                                <th scope="col">Nama PT</th>
                                <th scope="col">Pekerjaan</th>
                                <th scope="col">Tanggal Terima</th>
                                <th scope="col">Paket Pekerjaan</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asBuiltData as $row) : ?>
                            <tr>

                                <td><?= $row['id_asbuilt']; ?></td>
                                <td><?= $row['no_kontrak']; ?></td>
                                <td><?= $row['nama_pt']; ?></td>
                                <td><?= $row['pekerjaan']; ?></td>
                                <td><?= $row['tgl_terima']; ?></td>
                                <td><?= $row['status']; ?></td>
                                <td><?= $row['keterangan']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-detail" data-toggle="modal"
                                        data-target="#detailModal" data-id="<?= $row['id_asbuilt']; ?>"
                                        data-nokontrak="<?= $row['no_kontrak']; ?>"
                                        data-namapt="<?= $row['nama_pt']; ?>" data-pekerjaan="<?= $row['pekerjaan']; ?>"
                                        data-tglterima="<?= $row['tgl_terima']; ?>" data-status="<?= $row['status']; ?>"
                                        data-keterangan="<?= $row['keterangan']; ?>">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                        data-target="#editModal" data-id="<?= $row['id_asbuilt']; ?>"
                                        data-nokontrak="<?= $row['no_kontrak']; ?>"
                                        data-namapt="<?= $row['nama_pt']; ?>" data-pekerjaan="<?= $row['pekerjaan']; ?>"
                                        data-tglterima="<?= $row['tgl_terima']; ?>" data-status="<?= $row['status']; ?>"
                                        data-keterangan="<?= $row['keterangan']; ?>">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                </td>
                            </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- === DETAIL MODAL (MODERN DESIGN) === -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; background: #fff;">

                <!-- Header with Gradient -->
                <div class="modal-header border-0"
                    style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 12px 12px 0 0; padding: 2rem;">
                    <div>
                        <h5 class="modal-title text-white font-weight-bold" id="detailModalLabel"
                            style="font-size: 1.5rem;">
                            <i class="fas fa-search-plus mr-2"></i> Detail Asbuilt Drawing
                        </h5>
                        <small class="text-light opacity-75">Informasi lengkap data Asbuilt Drawing</small>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        style="font-size: 1.5rem; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4" style="background: #fff;">

                    <!-- Section 1: Informasi Kontrak -->
                    <div class="mb-4 p-4"
                        style="background: #e8f4f8; border-radius: 10px; border-left: 5px solid #17a2b8;">
                        <h6 class="text-uppercase font-weight-bold mb-4"
                            style="color: #138496; font-size: 0.9rem; letter-spacing: 0.5px;">
                            <i class="fas fa-briefcase mr-2"></i> Informasi Kontrak
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-file-contract text-info mr-2 mt-1"
                                        style="font-size: 1.2rem; color: #17a2b8;"></i>
                                    <div>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">No
                                            Kontrak</small>
                                        <p id="detailNoKontrak" class="mb-0 font-weight-bold"
                                            style="font-size: 1rem; color: #333;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-building text-info mr-2 mt-1"
                                        style="font-size: 1.2rem; color: #17a2b8;"></i>
                                    <div>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">Nama
                                            PT</small>
                                        <p id="detailNamaPT" class="mb-0 font-weight-bold"
                                            style="font-size: 1rem; color: #333;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-0">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-tools text-info mr-2 mt-1"
                                        style="font-size: 1.2rem; color: #17a2b8;"></i>
                                    <div>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">Pekerjaan</small>
                                        <p id="detailPekerjaan" class="mb-0 font-weight-bold"
                                            style="font-size: 1rem; color: #333;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Data Asbuilt -->
                    <div class="mb-4 p-4"
                        style="background: #e8f5e9; border-radius: 10px; border-left: 5px solid #28a745;">
                        <h6 class="text-uppercase font-weight-bold mb-4"
                            style="color: #1e7e34; font-size: 0.9rem; letter-spacing: 0.5px;">
                            <i class="fas fa-clipboard-check mr-2"></i> Data Asbuilt Drawing
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-calendar-alt text-success mr-2 mt-1"
                                        style="font-size: 1.2rem; color: #28a745;"></i>
                                    <div>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">Tanggal
                                            Terima</small>
                                        <p id="detailTglTerima" class="mb-0 font-weight-bold"
                                            style="font-size: 1rem; color: #333;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-tag text-success mr-2 mt-1"
                                        style="font-size: 1.2rem; color: #28a745;"></i>
                                    <div>
                                        <small class="text-muted d-block"
                                            style="font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase;">Status
                                            (Paket Pekerjaan)</small>
                                        <p id="detailStatus" class="mb-0 font-weight-bold"
                                            style="font-size: 1rem; color: #333;"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-0">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-sticky-note text-success mr-2 mt-1"
                                        style="font-size: 1.2rem; color: #28a745;"></i>
                                    <div class="w-100">
                                        <small class="text-muted d-block"
                                            style="font-size: 0.8rem; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.5rem;">Keterangan</small>
                                        <p id="detailKeterangan" class="mb-0 font-weight-bold"
                                            style="font-size: 1rem; color: #333; padding: 0.75rem; background: #f5f5f5; border-radius: 6px; border-left: 3px solid #28a745;">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Badge -->
                    <div class="alert alert-info border-0" role="alert"
                        style="border-radius: 8px; background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); border-left: 4px solid #17a2b8;">
                        <i class="fas fa-circle-info mr-2" style="color: #17a2b8;"></i>
                        <small style="color: #138496;"><strong>Catatan:</strong> Data ini bersifat read-only. Untuk
                            mengubah informasi, gunakan tombol Edit.</small>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-top-0 p-4" style="background: #f8f9fa; border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn text-white font-weight-600" data-dismiss="modal"
                        style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; border-radius: 8px; padding: 0.65rem 2rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- === EDIT MODAL (MODERN DESIGN) === -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg"
                style="border-radius: 12px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">

                <!-- Header with Gradient -->
                <div class="modal-header border-0"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0; padding: 2rem;">
                    <div>
                        <h5 class="modal-title text-white font-weight-bold" id="editModalLabel"
                            style="font-size: 1.5rem;">
                            <i class="fas fa-pencil-alt mr-2"></i> Edit Asbuilt Drawing
                        </h5>
                        <small class="text-light opacity-75">Perbarui informasi data Asbuilt Drawing</small>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        style="font-size: 1.5rem; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <form id="editAsbuiltForm" action="<?= base_url('user/update_asbuilt_data'); ?>" method="post">
                    <div class="modal-body p-4" style="background: #fff;">
                        <input type="hidden" id="editIdAsbuilt" name="id_asbuilt">

                        <!-- Section 1: Informasi Kontrak (Read Only) -->
                        <div class="mb-4 p-4"
                            style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #667eea;">
                            <h6 class="text-uppercase font-weight-bold mb-3"
                                style="color: #667eea; font-size: 0.9rem; letter-spacing: 0.5px;">
                                <i class="fas fa-info-circle mr-2"></i> Informasi Kontrak (Read Only)
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editNoKontrak" class="font-weight-bold text-muted"
                                        style="font-size: 0.85rem;">
                                        <i class="fas fa-file-contract mr-1" style="color: #667eea;"></i> No Kontrak
                                    </label>
                                    <input type="text" class="form-control" id="editNoKontrak" readonly
                                        style="background: #e9ecef; border: 1px solid #dee2e6; border-radius: 8px; padding: 0.75rem; color: #6c757d;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editNamaPT" class="font-weight-bold text-muted"
                                        style="font-size: 0.85rem;">
                                        <i class="fas fa-building mr-1" style="color: #667eea;"></i> Nama PT
                                    </label>
                                    <input type="text" class="form-control" id="editNamaPT" readonly
                                        style="background: #e9ecef; border: 1px solid #dee2e6; border-radius: 8px; padding: 0.75rem; color: #6c757d;">
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label for="editPekerjaan" class="font-weight-bold text-muted"
                                        style="font-size: 0.85rem;">
                                        <i class="fas fa-tools mr-1" style="color: #667eea;"></i> Pekerjaan
                                    </label>
                                    <input type="text" class="form-control" id="editPekerjaan" readonly
                                        style="background: #e9ecef; border: 1px solid #dee2e6; border-radius: 8px; padding: 0.75rem; color: #6c757d;">
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Informasi yang Dapat Diubah -->
                        <div class="mb-4 p-4"
                            style="background: #fff3e0; border-radius: 10px; border-left: 4px solid #ffc107;">
                            <h6 class="text-uppercase font-weight-bold mb-3"
                                style="color: #ff9800; font-size: 0.9rem; letter-spacing: 0.5px;">
                                <i class="fas fa-edit mr-2"></i> Informasi yang Dapat Diubah
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editTglTerima" class="font-weight-bold"
                                        style="color: #333; font-size: 0.9rem;">
                                        <i class="fas fa-calendar-alt mr-1" style="color: #ffc107;"></i> Tanggal Terima
                                    </label>
                                    <input type="date" class="form-control" id="editTglTerima" name="tgl_terima"
                                        required
                                        style="border: 2px solid #ffc107; border-radius: 8px; padding: 0.75rem; background: #fff; transition: all 0.3s ease;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editStatus" class="font-weight-bold"
                                        style="color: #333; font-size: 0.9rem;">
                                        <i class="fas fa-tag mr-1" style="color: #ffc107;"></i> Status (Paket Pekerjaan)
                                    </label>
                                    <input type="text" class="form-control" id="editStatus" name="status"
                                        placeholder="Masukkan status paket pekerjaan"
                                        style="border: 2px solid #ffc107; border-radius: 8px; padding: 0.75rem; background: #fff; transition: all 0.3s ease;">
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label for="editKeterangan" class="font-weight-bold"
                                        style="color: #333; font-size: 0.9rem;">
                                        <i class="fas fa-sticky-note mr-1" style="color: #ffc107;"></i> Keterangan
                                    </label>
                                    <textarea class="form-control" id="editKeterangan" name="keterangan" rows="3"
                                        placeholder="Masukkan keterangan tambahan..."
                                        style="border: 2px solid #ffc107; border-radius: 8px; padding: 0.75rem; background: #fff; transition: all 0.3s ease; resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer with Modern Buttons -->
                    <div class="modal-footer border-top-0 p-4"
                        style="background: #f8f9fa; border-radius: 0 0 12px 12px;">
                        <button type="button" class="btn btn-light border" data-dismiss="modal"
                            style="border-radius: 8px; padding: 0.65rem 1.5rem; font-weight: 600; transition: all 0.3s ease; color: #667eea; border: 2px solid #667eea;">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn text-white font-weight-600"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 8px; padding: 0.65rem 2rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade modal-background" id="newAsBuiltDrawingModal" tabindex="-1"
        aria-labelledby="newAsBuiltDrawingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newAsBuiltDrawingModalLabel">Tambah Data Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('user/add_asbuilt_data'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_pt" style="font-weight: 600; color: #333; margin-bottom: 0.5rem;">
                                <i class="fas fa-building" style="color: #667eea; margin-right: 0.5rem;"></i>Nama PT
                            </label>
                            <div class="search-input-group">
                                <input type="text" class="form-control" id="nama_pt" name="nama_pt"
                                    placeholder="Ketik nama PT..." autocomplete="off" required>
                                <div class="suggestion-dropdown" id="nama_pt_dropdown"></div>
                            </div>
                            <small class="help-text-error" id="namaPtHelp">
                                <i class="fas fa-exclamation-circle"></i> Data tidak ditemukan
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="no_kontrak">No Kontrak</label>
                            <select class="form-control" id="no_kontrak" name="no_kontrak" required>
                                <option value="">Pilih No Kontrak</option>
                                <!-- Options akan diisi melalui AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                placeholder="Nama Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="status">Paket Pekerjaan</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="Status">
                        </div>
                        <div class="form-group">
                            <label for="tgl_terima">Tanggal Terima</label>
                            <input type="date" class="form-control" id="tgl_terima" name="tgl_terima"
                                placeholder="Tanggal Terima Asbuilt">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Keterangan Asbuilt">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active"
                                    name="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    Active?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {

        // Ambil data dari PHP dan masukkan ke JavaScript
        var dataNamaPT = <?= json_encode(array_column($finalAccount, 'nama_pt')) ?>;

        // Menggunakan Set untuk menghilangkan duplikat
        var uniqueDataSet = new Set(dataNamaPT);

        // Membuat array dari data unik
        var options = Array.from(uniqueDataSet).map(function(item) {
            return {
                id: item,
                text: item
            };
        });


        var table = $('#asbuilt-data-tabel').DataTable({
            "stateSave": true // Enable state saving to maintain page state
        });

        // ===== DETAIL BUTTON HANDLER =====
        $(document).on('click', '.btn-detail', function() {
            var id = $(this).data('id');
            var noKontrak = $(this).data('nokontrak');
            var namaPT = $(this).data('namapt');
            var pekerjaan = $(this).data('pekerjaan');
            var tglTerima = $(this).data('tglterima');
            var status = $(this).data('status');
            var keterangan = $(this).data('keterangan');

            $('#detailNoKontrak').text(noKontrak);
            $('#detailNamaPT').text(namaPT);
            $('#detailPekerjaan').text(pekerjaan);
            $('#detailTglTerima').text(tglTerima);
            $('#detailStatus').text(status);
            $('#detailKeterangan').text(keterangan || '-');
        });

        // ===== EDIT BUTTON HANDLER =====
        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var noKontrak = $(this).data('nokontrak');
            var namaPT = $(this).data('namapt');
            var pekerjaan = $(this).data('pekerjaan');
            var tglTerima = $(this).data('tglterima');
            var status = $(this).data('status');
            var keterangan = $(this).data('keterangan');

            $('#editIdAsbuilt').val(id);
            $('#editNoKontrak').val(noKontrak);
            $('#editNamaPT').val(namaPT);
            $('#editPekerjaan').val(pekerjaan);
            $('#editTglTerima').val(tglTerima);
            $('#editStatus').val(status);
            $('#editKeterangan').val(keterangan);
        });

        // ===== EDIT FORM SUBMIT =====
        $('#editAsbuiltForm').on('submit', function(e) {
            e.preventDefault();

            var formData = {
                id_asbuilt: $('#editIdAsbuilt').val(),
                tgl_terima: $('#editTglTerima').val(),
                status: $('#editStatus').val(),
                keterangan: $('#editKeterangan').val()
            };

            $.ajax({
                url: '<?= base_url('user/update_asbuilt_data') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#editModal').modal('hide');
                        alert('Data berhasil diperbarui!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi error saat menyimpan data');
                    console.log(xhr);
                }
            });
        });

        // Save current page in localStorage before form submission
        $('#editForm').on('submit', function() {
            localStorage.setItem('currentPage', table.page.info().page);
        });

        // Restore table state (pagination) from localStorage after page load
        var savedPage = localStorage.getItem('currentPage');
        if (savedPage !== null) {
            table.page(parseInt(savedPage)).draw('page');
            localStorage.removeItem('currentPage'); // Clear saved page after applying
        }

        var namaPtList = $('#nama_pt_dropdown');
        var namaPtData = options.slice(); // Copy array

        function renderSuggestions(term) {
            namaPtList.empty();
            if (!term) {
                namaPtList.removeClass('active');
                return;
            }

            var filtered = namaPtData.filter(function(item) {
                return item.text.toLowerCase().indexOf(term.toLowerCase()) !== -1;
            });

            if (filtered.length === 0) {
                namaPtList.html(
                    '<div class="suggestion-empty"><i class="fas fa-search"></i><div>Tidak ada data yang cocok</div></div>'
                    );
                namaPtList.addClass('active');
                $('#namaPtHelp').addClass('active');
            } else {
                var html = '';
                filtered.forEach(function(item) {
                    html += '<div class="suggestion-item" data-value="' + item.text + '">' +
                        '<i class="fas fa-briefcase"></i>' + item.text +
                        '</div>';
                });
                namaPtList.html(html);
                namaPtList.addClass('active');
                $('#namaPtHelp').removeClass('active');
            }
        }

        $('#nama_pt').on('input', function() {
            var val = $(this).val().trim();
            renderSuggestions(val);
        });

        $(document).on('click', '.suggestion-item', function() {
            var value = $(this).data('value');
            $('#nama_pt').val(value);
            namaPtList.removeClass('active');
            $('#namaPtHelp').removeClass('active');
            $('#nama_pt').trigger('change');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-input-group').length) {
                namaPtList.removeClass('active');
            }
        });

        $('#nama_pt').on('focus', function() {
            if ($(this).val().trim()) {
                renderSuggestions($(this).val().trim());
            }
        });

    });

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });


    $(document).ready(function() {
        $('#nama_pt').change(function() {
            var nama_pt = $(this).val();
            $.ajax({
                url: '<?= base_url('user/getKontrakByNamaPT'); ?>',
                method: 'POST',
                data: {
                    nama_pt: nama_pt
                },
                dataType: 'json',
                success: function(data) {
                    $('#no_kontrak').html('<option value="">Pilih No Kontrak</option>');
                    $.each(data, function(key, value) {
                        $('#no_kontrak').append('<option value="' + value
                            .no_kontrak + '">' + value.no_kontrak + '</option>');
                    });
                }
            });
        });

        $('#no_kontrak').change(function() {
            var no_kontrak = $(this).val();
            $.ajax({
                url: '<?= base_url('user/getPekerjaanByNoKontrak'); ?>',
                method: 'POST',
                data: {
                    no_kontrak: no_kontrak
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data) {
                        var data = response.data;
                        $('#pekerjaan').val(data.pekerjaan || '');
                        $('#status').val(data.status || '');
                    } else {
                        console.error('Data tidak ditemukan:', response.message);
                        $('#pekerjaan').val('');
                        $('#status').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Gagal mengambil data pekerjaan');
                }
            });
        });
    });
    </script>
</body>

</html>