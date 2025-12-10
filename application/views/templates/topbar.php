<!-- Stylesheet & Scripts -->
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/boxicons/css/boxicons.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>

<!-- Custom CSS -->
<style>
    .navbar {
        background: linear-gradient(135deg, #4ca1af, #2c3e50);
        color: white;
        border-radius: 10px;
        padding: 15px;
    }

    .dropdown-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .dropdown-item {
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s, color 0.3s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #333;
    }

    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
    }
</style>

<!-- ======= Topbar ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="<?= base_url('dashboard'); ?>" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block"><?= $title; ?></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <!-- Notifikasi -->
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <?php
                    $alertCount = 0;
                    foreach ($reminder_dates as $reminder) {
                        $reminderDate = new DateTime($reminder['reminder_date']);
                        $currentDate = new DateTime($current_date);
                        $tglKembaliPOM = new DateTime($reminder['tgl_kembali_pom']);

                        if ($currentDate > $reminderDate && ($reminder['tgl_kembali_pom'] == '0000-00-00' || $tglKembaliPOM == null)) {
                            $alertCount++;
                        }
                    }
                    ?>
                    <?php if ($alertCount > 0) : ?>
                        <span class="badge bg-danger badge-number"><?= $alertCount; ?></span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">You have <?= $alertCount; ?> new notifications</li>
                    <?php foreach ($reminder_dates as $reminder) : ?>
                        <?php
                        $tglKirimPOM = new DateTime($reminder['tgl_kirim_pom']);
                        $tglKembaliPOM = $reminder['tgl_kembali_pom'] ? new DateTime($reminder['tgl_kembali_pom']) : null;
                        $currentDate = new DateTime();
                        $diff = $currentDate->diff($tglKirimPOM)->days;
                        ?>
                        <?php if ($tglKembaliPOM === null && $currentDate > $tglKirimPOM->add(new DateInterval('P10D'))) : ?>
                            <li class="notification-item">
                                <i class="bi bi-exclamation-triangle text-warning"></i>
                                <div>
                                    <h6>Reminder</h6>
                                    <p>Dokumen No <?= htmlspecialchars($reminder['no_dokumen']); ?> dari <?= htmlspecialchars($reminder['nama_kontraktor']); ?> sudah lebih dari <?= $diff; ?> hari.</p>
                                    <p class="small text-muted"><?= $tglKirimPOM->format('F j, Y'); ?></p>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <li><a class="dropdown-item text-center" href="#">Show All Alerts</a></li>
                </ul>
            </li>

            <!-- Profile -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['name']; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $user['name']; ?></h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-person"></i><span>My Profile</span></a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-gear"></i><span>Settings</span></a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<!-- End Topbar -->

<!-- Optional: Javascript tambahan jika ingin render dinamis notifikasi -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const currentDate = new Date("<?= $current_date; ?>");
        const reminderDates = <?= json_encode(array_column($reminder_dates, 'reminder_date', 'id_parsial')); ?>;
        const partials = <?= json_encode($partials); ?>;

        const dropdownMenu = document.querySelector('.dropdown-menu');
        let alertCount = 0;

        partials.forEach(partial => {
            const reminderDateStr = reminderDates[partial.id_parsial];
            if (reminderDateStr) {
                const reminderDate = new Date(reminderDateStr);
                const tglKembaliPOM = partial.tgl_kembali_pom && partial.tgl_kembali_pom !== '0000-00-00' ? new Date(partial.tgl_kembali_pom) : null;

                if (reminderDate < currentDate && !tglKembaliPOM) {
                    alertCount++;
                    const daysLate = Math.floor((currentDate - reminderDate) / (1000 * 60 * 60 * 24));
                    const alertItem = document.createElement('a');
                    alertItem.className = 'dropdown-item d-flex align-items-center';
                    alertItem.href = '#';
                    alertItem.innerHTML = `
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">${reminderDate.toLocaleDateString()}</div>
                            <span class="font-weight-bold">Reminder: Dokumen No ${partial.no_dokumen} dari Kontraktor ${partial.nama_kontraktor} sudah telat ${daysLate} hari.</span>
                        </div>
                    `;
                    dropdownMenu.insertBefore(alertItem, dropdownMenu.lastElementChild);
                }
            }
        });

        const badgeCounter = document.querySelector('.badge-counter');
        if (badgeCounter) badgeCounter.textContent = alertCount > 0 ? alertCount : '';
    });
</script>