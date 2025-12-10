<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include CSS and JS dependencies -->
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>

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

        .modal-header {
            background-color: #007bff;
            color: white;
            border-bottom: 1px solid #e5e5e5;
        }

        .modal-header .close {
            color: white;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #e5e5e5;
        }

        .modal-body ul {
            list-style: none;
            padding: 0;
        }

        .modal-body ul li {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
        }

        .modal-body ul li strong {
            display: block;
            margin-bottom: 5px;
        }

        .inactive {
            display: none;
        }

        .modal-dialog {
            overflow-y: auto;
            max-height: 80vh;
        }

        body.modal-open {
            overflow: auto;
        }

        .modal {
            overflow: auto;
        }

        .btn {
            pointer-events: auto;
        }

        /* Additional Styles */
        .card-title,
        .card-body {
            color: #333;
        }

        .text-center {
            text-align: center;
        }
    </style>

</head>

<body>
    <div class="container mt-4">
        <div class="container-fluid" style="background-image: url('<?= base_url('assets/img/background/footer.jpg'); ?>'); background-size: cover; background-position: center;">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>ID Parkir</th>
                        <th>Perusahaan</th>
                        <th>Nama Member</th>
                        <th>No Kendaraan</th>
                        <th>No Kartu</th>
                        <th>Jenis Kendaraan</th>
                        <th>Tanggal Pembuatan</th>
                        <th>Tanggal Berakhir</th>
                        <th>Keterangan</th>
                        <th>Scan Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($non_active_parkir)) : ?>
                        <?php foreach ($non_active_parkir as $parkir) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($parkir['id_parkir'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['perusahaan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['nama_member'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['no_kendaraan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['no_kartu'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['jenis_kendaraan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['tgl_pembuatan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['tgl_berakhir'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if (!empty($parkir['scan_dokumen'])) : ?>
                                        <a href="<?= base_url('assets/upload/parkir/') . htmlspecialchars($parkir['scan_dokumen'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">View</a>
                                    <?php else : ?>
                                        No file
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="text-center">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>