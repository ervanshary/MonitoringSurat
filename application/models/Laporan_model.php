<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function getLaporanData()
    {
        $this->db->select('
    user_final_account.no_kontrak,
    user_final_account.nama_pt,
    user_final_account.pekerjaan,
    user_asbuiltdrawing.tgl_terima as tgl_terima_asbuilt,
    user_asbuiltdrawing.updated_by as updated_by_asbuilt,
    user_asbuiltdrawing.keterangan as keterangan_asbuilt,
    user_bast.tgl_terima_bast as tgl_terima_bast,
    user_bast.tgl_pusat as tgl_pusat_bast1,
    user_bast.tgl_kontraktor as tgl_kontraktor_bast1,
    user_bast.updated_by as updated_by_bast,
    user_bast.is_revisi,
    user_bast.keterangan as keterangan_bast,
    user_bast2.tgl_terima_bast2,
    user_bast2.tgl_pom,
     user_bast2.kembali_pom,
    user_bast2.tgl_pusat2,
    user_bast2.tgl_kontraktor2,
    user_bast2.keterangan2,
    user_bast2.is_revisi as is_revisi_bast2,
    user_bast2.updated_by as updated_by_bast2,
    user_closing.tgl_closing,
    user_closing.updated_by as updated_by_closing,
    user_bast.opsi_retensi
');

        $this->db->from('user_final_account');
        $this->db->join('user_asbuiltdrawing', 'user_final_account.no_kontrak = user_asbuiltdrawing.no_kontrak', 'left');
        $this->db->join('user_bast', 'user_final_account.no_kontrak = user_bast.no_kontrak', 'left');
        $this->db->join('user_bast2', 'user_final_account.no_kontrak = user_bast2.no_kontrak', 'left');
        $this->db->join('user_closing', 'user_final_account.no_kontrak = user_closing.no_kontrak', 'left');

        $query = $this->db->get();

        if (!$query) {
            $error = $this->db->error();
            throw new Exception('Database error: ' . $error['message']);
        }

        $laporan = $query->result_array();

        foreach ($laporan as &$row) {
            $row['keterangan'] = $this->generateKeterangan($row);
        }

        return $laporan;
    }

    public function getFilteredLaporanData($search)
    {
        $this->db->select('
    user_final_account.no_kontrak,
    user_final_account.nama_pt,
    user_final_account.pekerjaan,
    user_asbuiltdrawing.tgl_terima as tgl_terima_asbuilt,
    user_asbuiltdrawing.updated_by as updated_by_asbuilt,
    user_asbuiltdrawing.keterangan as keterangan_asbuilt,
    user_bast.tgl_terima_bast as tgl_terima_bast,
    user_bast.tgl_pusat as tgl_pusat_bast1,
    user_bast.tgl_kontraktor as tgl_kontraktor_bast1,
    user_bast.updated_by as updated_by_bast,
    user_bast.is_revisi,
    user_bast.keterangan as keterangan_bast,
    user_bast2.tgl_terima_bast2,
    user_bast2.tgl_pom,
    user_bast2.kembali_pom,
    user_bast2.tgl_pusat2,
    user_bast2.tgl_kontraktor2,
    user_bast2.keterangan2,
    user_bast2.is_revisi as is_revisi_bast2,
    user_bast2.updated_by as updated_by_bast2,
    user_closing.tgl_closing,
    user_closing.updated_by as updated_by_closing,
    user_bast.opsi_retensi
');

        $this->db->from('user_final_account');
        $this->db->join('user_asbuiltdrawing', 'user_final_account.no_kontrak = user_asbuiltdrawing.no_kontrak', 'left');
        $this->db->join('user_bast', 'user_final_account.no_kontrak = user_bast.no_kontrak', 'left');
        $this->db->join('user_bast2', 'user_final_account.no_kontrak = user_bast2.no_kontrak', 'left');
        $this->db->join('user_closing', 'user_final_account.no_kontrak = user_closing.no_kontrak', 'left');

        $this->db->like('user_final_account.no_kontrak', $search);
        $this->db->or_like('user_final_account.nama_pt', $search);
        $this->db->or_like('user_final_account.pekerjaan', $search);

        $query = $this->db->get();

        if (!$query) {
            $error = $this->db->error();
            throw new Exception('Database error: ' . $error['message']);
        }

        $laporan = $query->result_array();

        foreach ($laporan as &$row) {
            $row['keterangan'] = $this->generateKeterangan($row);
        }

        return $laporan;
    }

    private function generateKeterangan($row)
    {
        // Fungsi bantuan untuk memeriksa apakah tanggal terisi (mengabaikan '0000-00-00' atau kosong)
        $is_date_filled = function ($date_value) {
            $date = $date_value ?? null;
            return !empty($date) && $date != '0000-00-00';
        };

        // Pre-load tanggal-tanggal penting
        $tgl_terima_bast = $is_date_filled($row['tgl_terima_bast'] ?? null);
        $tgl_pusat_bast1 = $is_date_filled($row['tgl_pusat_bast1'] ?? null);
        $tgl_kontraktor_bast1 = $is_date_filled($row['tgl_kontraktor_bast1'] ?? null);
        $tgl_kontraktor2 = $is_date_filled($row['tgl_kontraktor2'] ?? null);
        $tgl_pom         = $is_date_filled($row['tgl_pom'] ?? null);
        $tgl_pusat2      = $is_date_filled($row['tgl_pusat2'] ?? null);
        $tgl_bast2       = $is_date_filled($row['tgl_terima_bast2'] ?? null);
        $tgl_closing     = $is_date_filled($row['tgl_closing'] ?? null);
        $tgl_kembali_pom = $is_date_filled($row['kembali_pom'] ?? null);
        $tgl_terima_asbuilt = $is_date_filled($row['tgl_terima_asbuilt'] ?? null);

        // =========================================================================
        // CEK: Ada BAST 2 (jangan jalankan BAST 1)
        // Jika ada salah satu: tgl_bast2, tgl_pom, tgl_pusat2, tgl_kontraktor2, atau tgl_closing
        // =========================================================================
        if ($tgl_terima_bast && !$tgl_bast2 && !$tgl_closing && !$tgl_pom && !$tgl_pusat && !$tgl_kontraktor2) {
            $keterangan_bast1 = $row['keterangan_bast'] ?? '';
            if (!empty($keterangan_bast1)) {
                return 'BAST 1 sudah di terima - ' . $keterangan_bast1;
            }
            return 'BAST 1 sudah di terima';
        }

        // =========================================================================
        // LOGIKA BAST 1 (hanya jika tidak ada BAST 2)
        // =========================================================================

        // Logika 1 & 5 (Gabungan): Status DONE Final
        // (tgl_kontraktor2 terisi) ATAU (tgl_pom dan tgl_pusat TIDAK terisi, tapi tgl_kontraktor2 terisi)
        // Sebenarnya hanya perlu cek tgl_kontraktor2 saja karena sudah mencakup semua
        if ($tgl_kontraktor2) {
            return 'DONE';
        }

        // Logika 2 & 4 (Gabungan): Status Proses TTD di Pusat
        // (tgl_pom terisi DAN tgl_pusat terisi) ATAU (tgl_pusat terisi, tapi tgl_pom TIDAK)
        if ($tgl_pusat) { // Cukup cek tgl_pusat terisi (karena DONE sudah dicek di atas)
            return 'BAST 2 Proses TTD di Pusat';
        }

        // Logika 3: Proses TTD POM
        // Jika tgl_pom terisi, tetapi tgl_pusat dan tgl_kontraktor2 belum terisi
        if ($tgl_pom) { // Cukup cek tgl_pom terisi (karena tgl_pusat dan tgl_kontraktor2 sudah dicek di atas)
            return 'Proses TTD POM';
        }

        // Logika 4 (Asli): Proses TTD CM atau PM
        // Hanya tgl_terima_bast2 yang terisi, alur TTD (POM, Pusat, Kontraktor2) belum dimulai
        if ($tgl_bast2) {
            return 'Proses TTD CM atau PM';
        }

        // =========================================================================
        // LOGIKA BACKUP: Jika tidak masuk kondisi di atas
        // =========================================================================

        if (empty($row['tgl_terima_asbuilt'])) {
            return 'Belum BAST 1 / asbuilt belum diajukan';
        } elseif (!empty($row['tgl_terima_asbuilt']) && empty($row['tgl_terima_bast'])) {
            return 'Segera ajukan BAST 1';
        } elseif (!empty($row['tgl_terima_bast']) && empty($row['tgl_closing'])) {
            if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                return 'DONE';
            }
            return 'Ajukan Final Account terlebih dahulu';
        } elseif (!empty($row['tgl_terima_bast']) && !empty($row['tgl_closing'])) {

            // Pengecekan Masa Retensi
            if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                return 'DONE';
            }

            $tgl_terima_bast = strtotime($row['tgl_terima_bast']);
            $tgl_terima_bast_plus_retensi = strtotime("+" . $row['opsi_retensi'] . " days", $tgl_terima_bast);

            if (time() >= $tgl_terima_bast_plus_retensi) {
                return 'Masa retensi habis, segera ajukan BAST 2';
            } else {
                return 'BAST 2 belum diajukan / masih dalam masa retensi';
            }
        } else {
            return '';
        }
    }


    public function simpanKeLaporanTable($data)
    {
        return $this->db->insert('laporan', $data);
    }
}