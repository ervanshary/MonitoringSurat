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
    </style>

</head>

<div class="container-fluid" style="background-image: url('<?= base_url('assets/img/background/footer.jpg'); ?>'); background-size: flex; background-position: center;">

    <body>
        <!-- Begin Page Content -->
        <div class="container-fluid" style="background-image: url('assets/img/background/logo1.jpg'); background-size: cover; background-position: center; height: 100vh;">

            <!-- Page Heading -->


            <div class="row">

                <div class="col-lg-8">


                    <?= form_open_multipart('user/edit');  ?>
                    <form>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                            </div>
                        </div>
                        <form>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <form>
                                <div class=" form-group row">
                                    <div class="col-sm-2">Picture</div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-end">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </div>

                                </div>
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- Link CSS -->
<link rel="stylesheet" href="assets/css/style.css">
</body>

</html>