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
        background-color: #ffffff;
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
        margin: 2rem auto;
        max-width: 95%;
        width: 100%;
    }

    /* ======== TABEL ======== */
    #data-tabel {
        width: 100% !important;
        border-collapse: collapse;
    }

    #data-tabel thead {
        background: linear-gradient(90deg, #3b82f6, #06b6d4) !important;
        color: #ffffff !important;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    #data-tabel thead th {
        font-weight: 600;
        text-transform: uppercase;
        padding: 0.75rem !important;
        font-size: 0.8rem !important;
        line-height: 1.2;
        text-align: left;
        white-space: normal;
        word-wrap: break-word;
    }

    #data-tabel td {
        padding: 0.65rem !important;
        font-size: 0.85rem;
        color: #1e293b !important;
        border: 1px solid #e2e8f0;
        line-height: 1.4;
        vertical-align: middle;
    }

    /* tampil penuh saat hover */
    #data-tabel tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    #data-tabel td:hover {
        background-color: #e0f2fe;
    }

    /* Set column widths untuk lebih proporsional */
    #data-tabel th:nth-child(1), 
    #data-tabel td:nth-child(1) { width: 5%; min-width: 50px; }
    
    #data-tabel th:nth-child(2), 
    #data-tabel td:nth-child(2) { width: 10%; min-width: 120px; }
    
    #data-tabel th:nth-child(3), 
    #data-tabel td:nth-child(3) { width: 12%; min-width: 120px; }
    
    #data-tabel th:nth-child(4), 
    #data-tabel td:nth-child(4) { width: 14%; min-width: 150px; }
    
    #data-tabel th:nth-child(5),
    #data-tabel th:nth-child(6),
    #data-tabel th:nth-child(7),
    #data-tabel th:nth-child(8),
    #data-tabel th:nth-child(9),
    #data-tabel th:nth-child(10),
    #data-tabel th:nth-child(11),
    #data-tabel td:nth-child(5),
    #data-tabel td:nth-child(6),
    #data-tabel td:nth-child(7),
    #data-tabel td:nth-child(8),
    #data-tabel td:nth-child(9),
    #data-tabel td:nth-child(10),
    #data-tabel td:nth-child(11) { width: 8%; min-width: 100px; }
    
    #data-tabel th:nth-child(12), 
    #data-tabel td:nth-child(12) { width: 10%; min-width: 100px; }
    
    #data-tabel th:nth-child(13), 
    #data-tabel td:nth-child(13) { width: 8%; min-width: 100px; }
    
    #data-tabel th:nth-child(14),
    #data-tabel th:nth-child(15),
    #data-tabel th:nth-child(16),
    #data-tabel td:nth-child(14),
    #data-tabel td:nth-child(15),
    #data-tabel td:nth-child(16) { width: 7%; min-width: 80px; }
    
    #data-tabel th:nth-child(17), 
    #data-tabel td:nth-child(17) { width: 9%; min-width: 100px; }

    /* ======== DataTables control ======== */
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

    /* ===== BUTTONS CERAH ===== */
    .btn-3d {
        position: relative;
        padding: 0.5rem 0.9rem;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 0.4rem;
        transition: all 0.2s ease;
        top: 0;
        color: #fff !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        border: none;
        white-space: nowrap;
        min-width: fit-content;
    }

    .btn-3d i {
        margin-right: 0.4rem;
        font-size: 0.8rem;
    }

    .btn-3d.btn-teal {
        background-color: #14b8a6;
        box-shadow: 0 2px 0 #0f766e;
    }

    .btn-3d.btn-teal:hover {
        background-color: #0d9488;
        transform: translateY(-1px);
        box-shadow: 0 3px 0 #0f766e;
    }

    .btn-3d.btn-indigo {
        background-color: #4f46e5;
        box-shadow: 0 2px 0 #3730a3;
    }

    .btn-3d.btn-indigo:hover {
        background-color: #4338ca;
        transform: translateY(-1px);
        box-shadow: 0 3px 0 #3730a3;
    }

    .btn-3d:active {
        top: 1px;
        transform: translateY(0);
        box-shadow: none !important;
    }

    /* Action cell buttons layout */
    .action-buttons {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .action-buttons .btn-3d {
        flex-shrink: 0;
    }
    </style>
</head>


<body class="bg-gradient-to-r from-white via-cyan-100 to-cyan-400 min-h-screen">


    <div class="main-container mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b border-gray-200 pb-3">
            <i class="fas fa-file-signature text-indigo-600 mr-3"></i>Data BAST 2 <span
                class="text-xl font-normal text-indigo-500">(Tanda Tangan Proses)</span>
        </h1>

        <!-- Export Excel Menu -->
        <form method="GET" action="<?= base_url('User/export_bast2') ?>" class="mb-4 flex items-center gap-2">
            <input type="text" name="search" placeholder="Cari data..." value="<?= $this->input->get('search') ?>"
                class="border rounded-lg p-2 w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit"
                class="btn btn-success bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center gap-2 transition duration-150">
                <i class="fa fa-file-excel-o"></i> Export Excel
            </button>
        </form>

        <!-- === ALERT INFO UNTUK ADMIN === -->
        <?php if ($this->session->userdata('role') == 'admin') : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Admin Tools:</strong>
            <button type="button" class="btn btn-sm btn-warning" id="btnFillCreatedBy">
                <i class="fas fa-edit mr-1"></i> Isi Created By Data Lama
            </button>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <!-- === NOTIFIKASI POM YANG BELUM DIKEMBALIKAN (OVERDUE) === -->
        <?php if (!empty($pom_overdue) && count($pom_overdue) > 0) : ?>
        <div class="bg-red-100 border-l-4 border-red-600 p-4 mb-6 rounded-lg shadow-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-600 text-2xl mt-1"></i>
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-xl font-bold text-red-800 mb-3">
                        <i class="fas fa-clock mr-2"></i>PERHATIAN: POM BELUM DIKEMBALIKAN
                    </h4>
                    <p class="text-red-700 text-sm font-semibold mb-3">
                        Terdapat <?= count($pom_overdue); ?> dokumen BAST 2 yang belum dikembalikan dari POM dan sudah
                        melewati 7 hari!
                    </p>
                    <div class="space-y-2">
                        <?php foreach ($pom_overdue as $item) : ?>
                        <div class="bg-white border border-red-300 rounded-lg p-3">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-bold text-gray-800">
                                        <i class="fas fa-file-contract text-red-600 mr-2"></i>
                                        <?= $item['no_kontrak']; ?>
                                    </p>
                                    <p class="text-sm text-gray-700 mt-1">
                                        <strong>PT:</strong> <?= $item['nama_pt']; ?>
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        <strong>Pekerjaan:</strong> <?= $item['pekerjaan']; ?>
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        <strong>Tanggal Kirim POM:</strong>
                                        <?= date('d-m-Y', strtotime($item['tgl_pom'])); ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-block bg-red-600 text-white text-xs font-bold py-2 px-3 rounded-full">
                                        OVERDUE
                                    </span>
                                    <p class="text-red-800 font-bold text-lg mt-2">
                                        <?= $item['hari_terlewat']; ?> HARI
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="button" class="text-red-600 opacity-70 hover:opacity-100 focus:outline-none"
                    onclick="this.parentElement.parentElement.style.display='none';" aria-label="Close">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>

        <!-- PHP Alert Messages (re-styled with Tailwind) -->
        <?php if ($this->session->flashdata('message')) : ?>
        <div class="bg-green-100 text-green-700 border-l-4 border-green-500 p-4 mb-6 rounded-lg flex justify-between items-center shadow-md"
            role="alert">
            <span class="font-medium"><?= $this->session->flashdata('message'); ?></span>
            <button type="button" class="text-green-700 opacity-70 hover:opacity-100 focus:outline-none"
                onclick="this.parentElement.style.display='none';" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')) : ?>
        <div class="bg-red-100 text-red-700 border-l-4 border-red-500 p-4 mb-6 rounded-lg flex justify-between items-center shadow-md"
            role="alert">
            <span class="font-medium"><?= $this->session->flashdata('error'); ?></span>
            <button type="button" class="text-red-700 opacity-70 hover:opacity-100 focus:outline-none"
                onclick="this.parentElement.style.display='none';" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>

        <!-- Table Section -->
        <div class="overflow-x-auto shadow-xl rounded-xl" style="max-height: 800px; overflow-y: auto;">
            <table class="min-w-full text-sm text-left text-gray-700 bg-white border-collapse" id="data-tabel">
                <!-- Table Header: Indigo background with white text -->
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th scope="col" class="py-3 px-3">ID</th>
                        <th scope="col" class="py-3 px-3">No Kontrak</th>
                        <th scope="col" class="py-3 px-3">Nama PT</th>
                        <th scope="col" class="py-3 px-3">Pekerjaan</th>
                        <th scope="col" class="py-3 px-3">Tgl Terima<br/>BAST 1</th>
                        <th scope="col" class="py-3 px-3 text-center">Retensi</th>
                        <th scope="col" class="py-3 px-3">Tgl Terima<br/>BAST 2</th>
                        <th scope="col" class="py-3 px-3">Tgl Kirim<br/>POM</th>
                        <th scope="col" class="py-3 px-3">Tgl Kembali<br/>POM</th>
                        <th scope="col" class="py-3 px-3">Tgl Kirim<br/>Kepusat</th>
                        <th scope="col" class="py-3 px-3">Tgl Kembali</th>
                        <th scope="col" class="py-3 px-3">Keterangan</th>
                        <th scope="col" class="py-3 px-3">Status<br/>Revisi</th>
                        <th scope="col" class="py-3 px-3">File PDF</th>
                        <th scope="col" class="py-3 px-3">Created By</th>
                        <th scope="col" class="py-3 px-3">Updated By</th>
                        <th scope="col" class="py-3 px-3 text-center">Action</th>
                    </tr>
                </thead>
                <!-- Table Body (PHP loop kept intact) -->
                <tbody>
                    <?php foreach ($bastData as $data) : ?>
                    <tr
                        class="border-b border-gray-100 even:bg-gray-50 hover:bg-indigo-100/30 transition duration-150 ease-in-out">
                        <!-- Data Columns: Using smaller padding (py-2 px-3) for more compact view -->
                        <td class="py-2 px-3 font-medium text-gray-900 truncate max-w-[50px]" data-toggle="tooltip"
                            title="<?= $data['id_bast2']; ?>"><?= $data['id_bast2']; ?></td>
                        <td class="py-2 px-3 truncate max-w-[150px]" data-toggle="tooltip"
                            title="<?= $data['no_kontrak']; ?>"><?= $data['no_kontrak']; ?></td>
                        <td class="py-2 px-3 truncate max-w-[100px]" data-toggle="tooltip"
                            title="<?= $data['nama_pt']; ?>"><?= $data['nama_pt']; ?></td>
                        <td class="py-2 px-3 max-w-[200px] whitespace-normal" data-toggle="tooltip"
                            title="<?= $data['pekerjaan']; ?>"><?= $data['pekerjaan']; ?></td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= $data['tgl_terima_bast']; ?>"><?= $data['tgl_terima_bast']; ?></td>
                        <td class="py-2 px-3 text-center whitespace-nowrap" data-toggle="tooltip"
                            title="<?= $data['opsi_retensi']; ?>"><?= $data['opsi_retensi']; ?></td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= ($data['tgl_terima_bast2'] == '0000-00-00') ? '' : $data['tgl_terima_bast2']; ?>">
                            <?= ($data['tgl_terima_bast2'] == '0000-00-00') ? '' : $data['tgl_terima_bast2']; ?></td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= ($data['tgl_pom'] == '0000-00-00') ? '' : $data['tgl_pom']; ?>">
                            <?= ($data['tgl_pom'] == '0000-00-00') ? '' : $data['tgl_pom']; ?></td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= ($data['kembali_pom'] == '0000-00-00') ? '' : $data['kembali_pom']; ?>">
                            <?= ($data['kembali_pom'] == '0000-00-00') ? '' : $data['kembali_pom']; ?></td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= ($data['tgl_pusat2'] == '0000-00-00') ? '' : $data['tgl_pusat2']; ?>">
                            <?= ($data['tgl_pusat2'] == '0000-00-00') ? '' : $data['tgl_pusat2']; ?></td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= ($data['tgl_kontraktor2'] == '0000-00-00') ? '' : $data['tgl_kontraktor2']; ?>">
                            <?= ($data['tgl_kontraktor2'] == '0000-00-00') ? '' : $data['tgl_kontraktor2']; ?></td>
                        <td class="py-2 px-3 truncate max-w-[100px]" data-toggle="tooltip"
                            title="<?= $data['keterangan2']; ?>"><?= $data['keterangan2']; ?></td>
                        <td class="py-2 px-3 text-center">
                            <?php if (!empty($data['is_revisi_bast2']) && $data['is_revisi_bast2'] == 1) : ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Revisi
                                </span>
                            <?php else : ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Normal
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-3 text-center">
                            <a href="<?= base_url('assets/upload/bast2/' . $data['file_pdf_bast2']); ?>" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 text-lg transition duration-150">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= !empty($data['created_by']) ? $data['created_by'] : '-'; ?>">
                            <?= !empty($data['created_by']) ? $data['created_by'] : '-'; ?>
                        </td>
                        <td class="py-2 px-3 whitespace-nowrap" data-toggle="tooltip"
                            title="<?= !empty($data['updated_by_bast2']) ? $data['updated_by_bast2'] : '-'; ?>">
                            <?= !empty($data['updated_by_bast2']) ? $data['updated_by_bast2'] : '-'; ?>
                        </td>
                        <!-- Action Buttons -->
                        <td class="py-2 px-3">
                            <div class="action-buttons">
                                <button type="button"
                                    class="btn-3d btn-teal btn-detail"
                                    data-toggle="modal" data-target="#detailModal2"
                                    data-nokontrak="<?= $data['no_kontrak']; ?>" data-namapt="<?= $data['nama_pt']; ?>"
                                    data-pekerjaan="<?= $data['pekerjaan']; ?>"
                                    data-tanggalasbuilt="<?= $data['tanggal_terima_asbuilt']; ?>"
                                    data-tglterimabast="<?= $data['tgl_terima_bast']; ?>"
                                    data-filepdf="<?= $data['file_pdf']; ?>"
                                    data-tglterimabast2="<?= $data['tgl_terima_bast2']; ?>"
                                    data-tglpom="<?= $data['tgl_pom']; ?>" data-kembalipom="<?= $data['kembali_pom']; ?>"
                                    data-tglpusat2="<?= $data['tgl_pusat2']; ?>"
                                    data-tglkontraktor2="<?= $data['tgl_kontraktor2']; ?>"
                                    data-filepdfbast2="<?= $data['file_pdf_bast2']; ?>"
                                    data-keterangan="<?= $data['keterangan2']; ?>"
                                    data-createdby="<?= !empty($data['created_by']) ? $data['created_by'] : '-'; ?>"
                                    data-updatedby="<?= !empty($data['updated_by_bast2']) ? $data['updated_by_bast2'] : '-'; ?>"
                                    data-isrevisi="<?= !empty($data['is_revisi_bast2']) ? $data['is_revisi_bast2'] : 0; ?>"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button"
                                    class="btn-3d btn-indigo edit-btn"
                                    data-toggle="modal" data-target="#editModal2" data-id_bast2="<?= $data['id_bast2']; ?>"
                                    data-nokontrak="<?= $data['no_kontrak']; ?>" data-namapt="<?= $data['nama_pt']; ?>"
                                    data-pekerjaan="<?= $data['pekerjaan']; ?>"
                                    data-tglterimabast="<?= $data['tgl_terima_bast']; ?>"
                                    data-tglterimabast2="<?= $data['tgl_terima_bast2']; ?>"
                                    data-tglpom="<?= $data['tgl_pom']; ?>" data-kembalipom="<?= $data['kembali_pom']; ?>"
                                    data-tglpusat2="<?= $data['tgl_pusat2']; ?>"
                                    data-tglkontraktor2="<?= $data['tgl_kontraktor2']; ?>"
                                    data-keterangan="<?= $data['keterangan2']; ?>"
                                    data-filepdfbast2="<?= $data['file_pdf_bast2']; ?>"
                                    data-createdby="<?= !empty($data['created_by']) ? $data['created_by'] : '-'; ?>"
                                    data-updatedby="<?= !empty($data['updated_by_bast2']) ? $data['updated_by_bast2'] : '-'; ?>"
                                    data-isrevisi="<?= !empty($data['is_revisi_bast2']) ? $data['is_revisi_bast2'] : 0; ?>"
                                    title="Edit Data">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <!-- ============================================== -->
        <!-- MODALS (Detail and Edit) - Bootstrap/Tailwind Hybrid Styling -->
        <!-- ============================================== -->

        <div id="modal-content">

            <!-- Modal for Detail (DetailModal2) -->
            <div class="modal fade" id="detailModal2" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <!-- Added Tailwind classes to modal-content for rounded corners and shadow -->
                    <div class="modal-content bg-white p-6 rounded-xl shadow-2xl border border-gray-100">
                        <!-- Header -->
                        <div class="modal-header border-b pb-3 mb-4 flex justify-between items-center">
                            <h5 class="text-2xl font-bold text-gray-800" id="detailModalLabel"><i
                                    class="fas fa-info-circle mr-2 text-teal-600"></i> Detail Data BAST 2</h5>
                            <button type="button"
                                class="text-gray-500 hover:text-gray-900 transition focus:outline-none"
                                data-dismiss="modal" aria-label="Close">
                                <span class="text-3xl font-light">&times;</span>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body space-y-6">

                            <!-- Section 1: Informasi Kontrak -->
                            <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                                <h5 class="text-xl font-semibold mb-4 text-indigo-700 border-b border-indigo-300 pb-2">
                                    <i class="fas fa-building mr-2"></i> Informasi Kontrak
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                                    <p><strong>No Kontrak:</strong> <span class="font-semibold text-gray-900"
                                            id="modalNoKontrak"></span></p>
                                    <p><strong>Nama PT:</strong> <span class="font-semibold text-gray-900"
                                            id="modalNamaPT"></span></p>
                                    <p class="col-span-2"><strong>Pekerjaan:</strong> <span
                                            class="font-medium text-gray-900" id="modalPekerjaan"></span></p>
                                    <p><strong>Tanggal Terima Asbuilt:</strong> <span class="font-medium text-gray-900"
                                            id="modalTanggalAsbuilt"></span></p>
                                    <p><strong>Tanggal Terima BAST 1:</strong> <span class="font-medium text-gray-900"
                                            id="modalTglTerimaBast"></span></p>
                                    <p class="col-span-2"><strong>Tanggal Terima BAST 2:</strong> <span
                                            class="font-medium text-gray-900 text-teal-600"
                                            id="modalTglTerimaBast2"></span></p>
                                </div>
                            </div>

                            <!-- Section 2: Tanggal Pengiriman & TTD Proses -->
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                                <h5 class="text-xl font-semibold mb-4 text-gray-700 border-b border-gray-300 pb-2"><i
                                        class="fas fa-shipping-fast mr-2"></i> Proses Tanda Tangan & Pengiriman</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                                    <p><strong>Tanggal Kirim POM:</strong> <span class="font-medium text-gray-900"
                                            id="modalTglPom"></span></p>
                                    <p><strong>Tanggal Kembali POM:</strong> <span class="font-medium text-gray-900"
                                            id="modalkmbalipom"></span></p>
                                    <p><strong>Tanggal Kirim Ke Pusat:</strong> <span class="font-medium text-gray-900"
                                            id="modalTglPusat2"></span></p>
                                    <p><strong>Tanggal Kembali Kontraktor:</strong> <span
                                            class="font-medium text-gray-900" id="modalTglKontraktor2"></span></p>
                                    <p class="col-span-2"><strong>Keterangan:</strong> <span
                                            class="font-medium text-gray-900 bg-yellow-100 p-2 rounded-lg block mt-1"
                                            id="modalKeterangan"></span></p>
                                </div>
                            </div>

                            <!-- Section 3: File PDF -->
                            <div class="bg-teal-50 p-6 rounded-xl border border-teal-200">
                                <h5 class="text-xl font-semibold mb-4 text-teal-700 border-b border-teal-300 pb-2"><i
                                        class="fas fa-file-pdf mr-2"></i> Tautan Berkas PDF</h5>
                                <p><strong>File PDF BAST 1:</strong> <span class="font-medium text-gray-900 break-all"
                                        id="modalFilePdf"></span></p>
                                <p><strong>File PDF BAST 2:</strong> <span class="font-medium text-gray-900 break-all"
                                        id="modalFilePdfBast2"></span></p>
                            </div>

                            <!-- Section 4: Created By & Updated By -->
                            <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
                                <h5 class="text-xl font-semibold mb-4 text-purple-700 border-b border-purple-300 pb-2">
                                    <i class="fas fa-user-check mr-2"></i> Informasi Audit
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                                    <p><strong>Created By:</strong> <span class="font-medium text-gray-900"
                                            id="modalCreatedBy"></span></p>
                                    <p><strong>Updated By:</strong> <span class="font-medium text-gray-900"
                                            id="modalUpdatedBy"></span></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Edit (EditModal2) -->
            <div class="modal fade" id="editModal2" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <!-- Added Tailwind classes to modal-content for rounded corners and shadow -->
                    <div class="modal-content bg-white rounded-xl shadow-2xl border border-gray-100">

                        <!-- Header: Updated with Indigo background -->
                        <div
                            class="modal-header bg-indigo-600 text-white p-5 rounded-t-xl mb-4 flex justify-between items-center">
                            <h5 class="text-2xl font-bold" id="editModalLabel"><i class="fas fa-edit mr-2"></i> Edit
                                Data BAST 2 (TTD Proses)</h5>
                            <button type="button"
                                class="text-white opacity-90 hover:opacity-100 transition focus:outline-none"
                                data-dismiss="modal" aria-label="Close">
                                <span class="text-3xl font-light">&times;</span>
                            </button>
                        </div>

                        <!-- Body and Form -->
                        <div class="modal-body p-6">
                            <!-- PHP Form Action Kept Intact -->
                            <form id="editForm" action="<?= base_url('user/update_bast2_data') ?>" method="post"
                                enctype="multipart/form-data" class="space-y-6">
                                <input type="hidden" name="id_bast2" id="editIdBast2">
                                <input type="hidden" name="page" id="editPage" value="1">
                                <input type="hidden" name="search" id="editSearch" value="">

                                <!-- INFORMASI KONTRAK (READ-ONLY) -->
                                <div class="p-5 rounded-xl bg-gray-100 border border-gray-200">
                                    <h6 class="text-lg font-bold text-gray-700 mb-4 border-b border-gray-300 pb-2">
                                        Informasi Kontrak (Read-Only)</h6>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="editNoKontrak"
                                                class="block text-sm font-medium text-gray-700">No Kontrak</label>
                                            <input type="text"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200 cursor-not-allowed p-2 text-sm"
                                                id="editNoKontrak" name="no_kontrak" readonly>
                                        </div>
                                        <div>
                                            <label for="editNamaPT" class="block text-sm font-medium text-gray-700">Nama
                                                PT</label>
                                            <input type="text"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200 cursor-not-allowed p-2 text-sm"
                                                id="editNamaPT" name="nama_pt" readonly>
                                        </div>
                                        <div>
                                            <label for="editTglTerimaBast"
                                                class="block text-sm font-medium text-gray-700">Tgl Terima BAST 1 (Acuan
                                                Retensi)</label>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200 cursor-not-allowed p-2 text-sm"
                                                id="editTglTerimaBast" name="tgl_terima_bast" readonly>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label for="editPekerjaan"
                                            class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200 cursor-not-allowed p-2 text-sm"
                                            id="editPekerjaan" name="pekerjaan" readonly>
                                    </div>
                                </div>

                                <hr class="border-t border-indigo-200">

                                <!-- GRUP INPUT TANGGAL TTD BAST 2 (Horizontal Layout) -->
                                <div class="p-6 rounded-xl bg-indigo-50 border border-indigo-200 space-y-4">
                                    <h6 class="text-xl font-bold text-indigo-700 border-b border-indigo-300 pb-2"><i
                                            class="fas fa-calendar-alt mr-2"></i> Update Proses Tanda Tangan BAST 2</h6>

                                    <!-- Row 1: Terima BAST2 & Kirim POM -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="editTglTerimaBast2"
                                                class="block text-sm font-medium text-gray-700">1. Tanggal Terima BAST 2
                                                (Dari Proyek)</label>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm transition duration-150 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                id="editTglTerimaBast2" name="tgl_terima_bast2">
                                        </div>
                                        <div>
                                            <label for="editTglPom" class="block text-sm font-medium text-gray-700">2.
                                                Tanggal Kirim POM</label>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm transition duration-150 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                id="editTglPom" name="tgl_pom">
                                        </div>
                                    </div>

                                    <!-- Row 2: Kembali POM & Kirim Pusat -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="editKembaliPom"
                                                class="block text-sm font-medium text-gray-700">3. Tanggal Kembali ke
                                                POM (Dari TTD Luar)</label>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm transition duration-150 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                id="editKembaliPom" name="kembali_pom">
                                        </div>
                                        <div>
                                            <label for="editTglPusat2"
                                                class="block text-sm font-medium text-gray-700">4. Tanggal Kirim Ke
                                                Pusat BAST 2</label>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm transition duration-150 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                id="editTglPusat2" name="tgl_pusat2">
                                        </div>
                                    </div>

                                    <!-- Row 3: Kembali Kontraktor -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="editTglKontraktor2"
                                                class="block text-sm font-medium text-gray-700">5. Tanggal Kembali ke
                                                Kontraktor</label>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm transition duration-150 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                id="editTglKontraktor2" name="tgl_kontraktor2">
                                        </div>
                                        <!-- Placeholder for alignment or future field -->
                                        <div></div>
                                    </div>

                                    <!-- Keterangan (Full Width) -->
                                    <div class="pt-4">
                                        <label for="editKeterangan"
                                            class="block text-sm font-medium text-gray-700">Keterangan Tambahan (Akan
                                            jadi Komentar di Excel)</label>
                                        <textarea rows="2"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm transition duration-150 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            id="editKeterangan" name="keterangan2"></textarea>
                                    </div>
                                </div>

                                <!-- Flag Revisi -->
                                <div class="p-6 rounded-xl bg-red-50 border border-red-200 space-y-4">
                                    <h6 class="text-xl font-bold text-red-700 border-b border-red-300 pb-2">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> Status Revisi
                                    </h6>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="editIsRevisi2" name="is_revisi" value="1" 
                                            class="h-5 w-5 text-red-600 rounded focus:ring-2 focus:ring-red-500 cursor-pointer">
                                        <label for="editIsRevisi2" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                                            <strong>Centang jika dokumen dikembalikan untuk revisi ke kontraktor</strong>
                                        </label>
                                    </div>
                                    <p class="text-xs text-red-600 mt-2">
                                        Jika dicentang, keterangan otomatis akan berubah menjadi "Revisi BAST 2 dikembalikan ke kontraktor"
                                    </p>
                                </div>

                                <!-- FILE INPUT -->
                                <div class="mt-6 p-5 rounded-xl bg-yellow-50 border border-yellow-200">
                                    <label for="editFilePdfBast2"
                                        class="block text-sm font-bold text-yellow-800 mb-2"><i
                                            class="fas fa-upload mr-2"></i> Upload Ulang File PDF BAST 2</label>
                                    <p class="text-xs text-gray-600 mb-3">Abaikan jika tidak ada perubahan pada file PDF
                                        BAST 2.</p>
                                    <input type="file"
                                        class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer"
                                        id="editFilePdfBast2" name="file_pdf_bast2" accept=".pdf">
                                </div>

                                <!-- Created By & Updated By (Read-Only) -->
                                <div class="mt-6 p-5 rounded-xl bg-purple-50 border border-purple-200">
                                    <h6 class="text-lg font-bold text-purple-700 mb-4 border-b border-purple-300 pb-2">
                                        Informasi Audit (Read-Only)</h6>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="editCreatedBy"
                                                class="block text-sm font-medium text-gray-700">Created By</label>
                                            <input type="text"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200 cursor-not-allowed p-2 text-sm"
                                                id="editCreatedBy" readonly>
                                        </div>
                                        <div>
                                            <label for="editUpdatedBy"
                                                class="block text-sm font-medium text-gray-700">Updated By</label>
                                            <input type="text"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-200 cursor-not-allowed p-2 text-sm"
                                                id="editUpdatedBy" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="modal-footer pt-6 border-t border-gray-200 flex justify-end space-x-3">
                                    <button type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition"
                                        data-dismiss="modal">Tutup</button>
                                    <button type="submit"
                                        class="btn-3d btn-indigo text-white shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- End of modal-content -->
    </div> <!-- End of main-container -->

    <!-- JAVASCRIPT: PENTING UNTUK FUNGSI SUB-MENU BOOTSTRAP (COLLAPSE) DAN MODALS -->
    <!-- Catatan: jQuery, Popper, dan Bootstrap JS harus dimuat dalam urutan ini. -->

    <!-- 1. jQuery (Harus Pertama) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- 2. Popper.js (Dibutuhkan oleh Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- 3. Bootstrap JS (Menyediakan fungsi 'collapse' untuk sub-menu) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

    <!-- === MODAL UNTUK FILL CREATED BY === -->
    <div class="modal fade" id="fillCreatedByModal" tabindex="-1" role="dialog"
        aria-labelledby="fillCreatedByModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="fillCreatedByModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Isi Created By Data Lama
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <strong>Perhatian!</strong> Tindakan ini akan mengisi semua data kosong di kolom
                        <code>created_by</code> dengan "Admin". <br>
                        <strong>Tindakan ini TIDAK BISA DIBATALKAN!</strong>
                    </div>

                    <form id="fillCreatedByForm">
                        <div class="form-group">
                            <label class="font-weight-bold">Tabel yang akan diupdate:</label>
                            <input type="text" class="form-control" value="user_bast2 (BAST 2)" readonly>
                            <small class="text-muted">Data kosong akan diisi dengan user "Admin"</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="btnConfirmFill">
                        <i class="fas fa-check mr-1"></i> Ya, Isi Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Base URL configuration
    var BASE_URL = '<?= base_url() ?>';

    $(document).ready(function() {
        var table = $('#data-tabel');

        if (table.length) {
            if (!$.fn.dataTable.isDataTable('#data-tabel')) {
                table.DataTable({
                    scrollX: true,
                    scrollY: "400px", // tinggi scroll, ubah sesuai kebutuhan
                    scroller: true, // hanya render row visible
                    paging: true,
                    pageLength: 10,
                    searching: true,
                    ordering: true,
                    info: true,
                    responsive: true,
                    deferRender: true, // render row saat visible
                    processing: true,
                    bAutoWidth: false
                });
            }
        }


        // =========================
        // TOOLTIP INITIALIZATION
        // =========================
        try {
            $('[data-toggle="tooltip"]').tooltip({
                delay: {
                    "show": 250,
                    "hide": 100
                }
            });
        } catch (e) {
            console.warn('Tooltip initialization skipped');
        }

        // =========================
        // FILL CREATED BY MODAL
        // =========================
        $('#btnFillCreatedBy').on('click', function() {
            $('#fillCreatedByModal').modal('show');
        });

        $('#btnConfirmFill').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Final',
                html: 'Anda yakin ingin mengisi <strong>created_by</strong> dengan "Admin" untuk:<br><strong>user_bast2 (BAST 2)</strong><br><br><strong class="text-danger">Tindakan ini TIDAK bisa dibatalkan!</strong>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE_URL + 'user/fill_created_by_all',
                        type: 'POST',
                        data: {
                            tables: ['user_bast2']
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#fillCreatedByModal').modal('hide');
                            Swal.fire({
                                title: 'Berhasil!',
                                html: response.message,
                                icon: 'success',
                                timer: 3000
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function(xhr) {
                            var errorMsg = xhr.responseJSON?.message ||
                                'Terjadi error saat memproses data';
                            Swal.fire('Error', errorMsg, 'error');
                        }
                    });
                }
            });
        });

        // =========================
        // DETAIL MODAL LOGIC
        // =========================
        $(document).on('click', '.btn-detail', function(event) {
            event.preventDefault();
            var $btn = $(this);
            var modal = document.getElementById('detailModal2');
            if (!modal) return;

            // Populate modal fields
            modal.querySelector('#modalNoKontrak').textContent = $btn.attr('data-nokontrak') || '';
            modal.querySelector('#modalNamaPT').textContent = $btn.attr('data-namapt') || '';
            modal.querySelector('#modalPekerjaan').textContent = $btn.attr('data-pekerjaan') || '';
            modal.querySelector('#modalTanggalAsbuilt').textContent = $btn.attr(
                'data-tanggalasbuilt') || '';
            modal.querySelector('#modalTglTerimaBast').textContent = $btn.attr('data-tglterimabast') ||
                '';
            modal.querySelector('#modalTglTerimaBast2').textContent = $btn.attr(
                'data-tglterimabast2') || '';
            modal.querySelector('#modalTglPom').textContent = $btn.attr('data-tglpom') || '';
            modal.querySelector('#modalkmbalipom').textContent = $btn.attr('data-kembalipom') || '';
            modal.querySelector('#modalTglPusat2').textContent = $btn.attr('data-tglpusat2') || '';
            modal.querySelector('#modalTglKontraktor2').textContent = $btn.attr(
                'data-tglkontraktor2') || '';
            modal.querySelector('#modalKeterangan').textContent = $btn.attr('data-keterangan') || '';
            modal.querySelector('#modalCreatedBy').textContent = $btn.attr('data-createdby') || '-';
            modal.querySelector('#modalUpdatedBy').textContent = $btn.attr('data-updatedby') || '-';

            // File links
            var filePdfBast = $btn.attr('data-filepdf');
            var filePdfBast2 = $btn.attr('data-filepdfbast2');

            var link1 = document.createElement('a');
            link1.href = BASE_URL + 'assets/upload/bast/' + filePdfBast;
            link1.target = '_blank';
            link1.className = 'text-indigo-600 hover:text-indigo-800 break-all';
            link1.innerHTML = '<i class="fas fa-link mr-1"></i>' + filePdfBast;

            var link2 = document.createElement('a');
            link2.href = BASE_URL + 'assets/upload/bast2/' + filePdfBast2;
            link2.target = '_blank';
            link2.className = 'text-indigo-600 hover:text-indigo-800 break-all';
            link2.innerHTML = '<i class="fas fa-link mr-1"></i>' + filePdfBast2;

            // Clear & append
            modal.querySelector('#modalFilePdf').textContent = '';
            modal.querySelector('#modalFilePdf').appendChild(link1);

            modal.querySelector('#modalFilePdfBast2').textContent = '';
            modal.querySelector('#modalFilePdfBast2').appendChild(link2);
        });

        // =========================
        // EDIT MODAL LOGIC
        // =========================
        $(document).on('click', '.edit-btn', function(event) {
            event.preventDefault();
            var $btn = $(this);
            var modal = document.getElementById('editModal2');
            if (!modal) return;

            modal.querySelector('#editIdBast2').value = $btn.attr('data-id_bast2') || '';
            modal.querySelector('#editNoKontrak').value = $btn.attr('data-nokontrak') || '';
            modal.querySelector('#editNamaPT').value = $btn.attr('data-namapt') || '';
            modal.querySelector('#editPekerjaan').value = $btn.attr('data-pekerjaan') || '';
            modal.querySelector('#editTglTerimaBast').value = $btn.attr('data-tglterimabast') || '';
            modal.querySelector('#editTglTerimaBast2').value = ($btn.attr('data-tglterimabast2') ===
                '0000-00-00' || !$btn.attr('data-tglterimabast2')) ? '' : $btn.attr(
                'data-tglterimabast2');
            modal.querySelector('#editTglPom').value = ($btn.attr('data-tglpom') === '0000-00-00' || !
                $btn.attr('data-tglpom')) ? '' : $btn.attr('data-tglpom');
            modal.querySelector('#editKembaliPom').value = ($btn.attr('data-kembalipom') ===
                '0000-00-00' || !$btn.attr('data-kembalipom')) ? '' : $btn.attr('data-kembalipom');
            modal.querySelector('#editTglPusat2').value = ($btn.attr('data-tglpusat2') ===
                '0000-00-00' || !$btn.attr('data-tglpusat2')) ? '' : $btn.attr('data-tglpusat2');
            modal.querySelector('#editTglKontraktor2').value = ($btn.attr('data-tglkontraktor2') ===
                '0000-00-00' || !$btn.attr('data-tglkontraktor2')) ? '' : $btn.attr(
                'data-tglkontraktor2');
            modal.querySelector('#editKeterangan').value = $btn.attr('data-keterangan') || '';
            modal.querySelector('#editCreatedBy').value = $btn.attr('data-createdby') || '-';
            modal.querySelector('#editUpdatedBy').value = $btn.attr('data-updatedby') || '-';
            modal.querySelector('#editFilePdfBast2').value = '';
            
            // Load checkbox revisi state
            var isRevisi = $btn.attr('data-isrevisi');
            modal.querySelector('#editIsRevisi2').checked = (isRevisi == 1);
        });

        // Form submit - capture page and search before submit
        $(document).on('submit', '#editForm', function(e) {
            var urlParams = new URLSearchParams(window.location.search);
            var currentPage = urlParams.get('page') || '1';
            var searchQuery = urlParams.get('search') || '';
            
            console.log('=== FORM SUBMIT DEBUG ===');
            console.log('URL params - page:', currentPage);
            console.log('URL params - search:', searchQuery);
            console.log('URL:', window.location.href);
            
            // Set hidden fields dengan nilai terbaru
            var pageField = document.getElementById('editPage');
            var searchField = document.getElementById('editSearch');
            
            pageField.value = currentPage;
            searchField.value = searchQuery;
            
            console.log('After setting - page field value:', pageField.value);
            console.log('After setting - search field value:', searchField.value);
            
            // Verify form data sebelum submit
            var formData = new FormData(this);
            console.log('Form data akan dikirim:');
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            // Let form submit normally (tidak prevent default)
            // Form akan submit via POST dan redirect dengan parameters
        });
    });
    </script>
</body>

</html>