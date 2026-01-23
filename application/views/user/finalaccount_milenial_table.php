<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Kontrak Milenial'; ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            min-height: 100vh;
            color: #1e293b;
        }

        .main-container {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 95%;
        }

        #data-tabel thead {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #fff;
        }

        #data-tabel thead th {
            padding: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        #data-tabel tbody tr {
            background: #f8fafc;
        }

        #data-tabel tbody tr:hover {
            background: #e0f2fe;
        }

        #data-tabel td {
            padding: 0.75rem;
            color: #1e293b;
        }

        .btn-3d {
            padding: 0.45rem 0.9rem;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 0.5rem;
            text-transform: uppercase;
            color: #fff !important;
            transition: 0.2s;
            border: none;
            box-shadow: 0 3px 0 rgba(0, 0, 0, 0.2);
        }

        .btn-3d:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 rgba(0, 0, 0, 0.25);
        }

        .btn-primary {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
        }

        .btn-success {
            background: #10b981;
        }

        .btn-warning {
            background: #f59e0b;
        }

        .btn-danger {
            background: #ef4444;
        }

        .modal-header {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #fff;
        }

        .modal-content {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-body {
            background: #f8fafc;
        }

        .modal-footer {
            background: #f1f5f9;
            border-top: none;
        }

        #data-tabel th,
        #data-tabel td {
            padding: 0.4rem 0.5rem !important;
            font-size: 0.85rem !important;
            vertical-align: middle !important;
            text-align: left;
            border-color: #e2e8f0 !important;
        }

        #data-tabel tbody tr {
            line-height: 1.2rem;
        }

        #data-tabel td {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        #data-tabel td:hover {
            white-space: normal;
            overflow: visible;
            background-color: #e0f2fe !important;
            z-index: 10;
            position: relative;
        }

        #data-tabel thead th {
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            color: #fff;
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.4px;
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
        }

        #data-tabel tbody tr:nth-child(odd) {
            background-color: #f8fafc;
        }

        #data-tabel tbody tr:nth-child(even) {
            background-color: #f1f5f9;
        }

        #data-tabel tbody tr:hover {
            background-color: #e0f2fe !important;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-white via-cyan-100 to-cyan-400 min-h-screen">

    <div class="main-container mx-auto">
        <div class="row mb-3">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
                
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
                
                <div class="d-flex flex-wrap gap-2">
                    <a href="#" class="btn btn-primary btn-3d mb-2 mr-2" data-toggle="modal" data-target="#newMilenialModal">
                        <i class="fas fa-plus mr-1"></i> Tambah Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabel Data Kontrak Milenial -->
        <div class="table-responsive">
            <table class="table table-bordered" id="data-tabel" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Kontrak</th>
                        <th>Nama PT</th>
                        <th>Pekerjaan</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($milenialAccount)) : ?>
                        <?php $i = 1;
                        foreach ($milenialAccount as $ma) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= htmlspecialchars($ma['no_kontrak'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($ma['nama_pt'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($ma['pekerjaan'] ?? ''); ?></td>
                                <td>
                                    <?php if (($ma['status'] ?? '') == 'Selesai') : ?>
                                        <span class="badge badge-success">Selesai</span>
                                    <?php elseif (($ma['status'] ?? '') == 'Proses') : ?>
                                        <span class="badge badge-warning">Proses</span>
                                    <?php else : ?>
                                        <span class="badge badge-secondary"><?= htmlspecialchars($ma['status'] ?? ''); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= !empty($ma['created_by']) ? htmlspecialchars($ma['created_by']) : '-'; ?></td>
                                <td><?= htmlspecialchars($ma['updated_by'] ?? '-'); ?></td>
                                <td><?= !empty($ma['updated_at']) ? date('d-m-Y H:i', strtotime($ma['updated_at'])) : '-'; ?></td>
                                <td>
                                    <div class="flex flex-col md:flex-row items-center justify-center space-y-1 md:space-y-0 md:space-x-1">
                                        <a href="#" class="btn-3d bg-teal-500 hover:bg-teal-600 text-white transition text-xs py-1 px-2 rounded-md btn-detail w-full md:w-auto"
                                            data-toggle="modal" data-target="#milenialDetailModal" data-id="<?= $ma['id']; ?>">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>

                                        <a href="#" class="btn-3d bg-indigo-500 hover:bg-indigo-600 text-white edit-btn transition text-xs py-1 px-2 rounded-md w-full md:w-auto"
                                            data-toggle="modal" data-target="#editMilenialModal" data-id="<?= $ma['id']; ?>">
                                            <i class="fas fa-pen mr-1"></i> Edit
                                        </a>

                                        <a href="#" class="btn-3d bg-red-500 hover:bg-red-600 text-white btn-delete transition text-xs py-1 px-2 rounded-md w-full md:w-auto"
                                            data-id="<?= $ma['id']; ?>">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data yang tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editMilenialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Kontrak Milenial</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="editMilenialForm" method="post">
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="id">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>No Kontrak</label>
                                    <input type="text" class="form-control" id="no_kontrak" name="no_kontrak" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nama PT</label>
                                    <input type="text" class="form-control" id="nama_pt" name="nama_pt" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Proses">Proses</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-3d">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="milenialDetailModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Kontrak Milenial</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>No Kontrak</h6>
                                    <p id="modalNoKontrak" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Nama PT</h6>
                                    <p id="modalNamaPT" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Pekerjaan</h6>
                                    <p id="modalPekerjaan" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Status</h6>
                                    <p id="modalStatus" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Created By</h6>
                                    <p id="modalCreatedBy" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Updated By</h6>
                                    <p id="modalUpdatedBy" class="text-muted"></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card p-3 shadow-sm">
                                    <h6>Updated At</h6>
                                    <p id="modalUpdatedAt" class="text-muted"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="newMilenialModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kontrak Milenial</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="addMilenialForm" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>No Kontrak</label>
                                <input type="text" class="form-control" name="no_kontrak" required>
                            </div>
                            <div class="form-group">
                                <label>Nama PT</label>
                                <input type="text" class="form-control" name="nama_pt" required>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" name="pekerjaan" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="Proses">Proses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-3d" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-3d">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

    <!-- === MODAL UNTUK FILL CREATED BY === -->
    <div class="modal fade" id="fillCreatedByModal" tabindex="-1" role="dialog" aria-labelledby="fillCreatedByModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" value="user_final_account_milenial" readonly>
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
        $(document).ready(function() {
            // ===== HANDLE FILL CREATED BY BUTTON =====
            $('#btnFillCreatedBy').on('click', function() {
                $('#fillCreatedByModal').modal('show');
            });

            // ===== CONFIRM FILL CREATED BY =====
            $('#btnConfirmFill').on('click', function() {
                // Konfirmasi final
                Swal.fire({
                    title: 'Konfirmasi Final',
                    html: 'Anda yakin ingin mengisi <strong>created_by</strong> dengan "Admin" untuk:<br><strong>user_final_account_milenial</strong><br><br><strong class="text-danger">Tindakan ini TIDAK bisa dibatalkan!</strong>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proses fill
                        $.ajax({
                            url: '<?= base_url('user/fill_created_by_all') ?>',
                            type: 'POST',
                            data: {
                                tables: ['user_final_account_milenial']
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
                                // Reload halaman setelah 3 detik
                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            },
                            error: function(xhr) {
                                var errorMsg = xhr.responseJSON?.message || 'Terjadi error saat memproses data';
                                Swal.fire('Error', errorMsg, 'error');
                            }
                        });
                    }
                });
            });

            // Init DataTable
            $('#data-tabel').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        next: "›",
                        previous: "‹"
                    }
                }
            });

            // Tambah Data
            $('#addMilenialForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?= base_url('proyek/tambah_kontrak'); ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            $('#newMilenialModal').modal('hide');
                            location.reload();
                        } else {
                            alert(res.message || 'Gagal menyimpan');
                        }
                    },
                    error: function() {
                        alert('Error server saat tambah');
                    }
                });
            });

            // Edit Button Click
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.getJSON("<?= base_url('proyek/get_kontrak_data/'); ?>" + id, function(res) {
                    if (res.status === 'success' && res.data) {
                        const d = res.data;
                        $('#editId').val(d.id);
                        $('#no_kontrak').val(d.no_kontrak);
                        $('#nama_pt').val(d.nama_pt);
                        $('#pekerjaan').val(d.pekerjaan);
                        $('#status').val(d.status);
                        $('#editMilenialModal').modal('show');
                    } else {
                        alert('Data tidak ditemukan');
                    }
                }).fail(function() {
                    alert('Error mengambil data');
                });
            });

            // Detail Button Click
            $(document).on('click', '.btn-detail', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.getJSON("<?= base_url('proyek/get_kontrak_data/'); ?>" + id, function(res) {
                    if (res.status === 'success' && res.data) {
                        const d = res.data;
                        $('#modalNoKontrak').text(d.no_kontrak);
                        $('#modalNamaPT').text(d.nama_pt);
                        $('#modalPekerjaan').text(d.pekerjaan);
                        $('#modalStatus').text(d.status);
                        $('#modalCreatedBy').text(d.created_by || '-');
                        $('#modalUpdatedBy').text(d.updated_by || '-');
                        $('#modalUpdatedAt').text(d.updated_at ? new Date(d.updated_at).toLocaleString('id-ID') : '-');
                        $('#milenialDetailModal').modal('show');
                    } else {
                        alert('Data tidak ditemukan');
                    }
                }).fail(function() {
                    alert('Error mengambil data');
                });
            });

            // Edit Form Submit
            $('#editMilenialForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?= base_url('proyek/update_kontrak'); ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            $('#editMilenialModal').modal('hide');
                            location.reload();
                        } else {
                            alert(res.message || 'Gagal update');
                        }
                    },
                    error: function() {
                        alert('Error server saat update');
                    }
                });
            });

            // Delete Button Click
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                if (!confirm('Yakin ingin menghapus data ini?')) return;
                $.ajax({
                    url: "<?= base_url('proyek/delete_kontrak/'); ?>" + id,
                    type: "POST",
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'deleted') {
                            location.reload();
                        } else {
                            alert('Gagal menghapus');
                        }
                    },
                    error: function() {
                        alert('Error server saat hapus');
                    }
                });
            });
        });
    </script>
</body>

</html>
