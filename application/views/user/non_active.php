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
            padding: 5rem 1rem;
            width: 100%;
        }

        .table-responsive {
            overflow-x: auto;
        }


        .container-fluid {
            background-color: #fff;
            padding-top: 5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
            /* margin: auto;
            max-width: 100%; */

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
    </style>
</head>


<body class="bg-gradient-to-r from-white via-cyan-100 to-cyan-400 min-h-screen">

    <div class="container-fluid max-w-full">
        <div class="table-responsive">
            <table class="table table-bordered data-table" id="data-tabel">
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
                                <td><?php echo htmlspecialchars($parkir['jenis_kendaraan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td><?php echo htmlspecialchars($parkir['tgl_pembuatan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td><?php echo htmlspecialchars($parkir['tgl_berakhir'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($parkir['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if (!empty($parkir['scan_dokumen'])) : ?>
                                        <a href="<?= base_url('assets/upload/parkir/') . htmlspecialchars($parkir['scan_dokumen'], ENT_QUOTES, 'UTF-8'); ?>"
                                            target="_blank">View</a>
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