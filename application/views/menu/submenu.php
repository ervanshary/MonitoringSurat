<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="text-white"><?= $title; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="/login/assets/css/style.css">

    <style>
        .container-fluid {
            padding: 10px;
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
    </style>

</head>

<div class="container-fluid" style="background-image: url('<?= base_url('assets/img/background/footer.jpg'); ?>'); background-size: flex; background-position: center;">

    <body>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors();  ?>

                        </div>
                    <?php endif; ?>


                    <?= $this->session->flashdata('message'); ?>
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Tambah Sub Menu</a>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Url</th>
                                <th scope="col">Icon</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($subMenu as $sm) : ?>
                                <tr>
                                    <th scope="row"><?= $i;  ?></th>
                                    <td><?= $sm['title']; ?></td>
                                    <td><?= $sm['menu']; ?></td>
                                    <td><?= $sm['url']; ?></td>
                                    <td><?= $sm['icon']; ?></td>
                                    <td><?= $sm['is_active']; ?></td>
                                    <td>
                                        <a href="#" class="badge badge-success">Edit</a>
                                        <a href="#" class="badge badge-danger">Delete</a>

                                    </td>

                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>


                </div>
            </div>


        </div>
        <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- modal -->


<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Tambah Sub Menu Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Submenu Title">
                    </div>
                    <div>
                        <div class="form-group">
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">Select Menu</option>
                                <?php foreach ($menu as $m) : ?>
                                    <option value="<?= $m['id']; ?>"><?= $m['menu']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Submenu Url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu Icon">
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
</body>

</html>