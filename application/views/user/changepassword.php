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
            padding: 60px;
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
            <h1 class="h3 mb-4 text-red-800"><?= $title; ?></h1>


            <div class="row">

                <div class="col-lg-6">

                    <?= $this->session->flashdata('message');  ?>

                    <form action="<?= base_url('user/changepassword') ?>" method="post">

                        <div class="form-group">
                            <label for="current password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="new password1">New Password</label>
                            <input type="password" class="form-control" id="new_password1" name="new_password1">
                            <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="new password2">Repeat Password</label>
                            <input type="password" class="form-control" id="new_password2" name="new_password2">
                            <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Change Password</button>

                        </div>
                    </form>
                </div>
            </div>


        </div>
        <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</body>

</html>