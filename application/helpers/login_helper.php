<?php

function is_logged_in()

{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {

        redirect('auth');
    } else {

        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();

        $menu_id = $queryMenu['id'];
        $userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();


    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

/**
 * Fungsi untuk menghitung selisih hari antara tanggal kirim POM dan tanggal sekarang
 * 
 * @param string $tgl_pom - Tanggal kirim POM (format: YYYY-MM-DD)
 * @param string $kembali_pom - Tanggal kembali POM (format: YYYY-MM-DD)
 * @param string $tgl_pusat2 - Tanggal kirim ke pusat (format: YYYY-MM-DD)
 * @param string $tgl_kontraktor2 - Tanggal kembali kontraktor (format: YYYY-MM-DD)
 * @return array - Array berisi status dan jumlah hari terlewat
 */
function cek_pom_overdue($tgl_pom, $kembali_pom = null, $tgl_pusat2 = null, $tgl_kontraktor2 = null)
{
    // Jika tanggal POM tidak terisi atau invalid
    if (empty($tgl_pom) || $tgl_pom == '0000-00-00') {
        return [
            'status' => 'BELUM_DIKIRIM',
            'hari_terlewat' => 0,
            'pesan' => 'Belum dikirim ke POM'
        ];
    }

    // Jika sudah dikembalikan
    if (!empty($kembali_pom) && $kembali_pom != '0000-00-00') {
        try {
            $tgl_kirim = new DateTime($tgl_pom);
            $tgl_balik = new DateTime($kembali_pom);
            $selisih = $tgl_balik->diff($tgl_kirim)->days;

            return [
                'status' => 'SELESAI',
                'hari_terlewat' => $selisih,
                'pesan' => 'Sudah dikembalikan dari POM'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'ERROR',
                'hari_terlewat' => 0,
                'pesan' => 'Format tanggal tidak valid'
            ];
        }
    }

    // LOGIKA BARU: Jika tgl_pusat2 atau tgl_kontraktor2 sudah terisi, dokumen sudah dalam progress
    // Jadi tidak perlu tampilkan notifikasi OVERDUE
    if (((!empty($tgl_pusat2) && $tgl_pusat2 != '0000-00-00') || 
         (!empty($tgl_kontraktor2) && $tgl_kontraktor2 != '0000-00-00'))) {
        // Dokumen sudah dalam fase berikutnya (sudah dikirim ke pusat/kontraktor)
        return [
            'status' => 'DALAM_PROSES_LANJUT',
            'hari_terlewat' => 0,
            'pesan' => 'Dalam proses fase selanjutnya'
        ];
    }

    // Jika belum dikembalikan dari POM dan belum dikirim ke pusat (masih menunggu di POM)
    try {
        $tgl_kirim = new DateTime($tgl_pom);
        $hari_ini = new DateTime('now');
        $selisih = $tgl_kirim->diff($hari_ini)->days;

        // Jika sudah melewati 7 hari atau lebih
        if ($selisih >= 7) {
            return [
                'status' => 'OVERDUE',
                'hari_terlewat' => $selisih,
                'pesan' => "Belum dikembalikan dari POM - Terlewat " . $selisih . " hari"
            ];
        } else {
            return [
                'status' => 'DALAM_PROSES',
                'hari_terlewat' => $selisih,
                'pesan' => "Dalam proses di POM - " . (7 - $selisih) . " hari lagi mencapai deadline"
            ];
        }
    } catch (Exception $e) {
        return [
            'status' => 'ERROR',
            'hari_terlewat' => 0,
            'pesan' => 'Format tanggal tidak valid'
        ];
    }
}

/**
 * Fungsi untuk mendapatkan data POM yang belum dikembalikan dengan status OVERDUE
 * 
 * @return array - Array berisi data kontrak yang belum dikembalikan
 */
function get_pom_overdue_list()
{
    $ci = get_instance();

    // Query untuk mendapatkan data BAST2 yang belum dikembalikan POM
    // TETAPI exclude yang sudah dikirim ke pusat atau sudah ada progress di fase berikutnya
    $query = $ci->db->query("
        SELECT 
            ub2.id_bast2,
            ub2.no_kontrak,
            ub2.tgl_pom,
            ub2.kembali_pom,
            ub2.tgl_pusat2,
            ub2.tgl_kontraktor2,
            ufa.nama_pt,
            ufa.pekerjaan
        FROM user_bast2 ub2
        INNER JOIN user_final_account ufa ON ub2.no_kontrak = ufa.no_kontrak
        WHERE ub2.tgl_pom != '0000-00-00' 
        AND ub2.tgl_pom IS NOT NULL
        AND (ub2.kembali_pom = '0000-00-00' OR ub2.kembali_pom IS NULL)
        AND (ub2.tgl_pusat2 = '0000-00-00' OR ub2.tgl_pusat2 IS NULL)
        AND (ub2.tgl_kontraktor2 = '0000-00-00' OR ub2.tgl_kontraktor2 IS NULL)
        ORDER BY ub2.tgl_pom ASC
    ");

    $result = $query->result_array();
    $overdue_data = [];

    // Filter hanya yang OVERDUE (7 hari atau lebih)
    foreach ($result as $data) {
        $status = cek_pom_overdue($data['tgl_pom'], $data['kembali_pom'], $data['tgl_pusat2'], $data['tgl_kontraktor2']);

        if ($status['status'] == 'OVERDUE') {
            $data['hari_terlewat'] = $status['hari_terlewat'];
            $data['pesan'] = $status['pesan'];
            $overdue_data[] = $data;
        }
    }

    return $overdue_data;
}
