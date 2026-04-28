<?php
/**
 * CONTOH PENGGUNAAN FUNGSI POM NOTIFICATION
 * File: application/controllers/Example_Controller.php
 */

// ============================================
// CONTOH 1: Menggunakan di Controller
// ============================================

class Example_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('login');
    }

    // Contoh 1a: Menggunakan Helper Function
    public function example_helper_usage()
    {
        // Cek status POM tunggal
        $tgl_pom = '2024-01-20';
        $tgl_kembali = null;
        
        $status = cek_pom_overdue($tgl_pom, $tgl_kembali);
        
        if ($status['status'] == 'OVERDUE') {
            echo "⚠️ OVERDUE: " . $status['pesan'];
            // Output: ⚠️ OVERDUE: Belum dikembalikan dari POM - Terlewat 41 hari
        }
    }

    // Contoh 1b: Mendapatkan Daftar Lengkap POM OVERDUE
    public function example_get_overdue_list()
    {
        $overdue_list = get_pom_overdue_list();
        
        if (count($overdue_list) > 0) {
            echo "Daftar POM yang OVERDUE:\n";
            foreach ($overdue_list as $item) {
                echo "- " . $item['no_kontrak'] . 
                     " (" . $item['nama_pt'] . ") " .
                     $item['hari_terlewat'] . " hari\n";
            }
        } else {
            echo "Semua POM sudah kembali tepat waktu ✓";
        }
    }
}

// ============================================
// CONTOH 2: Menggunakan di Model
// ============================================

class Example_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Contoh 2a: Query data dengan status POM
    public function get_bast2_with_pom_status()
    {
        $this->load->model('Bast2_model');
        
        $pom_data = $this->Bast2_model->getPomBelumDikembalikan();
        $result = [];
        
        foreach ($pom_data as $data) {
            $status = $this->Bast2_model->getStatusPom($data['tgl_pom'], $data['kembali_pom']);
            $result[] = array_merge($data, $status);
        }
        
        return $result;
    }
}

// ============================================
// CONTOH 3: Menggunakan di View (PHP Blade)
// ============================================
?>

<!-- Contoh 3a: Menampilkan Badge Status -->
<?php if (!empty($pom_data)) : ?>
    <?php foreach ($pom_data as $item) : ?>
        <tr>
            <td><?= $item['no_kontrak']; ?></td>
            <td><?= $item['nama_pt']; ?></td>
            <td>
                <span class="badge <?= $item['badge_class']; ?> text-white">
                    <?= $item['pesan']; ?>
                </span>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Contoh 3b: Alert dengan Informasi Detail -->
<?php if (!empty($pom_overdue)) : ?>
    <div class="alert alert-warning">
        <h4>⚠️ Perhatian POM Overdue!</h4>
        <p>Terdapat <?= count($pom_overdue); ?> dokumen yang belum dikembalikan:</p>
        <ul>
            <?php foreach ($pom_overdue as $item) : ?>
                <li>
                    <strong><?= $item['no_kontrak']; ?></strong> - 
                    <?= $item['nama_pt']; ?> 
                    (Overdue <?= $item['hari_terlewat']; ?> hari)
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- ============================================
     CONTOH 4: JavaScript/AJAX Usage
     ============================================ -->
<script>
// Contoh 4a: Mengambil data notifikasi via AJAX
function loadPomNotification() {
    fetch('<?= base_url("User/get_pom_notification"); ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Total POM Overdue: ' + data.count);
                
                // Update badge counter (jika ada)
                document.getElementById('pom-counter').textContent = data.count;
                
                // Tampilkan daftar detail
                data.data.forEach(item => {
                    console.log(`${item.no_kontrak}: ${item.hari_terlewat} hari`);
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

// Panggil saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadPomNotification();
    
    // Refresh setiap 5 menit
    setInterval(loadPomNotification, 5 * 60 * 1000);
});

// Contoh 4b: Trigger manual
function refreshPomStatus() {
    loadPomNotification();
}
</script>

<!-- ============================================
     CONTOH 5: Menggunakan di Scheduled Task/Cron
     ============================================ -->
<?php
/**
 * Contoh file untuk cron job yang mengirim email notifikasi
 * File: application/controllers/Cron.php
 */

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // Atau custom auth untuk cron
        $this->load->helper('login');
        $this->load->library('email');
        $this->load->model('Bast2_model');
    }

    /**
     * Kirim email notifikasi POM overdue
     * Jalankan: https://yoursite.com/cron/send_pom_notification_email
     */
    public function send_pom_notification_email()
    {
        $overdue_list = get_pom_overdue_list();
        
        if (count($overdue_list) > 0) {
            $email_body = $this->build_email_body($overdue_list);
            
            // Konfigurasi email
            $this->email->from('noreply@yourcompany.com', 'System Notification');
            $this->email->to('admin@yourcompany.com');
            $this->email->subject('⚠️ Notifikasi POM Overdue - ' . date('d-m-Y'));
            $this->email->message($email_body);
            
            if ($this->email->send()) {
                log_message('info', 'POM overdue email sent successfully');
                echo "Email sent successfully";
            } else {
                log_message('error', 'Failed to send POM overdue email');
                echo "Failed to send email";
            }
        } else {
            echo "No overdue POM found";
        }
    }

    /**
     * Build HTML email body
     */
    private function build_email_body($overdue_list)
    {
        $html = '<h2>Notifikasi POM Overdue</h2>';
        $html .= '<p>Berikut adalah daftar dokumen BAST 2 yang belum dikembalikan dari POM:</p>';
        $html .= '<table border="1" cellpadding="10" cellspacing="0">';
        $html .= '<tr><th>No Kontrak</th><th>PT</th><th>Pekerjaan</th><th>Hari Terlewat</th></tr>';
        
        foreach ($overdue_list as $item) {
            $html .= '<tr>';
            $html .= '<td>' . $item['no_kontrak'] . '</td>';
            $html .= '<td>' . $item['nama_pt'] . '</td>';
            $html .= '<td>' . $item['pekerjaan'] . '</td>';
            $html .= '<td style="color: red; font-weight: bold;">' . $item['hari_terlewat'] . ' hari</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '<p>Silakan segera ambil tindakan untuk meminta kembali dokumen dari POM.</p>';
        
        return $html;
    }

    /**
     * Generate laporan POM overdue
     * Jalankan: https://yoursite.com/cron/generate_pom_report
     */
    public function generate_pom_report()
    {
        $overdue_list = get_pom_overdue_list();
        
        $report = [
            'generated_at' => date('Y-m-d H:i:s'),
            'total_overdue' => count($overdue_list),
            'data' => $overdue_list
        ];
        
        // Simpan ke file
        $filename = FCPATH . 'reports/pom_overdue_' . date('Y-m-d_H-i-s') . '.json';
        file_put_contents($filename, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo "Report generated: " . $filename;
    }
}
?>

<!-- ============================================
     CONTOH 6: Dashboard Widget
     ============================================ -->
<!-- File: application/views/templates/dashboard_widget.php -->

<div class="widget pom-status-widget">
    <h3>Status POM</h3>
    
    <?php
    $pom_stats = [
        'total' => 0,
        'overdue' => 0,
        'in_process' => 0,
        'completed' => 0
    ];
    
    $pom_all = $this->Bast2_model->getPomBelumDikembalikan();
    foreach ($pom_all as $data) {
        $status = $this->Bast2_model->getStatusPom($data['tgl_pom'], $data['kembali_pom']);
        $pom_stats['total']++;
        
        switch ($status['status']) {
            case 'OVERDUE':
                $pom_stats['overdue']++;
                break;
            case 'DALAM_PROSES':
                $pom_stats['in_process']++;
                break;
            case 'SELESAI':
                $pom_stats['completed']++;
                break;
        }
    }
    ?>
    
    <div class="stat-item overdue">
        <span class="label">Overdue:</span>
        <span class="value"><?= $pom_stats['overdue']; ?></span>
    </div>
    
    <div class="stat-item in-process">
        <span class="label">Dalam Proses:</span>
        <span class="value"><?= $pom_stats['in_process']; ?></span>
    </div>
    
    <div class="stat-item completed">
        <span class="label">Selesai:</span>
        <span class="value"><?= $pom_stats['completed']; ?></span>
    </div>
    
    <div class="stat-item total">
        <span class="label">Total:</span>
        <span class="value"><?= $pom_stats['total']; ?></span>
    </div>
</div>

<!-- ============================================
     CONTOH 7: Advanced Filtering
     ============================================ -->
<?php
/**
 * Filter POM berdasarkan kriteria tertentu
 * Contoh di Controller
 */

class Report_Controller extends CI_Controller
{
    /**
     * Dapatkan POM yang overdue lebih dari X hari
     */
    public function get_pom_overdue_more_than($days = 14)
    {
        $overdue_list = get_pom_overdue_list();
        $filtered = array_filter($overdue_list, function($item) use ($days) {
            return $item['hari_terlewat'] > $days;
        });
        return array_values($filtered);
    }

    /**
     * Dapatkan POM overdue dari PT tertentu
     */
    public function get_pom_overdue_by_pt($nama_pt)
    {
        $overdue_list = get_pom_overdue_list();
        $filtered = array_filter($overdue_list, function($item) use ($nama_pt) {
            return stripos($item['nama_pt'], $nama_pt) !== false;
        });
        return array_values($filtered);
    }

    /**
     * Dapatkan top N POM yang paling overdue
     */
    public function get_top_overdue_pom($limit = 5)
    {
        $overdue_list = get_pom_overdue_list();
        usort($overdue_list, function($a, $b) {
            return $b['hari_terlewat'] - $a['hari_terlewat'];
        });
        return array_slice($overdue_list, 0, $limit);
    }
}
?>
