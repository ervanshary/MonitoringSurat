<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="/login/assets/css/style.css">

    <style>
        .container-fluid {
            padding: 50px;
            border-radius: 8px;
            background-color: transparent;
            color: white;
            /* Warna latar belakang semi-transparan */
        }

        .table thead th {
            background-color: #f8f9fa;
            /* Warna latar belakang header tabel */
            font-weight: bold;
        }

        .table tbody tr {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .table tbody tr:hover {
            background-color: rgba(220, 220, 220, 0.8);
            /* Warna latar belakang saat hover */
            border-radius: 10px;
        }

        .modal-content {
            background-color: rgba(255, 255, 255, 0.9);
        }

        /* Target the label in DataTables filter and change text color to white */
        .dataTables_filter label {
            color: white;
            /* Set label text color to white */
        }

        .dataTables_length label {
            color: white;
            /* Set label text color to white */
        }

        /* Change the text color of the DataTables info */
        .dataTables_info {
            color: white;
            /* Set text color to white */
            background-color: white;
            /* Optional: Set background color */
            padding: 10px;
            /* Optional: Add some padding */
            border-radius: 5px;
            /* Optional: Add rounded corners */
        }

        /* Change the color of the text in the search input */
        .dataTables_filter input.form-control {
            color: white;
            /* Text color */
            background-color: black;
            /* Background color */
            border: 1px solid white;
            /* Border color */
        }

        /* Change the placeholder text color */
        .dataTables_info input.form-control::placeholder {
            color: grey;
            /* Placeholder text color */
        }

        /* Change the text color and background color of the dropdown */
        .dataTables_length .custom-select {
            color: black;
            /* Text color */
            background-color: black;
            /* Background color */
            border: 1px #ededf5;

            /* Border color */
        }

        /* Change the placeholder text color */
        .dataTables_length .custom-select::placeholder {
            color: grey;
            /* Placeholder text color */
        }

        /* Change the dropdown arrow color */
        .dataTables_length .custom-select:focus {
            border-color: black;

        }

        .form-group {
            color: black;
        }
    </style>

</head>

<div class="container-fluid" style="background-image: url('<?= base_url('assets/img/background/footer.jpg'); ?>'); background-size: flex; background-position: center;">

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="h3 mb-4 text-red-800"><?= $title; ?></h1>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role ID</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user['name']; ?></td>
                                    <td><?= $user['email']; ?></td>
                                    <td><?= $user['role_id']; ?></td>
                                    <td><?= date('d-m-Y H:i:s', $user['date_created']); ?></td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-primary edit-btn" data-toggle="modal" data-target="#editUserModal<?= $user['id']; ?>" data-id="<?= $user['id']; ?>" data-name="<?= $user['name']; ?>" data-email="<?= $user['email']; ?>" data-role-id="<?= $user['role_id']; ?>" data-date-created="<?= date('d-m-Y H:i:s', $user['date_created']); ?>">
                                            Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-toggle="modal" data-target="#deleteUserModal<?= $user['id']; ?>">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Edit User -->
        <?php foreach ($users as $user) : ?>
            <div class="modal fade" id="editUserModal<?= $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?= $user['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel<?= $user['id']; ?>">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('admin/update_user/' . $user['id']); ?>" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_name<?= $user['id']; ?>">Name</label>
                                    <input type="text" class="form-control" id="edit_name<?= $user['id']; ?>" name="edit_name<?= $user['id']; ?>" value="<?= $user['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="edit_email<?= $user['id']; ?>">Email</label>
                                    <input type="email" class="form-control" id="edit_email<?= $user['id']; ?>" name="edit_email<?= $user['id']; ?>" value="<?= $user['email']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="edit_role<?= $user['id']; ?>">Role ID</label>
                                    <input type="text" class="form-control" id="edit_role<?= $user['id']; ?>" name="edit_role<?= $user['id']; ?>" value="<?= $user['role_id']; ?>">
                                </div>
                                <!-- Tambahan input lain sesuai kebutuhan -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Modal Delete User -->
        <?php foreach ($users as $user) : ?>
            <div class="modal fade" id="deleteUserModal<?= $user['id']; ?>" tabindex="-1" aria-labelledby="deleteUserModalLabel<?= $user['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel<?= $user['id']; ?>">Hapus User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin ingin menghapus pengguna ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="<?= base_url('admin/delete_user/' . $user['id']); ?>" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </body>

</html>