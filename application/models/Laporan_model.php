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
        $ada_bast2_atau_closing = $tgl_bast2 || $tgl_pom || $tgl_pusat2 || $tgl_kontraktor2 || $tgl_closing;

        if ($ada_bast2_atau_closing) {
            // ===== LOGIKA BAST 2 - SCENARIO BARU =====
            
            // Jika tgl_bast2 ada, handle berbagai scenario TTD
            if ($tgl_bast2) {
                // Scenario 4: Semua ada → DONE
                if ($tgl_kontraktor2) {
                    return 'BAST 2 sudah diterima DONE';
                }

                // Scenario 3: tgl_pusat ada (tapi kontraktor tidak) → Proses ke Pusat
                // Even jika tgl_pom dan tgl_kembali_pom tidak ada
                if ($tgl_pusat2) {
                    return 'BAST 2 proses ke Pusat';
                }

                // Scenario 2: tgl_pom ada + tgl_kembali_pom TIDAK ada (dan pusat tidak ada) → Proses ke POM
                if ($tgl_pom && !$tgl_kembali_pom) {
                    return 'BAST 2 Proses ke POM';
                }

                // Scenario 1: Hanya tgl_bast2 → Proses TTD PM
                return 'BAST 2 Proses TTD PM';
            }

            // Jika tgl_closing ada tapi tgl_bast2 belum ada → jalankan logika lama BAST 2
            if ($tgl_closing && !$tgl_bast2) {
                if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                    return 'DONE';
                }

                $tgl_terima_bast_ts = strtotime($row['tgl_terima_bast']);
                $tgl_terima_bast_plus_retensi = strtotime("+" . $row['opsi_retensi'] . " days", $tgl_terima_bast_ts);

                if (time() >= $tgl_terima_bast_plus_retensi) {
                    return 'Masa retensi habis, segera ajukan BAST 2';
                } else {
                    return 'BAST 2 belum diajukan / masih dalam masa retensi';
                }
            }
        }

        // =========================================================================
        // LOGIKA BAST 1 (hanya jika tidak ada BAST 2)
        // =========================================================================
        if ($tgl_terima_bast) {
            // Cek revisi dulu
            if (!empty($row['is_revisi']) && $row['is_revisi'] == 1) {
                return 'BAST 1 sudah diterima - revisi dikembalikan ke kontraktor';
            }

            // Cek retensi = 0 (langsung DONE)
            if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                return 'DONE';
            }

            // Status normal (tidak ada revisi) - check scenario
            // Scenario C: tgl_kontraktor_bast1 ada (semua tgl BAST 1 terisi)
            if ($tgl_kontraktor_bast1) {
                return 'DONE - Bisa ajukan Final Account';
            }

            // Scenario A: tgl_pusat ada tapi tgl_kontraktor TIDAK ada
            if ($tgl_pusat_bast1 && !$tgl_kontraktor_bast1) {
                return 'BAST 1 sudah di terima - proses ke pusat';
            }

            // Scenario B: keduanya tidak ada
            if (!$tgl_pusat_bast1 && !$tgl_kontraktor_bast1) {
                return 'BAST 1 sudah diterima proses ttd PM';
            }
            
            // Fallback
            return 'BAST 1 sudah diterima';
        }

        // =========================================================================
        // LOGIKA BACKUP: Jika tidak masuk kondisi di atas
        // =========================================================================
        if (empty($tgl_terima_asbuilt)) {
            return 'Belum BAST 1 / asbuilt belum diajukan';
        } elseif ($tgl_terima_asbuilt && empty($tgl_terima_bast)) {
            return 'Segera ajukan BAST 1';
        } else {
            return '';
        }
    }


    public function simpanKeLaporanTable($data)
    {
        return $this->db->insert('laporan', $data);
    }
}