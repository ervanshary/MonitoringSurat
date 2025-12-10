<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .background {
            background-image: url('assets/img/background/login1.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            /* Mengisi satu layar penuh */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
            color: #fff;
        }

        .container h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 18px;
            margin-bottom: 40px;
        }

        .container a {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="background">
        <div class="container-fluid">
            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-8">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">

                                <div class="col-lg">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Halaman Login</h1>
                                        </div>

                                        <?= $this->session->flashdata('message'); ?>

                                        <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                            <hr>

                                        </form>

                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="<?= base_url('auth/registration') ?>">Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</body>

</html>