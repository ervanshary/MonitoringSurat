<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Bootstrap & Tailwind -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #1e293b;
        }

        .main-container {
            background-color: #fff;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
            margin: 2rem auto;
            max-width: 95%;
            width: 100%;
        }

        /* ==== TABLE ==== */
        #data-tabel {
            width: 100% !important;
            table-layout: fixed;
            /* penting agar kolom proporsional */
        }

        #data-tabel thead {
            background: linear-gradient(90deg, #3b82f6, #06b6d4) !important;
            color: white;
        }

        #data-tabel th {
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.6rem;
            font-size: 0.8rem;
        }

        #data-tabel td {
            padding: 0.55rem;
            font-size: 0.85rem;
            color: #1e293b;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* teks panjang tampil saat hover */
        #data-tabel td:hover {
            white-space: normal;
            overflow: visible;
            background-color: #e0f2fe;
            position: relative;
            z-index: 1;
        }

        #data-tabel tbody tr:hover {
            background-color: #f0f9ff !important;
        }

        /* ==== Buttons ==== */
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

        .btn-3d.btn-indigo {
            background-color: #4f46e5;
            box-shadow: 0 3px 0 #3730a3;
        }

        .btn-3d.btn-indigo:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #3730a3;
        }

        .btn-3d:active {
            top: 2px;
            transform: translateY(0);
            box-shadow: none !important;
        }
    </style>
</head>


<body class="bg-gradient-to-r from-white via-cyan-100 to-cyan-400 min-h-screen">

    <div class="main-container mx-auto">
        <!-- Judul Halaman -->
        <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b border-gray-200 pb-3">
            <i class="fas fa-file-contract text-indigo-600 mr-3"></i> Data BAST 1
            <span class="text-xl font-normal text-indigo-500">(Asbuilt Drawing)</span>
        </h1>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="bg-green-100 text-green-700 border-l-4 border-green-500 p-4 mb-6 rounded-lg flex justify-between items-center shadow-md" role="alert">
                <span class="font-medium"><?= $this->session->flashdata('message'); ?></span>
                <button type="button" class="text-green-700 opacity-70 hover:opacity-100 focus:outline-none" onclick="this.parentElement.style.display='none';">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="bg-red-100 text-red-700 border-l-4 border-red-500 p-4 mb-6 rounded-lg flex justify-between items-center shadow-md" role="alert">
                <span class="font-medium"><?= $this->session->flashdata('error'); ?></span>
                <button type="button" class="text-red-700 opacity-70 hover:opacity-100 focus:outline-none" onclick="this.parentElement.style.display='none';">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <div class="btn-group mb-3" role="group"> <a href="#" class="btn btn-primary btn-3d" data-toggle="modal" data-target="#addBastModal">Tambah Data</a> <a href="#" class="btn btn-success btn-3d" data-toggle="modal" data-target="#newFaModal">Tambah Data insert</a> <a href="<?= site_url('user/export_bast') ?>" class="btn btn-primary btn-3d"> <i class="fas fa-file-download"></i> Export Excel </a> </div>
    </div>


    <!-- Data Table -->
    <div class="overflow-x-auto shadow-xl rounded-xl px-6 py-4 bg-white">
        <table class="min-w-full text-sm text-left text-gray-700 border-collapse" id="data-tabel">
            <thead>
                <tr class="bg-indigo-600 text-white">
                    <th class="py-3 px-3">ID</th>
                    <th class="py-3 px-3">No Kontrak</th>
                    <th class="py-3 px-3">Nama PT</th>
                    <th class="py-3 px-3">Pekerjaan</th>
                    <th class="py-3 px-3">Tanggal Terima Asbuilt</th>
                    <th class="py-3 px-3">Tanggal Terima BAST 1</th>
                    <th>Keterangan BAST</th>
                    <th>Retensi</th>
                    <th class="py-3 px-3">File PDF</th>
                    <th class="py-3 px-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bastData as $data) : ?>
                    <tr class="border-b border-gray-100 even:bg-gray-50 hover:bg-indigo-100/30 transition">
                        <td class="py-2 px-3 font-medium text-gray-900"><?= $data['id_bast']; ?></td>
                        <td class="py-2 px-3"><?= $data['no_kontrak']; ?></td>
                        <td class="py-2 px-3"><?= $data['nama_pt']; ?></td>
                        <td class="py-2 px-3"><?= $data['pekerjaan']; ?></td>
                        <td class="py-2 px-3"><?= $data['tanggal_terima_asbuilt']; ?></td>
                        <td class="py-2 px-3"><?= $data['tgl_terima_bast']; ?></td>
                        <td data-toggle="tooltip" title="<?= $data['keterangan_bast']; ?>"><?= isset($data['keterangan_bast']) ? $data['keterangan_bast'] : ''; ?></td>
                        <td data-toggle="tooltip" title="<?= $data['opsi_retensi'] . ' hari'; ?>"><?= isset($data['opsi_retensi']) ? $data['opsi_retensi'] . ' hari' : ''; ?></td>
                        <td class="py-2 px-3 text-center">
                            <?php if (!empty($data['file_pdf']) && file_exists(FCPATH . 'assets/upload/bast1/' . $data['file_pdf'])) : ?>
                                <a href="<?= base_url('assets/upload/bast1/' . $data['file_pdf']); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-lg transition">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            <?php else : ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-3 flex flex-col md:flex-row items-center justify-center space-y-1 md:space-y-0 md:space-x-2">
                            <!-- Detail -->
                            <button type="button" class="btn-3d btn-teal text-white text-xs py-1 px-2 btn-detail"
                                data-toggle="modal" data-target="#detailModal1"
                                data-nokontrak="<?= $data['no_kontrak']; ?>"
                                data-namapt="<?= $data['nama_pt']; ?>"
                                data-pekerjaan="<?= $data['pekerjaan']; ?>"
                                data-tanggalasbuilt="<?= $data['tanggal_terima_asbuilt']; ?>"
                                data-statusasbuilt="<?= $data['status_asbuilt']; ?>"
                                data-opsiretensi="<?= $data['opsi_retensi']; ?>"
                                data-tglbast="<?= $data['tgl_terima_bast']; ?>"
                                data-tglpusat="<?= $data['tgl_pusat']; ?>"
                                data-tglkontraktor="<?= $data['tgl_kontraktor']; ?>"
                                data-keterangan="<?= $data['keterangan_bast']; ?>"
                                data-filepdf="<?= $data['file_pdf']; ?>">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </button>

                            <!-- Edit -->
                            <button type="button" class="btn-3d btn-indigo text-white text-xs py-1 px-2 edit-btn"
                                data-toggle="modal" data-target="#editModal1"
                                data-id_bast="<?= $data['id_bast']; ?>"

                                data-nokontrak="<?= $data['no_kontrak']; ?>"
                                data-namapt="<?= $data['nama_pt']; ?>"
                                data-pekerjaan="<?= $data['pekerjaan']; ?>"
                                data-tanggalasbuilt="<?= $data['tanggal_terima_asbuilt']; ?>"
                                data-statusasbuilt="<?= $data['status_asbuilt']; ?>"
                                data-opsiretensi="<?= $data['opsi_retensi']; ?>"
                                data-tglbast="<?= $data['tgl_terima_bast']; ?>"
                                data-tglpusat="<?= $data['tgl_pusat']; ?>"
                                data-tglkontraktor="<?= $data['tgl_kontraktor']; ?>"
                                data-keterangan="<?= $data['keterangan_bast']; ?>"
                                data-filepdf="<?= $data['file_pdf']; ?>">
                                <i class="fas fa-pen mr-1"></i> Edit
                            </button>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- ============================== -->
    <!-- MODALS BAST 1 - Detail & Edit -->
    <!-- ============================== -->

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content bg-white p-6 rounded-xl shadow-2xl border border-gray-100">

                <!-- Header -->
                <div class="modal-header border-b pb-3 mb-4 flex justify-between items-center">
                    <h5 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-info-circle mr-2 text-teal-600"></i> Detail Data BAST 1
                    </h5>
                    <button type="button" class="text-gray-500 hover:text-gray-900 transition" data-dismiss="modal">
                        <span class="text-3xl font-light">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body space-y-6">

                    <!-- Informasi Kontrak -->
                    <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                        <h5 class="text-xl font-semibold mb-4 text-indigo-700 border-b border-indigo-300 pb-2">
                            <i class="fas fa-building mr-2"></i> Informasi Kontrak
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                            <p><strong>No Kontrak:</strong> <span id="modalNoKontrak"></span></p>
                            <p><strong>Nama PT:</strong> <span id="modalNamaPT"></span></p>
                            <p class="col-span-2"><strong>Pekerjaan:</strong> <span id="modalPekerjaan"></span></p>
                            <p><strong>Tgl Terima Asbuilt:</strong> <span id="modalTanggalAsbuilt"></span></p>
                            <p><strong>Status Asbuilt:</strong> <span id="modalStatusAsbuilt"></span></p>
                            <p><strong>Opsi Retensi:</strong> <span id="modalOpsiRetensi"></span></p>
                            <p><strong>Tgl Terima BAST:</strong> <span id="modalTglBast"></span></p>
                            <p><strong>Tgl Pusat:</strong> <span id="modalTglPusat"></span></p>
                            <p><strong>Tgl Kontraktor:</strong> <span id="modalTglKontraktor"></span></p>
                            <p class="col-span-2"><strong>Keterangan:</strong> <span id="modalKeterangan"></span></p>
                        </div>
                    </div>

                    <!-- File PDF -->
                    <div class="bg-teal-50 p-6 rounded-xl border border-teal-200">
                        <h5 class="text-xl font-semibold mb-4 text-teal-700 border-b border-teal-300 pb-2">
                            <i class="fas fa-file-pdf mr-2"></i> Tautan Berkas PDF
                        </h5>
                        <p><strong>File PDF BAST 1:</strong>
                            <a id="modalFilePdf" href="#" target="_blank" class="font-medium text-indigo-600 hover:underline"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content bg-white rounded-xl shadow-2xl border border-gray-100">

                <!-- Header -->
                <div class="modal-header bg-indigo-600 text-white p-5 rounded-t-xl mb-4 flex justify-between items-center">
                    <h5 class="text-2xl font-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Data BAST 1
                    </h5>
                    <button type="button" class="text-white opacity-90 hover:opacity-100 transition" data-dismiss="modal">
                        <span class="text-3xl font-light">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body p-6">
                    <form id="editForm1" action="<?= base_url('user/updatebast1') ?>" method="post" enctype="multipart/form-data">

                        <input type="hidden" name="id_bast" id="editIdBast">

                        <!-- Informasi Kontrak (Read Only) -->
                        <div class="p-5 rounded-xl bg-gray-100 border border-gray-200">
                            <h6 class="text-lg font-bold text-gray-700 mb-4 border-b border-gray-300 pb-2">Informasi Kontrak (Read-Only)</h6>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">No Kontrak</label>
                                    <input type="text" id="editNoKontrak" name="no_kontrak" class="w-full rounded-md border-gray-300 bg-gray-200 cursor-not-allowed p-2 text-sm" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Nama PT</label>
                                    <input type="text" id="editNamaPT" name="nama_pt" class="w-full rounded-md border-gray-300 bg-gray-200 cursor-not-allowed p-2 text-sm" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Pekerjaan</label>
                                    <input type="text" id="editPekerjaan" name="pekerjaan" class="w-full rounded-md border-gray-300 bg-gray-200 cursor-not-allowed p-2 text-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <hr class="border-t border-indigo-200">

                        <!-- Update Data -->
                        <div class="p-6 rounded-xl bg-indigo-50 border border-indigo-200 space-y-4">
                            <h6 class="text-xl font-bold text-indigo-700 border-b border-indigo-300 pb-2">
                                <i class="fas fa-calendar-alt mr-2"></i> Update Data BAST 1
                            </h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Tanggal Terima Asbuilt</label>
                                    <input type="date" id="editTglAsbuilt" name="tanggal_terima_asbuilt" class="w-full rounded-md border-gray-300 p-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Tanggal Terima BAST 1</label>
                                    <input type="date" id="editTglBast" name="tgl_terima_bast" class="w-full rounded-md border-gray-300 p-2 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Status Asbuilt</label>
                                <input type="text" id="editStatusAsbuilt" name="status_asbuilt" class="w-full rounded-md border-gray-300 p-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Opsi Retensi</label>
                                <input type="text" id="editOpsiRetensi" name="opsi_retensi" class="w-full rounded-md border-gray-300 p-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Tanggal Pusat</label>
                                <input type="date" id="editTglPusat" name="tgl_pusat" class="w-full rounded-md border-gray-300 p-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Tanggal Kontraktor</label>
                                <input type="date" id="editTglKontraktor" name="tgl_kontraktor" class="w-full rounded-md border-gray-300 p-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Keterangan</label>
                                <textarea id="editKeterangan" name="keterangan" class="w-full rounded-md border-gray-300 p-2 text-sm" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Upload File PDF</label>
                                <input type="file" id="editFilePdf" name="file_pdf" accept=".pdf" class="w-full text-sm text-gray-700">
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer pt-6 border-t border-gray-200 flex justify-end space-x-3">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn-3d btn-indigo text-white shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambahkan data -->
    <div class="modal fade" id="addBastModal" tabindex="-1" role="dialog" aria-labelledby="addBastModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addBastModalLabel">Tambah Data BAST</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('user/add_bast_data'); ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6"> <!-- Input untuk Nama PT -->
                                <div class="form-group"> <label for="nama_pt" class="required">Nama PT:</label> <select class="form-control" id="nama_pt" name="nama_pt">
                                        <option value="">Pilih Nama PT</option> <?php $nama_pt_list = array_unique(array_column($id_asbuilts, 'nama_pt'));
                                                                                foreach ($nama_pt_list as $nama_pt) : ?> <option value="<?= $nama_pt; ?>"><?= $nama_pt; ?></option> <?php endforeach; ?>
                                    </select> </div> <!-- Input untuk No Kontrak -->
                                <div class="form-group"> <label for="no_kontrak" class="required">No Kontrak:</label> <select class="form-control" id="no_kontrak" name="no_kontrak">
                                        <option value="">Pilih No Kontrak</option> <?php foreach ($id_asbuilts as $asbuilt) : ?> <option value="<?= $asbuilt['no_kontrak']; ?>" data-nama-pt="<?= $asbuilt['nama_pt']; ?>" data-id-asbuilt="<?= $asbuilt['id_asbuilt']; ?>" data-pekerjaan="<?= $asbuilt['pekerjaan']; ?>"> <?= $asbuilt['no_kontrak']; ?> </option> <?php endforeach; ?>
                                    </select> </div>
                                <div class="form-group"> <label for="pekerjaan" class="required">Pekerjaan:</label> <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" readonly> </div> <!-- Input tersembunyi untuk ID Asbuilt --> <input type="hidden" id="id_asbuilt" name="id_asbuilt"> <!-- Input tanggal -->
                                <div class="form-group"> <label for="tgl_terima_bast" class="required">Tanggal Terima BAST:</label> <input type="date" id="tgl_terima_bast" name="tgl_terima_bast" class="form-control"> </div>
                                <div class="form-group"> <label for="tgl_pusat">Tanggal Pusat:</label> <input type="date" id="tgl_pusat" name="tgl_pusat" class="form-control"> </div>
                                <div class="form-group"> <label for="tgl_kontraktor">Tanggal Kontraktor:</label> <input type="date" id="tgl_kontraktor" name="tgl_kontraktor" class="form-control"> </div>
                            </div>
                            <div class="col-md-6"> <!-- Input untuk Opsi Retensi -->
                                <div class="form-group"> <label for="opsi_retensi" class="required">Opsi Retensi:</label> <select class="form-control" id="opsi_retensi" name="opsi_retensi">
                                        <option value="90">90 hari</option>
                                        <option value="120">120 hari</option>
                                        <option value="180">180 hari</option>
                                        <option value="365">365 hari</option>
                                        <option value="730">730 hari</option>
                                        <option value="0">Tanpa Retensi</option>
                                    </select> </div> <!-- Textarea untuk Keterangan -->
                                <div class="form-group"> <label for="keterangan_bast" class="required">Keterangan:</label> <textarea id="keterangan_bast" name="keterangan" class="form-control" style="resize: vertical;" required></textarea> </div> <!-- Upload PDF -->
                                <div class="form-group"> <label for="file_pdf">Unggah PDF:</label> <input type="file" id="file_pdf" name="file_pdf" class="form-control-file" accept="application/pdf"> </div> <!-- Tombol submit -->
                                <div class="form-group text-right mt-3"> <button type="submit" class="btn btn-primary">Submit</button> </div>
                            </div>
                        </div>
                    </form>
                </div> <!-- Modal Footer -->
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button> </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#data-tabel').DataTable({
                "paging": true,
                "lengthChange": true,
                "lengthMenu": [10, 50, 100],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "stateSave": true, // << simpan halaman terakhir saat refresh
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "search": "Cari:",
                    "zeroRecords": "Tidak ada data yang cocok ditemukan"
                }
            });

            // Event delegation utk tombol detail
            $(document).on('click', '.btn-detail', function() {
                $('#modalNoKontrak').text($(this).data('nokontrak'));
                $('#modalNamaPT').text($(this).data('namapt'));
                $('#modalPekerjaan').text($(this).data('pekerjaan'));
                $('#modalStatusAsbuilt').text($(this).data('statusasbuilt'));
                $('#modalOpsiRetensi').text($(this).data('opsiretensi'));
                $('#modalTanggalAsbuilt').text($(this).data('tanggalasbuilt'));
                $('#modalTglBast').text($(this).data('tglbast'));
                $('#modalTglPusat').text($(this).data('tglpusat'));
                $('#modalTglKontraktor').text($(this).data('tglkontraktor'));
                $('#modalKeterangan').text($(this).data('keterangan'));
                $('#modalFilePdf').attr('href', "<?= base_url('assets/upload/bast/') ?>" + $(this).data('filepdf'))
                    .text($(this).data('filepdf'));
            });

            $(document).on('click', '.edit-btn', function() {
                $('#editIdBast').val($(this).data('id_bast'));
                $('#editIdAsbuilt').val($(this).data('id_asbuilt')); // tambahkan
                $('#editNoKontrak').val($(this).data('nokontrak'));
                $('#editNamaPT').val($(this).data('namapt'));
                $('#editPekerjaan').val($(this).data('pekerjaan'));
                $('#editTglAsbuilt').val($(this).data('tanggalasbuilt'));
                $('#editStatusAsbuilt').val($(this).data('statusasbuilt'));
                $('#editOpsiRetensi').val($(this).data('opsiretensi'));
                $('#editTglBast').val($(this).data('tglbast'));
                $('#editTglPusat').val($(this).data('tglpusat'));
                $('#editTglKontraktor').val($(this).data('tglkontraktor'));
                $('#editKeterangan').val($(this).data('keterangan'));
            });


            // Auto close flash message
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        });

        $(document).ready(function() {
            $('#data-tabel').DataTable({
                pageLength: 10,
                responsive: true
            });
        });
    </script>
</body>

</html>