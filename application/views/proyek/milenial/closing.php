<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #1e293b;
        }

        .main-container {
            background-color: #fff;
            border-radius: 1rem;
            padding: 2rem;
            margin: 2rem auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 95%;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            table-layout: auto;
            /* biar proporsional */
            overflow: visible !important;
        }

        table.dataTable thead th {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #fff;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
            padding: 10px 8px;
            border-bottom: 2px solid #06b6d4;
            font-size: 0.9rem;
            white-space: normal;
            /* biar teks wrap */
        }

        table.dataTable tbody td {
            text-align: center;
            vertical-align: middle;
            padding: 8px 6px;
            font-size: 0.88rem;
            color: #1e293b;
        }

        table.dataTable tbody tr:hover {
            background-color: #e0f2fe !important;
        }

        /* Tombol 3D */
        .btn-3d {
            font-weight: 600;
            border-radius: 0.4rem;
            padding: 0.35rem 0.6rem;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
            border: none;
            font-size: 0.75rem;
        }

        .btn-3d:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.2);
        }

        .btn-3d-blue {
            background: linear-gradient(to right, #2563eb, #3b82f6);
        }

        .btn-3d-green {
            background: linear-gradient(to right, #10b981, #059669);
        }

        .btn-3d-red {
            background: linear-gradient(to right, #ef4444, #dc2626);
        }

        /* Agar tombol tidak terpotong */
        td.text-center {
            overflow: visible !important;
            white-space: nowrap;
        }

        /* Responsif DataTables */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.5rem;
            padding: 0.4rem 0.6rem;
            border: 1px solid #cbd5e1;
            background-color: #f1f5f9;
        }
    </style>

</head>

<body>
    <div class="main-container">
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('message'); ?></div>
        <?php elseif ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-end mb-3">
            <a href="<?= base_url('User/export_closing_excel') ?>" class="btn-3d btn-3d-green export-btn">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </a>
        </div>

        <div class="table-responsive">
            <table id="closingTable" class="display table table-bordered w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>No Kontrak</th>
                        <th>Nama DC</th>
                        <th>Pekerjaan</th>
                        <th>Tgl Terima BAST</th>
                        <th>Tgl Final Account</th>
                        <th>File PDF</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($closing as $fa) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $fa['id_closing']; ?></td>
                            <td><?= $fa['no_kontrak']; ?></td>
                            <td><?= $fa['nama_pt']; ?></td>
                            <td><?= $fa['pekerjaan']; ?></td>
                            <td><?= $fa['tgl_terima_bast']; ?></td>
                            <td><?= $fa['tgl_closing']; ?></td>
                            <td>
                                <?php if (!empty($fa['scan_fa'])) : ?>
                                    <a href="<?= base_url('assets/upload/' . $fa['scan_fa']); ?>" target="_blank" class="btn-3d btn-3d-green">
                                        <i class="fas fa-download"></i>
                                    </a>
                                <?php else : ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $fa['keterangan_fa']; ?></td>
                            <td class="text-center">
                                <button
                                    class="btn-3d btn-3d-blue btn-sm editFinalAccount"
                                    data-id="<?= $fa['id_closing']; ?>"
                                    data-no_kontrak="<?= $fa['no_kontrak']; ?>"
                                    data-nama_pt="<?= $fa['nama_pt']; ?>"
                                    data-pekerjaan="<?= $fa['pekerjaan']; ?>"
                                    data-tgl_terima_bast="<?= $fa['tgl_terima_bast']; ?>"
                                    data-tgl_closing="<?= $fa['tgl_closing']; ?>"
                                    data-keterangan="<?= $fa['keterangan_fa']; ?>"
                                    data-toggle="modal"
                                    data-target="#editFaModal">
                                    <i class="fas fa-edit"></i> EDIT
                                </button>

                                <button type="button" class="btn-3d btn-3d-green btn-detail" data-id="<?= $fa['id_closing']; ?>" data-toggle="modal" data-target="#finalAccountDetailModal" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn-3d btn-3d-red btn-delete" data-id="<?= $fa['id_closing']; ?>" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- ================= MODAL EDIT ================= -->
    <div class="modal fade" id="editFaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-xl overflow-hidden">
                <div class="modal-header text-white" style="background: linear-gradient(90deg, #3b82f6, #06b6d4);">
                    <h5 class="modal-title font-semibold">✏️ Edit Final Account</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="<?= base_url('User/update') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body bg-gray-50">
                        <input type="hidden" id="editId" name="id_closing">

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="font-semibold text-sm text-gray-700">No Kontrak</label>
                                <input type="text" class="form-control" id="no_kontrak" name="no_kontrak" required>
                            </div>
                            <div class="form-group">
                                <label class="font-semibold text-sm text-gray-700">Nama DC</label>
                                <input type="text" class="form-control" id="nama_pt" name="nama_pt" required>
                            </div>
                            <div class="form-group">
                                <label class="font-semibold text-sm text-gray-700">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                            </div>
                            <div class="form-group">
                                <label class="font-semibold text-sm text-gray-700">Tanggal Terima BAST</label>
                                <input type="date" class="form-control" id="tgl_terima_bast" name="tgl_terima_bast">
                            </div>
                            <div class="form-group">
                                <label class="font-semibold text-sm text-gray-700">Tanggal Final Account</label>
                                <input type="date" class="form-control" id="tgl_closing" name="tgl_closing">
                            </div>
                            <div class="form-group col-span-2">
                                <label class="font-semibold text-sm text-gray-700">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan_fa" name="keterangan_fa">
                            </div>
                            <div class="form-group col-span-2">
                                <label class="font-semibold text-sm text-gray-700">Upload File PDF</label>
                                <input type="file" class="form-control-file" id="edit_scan_fa" name="ScanFA" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-100">
                        <button type="submit" class="btn-3d btn-3d-blue">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <button type="button" class="btn-3d btn-3d-red" data-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================= MODAL DETAIL ================= -->
    <div class="modal fade" id="finalAccountDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-xl overflow-hidden">
                <div class="modal-header text-white" style="background: linear-gradient(90deg, #06b6d4, #3b82f6);">
                    <h5 class="modal-title font-semibold">📄 Detail Final Account</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-gray-50">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="font-semibold text-gray-700">No Kontrak</p>
                            <p id="modalNoKontrak" class="text-gray-600"></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Nama DC</p>
                            <p id="modalNamaPT" class="text-gray-600"></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Pekerjaan</p>
                            <p id="modalPekerjaan" class="text-gray-600"></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Tanggal Terima BAST</p>
                            <p id="modalTglTerimaBast" class="text-gray-600"></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Tanggal Final Account</p>
                            <p id="modalTglClosing" class="text-gray-600"></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Keterangan</p>
                            <p id="modalketerangan" class="text-gray-600"></p>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <a id="pdfDownloadLink" href="#" target="_blank" class="btn-3d btn-3d-green">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </a>
                    </div>
                </div>
                <div class="modal-footer bg-gray-100 border-t">
                    <button type="button" class="btn-3d btn-3d-red" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#closingTable').DataTable({
                pageLength: 10,
                autoWidth: false,
                responsive: true
            });

            // tombol detail
            $('.btn-detail').on('click', function() {
                const id = $(this).data('id');
                $.post('<?= base_url('user/get_closing_data'); ?>', {
                    id: id
                }, function(data) {
                    if (data) {
                        $('#modalNoKontrak').text(data.no_kontrak);
                        $('#modalNamaPT').text(data.nama_pt);
                        $('#modalPekerjaan').text(data.pekerjaan);
                        $('#modalTglTerimaBast').text(data.tgl_terima_bast);
                        $('#modalTglClosing').text(data.tgl_closing);
                        $('#modalketerangan').text(data.keterangan_fa);
                        $('#pdfDownloadLink').attr('href', '<?= base_url('assets/upload/') ?>' + data.scan_fa);
                    }
                }, 'json');
            });

            // buka modal dan isi datanya
            $('.editFinalAccount').on('click', function() {
                $('#editId').val($(this).data('id'));
                $('#no_kontrak').val($(this).data('no_kontrak'));
                $('#nama_pt').val($(this).data('nama_pt'));
                $('#pekerjaan').val($(this).data('pekerjaan'));
                $('#tgl_terima_bast').val($(this).data('tgl_terima_bast'));
                $('#tgl_closing').val($(this).data('tgl_closing'));
                $('#keterangan_fa').val($(this).data('keterangan'));
            });
        });
    </script>
</body>

</html>