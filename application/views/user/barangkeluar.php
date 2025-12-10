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

<body class="bg-gradient-to-r from-white via-cyan-100 to-cyan-400 min-h-screen">


    <div class="main-container mx-auto">
        <!-- Page Heading -->
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('message'); ?></div>
        <?php elseif ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-lg-12">
                <!-- Tombol Tambah Data Barang -->
                <a href="#newMasukmodal" class="btn btn-primary" data-toggle="modal">
                    <i class="fas fa-plus"></i> Tambah Data Barang
                </a>
                <!-- Tombol untuk membuka modal import -->
                <a href="#importModal" class="btn btn-warning" data-toggle="modal">
                    <i class="fas fa-upload"></i> Import Data
                </a>
                <!-- Tombol Export Data -->
                <a href="<?= base_url('Gudang_keluar/export') ?>" class="btn btn-success">
                    <i class="fas fa-file-export"></i> Export Data
                </a>
            </div>
        </div>

        <div class="table-responsive mx-auto">
            <table class="table table-bordered" id="barang-table" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Jenis Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">jumlah Akhir</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Tanggal Keluar</th>
                        <th scope="col">Pengirim</th>
                        <th scope="col">Penerima</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Foto Keluar</th>
                        <th scope="col">Tanda Terima Keluar</th>
                        <th scope="col">Action</th>
                        <th scope="col">Print</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                        <tr>

                            <td title="<?= htmlspecialchars($item['id'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['id'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['jenis_barang'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['jenis_barang'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['nama_barang'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['nama_barang'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['lokasi'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['lokasi'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['jumlah_awal'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['jumlah_awal'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['satuan'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['satuan'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['tanggal_keluar'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['tanggal_keluar'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['pengirim'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['pengirim'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['penerima'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['penerima'] ?? ''); ?>
                            </td>
                            <td title="<?= htmlspecialchars($item['keterangan'] ?? ''); ?>" data-bs-toggle="tooltip">
                                <?= htmlspecialchars($item['keterangan'] ?? ''); ?>
                            </td>


                            <td>
                                <?php if (!empty($item['foto'])): ?>
                                    <a href="<?= base_url('assets/upload/foto/' . $item['foto']); ?>" target="_blank">
                                        <img src="<?= base_url('assets/upload/foto/' . $item['foto']); ?>"
                                            alt="Foto Barang"
                                            class="img-thumbnail"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak Ada Foto</span>
                                <?php endif; ?>
                            </td>

                            <!-- Tanda Terima -->
                            <td>
                                <?php if (!empty($item['tanda_terima'])): ?>
                                    <a href="<?= base_url('assets/upload/tanda_terima/' . $item['tanda_terima']); ?>" target="_blank" class="btn btn-primary btn-sm">
                                        Lihat Tanda Terima
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak Ada Tanda Terima</span>
                                <?php endif; ?>
                            </td>


                            <td>
                                <div class="buttons">
                                    <!-- Button to trigger Detail Modal -->
                                    <button class="btn btn-info btn-detail" data-toggle="modal" data-target="#detailModal"
                                        data-id="<?= htmlspecialchars($item['id'] ?? ''); ?>"
                                        data-jenis_barang="<?= htmlspecialchars($item['jenis_barang'] ?? ''); ?>"
                                        data-nama_barang="<?= htmlspecialchars($item['nama_barang'] ?? ''); ?>"
                                        data-lokasi="<?= htmlspecialchars($item['lokasi'] ?? ''); ?>"
                                        data-jumlah_awal="<?= htmlspecialchars($item['jumlah_awal'] ?? ''); ?>"
                                        data-satuan="<?= htmlspecialchars($item['satuan'] ?? ''); ?>"
                                        data-tanggal_keluar="<?= htmlspecialchars($item['tanggal_keluar'] ?? ''); ?>"
                                        data-pengirim="<?= htmlspecialchars($item['pengirim'] ?? ''); ?>"
                                        data-penerima="<?= htmlspecialchars($item['penerima'] ?? ''); ?>"
                                        data-keterangan="<?= htmlspecialchars($item['keterangan'] ?? ''); ?>">
                                        Detail
                                    </button>

                                    <!-- Button to trigger Edit Modal -->
                                    <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal"
                                        data-id="<?= htmlspecialchars($item['id'] ?? ''); ?>"
                                        data-jenis_barang="<?= htmlspecialchars($item['jenis_barang'] ?? ''); ?>"
                                        data-nama_barang="<?= htmlspecialchars($item['nama_barang'] ?? ''); ?>"
                                        data-lokasi="<?= htmlspecialchars($item['lokasi'] ?? ''); ?>"
                                        data-jumlah_awal="<?= htmlspecialchars($item['jumlah_awal'] ?? ''); ?>"
                                        data-satuan="<?= htmlspecialchars($item['satuan'] ?? ''); ?>"
                                        data-tanggal_keluar="<?= htmlspecialchars($item['tanggal_keluar'] ?? ''); ?>"
                                        data-pengirim="<?= htmlspecialchars($item['pengirim'] ?? ''); ?>"
                                        data-penerima="<?= htmlspecialchars($item['penerima'] ?? ''); ?>"
                                        data-keterangan="<?= htmlspecialchars($item['keterangan'] ?? ''); ?>">
                                        Edit
                                    </button>


                                </div>
                            </td>

                            <td>

                                <!-- Tombol Buat Tanda Terima -->
                                <a href="<?= base_url('user/barangkeluar_pdf/' . $item['id']); ?>" target="_blank" class="btn btn-sm btn-danger">
                                    <i class="fas fa-file-pdf"></i> Download PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <!-- Modal Tambah Barang Masuk -->
        <div class="modal fade" id="newMasukmodal" tabindex="-1" aria-labelledby="newMasukmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content shadow-lg border-0 rounded-3">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title fw-bold" id="newMasukmodalLabel">Tambah Barang Masuk</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('Gudang/add'); ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <!-- Jenis Barang -->
                                <div class="col-md-6">
                                    <label for="jenis_barang" class="form-label fw-semibold">Jenis Barang</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="jenis_barang" name="jenis_barang" placeholder="Contoh: Elektronik" required>
                                </div>
                                <!-- Nama Barang -->
                                <div class="col-md-6">
                                    <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="nama_barang" name="nama_barang" placeholder="Contoh: Laptop" required>
                                </div>
                                <!-- Lokasi Penyimpanan -->
                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label fw-semibold">Lokasi Penyimpanan</label>
                                    <select class="form-select rounded-pill px-3" id="lokasi" name="lokasi" required>
                                        <option value="" disabled selected>Pilih Lokasi</option>
                                        <option value="Gudang Utama">Gudang Office</option>
                                        <option value="Gudang Cabang">Gudang Kontener</option>
                                    </select>
                                </div>
                                <!-- jumlah_awal -->
                                <div class="col-md-6">
                                    <label for="jumlah_awal" class="form-label fw-semibold">jumlah_awal</label>
                                    <input type="number" class="form-control rounded-pill px-3" id="jumlah_awal" name="jumlah_awal" placeholder="Contoh: 10" required>
                                </div>
                                <!-- Satuan -->
                                <div class="col-md-6">
                                    <label for="satuan" class="form-label fw-semibold">Satuan</label>
                                    <select class="form-select rounded-pill px-3" id="satuan" name="satuan" required>
                                        <option value="" disabled selected>Pilih Satuan</option>
                                        <option value="pcs">Pcs</option>
                                        <option value="dus">Dus</option>
                                        <option value="Unit">Unit</option>
                                    </select>
                                </div>
                                <!-- Tanggal Masuk -->
                                <div class="col-md-6">
                                    <label for="tanggal_keluar" class="form-label fw-semibold">Tanggal Masuk</label>
                                    <input type="date" class="form-control rounded-pill px-3" id="tanggal_keluar" name="tanggal_keluar" required>
                                </div>
                                <!-- Pengirim -->
                                <div class="col-md-6">
                                    <label for="pengirim" class="form-label fw-semibold">Nama Pengirim</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="pengirim" name="pengirim" placeholder="Contoh: John Doe" required>
                                </div>
                                <!-- Penerima -->
                                <div class="col-md-6">
                                    <label for="penerima" class="form-label fw-semibold">Nama Penerima</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="penerima" name="penerima" placeholder="Contoh: Jane Smith" required>
                                </div>
                                <!-- Keterangan -->
                                <div class="col-md-12">
                                    <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                                    <textarea class="form-control rounded-3 px-3" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-top-0">
                            <button type="button" class="btn btn-secondary px-4 rounded-pill fw-semibold" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content shadow-lg rounded-lg">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title" id="detailModalLabel">Detail Barang Masuk</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-jenis_barang">Jenis Barang</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-jenis_barang" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-nama_barang" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-lokasi">Lokasi Penyimpanan</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-lokasi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-jumlah_awal">jumlah_awal</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-jumlah_awal" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-satuan">Satuan</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-satuan" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-tanggal_keluar">Tanggal Masuk</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-tanggal_keluar" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-pengirim">Nama Pengirim</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-pengirim" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-penerima">Nama Penerima</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-penerima" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-keterangan">Keterangan</label>
                                        <textarea class="form-control border-0 bg-light" id="modal-keterangan" rows="3" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0 rounded-4">

                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white border-bottom-0 rounded-top-4">
                        <h5 class="modal-title fw-bold" id="editModalLabel">Edit Barang Keluar</h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <form id="editForm" method="post" action="<?= base_url('user/barangkeluar/update'); ?>" class="needs-validation" enctype="multipart/form-data" novalidate>

                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <!-- Hidden Input for ID -->
                                <input type="hidden" id="edit-id" name="id">

                                <!-- Jenis Barang -->
                                <div class="col-md-6">
                                    <label for="edit-jenis_barang" class="form-label fw-semibold">Jenis Barang</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="edit-jenis_barang" name="jenis_barang" placeholder="Contoh: Elektronik" required>
                                    <div class="invalid-feedback">Harap masukkan jenis barang.</div>
                                </div>

                                <!-- Nama Barang -->
                                <div class="col-md-6">
                                    <label for="edit-nama_barang" class="form-label fw-semibold">Nama Barang</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="edit-nama_barang" name="nama_barang" placeholder="Contoh: Laptop" required>
                                    <div class="invalid-feedback">Harap masukkan nama barang.</div>
                                </div>

                                <!-- Lokasi Penyimpanan -->
                                <div class="col-md-6">
                                    <label for="edit-lokasi" class="form-label fw-semibold">Lokasi Penyimpanan</label>
                                    <select class="form-select rounded-pill px-3" id="edit-lokasi" name="lokasi" required>
                                        <option value="" disabled selected>Pilih Lokasi</option>
                                        <option value="Gudang Utama">Gudang Office</option>
                                        <option value="Gudang Cabang">Gudang Kontener</option>
                                    </select>
                                    <div class="invalid-feedback">Pilih lokasi penyimpanan.</div>
                                </div>

                                <!-- Jumlah Awal -->
                                <div class="col-md-6">
                                    <label for="edit-jumlah_awal" class="form-label fw-semibold">Jumlah Awal</label>
                                    <input type="number" class="form-control rounded-pill px-3" id="edit-jumlah_awal" name="jumlah_awal" placeholder="Contoh: 10" required>
                                    <div class="invalid-feedback">Harap masukkan jumlah awal.</div>
                                </div>

                                <!-- Satuan -->
                                <div class="col-md-6">
                                    <label for="edit-satuan" class="form-label fw-semibold">Satuan</label>
                                    <select class="form-select rounded-pill px-3" id="edit-satuan" name="satuan" required>
                                        <option value="" disabled selected>Pilih Satuan</option>
                                        <option value="pcs">Pcs</option>
                                        <option value="dus">Dus</option>
                                        <option value="Unit">Unit</option>
                                    </select>
                                    <div class="invalid-feedback">Pilih satuan barang.</div>
                                </div>

                                <!-- Tanggal Keluar -->
                                <div class="col-md-6">
                                    <label for="edit-tanggal_keluar" class="form-label fw-semibold">Tanggal Keluar</label>
                                    <input type="date" class="form-control rounded-pill px-3" id="edit-tanggal_keluar" name="tanggal_keluar" required>
                                    <div class="invalid-feedback">Pilih tanggal keluar barang.</div>
                                </div>

                                <!-- Nama Pengirim -->
                                <div class="col-md-6">
                                    <label for="edit-pengirim" class="form-label fw-semibold">Nama Pengirim</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="edit-pengirim" name="pengirim" placeholder="Contoh: John Doe" required>
                                    <div class="invalid-feedback">Harap masukkan nama pengirim.</div>
                                </div>

                                <!-- Nama Penerima -->
                                <div class="col-md-6">
                                    <label for="edit-penerima" class="form-label fw-semibold">Nama Penerima</label>
                                    <input type="text" class="form-control rounded-pill px-3" id="edit-penerima" name="penerima" placeholder="Contoh: Jane Smith" required>
                                    <div class="invalid-feedback">Harap masukkan nama penerima.</div>
                                </div>

                                <!-- Keterangan -->
                                <div class="col-12">
                                    <label for="edit-keterangan" class="form-label fw-semibold">Keterangan</label>
                                    <textarea class="form-control rounded-3 px-3" id="edit-keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan..."></textarea>
                                </div>

                                <!-- Foto (JPG/JPEG) -->
                                <div class="col-md-6">
                                    <label for="edit-foto" class="form-label fw-semibold">Upload Foto (JPG/JPEG)</label>
                                    <input type="file" class="form-control rounded-pill px-3" id="edit-foto" name="foto" accept=".jpg, .jpeg">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah foto.</div>
                                </div>

                                <!-- Tanda Terima (PDF) -->
                                <div class="col-md-6">
                                    <label for="edit-tanda_terima" class="form-label fw-semibold">Upload Tanda Terima (PDF)</label>
                                    <input type="file" class="form-control rounded-pill px-3" id="edit-tanda_terima" name="tanda_terima" accept=".pdf">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah tanda terima.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer bg-light border-top-0">
                            <button type="button" class="btn btn-secondary px-4 rounded-pill fw-semibold" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Import Data -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('Gudang/import') ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="file">Pilih file Excel</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- jQuery, Popper.js, and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#newMasukmodal').on('show.bs.modal', function() {
                    console.log('Modal is about to be shown!');
                });
                var table = $('#barang-table').DataTable({
                    "stateSave": true // Enable state saving to maintain page state
                });


            });

            // Fungsi untuk membuka modal detail dan mengisi data
            $(document).ready(function() {
                // Event listener untuk tombol Detail
                $('.btn-detail').on('click', function() {
                    const jenisBarang = $(this).data('jenis_barang');
                    const namaBarang = $(this).data('nama_barang');
                    const lokasi = $(this).data('lokasi');
                    const jumlah_awal = $(this).data('jumlah_awal');
                    const satuan = $(this).data('satuan');
                    const tanggalMasuk = $(this).data('tanggal_keluar');
                    const pengirim = $(this).data('pengirim');
                    const penerima = $(this).data('penerima');
                    const keterangan = $(this).data('keterangan');

                    // Isi modal dengan data dari tombol
                    $('#modal-jenis_barang').val(jenisBarang);
                    $('#modal-nama_barang').val(namaBarang);
                    $('#modal-lokasi').val(lokasi);
                    $('#modal-jumlah_awal').val(jumlah_awal);
                    $('#modal-satuan').val(satuan);
                    $('#modal-tanggal_keluar').val(tanggalMasuk);
                    $('#modal-pengirim').val(pengirim);
                    $('#modal-penerima').val(penerima);
                    $('#modal-keterangan').val(keterangan);
                });
            });

            $(document).ready(function() {
                // Event listener untuk tombol Edit
                $('.edit-btn').on('click', function() {
                    const id = $(this).data('id');
                    const jenisBarang = $(this).data('jenis_barang');
                    const namaBarang = $(this).data('nama_barang');
                    const lokasi = $(this).data('lokasi');
                    const jumlah_awal = $(this).data('jumlah_awal');
                    const satuan = $(this).data('satuan');
                    const tanggalMasuk = $(this).data('tanggal_keluar');
                    const pengirim = $(this).data('pengirim');
                    const penerima = $(this).data('penerima');
                    const keterangan = $(this).data('keterangan');
                    const foto = $(this).data('foto');
                    const tanda_terima = $(this).data('tanda_terima');

                    // Isi modal Edit dengan data dari tombol
                    $('#edit-id').val(id);
                    $('#edit-jenis_barang').val(jenisBarang);
                    $('#edit-nama_barang').val(namaBarang);
                    $('#edit-lokasi').val(lokasi);
                    $('#edit-jumlah_awal').val(jumlah_awal);
                    $('#edit-satuan').val(satuan);
                    $('#edit-tanggal_keluar').val(tanggalMasuk);
                    $('#edit-pengirim').val(pengirim);
                    $('#edit-penerima').val(penerima);
                    $('#edit-keterangan').val(keterangan);
                    $('#old-foto').val(foto);
                    $('#old-tanda_terima').val(tanda_terima);
                });
            });

            function openEditModal(data) {
                // Mengisi input teks
                document.getElementById('edit-id').value = data.id || ''; // ID hidden input
                document.getElementById('edit-jenis_barang').value = data.jenis_barang || '';
                document.getElementById('edit-nama_barang').value = data.nama_barang || '';
                document.getElementById('edit-jumlah_awal').value = data.jumlah_awal || '';
                document.getElementById('edit-tanggal_keluar').value = data.tanggal_keluar || '';
                document.getElementById('edit-pengirim').value = data.pengirim || '';
                document.getElementById('edit-penerima').value = data.penerima || '';
                document.getElementById('edit-keterangan').value = data.keterangan || '';

                // Mengisi dropdown lokasi
                const lokasiSelect = document.getElementById('edit-lokasi');
                lokasiSelect.value = data.lokasi || '';

                // Mengisi dropdown satuan
                const satuanSelect = document.getElementById('edit-satuan');
                satuanSelect.value = data.satuan || '';

                // Menampilkan modal
                $('#editModal').modal('show');
            }


            // Fungsi untuk menutup modal
            function closeModal(modalId) {
                $(`#${modalId}`).modal('hide');
            }

            // Event listener untuk memilih file di modal import
            document.getElementById('importFile')?.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Tidak ada file dipilih';
                alert(`File dipilih: ${fileName}`);
            });

            // Menghapus alert setelah 5 detik
            setTimeout(() => {
                const alertElement = document.getElementById('autoDismissAlert');
                if (alertElement) {
                    alertElement.classList.remove('show'); // Menghapus kelas "show"
                    alertElement.classList.add('fade'); // Menambahkan efek fade-out
                    setTimeout(() => alertElement.remove(), 500); // Menghapus elemen dari DOM
                }
            }, 5000); // Waktu dalam milidetik (5 detik)


            // Contoh untuk membuka modal detail atau edit
            // openDetailModal(sampleData);
            // openEditModal(sampleData);
        </script>
    </div>

</body>