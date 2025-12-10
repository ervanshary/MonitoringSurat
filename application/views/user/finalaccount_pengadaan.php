<!-- Begin Page Content -->
<div class="container-fluid" style="background-image: url('assets/img/background/page.jpg'); background-size: cover; background-position: center;">
    <!-- Page Heading -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg ">
                <?= $this->session->flashdata('message');  ?>
                <div class="btn-group mb-3 " role="group">
                    <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#newFaModal">Tambah Data</a>
                    <a href="<?= site_url('user/export') ?>" class="btn btn-primary mr-2">
                        <i class="fas fa-fw fa-file-download"></i> Export Excel
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-file-download"></i> Import
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"><i class="fas fa-fw fa-file-excel"></i> Download File</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal-import-Fa">
                                <i class="fas fa-fw fa-file-import"></i> Upload File</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your table data goes here -->
    </div>
    <table class="table table-bordered mb-3" id="data-tabel" width="100%">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">No Kontrak</th>
                <th scope="col">Nama DC</th>
                <th scope="col">Pekerjaan</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($finalAccount)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($finalAccount as $fa) : ?>
                    <tr>
                        <th scope="row"><?= $i;  ?></th>
                        <td><?= $fa['no_kontrak']; ?></td>
                        <td><?= $fa['nama_pt']; ?></td>
                        <td><?= $fa['pekerjaan']; ?></td>
                        <td><?= $fa['status']; ?></td>
                        <td>
                            <a href="#" class="badge badge-warning btn-detail" data-toggle="modal" data-target="#finalAccountDetailModal" data-id="<?= $fa['id']; ?>">Detail</a>
                            <a href="#" class="badge badge-success editBtn" data-toggle="modal" data-target="#editFaModal" data-id="<?= $fa['id']; ?>">Edit</a>
                            <a href="#" class="badge badge-danger btn-delete" data-id="<?= $fa['id']; ?>">Delete</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data yang tersedia</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- modal import -->
<div class="modal fade" tabindex="-1" role="dialog" id="Modal-import-Fa">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Final Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('user/import') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file_fa">File Excel</label>
                        <div class="custom-file">
                            <input type="file" name="file_fa" class="custom-file-input" id="file_fa" required>
                            <label class="custom-file-label" for="file_fa">Pilih File</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<!-- End of Main Content -->


<!-- Modal Edit data -->
<div class="modal fade" id="editFaModal" tabindex="-1" aria-labelledby="editFaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="editFaModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <form id="editForm" action="<?= base_url('user/finalaccount_update'); ?>" method="post">
                <div class="modal-body">
                    <!-- Form inputs for editing -->
                    <input type="hidden" id="editId" name="editId">
                    <div class="form-group">
                        <label for="no_kontrak">No Kontrak</label>
                        <input type="text" class="form-control" id="no_kontrak" name="no_kontrak">
                    </div>
                    <div class="form-group">
                        <label for="nama_pt">Nama DC</label>
                        <input type="text" class="form-control" id="nama_pt" name="nama_pt">
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status" name="status">
                    </div>
                    <!-- Add more input fields for other data to be edited -->
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal detail -->
<!-- Isi halaman finalaccount.php -->

<!-- Modal Detail -->
<div class="modal fade" id="finalAccountDetailModal" tabindex="-1" aria-labelledby="finalAccountDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalAccountDetailModalLabel">Final Account Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="col">No Kontrak</th>
                                    <td id="modalNoKontrak"></td>
                                </tr>
                                <tr>
                                    <th scope="col">Nama PT</th>
                                    <td id="modalNamaPT"></td>
                                </tr>
                                <tr>
                                    <th scope="col">Pekerjaan</th>
                                    <td id="modalPekerjaan"></td>
                                </tr>
                                <tr>
                                    <th scope="col">Status</th>
                                    <td id="modalStatus"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Akhir halaman finalaccount.php -->


<!-- Modal tambah data -->
<div class="modal fade modal-background" id="newFaModal" tabindex="-1" aria-labelledby="newFaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFaModalLabel">Tambah Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/finalaccount'); ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="no_kontrak" name="no_kontrak" placeholder="No Kontrak">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_pt" name="nama_pt" placeholder="Nama Kontraktor">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Nama Pekerjaan">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="status" name="status" placeholder="Status">
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