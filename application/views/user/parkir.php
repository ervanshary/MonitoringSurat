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
        }

        /* === HEADER TABEL === */
        #parkir-filter-tabel thead th {
            background: linear-gradient(90deg, #2563eb, #0ea5e9);
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 10px;
            border-bottom: 2px solid #0ea5e9;
        }

        /* === ISI TABEL === */
        #parkir-filter-tabel td {
            text-align: center;
            vertical-align: middle;
            padding: 8px 10px;
            color: #1e293b;
            font-size: 0.85rem;
            border: 1px solid #e2e8f0;
        }

        #parkir-filter-tabel tbody tr:nth-child(odd) {
            background-color: #f8fafc;
        }

        #parkir-filter-tabel tbody tr:hover {
            background-color: #e0f2fe;
        }

        /* === TOMBOL === */
        .btn {
            border-radius: 8px !important;
            font-size: 0.8rem !important;
            font-weight: 600;
            padding: 6px 10px;
            transition: all 0.2s ease-in-out;
        }

        .btn-info {
            background: linear-gradient(90deg, #0ea5e9, #38bdf8);
            border: none;
            color: white;
        }

        .btn-info:hover {
            background: linear-gradient(90deg, #0284c7, #0ea5e9);
        }

        .btn-primary {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #1d4ed8, #2563eb);
        }

        .btn-success {
            background: linear-gradient(90deg, #059669, #10b981);
            border: none;
            color: white;
        }

        .btn-warning {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
            border: none;
            color: white;
        }

        /* Lebar kolom proporsional */
        #parkir-filter-tabel th,
        #parkir-filter-tabel td {
            white-space: nowrap;
        }

        #parkir-filter-tabel th:nth-child(1) {
            width: 4%;
        }

        #parkir-filter-tabel th:nth-child(2),
        #parkir-filter-tabel th:nth-child(3),
        #parkir-filter-tabel th:nth-child(4) {
            width: 12%;
        }

        #parkir-filter-tabel th:nth-child(5),
        #parkir-filter-tabel th:nth-child(6),
        #parkir-filter-tabel th:nth-child(7),
        #parkir-filter-tabel th:nth-child(8) {
            width: 10%;
        }

        #parkir-filter-tabel th:nth-child(9) {
            width: 15%;
        }

        #parkir-filter-tabel th:nth-child(10) {
            width: 10%;
        }

        #parkir-filter-tabel th:nth-child(11) {
            width: 10%;
        }

        /* ===== MODAL DESIGN REFINED ===== */
        .modal-content {
            border-radius: 1rem !important;
            border: none !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #ffffff !important;
            text-align: center;
            justify-content: center;
            position: relative;
            padding: 1rem 1.5rem;
            border-bottom: none;
        }

        .modal-header .modal-title {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            margin: 0 auto;
        }

        .modal-header .close {
            position: absolute;
            right: 1rem;
            top: 0.8rem;
            color: #fff !important;
            opacity: 0.8;
            font-size: 1.4rem;
            transition: opacity 0.2s ease;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        .modal-body {
            background-color: #f8fafc;
            padding: 1.75rem 2rem;
            color: #1e293b;
        }

        .modal-body label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .modal-body .form-control {
            border-radius: 0.5rem;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .modal-body .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .modal-footer {
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        /* Upload area */
        .upload-area {
            border: 2px dashed #94a3b8;
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            background-color: #f1f5f9;
            transition: all 0.3s;
        }

        .upload-area:hover {
            background-color: #e0f2fe;
            border-color: #3b82f6;
        }

        .upload-placeholder span {
            font-size: 2rem;
            color: #3b82f6;
        }

        .upload-placeholder p {
            color: #475569;
            font-size: 0.9rem;
        }

        /* Image preview grid */
        .image-preview {
            position: relative;
            margin-right: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .image-preview img {
            width: 100px;
            height: 100px;
            border-radius: 0.5rem;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .image-preview .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ef4444;
            border: none;
            color: #fff;
            font-size: 0.8rem;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        /* Modal buttons */
        .modal-footer .btn {
            min-width: 100px;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .modal-footer .btn-primary {
            background-color: #3b82f6;
            border: none;
            box-shadow: 0 3px 0 #1d4ed8;
        }

        .modal-footer .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #1d4ed8;
        }

        .modal-footer .btn-secondary {
            background-color: #64748b;
            border: none;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #475569;
        }

        .modal-footer .btn-danger {
            background-color: #ef4444;
            border: none;
            box-shadow: 0 3px 0 #b91c1c;
        }

        .modal-footer .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #b91c1c;
        }

        /* Detail modal (readonly fields) */
        .modal-body .form-control[readonly],
        .modal-body textarea[readonly] {
            background-color: #e2e8f0;
            border: none;
            color: #334155;
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

        <div class="container">
            <!-- Reminder Modal -->
            <?php if (!empty($parkir_reminders)) : ?>
                <div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reminderModalLabel">Reminder!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Beberapa data parkir akan segera berakhir dalam waktu 7 hari ke depan:</p>
                                <ul>
                                    <?php foreach ($parkir_reminders as $reminder) : ?>
                                        <li>
                                            <strong>Perusahaan:</strong> <?= htmlspecialchars($reminder['perusahaan']); ?><br>
                                            <strong>Nama Member:</strong> <?= htmlspecialchars($reminder['nama_member']); ?><br>
                                            <strong>No Kendaraan:</strong> <?= htmlspecialchars($reminder['no_kendaraan']); ?><br>
                                            <strong>No Kartu:</strong> <?= htmlspecialchars($reminder['no_kartu']); ?><br>
                                            <strong>Tanggal Berakhir:</strong> <?= htmlspecialchars($reminder['tgl_berakhir']); ?><br>
                                            <a href="#" class="btn btn-primary edit-btn" data-id_parkir="<?= $reminder['id_parkir']; ?>" data-perusahaan="<?= $reminder['perusahaan']; ?>" data-nama_member="<?= $reminder['nama_member']; ?>" data-no_kendaraan="<?= $reminder['no_kendaraan']; ?>" data-no_kartu="<?= $reminder['no_kartu']; ?>" data-jenis_kendaraan="<?= $reminder['jenis_kendaraan']; ?>" data-tgl_pembuatan="<?= $reminder['tgl_pembuatan']; ?>" data-tgl_berakhir="<?= $reminder['tgl_berakhir']; ?>" data-keterangan="<?= $reminder['keterangan']; ?>" data-scan_dokumen="<?= $reminder['scan_dokumen']; ?>" data-status="<?= $reminder['status']; ?>">Edit</a>
                                        </li>
                                        <hr>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <div class="row mb-3">
            <div class="col-lg-12">
                <!-- Tombol Export -->
                <a href="<?= base_url('user/export_parkir'); ?>" class="btn btn-success">
                    <i class="fas fa-file-export"></i> Export Data
                </a>
                <a href="#newParkirmodal" class="btn btn-primary" data-toggle="modal">
                    <i class="fas fa-plus"></i> Tambah Member Parkir
                </a>
                <!-- Tombol untuk membuka modal import -->
                <a href="#importModal" class="btn btn-warning" data-toggle="modal">
                    <i class="fas fa-upload"></i> Import Data
                </a>
            </div>
        </div>

        <div class="table-responsive mx-auto">
            <table class="table table-bordered" id="parkir-filter-tabel" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Perusahaan</th>
                        <th scope="col">Nama Member</th>
                        <th scope="col">No Kendaraan</th>
                        <th scope="col">No Kartu</th>
                        <th scope="col">Jenis Kendaraan</th>
                        <th scope="col">Tanggal Pembuatan</th>
                        <th scope="col">Tanggal Berakhir</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Scan PDF</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parkirs as $data) : ?>
                        <tr>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['id_parkir'] ?? ''); ?>"><?= $data['id_parkir'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['perusahaan'] ?? ''); ?>"><?= $data['perusahaan'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['nama_member'] ?? ''); ?>"><?= $data['nama_member'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['no_kendaraan'] ?? ''); ?>"><?= $data['no_kendaraan'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['no_kartu'] ?? ''); ?>"><?= $data['no_kartu'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['jenis_kendaraan'] ?? ''); ?>"><?= $data['jenis_kendaraan'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['tgl_pembuatan'] ?? ''); ?>"><?= $data['tgl_pembuatan'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['tgl_berakhir'] ?? ''); ?>"><?= $data['tgl_berakhir'] ?? ''; ?></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($data['keterangan'] ?? ''); ?>"><?= $data['keterangan'] ?? ''; ?></td>
                            <td>
                                <?php if ($data['scan_dokumen']) : ?>
                                    <a href="<?= base_url('assets/upload/parkir/' . $data['scan_dokumen']); ?>" target="_blank">
                                        <?= htmlspecialchars($data['scan_dokumen'] ?? 'No file'); ?>
                                    </a>
                                <?php else : ?>
                                    No file
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="buttons">
                                    <!-- Button to trigger Detail Modal -->
                                    <button class="btn btn-info btn-detail" data-toggle="modal" data-target="#detailModal"
                                        data-id_parkir="<?= $data['id_parkir']; ?>"
                                        data-perusahaan="<?= htmlspecialchars($data['perusahaan'] ?? ''); ?>"
                                        data-nama_member="<?= htmlspecialchars($data['nama_member'] ?? ''); ?>"
                                        data-no_kendaraan="<?= htmlspecialchars($data['no_kendaraan'] ?? ''); ?>"
                                        data-no_kartu="<?= htmlspecialchars($data['no_kartu'] ?? ''); ?>"
                                        data-jenis_kendaraan="<?= htmlspecialchars($data['jenis_kendaraan'] ?? ''); ?>"
                                        data-tgl_pembuatan="<?= htmlspecialchars($data['tgl_pembuatan'] ?? ''); ?>"
                                        data-tgl_berakhir="<?= htmlspecialchars($data['tgl_berakhir'] ?? ''); ?>"
                                        data-keterangan="<?= htmlspecialchars($data['keterangan'] ?? ''); ?>"
                                        data-scan_dokumen="<?= htmlspecialchars($data['scan_dokumen'] ?? ''); ?>">
                                        Detail
                                    </button>

                                    <!-- Button to trigger Edit Modal -->
                                    <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal"
                                        data-id_parkir="<?= $data['id_parkir']; ?>"
                                        data-perusahaan="<?= htmlspecialchars($data['perusahaan'] ?? ''); ?>"
                                        data-nama_member="<?= htmlspecialchars($data['nama_member'] ?? ''); ?>"
                                        data-no_kendaraan="<?= htmlspecialchars($data['no_kendaraan'] ?? ''); ?>"
                                        data-no_kartu="<?= htmlspecialchars($data['no_kartu'] ?? ''); ?>"
                                        data-jenis_kendaraan="<?= htmlspecialchars($data['jenis_kendaraan'] ?? ''); ?>"
                                        data-tgl_pembuatan="<?= htmlspecialchars($data['tgl_pembuatan'] ?? ''); ?>"
                                        data-tgl_berakhir="<?= htmlspecialchars($data['tgl_berakhir'] ?? ''); ?>"
                                        data-keterangan="<?= htmlspecialchars($data['keterangan'] ?? ''); ?>"
                                        data-scan_dokumen="<?= htmlspecialchars($data['scan_dokumen'] ?? ''); ?>">
                                        Edit
                                    </button>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="newParkirmodal" tabindex="-1" role="dialog" aria-labelledby="newParkirmodalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newParkirmodal">Add New Partial Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('Parkir/add'); ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="perusahaan">Perusahaan</label>
                                <input type="text" class="form-control" id="perusahaan" name="perusahaan" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_member">Nama Member</label>
                                <input type="text" class="form-control" id="nama_member" name="nama_member" required>
                            </div>
                            <div class="form-group">
                                <label for="no_kendaraan">No Kendaraan</label>
                                <input type="text" class="form-control" id="no_kendaraan" name="no_kendaraan" required>
                            </div>
                            <div class="form-group">
                                <label for="no_kartu">No kartu</label>
                                <input type="text" class="form-control" id="no_kartu" name="no_kartu">
                            </div>
                            <div class="form-group">
                                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_pembuatan">Tanggal pembuatan</label>
                                <input type="date" class="form-control" id="tgl_pembuatan" name="tgl_pembuatan">
                            </div>
                            <div class="form-group">
                                <label for="tgl_berakhir">Tanggal Berakhir</label>
                                <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir">
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan">
                            </div>
                            <div class="form-group">
                                <label for="scan_dokumen_jpg">Upload Images</label>
                                <div id="uploadArea" class="upload-area">
                                    <div class="upload-placeholder">
                                        <span>+</span>
                                        <p>Click or Drag & Drop to Upload Images</p>
                                    </div>
                                    <input type="file" id="scan_dokumen_jpg" name="scan_dokumen_jpg[]" multiple hidden>
                                </div>
                                <div id="imagePreviewContainer" class="d-flex flex-wrap mt-3"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
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
                        <h5 class="modal-title" id="detailModalLabel">Detail Parkir</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-id_parkir">ID Parkir</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-id_parkir" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-perusahaan">Perusahaan</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-perusahaan" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-nama_member">Nama Member</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-nama_member" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-no_kendaraan">No Kendaraan</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-no_kendaraan" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-no_kartu">No Kartu</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-no_kartu" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modal-jenis_kendaraan">Jenis Kendaraan</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-jenis_kendaraan" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-tgl_pembuatan">Tanggal Pembuatan</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-tgl_pembuatan" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-tgl_berakhir">Tanggal Berakhir</label>
                                        <input type="text" class="form-control border-0 bg-light" id="modal-tgl_berakhir" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="modal-keterangan">Keterangan</label>
                                        <textarea class="form-control border-0 bg-light" id="modal-keterangan" rows="3" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label for="modal-scan_dokumen">Scan Dokumen (PDF)</label>
                                <a href="#" id="modal-scan_dokumen" class="btn btn-outline-primary btn-sm" target="_blank">View File</a>
                            </div>
                            <div class="form-group mt-4">
                                <label for="modal-scan_dokumen_jpg">Scan Dokumen (Images)</label>
                                <div id="modal-scan_dokumen_jpg" class="d-flex flex-wrap">
                                    <!-- Images will be displayed here -->
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Parkir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="post" action="<?= base_url('parkir/update'); ?>">

                            <div class="form-group">
                                <label for="edit-perusahaan">ID</label>
                                <input type="text" class="form-control" id="edit-id_parkir" name="id_parkir" readonly>
                            </div>
                            <div class="form-group">
                                <label for="edit-perusahaan">Perusahaan</label>
                                <input type="text" class="form-control" id="edit-perusahaan" name="perusahaan" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-nama_member">Nama Member</label>
                                <input type="text" class="form-control" id="edit-nama_member" name="nama_member" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-no_kendaraan">No Kendaraan</label>
                                <input type="text" class="form-control" id="edit-no_kendaraan" name="no_kendaraan" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-no_kartu">No Kartu</label>
                                <input type="text" class="form-control" id="edit-no_kartu" name="no_kartu">
                            </div>
                            <div class="form-group">
                                <label for="edit-jenis_kendaraan">Jenis Kendaraan</label>
                                <input type="text" class="form-control" id="edit-jenis_kendaraan" name="jenis_kendaraan" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-tgl_pembuatan">Tanggal Pembuatan</label>
                                <input type="date" class="form-control" id="edit-tgl_pembuatan" name="tgl_pembuatan" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-tgl_berakhir">Tanggal Berakhir</label>
                                <input type="date" class="form-control" id="edit-tgl_berakhir" name="tgl_berakhir" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-keterangan">Keterangan</label>
                                <textarea class="form-control" id="edit-keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit-scan_dokumen">Scan Dokumen</label>
                                <input type="file" class="form-control" id="edit-scan_dokumen" name="scan_dokumen">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
                        <button type="button" id="nonActiveBtn" class="btn btn-danger">Non Active</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Import -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Parkir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('user/import_parkir'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="importFile">Pilih File Excel:</label>
                                <input type="file" class="form-control-file" id="importFile" name="importFile" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
        $(document).ready(function() {
            var table = $('#parkir-filter-tabel').DataTable({
                "stateSave": true // Enable state saving to maintain page state
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

            // Re-apply event handlers after DataTables operations
            table.on('draw', function() {
                // Handle detail button click
                $('.btn-detail').off('click').on('click', function() {
                    var id_parkir = $(this).data('id_parkir');
                    var perusahaan = $(this).data('perusahaan');
                    var nama_member = $(this).data('nama_member');
                    var no_kendaraan = $(this).data('no_kendaraan');
                    var no_kartu = $(this).data('no_kartu');
                    var jenis_kendaraan = $(this).data('jenis_kendaraan');
                    var tgl_pembuatan = $(this).data('tgl_pembuatan');
                    var tgl_berakhir = $(this).data('tgl_berakhir');
                    var keterangan = $(this).data('keterangan');
                    var scan_dokumen = $(this).data('scan_dokumen');

                    $('#modal-id_parkir').val(id_parkir);
                    $('#modal-perusahaan').val(perusahaan);
                    $('#modal-nama_member').val(nama_member);
                    $('#modal-no_kendaraan').val(no_kendaraan);
                    $('#modal-no_kartu').val(no_kartu);
                    $('#modal-jenis_kendaraan').val(jenis_kendaraan);
                    $('#modal-tgl_pembuatan').val(tgl_pembuatan);
                    $('#modal-tgl_berakhir').val(tgl_berakhir);
                    $('#modal-keterangan').val(keterangan);
                    if (scan_dokumen) {
                        $('#modal-scan_dokumen').attr('href', '<?= base_url('assets/upload/parkir/'); ?>' + scan_dokumen);
                        $('#modal-scan_dokumen').text(scan_dokumen);
                    } else {
                        $('#modal-scan_dokumen').attr('href', '#').text('No file');
                    }
                });

                // Handle edit button click
                $('.edit-btn').off('click').on('click', function() {
                    var id_parkir = $(this).data('id_parkir');
                    var perusahaan = $(this).data('perusahaan');
                    var nama_member = $(this).data('nama_member');
                    var no_kendaraan = $(this).data('no_kendaraan');
                    var no_kartu = $(this).data('no_kartu');
                    var jenis_kendaraan = $(this).data('jenis_kendaraan');
                    var tgl_pembuatan = $(this).data('tgl_pembuatan');
                    var tgl_berakhir = $(this).data('tgl_berakhir');
                    var keterangan = $(this).data('keterangan');
                    var scan_dokumen = $(this).data('scan_dokumen');
                    var status = $(this).data('status');

                    $('#edit-id_parkir').val(id_parkir);
                    $('#edit-perusahaan').val(perusahaan);
                    $('#edit-nama_member').val(nama_member);
                    $('#edit-no_kendaraan').val(no_kendaraan);
                    $('#edit-no_kartu').val(no_kartu);
                    $('#edit-jenis_kendaraan').val(jenis_kendaraan);
                    $('#edit-tgl_pembuatan').val(tgl_pembuatan);
                    $('#edit-tgl_berakhir').val(tgl_berakhir);
                    $('#edit-keterangan').val(keterangan);

                    if (scan_dokumen) {
                        $('#edit-scan_dokumen').next('label').text('Current file: ' + scan_dokumen);
                    } else {
                        $('#edit-scan_dokumen').next('label').text('No file');
                    }

                    // Hide the reminder modal
                    $('#reminderModal').modal('hide');

                    // Show the edit modal
                    $('#editModal').modal('show');
                });
            });

            // Trigger a redraw to ensure event handlers are attached initially
            table.draw();

            // Hide alerts after 3 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Show reminder modal if reminders exist
            <?php if (!empty($parkir_reminders)) : ?>
                $('#reminderModal').modal('show');
            <?php endif; ?>

            $('#nonActiveBtn').on('click', function() {
                var id_parkir = $('#edit-id_parkir').val();
                console.log('ID Parkir:', id_parkir); // Log ID parkir

                if (id_parkir) {
                    $.ajax({
                        url: '<?= base_url('parkir/move_to_non_active'); ?>',
                        type: 'POST',
                        data: {
                            id_parkir: id_parkir
                        },
                        success: function(response) {
                            console.log('Response:', response); // Log response
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                                alert('Data moved to non-active successfully');
                                $('#editModal').modal('hide');
                                location.reload();
                            } else {
                                alert('Error: ' + res.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                } else {
                    alert('No ID provided');
                }
            });

            // Handle form submission
            $('#editForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = new FormData(this); // Create a FormData object from the form

                $.ajax({
                    url: $(this).attr('action'), // Use the form's action attribute
                    type: 'POST',
                    data: formData,
                    contentType: false, // Required for file uploads
                    processData: false, // Required for file uploads
                    success: function(response) {
                        $('#editModal').modal('hide');
                        location.reload(); // Reload the page or refresh the table
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            document.getElementById('uploadArea').addEventListener('click', function() {
                document.getElementById('scan_dokumen_jpg').click();
            });

            document.getElementById('scan_dokumen_jpg').addEventListener('change', function(event) {
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const files = event.target.files;

                // Iterate through the files and add previews
                for (let i = 0; i < Math.min(files.length, 3); i++) { // Limit to 3 previews
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewBox = document.createElement('div');
                        previewBox.classList.add('image-preview');

                        const img = document.createElement('img');
                        img.src = e.target.result;

                        const removeButton = document.createElement('button');
                        removeButton.classList.add('remove-image');
                        removeButton.innerHTML = '&times;';
                        removeButton.addEventListener('click', function() {
                            previewBox.remove();
                        });

                        previewBox.appendChild(img);
                        previewBox.appendChild(removeButton);
                        imagePreviewContainer.appendChild(previewBox);
                    };

                    reader.readAsDataURL(file);
                }
            });

            document.getElementById('uploadArea').addEventListener('dragover', function(event) {
                event.preventDefault();
                event.stopPropagation();
                this.classList.add('dragging');
            });

            document.getElementById('uploadArea').addEventListener('dragleave', function(event) {
                event.preventDefault();
                event.stopPropagation();
                this.classList.remove('dragging');
            });

            document.getElementById('uploadArea').addEventListener('drop', function(event) {
                event.preventDefault();
                event.stopPropagation();
                this.classList.remove('dragging');

                const files = event.dataTransfer.files;

                // Handle drag-and-drop files
                const inputFileElement = document.getElementById('scan_dokumen_jpg');
                const dataTransfer = new DataTransfer();

                // Combine existing files in input and new files from drag-and-drop
                for (let i = 0; i < inputFileElement.files.length; i++) {
                    dataTransfer.items.add(inputFileElement.files[i]);
                }
                for (let i = 0; i < files.length; i++) {
                    dataTransfer.items.add(files[i]);
                }

                inputFileElement.files = dataTransfer.files;
                inputFileElement.dispatchEvent(new Event('change'));
            });

        });
    </script>

</body>

</html>