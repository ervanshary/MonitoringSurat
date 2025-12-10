<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Bootstrap & Tailwind & Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #e0f7fa, #ffffff);
            color: #1f2937;
        }

        .main-container {
            background: rgba(224, 247, 250, 0.8);
            /* cyan transparan */
            padding: 2rem;
            border-radius: 1.25rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            max-width: 95%;
        }

        .alert {
            border-radius: 0.75rem;
            font-weight: 500;
        }

        .btn-modern {
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .btn-modern.btn-primary {
            background: linear-gradient(90deg, #4f46e5, #6366f1);
            color: #fff;
        }

        .btn-modern.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }

        .btn-modern.btn-success {
            background: linear-gradient(90deg, #10b981, #34d399);
            color: #fff;
        }

        .btn-modern.btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 211, 153, 0.4);
        }

        #barang-table {
            border-radius: 0.75rem;
            overflow: hidden;
            border-collapse: separate !important;
        }

        #barang-table thead {
            background: linear-gradient(90deg, #4f46e5, #6366f1);
            color: #ffffff;
        }

        #barang-table thead th {
            font-weight: 600;
            padding: 0.75rem;
        }

        #barang-table tbody tr {
            background-color: #f9fafb;
            transition: all 0.2s;
        }

        #barang-table tbody tr:hover {
            background-color: #e0f2fe;
        }

        #barang-table td {
            padding: 0.75rem;
            color: #1f2937;
            border: 1px solid #e5e7eb;
        }

        #barang-table td img {
            border-radius: 0.5rem;
        }

        /* Tombol aksi rapi */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(90deg, #4f46e5, #6366f1);
            color: #fff;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 700;
        }

        .form-control,
        .form-select,
        textarea {
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
            background-color: #fff;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.5rem !important;
            padding: 0.5rem 0.75rem !important;
            margin: 0 0.25rem !important;
            background-color: #f3f4f6 !important;
            border: 1px solid #d1d5db !important;
            color: #4f46e5 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(90deg, #4f46e5, #6366f1) !important;
            color: #fff !important;
        }

        /* Batasi lebar tabel agar tidak melebar */
        #barang-table {
            table-layout: fixed;
            width: 150%;
            word-wrap: break-word;
        }

        #barang-table th,
        #barang-table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
            vertical-align: middle;
        }

        /* Kolom tertentu bisa lebih sempit */
        #barang-table td:nth-child(1),
        #barang-table td:nth-child(13),
        #barang-table td:nth-child(14) {
            max-width: 100px;
            text-align: center;
        }

        /* Tooltip styling agar elegan */
        [data-toggle="tooltip"] {
            cursor: help;
        }
    </style>
</head>

<body>
    <div class="main-container mx-auto">

        <!-- Alerts -->
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('message'); ?></div>
        <?php elseif ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <!-- Buttons -->
        <div class="mb-4 flex flex-wrap gap-3">
            <a href="#newMasukmodal" class="btn-modern btn-primary" data-toggle="modal">
                <i class="fas fa-plus"></i> Tambah Data Barang
            </a>
            <a href="<?= base_url('Gudang/export') ?>" class="btn-modern btn-success">
                <i class="fas fa-file-export"></i> Export Data
            </a>
        </div>

        <div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview Foto</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="fotoPreview" src="#" alt="Foto Barang" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>


        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered" id="barang-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Barang</th>
                        <th>Nama Barang</th>
                        <th>Lokasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tanggal Masuk</th>
                        <th>Pengirim</th>
                        <th>Nama PT</th>
                        <th>Penerima</th>
                        <th>Keterangan</th>
                        <th>Foto</th>
                        <th>Tanda Terima</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['id'] ?? ''); ?></td>
                            <td data-toggle="tooltip" title="<?= htmlspecialchars($item['jenis_barang'] ?? ''); ?>">
                                <?= htmlspecialchars($item['jenis_barang'] ?? ''); ?>
                            </td>
                            <td data-toggle="tooltip" title="<?= htmlspecialchars($item['nama_barang'] ?? ''); ?>">
                                <?= htmlspecialchars($item['nama_barang'] ?? ''); ?>
                            </td>
                            <td data-toggle="tooltip" title="<?= htmlspecialchars($item['lokasi'] ?? ''); ?>">
                                <?= htmlspecialchars($item['lokasi'] ?? ''); ?>
                            </td>
                            <td><?= htmlspecialchars($item['jumlah'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($item['satuan'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($item['tanggal_masuk'] ?? ''); ?></td>
                            <td data-toggle="tooltip" title="<?= htmlspecialchars($item['pengirim'] ?? ''); ?>">
                                <?= htmlspecialchars($item['pengirim'] ?? ''); ?>
                            </td>
                            <td><?= htmlspecialchars($item['perusahaan'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($item['penerima'] ?? ''); ?></td>
                            <td data-toggle="tooltip" title="<?= htmlspecialchars($item['keterangan'] ?? ''); ?>">
                                <?= htmlspecialchars($item['keterangan'] ?? ''); ?>
                            </td>
                            <td>
                                <?php if (!empty($item['foto'])): ?>
                                    <img src="<?= base_url('./assets/upload/foto/' . $item['foto']); ?>"
                                        alt="Foto Barang"
                                        class="img-thumbnail foto-table"
                                        style="width:50px;height:50px;object-fit:cover;cursor:pointer;"
                                        data-toggle="modal"
                                        data-target="#fotoModal"
                                        data-foto="<?= base_url('./assets/upload/foto/' . $item['foto']); ?>">
                                <?php else: ?>
                                    <span class="text-muted">Tidak Ada</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($item['tanda_terima'])): ?>
                                    <a href="<?= base_url('./assets/upload/tanda terima/' . $item['tanda_terima']); ?>" class="btn btn-sm btn-primary">Lihat</a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak Ada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn-modern btn-primary dropdown-toggle" type="button" id="actionDropdown<?= $item['id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="actionDropdown<?= $item['id']; ?>">
                                        <a class="dropdown-item btn-detail" href="javascript:void(0);"
                                            data-toggle="modal" data-target="#detailModal"
                                            data-id="<?= htmlspecialchars($item['id'] ?? ''); ?>"
                                            data-jenis_barang="<?= htmlspecialchars($item['jenis_barang'] ?? ''); ?>"
                                            data-nama_barang="<?= htmlspecialchars($item['nama_barang'] ?? ''); ?>"
                                            data-lokasi="<?= htmlspecialchars($item['lokasi'] ?? ''); ?>"
                                            data-jumlah="<?= htmlspecialchars($item['jumlah'] ?? ''); ?>"
                                            data-satuan="<?= htmlspecialchars($item['satuan'] ?? ''); ?>"
                                            data-tanggal_masuk="<?= htmlspecialchars($item['tanggal_masuk'] ?? ''); ?>"
                                            data-pengirim="<?= htmlspecialchars($item['pengirim'] ?? ''); ?>"
                                            data-perusahaan="<?= htmlspecialchars($item['perusahaan'] ?? ''); ?>"
                                            data-penerima="<?= htmlspecialchars($item['penerima'] ?? ''); ?>"
                                            data-keterangan="<?= htmlspecialchars($item['keterangan'] ?? ''); ?>"
                                            data-foto="<?= htmlspecialchars($item['foto'] ?? ''); ?>"
                                            data-tanda_terima="<?= htmlspecialchars($item['tanda_terima'] ?? ''); ?>">
                                            Detail
                                        </a>
                                        <a class="dropdown-item edit-btn" href="javascript:void(0);"
                                            data-toggle="modal" data-target="#editModal"
                                            data-id="<?= htmlspecialchars($item['id']); ?>"
                                            data-jenis_barang="<?= htmlspecialchars($item['jenis_barang']); ?>"
                                            data-nama_barang="<?= htmlspecialchars($item['nama_barang']); ?>"
                                            data-lokasi="<?= htmlspecialchars($item['lokasi']); ?>"
                                            data-jumlah="<?= htmlspecialchars($item['jumlah']); ?>"
                                            data-satuan="<?= htmlspecialchars($item['satuan']); ?>"
                                            data-tanggal_masuk="<?= htmlspecialchars($item['tanggal_masuk']); ?>"
                                            data-pengirim="<?= htmlspecialchars($item['pengirim']); ?>"
                                            data-perusahaan="<?= htmlspecialchars($item['perusahaan']); ?>"
                                            data-penerima="<?= htmlspecialchars($item['penerima']); ?>"
                                            data-keterangan="<?= htmlspecialchars($item['keterangan']); ?>">
                                            Edit
                                        </a>
                                        <a class="dropdown-item btn-pindah-barang" href="javascript:void(0);"
                                            data-toggle="modal" data-target="#pindahModal"
                                            data-id="<?= htmlspecialchars($item['id']); ?>"
                                            data-jenis_barang="<?= htmlspecialchars($item['jenis_barang']); ?>"
                                            data-nama_barang="<?= htmlspecialchars($item['nama_barang']); ?>"
                                            data-lokasi="<?= htmlspecialchars($item['lokasi']); ?>"
                                            data-jumlah="<?= htmlspecialchars($item['jumlah']); ?>"
                                            data-satuan="<?= htmlspecialchars($item['satuan']); ?>"
                                            data-pengirim="<?= htmlspecialchars($item['pengirim']); ?>"
                                            data-perusahaan="<?= htmlspecialchars($item['perusahaan']); ?>"
                                            data-penerima="<?= htmlspecialchars($item['penerima']); ?>">
                                            Pindahkan
                                        </a>

                                    </div>
                                </div>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ====================== MODAL TAMBAH BARANG ======================  -->
    <div class="modal fade" id="newMasukmodal" tabindex="-1" aria-labelledby="newMasukmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                <label class="form-label fw-semibold">Jenis Barang</label>
                                <input type="text" class="form-control rounded-pill px-3" name="jenis_barang" placeholder="Contoh: Elektronik" required>
                            </div>
                            <!-- Nama Barang -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <input type="text" class="form-control rounded-pill px-3" name="nama_barang" placeholder="Contoh: Laptop" required>
                            </div>
                            <!-- Lokasi -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Lokasi Penyimpanan</label>
                                <select class="form-select rounded-pill px-3" name="lokasi" required>
                                    <option value="" disabled selected>Pilih Lokasi</option>
                                    <option value="Gudang Office">Gudang Office</option>
                                    <option value="Gudang Kontener">Gudang Kontener</option>
                                    <option value="Office Bawah">Office Bawah</option>
                                    <option value="Office Atas">Office Atas</option>
                                </select>
                            </div>
                            <!-- Jumlah & Satuan -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah</label>
                                <input type="number" class="form-control rounded-pill px-3" name="jumlah" placeholder="Contoh: 10" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Satuan</label>
                                <select class="form-select rounded-pill px-3" name="satuan" required>
                                    <option value="" disabled selected>Pilih Satuan</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="dus">Dus</option>
                                    <option value="unit">Unit</option>
                                </select>
                            </div>
                            <!-- Tanggal Masuk & Pengirim -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Masuk</label>
                                <input type="date" class="form-control rounded-pill px-3" name="tanggal_masuk" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Pengirim</label>
                                <input type="text" class="form-control rounded-pill px-3" name="pengirim" placeholder="Contoh: John Doe" required>
                            </div>
                            <!-- Perusahaan & Penerima -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama PT</label>
                                <input type="text" class="form-control rounded-pill px-3" name="perusahaan" placeholder="Contoh: PT.X" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Penerima</label>
                                <input type="text" class="form-control rounded-pill px-3" name="penerima" placeholder="Contoh: Jane Smith" required>
                            </div>
                            <!-- Keterangan -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea class="form-control rounded-3 px-3" name="keterangan" rows="3" placeholder="Tambahkan keterangan..."></textarea>
                            </div>
                            <!-- Upload Foto & Preview -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Foto Barang</label>
                                <input type="file" name="foto" class="form-control" id="fotoTambah">
                                <img id="previewTambah" src="#" alt="Preview Foto" class="mt-2" style="display:none;width:100px;height:100px;object-fit:cover;border-radius:0.5rem;">
                            </div>
                            <!-- Upload PDF & Preview -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanda Terima (PDF)</label>
                                <input type="file" name="tanda_terima" class="form-control" id="tandaTambah">
                                <iframe id="previewTandaTambah" style="display:none;width:100%;height:200px;border:1px solid #ccc;margin-top:0.5rem;"></iframe>
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

    <!-- ====================== MODAL EDIT BARANG ====================== -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-primary text-white border-bottom-0 rounded-top-4">
                    <h5 class="modal-title fw-bold">Edit Barang Masuk</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="post" action="<?= base_url('Gudang/update'); ?>" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="row g-3">
                            <!-- Input sama seperti Tambah, tapi id untuk JS -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Barang</label>
                                <input type="text" class="form-control rounded-pill px-3" id="edit-jenis_barang" name="jenis_barang" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <input type="text" class="form-control rounded-pill px-3" id="edit-nama_barang" name="nama_barang" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Lokasi Penyimpanan</label>
                                <select class="form-select rounded-pill px-3" id="edit-lokasi" name="lokasi" required>
                                    <option value="" disabled selected>Pilih Lokasi</option>
                                    <option value="Gudang Office">Gudang Office</option>
                                    <option value="Gudang Kontener">Gudang Kontener</option>
                                    <option value="Office Bawah">Office Bawah</option>
                                    <option value="Office Atas">Office Atas</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah</label>
                                <input type="number" class="form-control rounded-pill px-3" id="edit-jumlah" name="jumlah" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Satuan</label>
                                <select class="form-select rounded-pill px-3" id="edit-satuan" name="satuan" required>
                                    <option value="" disabled selected>Pilih Satuan</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="dus">Dus</option>
                                    <option value="unit">Unit</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Masuk</label>
                                <input type="date" class="form-control rounded-pill px-3" id="edit-tanggal_masuk" name="tanggal_masuk" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Pengirim</label>
                                <input type="text" class="form-control rounded-pill px-3" id="edit-pengirim" name="pengirim" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama PT</label>
                                <input type="text" class="form-control rounded-pill px-3" id="edit-perusahaan" name="perusahaan" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Penerima</label>
                                <input type="text" class="form-control rounded-pill px-3" id="edit-penerima" name="penerima" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea class="form-control rounded-3 px-3" id="edit-keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Foto Barang</label>
                                <input type="file" name="foto" class="form-control" id="fotoEdit">
                                <img id="previewEdit" src="#" alt="Preview Foto" class="mt-2" style="display:none;width:100px;height:100px;object-fit:cover;border-radius:0.5rem;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanda Terima (PDF)</label>
                                <input type="file" name="tanda_terima" class="form-control" id="tandaEdit">
                                <iframe id="previewTandaEdit" style="display:none;width:100%;height:200px;border:1px solid #ccc;margin-top:0.5rem;"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-secondary px-4 rounded-pill fw-semibold" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Barang Masuk</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>ID:</strong> <span id="detail-id"></span></div>
                        <div class="col-md-6"><strong>Jenis Barang:</strong> <span id="detail-jenis_barang"></span></div>
                        <div class="col-md-6"><strong>Nama Barang:</strong> <span id="detail-nama_barang"></span></div>
                        <div class="col-md-6"><strong>Lokasi:</strong> <span id="detail-lokasi"></span></div>
                        <div class="col-md-6"><strong>Jumlah:</strong> <span id="detail-jumlah"></span></div>
                        <div class="col-md-6"><strong>Satuan:</strong> <span id="detail-satuan"></span></div>
                        <div class="col-md-6"><strong>Tanggal Masuk:</strong> <span id="detail-tanggal_masuk"></span></div>
                        <div class="col-md-6"><strong>Pengirim:</strong> <span id="detail-pengirim"></span></div>
                        <div class="col-md-6"><strong>Perusahaan:</strong> <span id="detail-perusahaan"></span></div>
                        <div class="col-md-6"><strong>Penerima:</strong> <span id="detail-penerima"></span></div>
                        <div class="col-12"><strong>Keterangan:</strong>
                            <p id="detail-keterangan"></p>
                        </div>
                        <div class="col-md-6"><strong>Foto Barang:</strong>
                            <div id="detail-foto"></div>
                        </div>
                        <div class="col-md-6"><strong>Tanda Terima:</strong>
                            <div id="detail-tanda_terima"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill fw-semibold" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ====================== MODAL PINDAH BARANG ====================== -->
    <div class="modal fade" id="pindahModal" tabindex="-1" role="dialog" aria-labelledby="pindahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-3 shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="pindahModalLabel">Pindahkan Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="pindahForm" method="post" action="<?= base_url('Gudang/pindahkan_barang'); ?>">
                    <div class="modal-body">
                        <input type="hidden" id="pindah-id" name="id">

                        <div class="form-group">
                            <label for="pindah-jenis_barang">Jenis Barang</label>
                            <input type="text" class="form-control" id="pindah-jenis_barang" name="jenis_barang" readonly>
                        </div>

                        <div class="form-group">
                            <label for="pindah-nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="pindah-nama_barang" name="nama_barang" readonly>
                        </div>

                        <div class="form-group">
                            <label for="pindah-lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="pindah-lokasi" name="lokasi" readonly>
                        </div>

                        <div class="form-group">
                            <label for="pindah-jumlah_keluar">Jumlah Keluar <small id="stok-info" class="text-muted"></small></label>
                            <input type="number" class="form-control" id="pindah-jumlah_keluar" name="jumlah_keluar" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="pindah-satuan">Satuan</label>
                            <input type="text" class="form-control" id="pindah-satuan" name="satuan" readonly>
                        </div>

                        <div class="form-group">
                            <label for="pindah-tanggal_keluar">Tanggal Keluar</label>
                            <input type="date" class="form-control" id="pindah-tanggal_keluar" name="tanggal_keluar" required
                                value="<?= date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="pindah-pengirim">Pengirim</label>
                            <input type="text" class="form-control" id="pindah-pengirim" name="pengirim" placeholder="Isi pengirim..." required>
                        </div>

                        <div class="form-group">
                            <label for="pindah-penerima">Penerima</label>
                            <input type="text" class="form-control" id="pindah-penerima" name="penerima" placeholder="Isi penerima..." required>
                        </div>

                        <div class="form-group">
                            <label for="pindah-keterangan">Keterangan</label>
                            <textarea class="form-control" id="pindah-keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill">Pindahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#barang-table').DataTable({
                stateSave: true
            });

            // Fill Edit Modal
            $('.edit-btn').click(function() {
                $('#edit-id').val($(this).data('id'));
                $('#edit-jenis_barang').val($(this).data('jenis_barang'));
                $('#edit-nama_barang').val($(this).data('nama_barang'));
                $('#edit-lokasi').val($(this).data('lokasi'));
                $('#edit-jumlah').val($(this).data('jumlah'));
                $('#edit-satuan').val($(this).data('satuan'));
                $('#edit-tanggal_masuk').val($(this).data('tanggal_masuk'));
                $('#edit-pengirim').val($(this).data('pengirim'));
                $('#edit-perusahaan').val($(this).data('perusahaan'));
                $('#edit-penerima').val($(this).data('penerima'));
                $('#edit-keterangan').val($(this).data('keterangan'));
            });

            // Fill Detail Modal
            $('.btn-detail').click(function() {
                $('#detail-id').text($(this).data('id'));
                $('#detail-jenis_barang').text($(this).data('jenis_barang'));
                $('#detail-nama_barang').text($(this).data('nama_barang'));
                $('#detail-lokasi').text($(this).data('lokasi'));
                $('#detail-jumlah').text($(this).data('jumlah'));
                $('#detail-satuan').text($(this).data('satuan'));
                $('#detail-tanggal_masuk').text($(this).data('tanggal_masuk'));
                $('#detail-pengirim').text($(this).data('pengirim'));
                $('#detail-perusahaan').text($(this).data('perusahaan'));
                $('#detail-penerima').text($(this).data('penerima'));
                $('#detail-keterangan').text($(this).data('keterangan'));

                let foto = $(this).data('foto');
                if (foto) {
                    $('#detail-foto').html('<img src="<?= base_url("./assets/upload/foto/") ?>' + foto + '" alt="Foto Barang" class="img-fluid rounded" style="max-width:150px;">');
                } else {
                    $('#detail-foto').text('Tidak Ada');
                }

                let tanda = $(this).data('tanda_terima');
                if (tanda) {
                    $('#detail-tanda_terima').html('<a href="<?= base_url("./assets/upload/tanda terima/") ?>' + tanda + '" target="_blank" class="btn btn-sm btn-primary">Lihat PDF</a>');
                } else {
                    $('#detail-tanda_terima').text('Tidak Ada');
                }
            });
        });

        // Fill Pindah Modal
        $('.btn-pindah-barang').click(function() {
            // Ambil data dari tombol
            const id = $(this).data('id');
            const jenis = $(this).data('jenis_barang');
            const nama = $(this).data('nama_barang');
            const lokasi = $(this).data('lokasi');
            const satuan = $(this).data('satuan');
            const jumlah = parseInt($(this).data('jumlah')); // stok tersedia

            // Set value modal
            $('#pindah-id').val(id);
            $('#pindah-jenis_barang').val(jenis);
            $('#pindah-nama_barang').val(nama);
            $('#pindah-lokasi').val(lokasi);
            $('#pindah-satuan').val(satuan);

            // Reset jumlah keluar & input pengirim/penerima
            $('#pindah-jumlah_keluar').val(1).attr('max', jumlah);
            $('#stok-info').text('Stok tersedia: ' + jumlah);
            $('#pindah-pengirim').val('');
            $('#pindah-penerima').val('');
            $('#pindah-keterangan').val('');
            $('#pindah-tanggal_keluar').val('<?= date('Y-m-d'); ?>');
        });



        function previewFile(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                const reader = new FileReader();
                const ext = file.name.split('.').pop().toLowerCase();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }

        // Tambah Modal
        document.getElementById('fotoTambah').addEventListener('change', function() {
            previewFile(this, 'previewTambah');
        });
        document.getElementById('tandaTambah').addEventListener('change', function() {
            previewFile(this, 'previewTandaTambah');
        });

        // Edit Modal
        document.getElementById('fotoEdit').addEventListener('change', function() {
            previewFile(this, 'previewEdit');
        });
        document.getElementById('tandaEdit').addEventListener('change', function() {
            previewFile(this, 'previewTandaEdit');
        });

        // Preview foto tabel
        $('.foto-table').click(function() {
            var src = $(this).data('foto');
            $('#fotoPreview').attr('src', src);
            $('#fotoModal').modal('show');
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</body>

</html>