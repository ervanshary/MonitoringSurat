<?php $this->load->view('templates/header', $this); ?>
<?php $this->load->view('templates/sidebar', $this); ?>
<?php $this->load->view('templates/topbar', $this); ?>

<div id="layoutSidenav_content">
    <main>
        <?php $this->load->view($page, $this); ?>
    </main>
</div>

<?php $this->load->view('templates/footer', $this); ?>