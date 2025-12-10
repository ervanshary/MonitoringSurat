<div class="main-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fas fa-file-contract mr-2 text-blue-500"></i>Kontrak Milenial</h4>
        <div>
            <button class="btn btn-primary btn-3d" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="data-tabel" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Kontrak</th>
                    <th>Nama PT</th>
                    <th>Pekerjaan</th>
                    <th>Status</th>
                    <th>Updated By</th>
                    <th>Updated At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kontrak)) : ?>
                    <?php $i = 1;
                    foreach ($kontrak as $row) : ?>
                        <tr data-id="<?= $row['id']; ?>">
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['no_kontrak']); ?></td>
                            <td><?= htmlspecialchars($row['nama_pt']); ?></td>
                            <td><?= htmlspecialchars($row['pekerjaan']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'Selesai') : ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php elseif ($row['status'] == 'Proses') : ?>
                                    <span class="badge badge-warning">Proses</span>
                                <?php else : ?>
                                    <span class="badge badge-secondary"><?= htmlspecialchars($row['status']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['updated_by'] ?? '-'); ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row['updated_at'])); ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="aksi">
                                    <button class="btn btn-sm btn-info btn-detail" title="Detail" data-id="<?= $row['id']; ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning btn-edit" title="Edit" data-id="<?= $row['id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="<?= $row['id']; ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada data kontrak.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formTambah" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kontrak</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>No Kontrak</label><input type="text" name="no_kontrak" class="form-control" required></div>
                <div class="form-group"><label>Nama PT</label><input type="text" name="nama_pt" class="form-control" required></div>
                <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan" class="form-control" required></div>
                <div class="form-group"><label>Status</label>
                    <select name="status" class="form-control">
                        <option value="Proses">Proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEdit" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kontrak</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group"><label>No Kontrak</label><input type="text" name="no_kontrak" id="edit_no_kontrak" class="form-control" required></div>
                <div class="form-group"><label>Nama PT</label><input type="text" name="nama_pt" id="edit_nama_pt" class="form-control" required></div>
                <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan" id="edit_pekerjaan" class="form-control" required></div>
                <div class="form-group"><label>Status</label>
                    <select name="status" id="edit_status" class="form-control">
                        <option value="Proses">Proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button>
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kontrak</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- isi dinamis -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Pastikan DataTable ter-init hanya sekali
        if (!$.fn.DataTable.isDataTable('#data-tabel')) {
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
        }

        // ------------- Tambah (AJAX) -------------
        $('#formTambah').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('proyek/tambah_kontrak'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#modalTambah').modal('hide');
                        // reload current tab (trigger klik active tab)
                        $('#sheetTabs .nav-link.active').trigger('click');
                    } else {
                        alert(res.message || 'Gagal menyimpan');
                    }
                },
                error: function() {
                    alert('Error server saat tambah');
                }
            });
        });

        // ------------- Ambil data untuk Edit & Detail -------------
        // Event delegation karena konten dimuat ulang via AJAX
        $(document).on('click', '.btn-edit, .btn-detail', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            $.getJSON("<?= base_url('proyek/get_kontrak_data/'); ?>" + id, function(res) {
                if (res.status === 'success' && res.data) {
                    const d = res.data;
                    if ($(e.currentTarget).hasClass('btn-edit')) {
                        // isi form edit lalu tampilkan modal
                        $('#edit_id').val(d.id);
                        $('#edit_no_kontrak').val(d.no_kontrak);
                        $('#edit_nama_pt').val(d.nama_pt);
                        $('#edit_pekerjaan').val(d.pekerjaan);
                        $('#edit_status').val(d.status);
                        $('#modalEdit').modal('show');
                    } else {
                        // tampilkan detail
                        let html = `
                        <dl class="row">
                          <dt class="col-sm-4">No Kontrak</dt><dd class="col-sm-8">${d.no_kontrak}</dd>
                          <dt class="col-sm-4">Nama PT</dt><dd class="col-sm-8">${d.nama_pt}</dd>
                          <dt class="col-sm-4">Pekerjaan</dt><dd class="col-sm-8">${d.pekerjaan}</dd>
                          <dt class="col-sm-4">Status</dt><dd class="col-sm-8">${d.status}</dd>
                          <dt class="col-sm-4">Is Active</dt><dd class="col-sm-8">${d.is_active}</dd>
                          <dt class="col-sm-4">Updated By</dt><dd class="col-sm-8">${d.updated_by}</dd>
                          <dt class="col-sm-4">Updated At</dt><dd class="col-sm-8">${d.updated_at}</dd>
                        </dl>`;
                        $('#detailContent').html(html);
                        $('#modalDetail').modal('show');
                    }
                } else {
                    alert('Data tidak ditemukan');
                }
            }).fail(function() {
                alert('Error mengambil data');
            });
        });

        // ------------- Update (AJAX) -------------
        $('#formEdit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('proyek/update_kontrak'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#modalEdit').modal('hide');
                        $('#sheetTabs .nav-link.active').trigger('click');
                    } else {
                        alert(res.message || 'Gagal update');
                    }
                },
                error: function() {
                    alert('Error server saat update');
                }
            });
        });

        // ------------- Hapus (AJAX) -------------
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
                        $('#sheetTabs .nav-link.active').trigger('click');
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