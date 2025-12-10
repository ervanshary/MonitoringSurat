<!-- Begin Page Content -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title; ?></title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">



<div class="container-fluid" style="background-image: url('assets/img/background/logo1.jpg'); background-size: cover; background-position: center; height: 100vh;">

    <!-- Page Heading -->

    <body>


        <div class="row">
            <div class="col-lg-6">
                <?= $this->session->flashdata('message');  ?>
            </div>
        </div>

        <div class="card mb-3 col-lg-8">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title text-dark"><?= $user['name']; ?></h5>
                        <p class="card-text text-dark"><?= $user['email']; ?></p>
                        <p class="card-text text-dark"><small class="text-body-secondary">Member since <?= date('d F Y', $user['date_created']); ?></small></p>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Link CSS -->
<link rel="stylesheet" href="assets/css/style.css">
</body>