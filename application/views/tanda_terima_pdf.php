<!DOCTYPE html>
<html>

<head>
    <title>Tanda Terima Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            color: #333;
            margin: 10px;
        }

        .header {
            display: flex;
            align-items: flex-start;
            /* Ini penting agar logo & teks sejajar atas */
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .header img {
            width: 100px;
            /* Sesuaikan ukuran, jangan terlalu besar */
            height: auto;
            margin-right: 20px;
            margin-top: 5px;
            /* opsional jika ingin lebih rata */
        }

        .header h1 {
            font-size: 18pt;
            margin: 0;
            line-height: 1.2;
        }

        .header p {
            margin: 2px 0;
            font-size: 10pt;
            line-height: 1.2;
        }


        h2.title {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 14pt;
            letter-spacing: 1px;
        }

        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.detail-table th,
        table.detail-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .signature-table {
            width: 100%;
            margin-top: 10px;
            text-align: center;
        }

        .signature-table td {
            border: none;
            padding: 50px 10px 0 10px;
        }

        .signature-table .label {
            padding-bottom: 60px;
        }

        .note-section {
            margin-top: 2px;
        }

        .note-section h4 {
            margin-bottom: 5px;
            font-size: 11pt;
        }

        .note-box {
            border: 1px dashed #888;
            height: 100px;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="data:image/png;base64,<?= base64_encode(file_get_contents(FCPATH . 'assets/img/tokyo.png')) ?>" alt="Logo">
        <div>
            <h1>PT. Mandiri Bangun Makmur</h1>
            <p>ASG Headquarter - PIK Office</p>
            <p>Jl. Pantai Indah Kapuk Boulevard</p>
            <p>Kamal Muara, Penjaringan - Jakarta Utara (14470)</p>
        </div>
    </div>

    <h2 class="title">Tanda Terima Barang</h2>

    <table class="detail-table">
        <tr>
            <th>Nama Barang</th>
            <td><?= $item['nama_barang']; ?></td>
        </tr>
        <tr>
            <th>Jenis Barang</th>
            <td><?= $item['jenis_barang']; ?></td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td><?= $item['lokasi']; ?></td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td><?= $item['jumlah_awal'] . ' ' . $item['satuan']; ?></td>
        </tr>
        <tr>
            <th>Tanggal Keluar</th>
            <td><?= $item['tanggal_keluar']; ?></td>
        </tr>
        <tr>
            <th>Pengirim</th>
            <td><?= $item['pengirim']; ?></td>
        </tr>
        <tr>
            <th>Penerima</th>
            <td><?= $item['penerima']; ?></td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td><?= $item['keterangan']; ?></td>
        </tr>
    </table>

    <div class="note-section">
        <h4>Catatan / Note :</h4>
        <div class="note-box">
            <!-- Kosong agar bisa ditulis tangan setelah dicetak -->
        </div>
    </div>


    <table class="signature-table">
        <tr>
            <td>Pengirim</td>
            <td>Penerima</td>
        </tr>
        <tr>
            <td class="label">(<?= $item['pengirim']; ?>)</td>
            <td class="label">(<?= $item['penerima']; ?>)</td>
        </tr>
    </table>


</body>

</html>