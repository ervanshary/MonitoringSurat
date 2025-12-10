<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data BAST</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/modal-styles.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .container-fluid {
            padding: 20px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.9);

        }

        .table-responsive {
            max-width: 100%;
            overflow-x: auto;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table tbody tr {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .table tbody tr:hover {
            background-color: rgba(220, 220, 220, 0.8);
        }

        .modal-content {
            background-color: rgba(255, 255, 255, 0.95);
        }

        .dataTables_filter label,
        .dataTables_length label,
        .dataTables_info {
            color: white;
        }

        .form-group label,
        .modal-body label,
        .card-title,
        .card-body {
            color: black;
        }

        .buttons {
            display: flex;
            width: 150px;
            gap: 10px;
            --b: 5px;
            --h: 1.8em;
        }

        .buttons button {
            cursor: pointer;
            height: 50px;
            width: 50px;
            font-family: 'Titillium Web', sans-serif;
            color: #333;
            border-radius: 100%;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.1);
            background: white;
            margin: 5px;
            transition: 1s;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .buttons button span {
            width: 0px;
            overflow: hidden;
            transition: 1s;
            text-align: center;
        }

        .buttons button:hover {
            width: 150px;
            border-radius: 5px;
        }

        .buttons button:hover span {
            padding: 2px;
            width: max-content;
        }

        .table-responsive {
            overflow-x: auto;
        }

        #partial-data-tabel {
            width: 100% !important;
            max-width: 100%;
            white-space: nowrap;
        }

        /* Batasi lebar kolom dan tambahkan ellipsis untuk teks panjang */
        .table td {
            max-width: 150px;
            /* Atur lebar maksimum sesuai kebutuhan */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

</head>


<body>
    <div class="container-fluid" style="background-image: url('<?= base_url('assets/img/background/footer.jpg'); ?>'); background-size: cover; background-position: center;">
        <!-- Page Heading -->
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('message'); ?></div>
        <?php elseif ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
        <!-- Tombol Export -->
        <div>
            <a href="<?= base_url('user/export_partial'); ?>" class="btn btn-success">
                <i class="fas fa-file-export"></i> Export Data
            </a>
            <a href="#newPartialModal" class="btn btn-primary" data-toggle="modal">
                <i class="fas fa-plus"></i> Add New Partial
            </a>

            <!-- Tombol untuk membuka modal import -->
            <!-- <a href="#importModal" class="btn btn-success" data-toggle="modal">
                    <i class="fas fa-upload"></i> Import Data
                </a> -->

            <div class="table-responsive mx-auto">
                <table class="table table-bordered" id="partial-data-tabel" style="width: 100%;">
                    <thead class="thead-dark">
                        <tr>
                            <!-- <th scope="col">#</th> -->
                            <th scope="col">Lokasi</th>
                            <th scope="col">Area</th>
                            <th scope="col">Pekerjaan</th>
                            <th scope="col">Nama Kontraktor</th>
                            <th scope="col">No Dokumen</th>
                            <th scope="col">Tgl Kirim POM</th>
                            <th scope="col">Tgl Kembali POM</th>
                            <th scope="col">Tgl Kembali Kontraktor</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Scan PDF</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($partials as $partial) : ?>
                            <tr class="data-row" data-tgl-kirim-pom="<?= $partial['tgl_kirim_pom']; ?>" data-tgl-kembali-pom="<?= $partial['tgl_kembali_pom']; ?>">
                                <!-- <th scope="row"><?= $partial['id_parsial']; ?></th> -->
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['lokasi']); ?>"><?= $partial['lokasi']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['area']); ?>"><?= $partial['area']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['pekerjaan']); ?>"><?= $partial['pekerjaan']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['nama_kontraktor']); ?>"><?= $partial['nama_kontraktor']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['no_dokumen']); ?>"><?= $partial['no_dokumen']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['tgl_kirim_pom']); ?>"><?= $partial['tgl_kirim_pom']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['tgl_kembali_pom']); ?>"><?= $partial['tgl_kembali_pom']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['tgl_kembali_kontraktor']); ?>"><?= $partial['tgl_kembali_kontraktor']; ?></td>
                                <td data-toggle="tooltip-click" data-placement="top" title="<?= htmlspecialchars($partial['keterangan']); ?>"><?= $partial['keterangan']; ?></td>

                                <td>
                                    <?php if ($partial['scan_pdf']) : ?>
                                        <a href="<?= base_url('assets/upload/partial/' . $partial['scan_pdf']); ?>" target="_blank">
                                            <?= $partial['scan_pdf']; ?>
                                        </a>
                                    <?php else : ?>
                                        No file
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="buttons">
                                        <!-- Button to trigger Detail Modal -->
                                        <button class="btn btn-info btn-detail" data-toggle="modal" data-target="#detailModal" data-id_parsial="<?= $partial['id_parsial']; ?>" data-lokasi="<?= $partial['lokasi']; ?>" data-area="<?= $partial['area']; ?>" data-pekerjaan="<?= $partial['pekerjaan']; ?>" data-nama_kontraktor="<?= $partial['nama_kontraktor']; ?>" data-no_dokumen="<?= $partial['no_dokumen']; ?>" data-tgl_kirim_pom="<?= $partial['tgl_kirim_pom']; ?>" data-tgl_kembali_pom="<?= $partial['tgl_kembali_pom']; ?>" data-tgl_kembali_kontraktor="<?= $partial['tgl_kembali_kontraktor']; ?>" data-keterangan="<?= $partial['keterangan']; ?>" data-scan_pdf="<?= $partial['scan_pdf']; ?>">
                                            <i class="fas fa-info-circle"></i> <span>Detail</span>
                                        </button>

                                        <!-- Button to trigger Edit Modal -->
                                        <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal" data-id_parsial="<?= $partial['id_parsial']; ?>" data-lokasi="<?= $partial['lokasi']; ?>" data-area="<?= $partial['area']; ?>" data-pekerjaan="<?= $partial['pekerjaan']; ?>" data-nama_kontraktor="<?= $partial['nama_kontraktor']; ?>" data-no_dokumen="<?= $partial['no_dokumen']; ?>" data-tgl_kirim_pom="<?= $partial['tgl_kirim_pom']; ?>" data-tgl_kembali_pom="<?= $partial['tgl_kembali_pom']; ?>" data-tgl_kembali_kontraktor="<?= $partial['tgl_kembali_kontraktor']; ?>" data-keterangan="<?= $partial['keterangan']; ?>" data-scan_pdf="<?= $partial['scan_pdf']; ?>">
                                            <i class="fas fa-edit"></i> <span>Edit</span>
                                        </button>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- </div> -->

        <!-- Tombol Import -->
        <div class="container">
            <!-- Import Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Data Partial</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('user/import_partial'); ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file_partial">Pilih File Excel (.xlsx atau .xls)</label>
                                    <input type="file" class="form-control-file" id="file_partial" name="file_partial" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="newPartialModal" tabindex="-1" role="dialog" aria-labelledby="newPartialModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newPartialModalLabel">Add New Partial Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('user/add'); ?>" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                                </div>
                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" name="area" required>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_kontraktor">Nama Kontraktor</label>
                                    <input type="text" class="form-control" id="nama_kontraktor" name="nama_kontraktor" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_dokumen">No Dokumen</label>
                                    <input type="text" class="form-control" id="no_dokumen" name="no_dokumen" required>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_kirim_pom">Tgl Kirim POM</label>
                                    <input type="date" class="form-control" id="tgl_kirim_pom" name="tgl_kirim_pom">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_kembali_pom">Tgl Kembali POM</label>
                                    <input type="date" class="form-control" id="tgl_kembali_pom" name="tgl_kembali_pom">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_kembali_kontraktor">Tgl Kembali Kontraktor</label>
                                    <input type="date" class="form-control" id="tgl_kembali_kontraktor" name="tgl_kembali_kontraktor">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan">
                                </div>
                                <div class="form-group">
                                    <label for="scan_pdf">Scan PDF</label>
                                    <input type="file" class="form-control" id="scan_pdf" name="scan_pdf">
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



            <!-- Detail Modal -->
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Detail Partial Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Lokasi:</strong> <span id="detail-lokasi"></span></p>
                            <p><strong>Area:</strong> <span id="detail-area"></span></p>
                            <p><strong>Pekerjaan:</strong> <span id="detail-pekerjaan"></span></p>
                            <p><strong>Nama Kontraktor:</strong> <span id="detail-nama_kontraktor"></span></p>
                            <p><strong>No Dokumen:</strong> <span id="detail-no_dokumen"></span></p>
                            <p><strong>Tgl Kirim POM:</strong> <span id="detail-tgl_kirim_pom"></span></p>
                            <p><strong>Tgl Kembali POM:</strong> <span id="detail-tgl_kembali_pom"></span></p>
                            <p><strong>Tgl Kembali Kontraktor:</strong> <span id="detail-tgl_kembali_kontraktor"></span></p>
                            <p><strong>Keterangan:</strong> <span id="detail-keterangan"></span></p>
                            <p><strong>Scan PDF:</strong> <span id="detail-scan_pdf"></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Partial Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('user/update_partial'); ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" id="edit-id" name="id_parsial">
                                <div class="form-group">
                                    <label for="edit-lokasi">Lokasi</label>
                                    <input type="text" class="form-control" id="edit-lokasi" name="lokasi" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-area">Area</label>
                                    <input type="text" class="form-control" id="edit-area" name="area" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control" id="edit-pekerjaan" name="pekerjaan" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-nama_kontraktor">Nama Kontraktor</label>
                                    <input type="text" class="form-control" id="edit-nama_kontraktor" name="nama_kontraktor" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-no_dokumen">No Dokumen</label>
                                    <input type="text" class="form-control" id="edit-no_dokumen" name="no_dokumen" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit-tgl_kirim_pom">Tgl Kirim POM</label>
                                    <input type="date" class="form-control" id="edit-tgl_kirim_pom" name="tgl_kirim_pom">
                                </div>
                                <div class="form-group">
                                    <label for="edit-tgl_kembali_pom">Tgl Kembali POM</label>
                                    <input type="date" class="form-control" id="edit-tgl_kembali_pom" name="tgl_kembali_pom">
                                </div>
                                <div class="form-group">
                                    <label for="edit-tgl_kembali_kontraktor">Tgl Kembali Kontraktor</label>
                                    <input type="date" class="form-control" id="edit-tgl_kembali_kontraktor" name="tgl_kembali_kontraktor">
                                </div>
                                <div class="form-group">
                                    <label for="edit-keterangan">Keterangan</label>
                                    <input type="text" class="form-control" id="edit-keterangan" name="keterangan">
                                </div>
                                <div class="form-group">
                                    <label for="scan_pdf">Scan PDF</label>
                                    <input type="file" class="form-control-file" id="scan_pdf" name="scan_pdf">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#partial-data-tabel').DataTable({
                "stateSave": true // Enable state saving to maintain page state
            });

            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);

            $('[data-toggle="tooltip"]').tooltip();

            // $('#partialTable').DataTable({
            //     "paging": true,
            //     "lengthChange": false,
            //     "searching": true,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true
            // });

            $('[data-toggle="tooltip-click"]').tooltip();

            // Detail modal
            $('.btn-detail').on('click', function() {
                $('#detail-lokasi').text($(this).data('lokasi'));
                $('#detail-area').text($(this).data('area'));
                $('#detail-pekerjaan').text($(this).data('pekerjaan'));
                $('#detail-nama_kontraktor').text($(this).data('nama_kontraktor'));
                $('#detail-no_dokumen').text($(this).data('no_dokumen'));
                $('#detail-tgl_kirim_pom').text($(this).data('tgl_kirim_pom'));
                $('#detail-tgl_kembali_pom').text($(this).data('tgl_kembali_pom'));
                $('#detail-tgl_kembali_kontraktor').text($(this).data('tgl_kembali_kontraktor'));
                $('#detail-keterangan').text($(this).data('keterangan'));
                $('#detail-scan_pdf').text($(this).data('scan_pdf'));
            });

            // Edit modal
            $('.edit-btn').on('click', function() {
                $('#edit-id').val($(this).data('id_parsial'));
                $('#edit-lokasi').val($(this).data('lokasi'));
                $('#edit-area').val($(this).data('area'));
                $('#edit-pekerjaan').val($(this).data('pekerjaan'));
                $('#edit-nama_kontraktor').val($(this).data('nama_kontraktor'));
                $('#edit-no_dokumen').val($(this).data('no_dokumen'));
                $('#edit-tgl_kirim_pom').val($(this).data('tgl_kirim_pom'));
                $('#edit-tgl_kembali_pom').val($(this).data('tgl_kembali_pom'));
                $('#edit-tgl_kembali_kontraktor').val($(this).data('tgl_kembali_kontraktor'));
                $('#edit-keterangan').val($(this).data('keterangan'));
                $('#edit-scan_pdf').val($(this).data('scan_pdf'));
            });
        });
    </script>
</body>

</html>