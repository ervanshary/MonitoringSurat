<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-red-800"><?= $title; ?></h1>
    <!-- upload_form.php -->
    <?= form_open_multipart('user/upload_excel'); ?>
    <input type="file" name="file_excel" />
    <input type="submit" value="Upload" />
    <?= form_close(); ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->