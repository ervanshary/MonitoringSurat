<style>
    /* Pastikan submenu teks putih */
    .sidebar .nav-content a {
        color: #ffffff !important;
        /* putih */
    }

    /* Hover submenu tetap putih tapi dengan background transparan */
    .sidebar .nav-content a:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }
</style>
<?php
$role_id = $this->session->userdata('role_id');

// Query menu sesuai role
$queryMenu = "SELECT `user_menu`.`id`, `menu`
              FROM `user_menu`
              JOIN `user_access_menu` 
              ON `user_menu`.`id` = `user_access_menu`.`menu_id`
              WHERE `user_access_menu`.`role_id` = $role_id
              ORDER BY `user_access_menu`.`menu_id` ASC";
$menu = $this->db->query($queryMenu)->result_array();
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar h-screen w-64 p-3 
    bg-gradient-to-b from-blue-600 to-cyan-500 
    text-white shadow-lg">

    <ul class="sidebar-nav space-y-2" id="sidebar-nav">

        <!-- LOOPING MENU -->
        <?php foreach ($menu as $m) : ?>
            <?php
            $menuId = $m['id'];
            $querySubmenu = "SELECT * FROM `user_sub_menu` 
                             WHERE `menu_id`=$menuId 
                             AND `is_active`=1";
            $subMenu = $this->db->query($querySubmenu)->result_array();
            ?>

            <?php if (!empty($subMenu)) : ?>
                <!-- Menu dengan Submenu -->
                <li class="nav-item">
                    <a href="javascript:void(0);"
                        class="flex items-center justify-between nav-link submenu-toggle 
                               px-3 py-2 rounded 
                               hover:bg-white/20 transition"
                        data-target="#menu-<?= $menuId; ?>">
                        <span class="flex items-center gap-2">
                            <i class="bi bi-list"></i>
                            <?= $m['menu']; ?>
                        </span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul id="menu-<?= $menuId; ?>"
                        class="nav-content hidden pl-6 mt-1 space-y-1">
                        <?php foreach ($subMenu as $sm) : ?>
                            <li>
                                <a href="<?= base_url($sm['url']); ?>"
                                    class="flex items-center gap-2 px-2 py-1 rounded 
                       hover:bg-white/20 transition text-sm text-white">
                                    <i class="<?= !empty($sm['icon']) ? $sm['icon'] : 'bi bi-dot'; ?>"></i>
                                    <span><?= $sm['title']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                </li>
            <?php else : ?>
                <!-- Menu tanpa Submenu -->
                <li class="nav-item">
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded 
                              hover:bg-white/20 transition">
                        <i class="bi bi-list"></i>
                        <span><?= $m['menu']; ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

    </ul>
</aside>


<!-- JS Toggle Submenu -->
<script>
    document.querySelectorAll('.submenu-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const target = document.querySelector(this.dataset.target);
            target.classList.toggle('hidden'); // Tailwind utility untuk show/hide
        });
    });
</script>