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
    </style>
</head>


<body class="bg-gradient-to-r from-white via-cyan-100 to-cyan-400 min-h-screen">
    <div class="main-container mx-auto">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary mb-3 btn-3d" data-toggle="modal" data-target="#newAsBuiltDrawingModal">Tambah Data</button>
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
                                <!-- <th scope="col">Action</th> -->
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
                                    <!-- <td>
                                        <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal" data-id_asbuilt="<?= $row['id_asbuilt']; ?>" data-no-kontrak="<?= $row['no_kontrak']; ?>" data-nama-pt="<?= $row['nama_pt']; ?>" data-pekerjaan="<?= $row['pekerjaan']; ?>" data-tgl-terima="<?= $row['tgl_terima']; ?>" data-status="<?= $row['status']; ?>" data-keterangan="<?= $row['keterangan']; ?>">
                                            Edit
                                        </button>
                                    </td> -->
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Tambah Data -->
    <div class="modal fade modal-background" id="newAsBuiltDrawingModal" tabindex="-1" aria-labelledby="newAsBuiltDrawingModalLabel" aria-hidden="true">
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
                            <label for="nama_pt">Nama PT</label>
                            <select class="form-control" id="nama_pt" name="nama_pt" required>
                                <option value="">Pilih Nama PT</option>
                                <?php foreach ($finalAccount as $fa) : ?>
                                    <option value="<?= $fa['nama_pt']; ?>"><?= $fa['nama_pt']; ?></option>
                                <?php endforeach; ?>
                            </select>
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
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Nama Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="status">Paket Pekerjaan</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="Status">
                        </div>
                        <div class="form-group">
                            <label for="tgl_terima">Tanggal Terima</label>
                            <input type="date" class="form-control" id="tgl_terima" name="tgl_terima" placeholder="Tanggal Terima Asbuilt">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Asbuilt">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

            // Menambahkan opsi ke dropdown
            $('#nama_pt').append(options.map(function(option) {
                return $('<option>', {
                    value: option.id,
                    text: option.text
                });
            }));

            // Inisialisasi Select2
            $('#nama_pt').select2({
                placeholder: "Pilih Nama PT",
                allowClear: true,
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }
                    if (typeof data.text === 'undefined') {
                        return null;
                    }
                    // Ubah kata kunci pencarian menjadi lowercase
                    var term = params.term.toLowerCase();
                    // Hilangkan "PT." dan "CV." dan cek huruf pertama setelah itu
                    var text = data.text.replace(/^(PT|CV)\.\s*/i, '').toLowerCase();
                    if (text.includes(term)) {
                        return data;
                    }
                    return null;
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
                            $('#no_kontrak').append('<option value="' + value.no_kontrak + '">' + value.no_kontrak + '</option>');
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
                    success: function(data) {
                        $('#pekerjaan').val(data.pekerjaan);
                        // Get status by pekerjaan
                        $.ajax({
                            url: '<?= base_url('user/getStatusByPekerjaan'); ?>',
                            method: 'POST',
                            data: {
                                pekerjaan: data.pekerjaan
                            },
                            dataType: 'json',
                            success: function(statusData) {
                                $('#status').val(statusData.status);
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>