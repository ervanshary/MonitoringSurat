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
    }

    /* === RESPONSIVE TABLE (OPSI 3) === */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* === TRUNCATE STYLE (OPSI 1) === */
    .truncate-cell {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }

    /* Header gradient */
    #reportTable thead {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: #fff;
    }

    #reportTable th {
        text-transform: uppercase;
        font-weight: 600;
        padding: 10px;
    }

    #reportTable td {
        border: 1px solid #e2e8f0;
        padding: 8px;
        color: #1e293b;
    }

    #reportTable tbody tr:hover {
        background-color: #e0f2fe;
    }

    .btn-success {
        background-color: #16a34a;
        border: none;
    }

    .btn-success:hover {
        background-color: #15803d;
    }

    /* === OPTIMASI LEBAR TABEL DAN HEADER === */
    #reportTable th,
    #reportTable td {
        padding: 0.35rem 0.5rem !important;
        /* lebih kecil dari default */
        font-size: 0.85rem !important;
        /* sedikit lebih kecil */
        vertical-align: middle !important;
    }

    /* Batasi tinggi baris agar tabel lebih rapat */
    #reportTable tbody tr {
        line-height: 1.2rem;
    }

    /* Batasi lebar kolom panjang, bungkus teks */
    #reportTable td {
        max-width: 160px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        /* tampilkan "..." kalau teks panjang */
    }

    /* Saat hover, munculkan teks penuh */
    #reportTable td:hover {
        white-space: normal;
        overflow: visible;
        background-color: #e0f2fe !important;
        z-index: 10;
        position: relative;
    }

    /* Header table (rapat & jelas) */
    #reportTable thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Supaya table responsif di layar kecil */
    .table-responsive {
        overflow-x: auto;
        max-width: 100%;
    }
    </style>
</head>

<body>
    <div class="main-container mx-auto">

        <!-- Export Excel - BAST 1 & BAST 2 -->
        <div class="mb-3 flex items-center gap-3 flex-wrap">
            <input type="text" id="searchExport" placeholder="Cari data..." value="<?= $this->input->get('search') ?>"
                class="border rounded-lg p-2 w-64">

            <form method="GET" action="<?= base_url('User/export_report_bast1') ?>" class="d-inline" id="formBast1">
                <input type="hidden" name="search" id="searchBast1" value="<?= $this->input->get('search') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-file-excel-o mr-1"></i> Export BAST 1
                </button>
            </form>

            <form method="GET" action="<?= base_url('User/export_report_bast2') ?>" class="d-inline" id="formBast2">
                <input type="hidden" name="search" id="searchBast2" value="<?= $this->input->get('search') ?>">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-file-excel-o mr-1"></i> Export BAST 2
                </button>
            </form>

            <form method="GET" action="<?= base_url('User/export_report') ?>" class="d-inline" id="formAll">
                <input type="hidden" name="search" id="searchAll" value="<?= $this->input->get('search') ?>">
                <button type="submit" class="btn btn-secondary">
                    <i class="fa fa-file-excel-o mr-1"></i> Export All
                </button>
            </form>
        </div>

        <script>
        // Update semua hidden input saat user mengetik di search box
        document.getElementById('searchExport').addEventListener('input', function() {
            const searchValue = this.value;
            document.getElementById('searchBast1').value = searchValue;
            document.getElementById('searchBast2').value = searchValue;
            document.getElementById('searchAll').value = searchValue;
        });
        </script>

        <div class="table-responsive">
            <table id="reportTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No Kontrak</th>
                        <th>Nama PT</th>
                        <th>Pekerjaan</th>
                        <th>Tanggal Terima Asbuilt</th>
                        <th>Tanggal Terima BAST</th>
                        <th>Retensi</th>
                        <th>Tanggal Final Account</th>
                        <th>Tanggal Terima BAST 2</th>
                        <th>Tanggal kirim POM</th>
                        <th>Tanggal kembali POM</th>
                        <th>Tanggal Kirim Kepusat</th>
                        <th>Tanggal Kembali</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $row) : ?>
                    <tr>
                        <td><?= $row['no_kontrak']; ?></td>
                        <td><?= $row['nama_pt']; ?></td>

                        <!-- truncate kolom panjang -->
                        <td class="truncate-cell"
                            onclick="showDetail('<?= htmlspecialchars($row['pekerjaan'], ENT_QUOTES); ?>')">
                            <?= $row['pekerjaan']; ?>
                        </td>

                        <td><?= ($row['tgl_terima_asbuilt'] == '0000-00-00') ? '' : $row['tgl_terima_asbuilt']; ?></td>
                        <td><?= $row['tgl_terima_bast']; ?></td>
                        <td><?= $row['opsi_retensi'] . ' hari'; ?></td>
                        <td><?= $row['tgl_closing']; ?></td>
                        <td><?= ($row['tgl_terima_bast2'] == '0000-00-00') ? '' : $row['tgl_terima_bast2']; ?></td>
                        <td><?= ($row['tgl_pom'] == '0000-00-00') ? '' : $row['tgl_pom']; ?></td>
                        <td><?= ($row['kembali_pom'] == '0000-00-00') ? '' : $row['kembali_pom']; ?></td>
                        <td><?= ($row['tgl_pusat2'] == '0000-00-00') ? '' : $row['tgl_pusat2']; ?></td>
                        <td><?= ($row['tgl_kontraktor2'] == '0000-00-00') ? '' : $row['tgl_kontraktor2']; ?></td>

                        <!-- truncate juga keterangan -->
                        <td class="truncate-cell"
                            onclick="showDetail('<?= htmlspecialchars($row['keterangan'], ENT_QUOTES); ?>')">
                            <?= $row['keterangan']; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- === MODAL DETAIL === -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-lg">
                <div class="modal-header bg-blue-600 text-white rounded-t-lg">
                    <h5 class="modal-title font-semibold" id="detailModalLabel">Detail Informasi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-2xl">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <p id="modalContent" class="text-gray-800"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded-md"
                        id="closeModalBtn">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        // DataTables
        $('#reportTable').DataTable({
            "destroy": true,
            "order": [],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Data tidak tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "zeroRecords": "Data tidak ditemukan",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        // Tampilkan modal detail
        window.showDetail = function(text) {
            $('#modalContent').text(text);
            $('#detailModal').modal('show');
        };

        // Tutup modal (perbaikan)
        $('#closeModalBtn').click(function() {
            $('#detailModal').modal('hide');
        });
    });
    </script>

</body>

</html>