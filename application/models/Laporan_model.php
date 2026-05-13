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
        
        // Cek field revisi di BAST1 dan BAST2
        $is_revisi_bast1 = isset($row['is_revisi']) ? intval($row['is_revisi']) : 0;
        $is_revisi_bast2 = isset($row['is_revisi_bast2']) ? intval($row['is_revisi_bast2']) : 0;
        
        // Ambil keterangan dari BAST1 dan BAST2
        $keterangan_bast1 = isset($row['keterangan_bast']) ? trim($row['keterangan_bast']) : '';
        $keterangan_bast2 = isset($row['keterangan2']) ? trim($row['keterangan2']) : '';

        $build_bast2_desc = function () use ($tgl_kontraktor2, $tgl_pusat2, $tgl_pom, $tgl_bast2, $keterangan_bast2) {
            if ($tgl_kontraktor2) {
                $stage = 'TTD Kontraktor (Selesai)';
            } elseif ($tgl_pusat2) {
                $stage = 'TTD Pusat';
            } elseif ($tgl_pom) {
                $stage = 'TTD POM';
            } elseif ($tgl_bast2) {
                $stage = 'TTD PM/CM (Belum TTD POM/Pusat/Kontraktor)';
            } else {
                $stage = 'BAST 2 sudah diterima';
            }
            return 'BAST 2 sudah diterima - ' . ($keterangan_bast2 ?: $stage);
        };

        // =========================================================================
        // LOGIKA BAST 1 (Cek DULU, sebelum BAST 2)
        // =========================================================================
        
        // 1. Jika is_revisi = 1 (centang revisi), prioritas tertinggi
        if ($is_revisi_bast1) {
            return 'Revisi BAST dikembalikan ke kontraktor';
        }
        
        // 2. Jika BAST1 belum ada (tgl_terima_bast kosong)
        if (!$tgl_terima_bast) {
            return 'Belum BAST 1 / asbuilt belum diajukan';
        }
        
        // 3. Jika BAST1 sudah ada (tgl_terima_bast terisi) dan closing belum ada
        if ($tgl_terima_bast && !$tgl_closing) {
            // Sub-check: Jika retensi = 0, tidak perlu BAST 2
            if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                return 'BAST 1 DONE tidak perlu BAST 2';
            }

            // Jika BAST2 sudah dimulai, gunakan BAST2 status terlebih dahulu
            if ($tgl_bast2 || $tgl_pom || $tgl_pusat2 || $tgl_kontraktor2) {
                if ($is_revisi_bast2) {
                    return 'Revisi BAST 2 dikembalikan ke kontraktor';
                }
                return $build_bast2_desc();
            }
            
            // Sub-check: Jika tgl_kontraktor ada, ajukan final account
            if ($tgl_kontraktor_bast1) {
                return 'Ajukan Final Account terlebih dahulu';
            }
            
            // Default: BAST1 sudah diterima dengan keterangan stage atau keterangan BAST1
            $stage1 = '';
            if ($tgl_kontraktor_bast1) {
                $stage1 = 'TTD Kontraktor (Selesai)';
            } elseif ($tgl_pusat_bast1) {
                $stage1 = 'Proses TTD Pusat';
            } else {
                $stage1 = 'Proses TTD PM/CM';
            }
            $desc1 = $keterangan_bast1 ?: $stage1;
            return 'BAST 1 sudah diterima - ' . $desc1;
        }

        // 4. Jika BAST1 dan closing sudah ada - cek masa retensi
        if ($tgl_terima_bast && $tgl_closing) {
            // Jika retensi = 0, DONE
            if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                return 'BAST 1 DONE tidak perlu BAST 2';
            }

            // Jika BAST2 sudah ada atau sedang direvisi, proses BAST2 (prioritaskan BAST2)
            if ($tgl_bast2 || $is_revisi_bast2) {
                // jika revisi BAST2
                if ($is_revisi_bast2) {
                    return 'Revisi BAST 2 dikembalikan ke kontraktor';
                }

                // Bangun keterangan BAST2 yang lebih deskriptif
                $stage = '';
                if ($tgl_kontraktor2) {
                    $stage = 'TTD Kontraktor (Selesai)';
                } elseif ($tgl_pusat2) {
                    $stage = 'TTD Pusat';
                } elseif ($tgl_pom) {
                    $stage = 'TTD POM';
                } elseif ($tgl_bast2) {
                    $stage = 'TTD PM/CM (Belum TTD POM/Pusat/Kontraktor)';
                }

                $desc = $keterangan_bast2 ?: $stage;
                return 'BAST 2 sudah diterima - ' . $desc;
            }

            // Cek masa retensi jika BAST2 belum ada
            $tgl_terima_bast_time = strtotime($row['tgl_terima_bast']);
            $tgl_terima_bast_plus_retensi = strtotime("+" . $row['opsi_retensi'] . " days", $tgl_terima_bast_time);

            if (time() >= $tgl_terima_bast_plus_retensi) {
                return 'Masa retensi habis, segera ajukan BAST 2';
            } else {
                return 'BAST 2 belum diajukan / masih dalam masa retensi';
            }
        }

        // =========================================================================
        // LOGIKA BAST 2 (Setelah BAST1 OK - Cek hanya jika BAST1 sudah ada)
        // =========================================================================

        if ($tgl_terima_bast) {
            // Jika revisi BAST2
            if ($is_revisi_bast2) {
                return 'Revisi BAST 2 dikembalikan ke kontraktor';
            }

            // Jika BAST2 sudah diterima, kembalikan dengan gabungan keterangan
            if ($tgl_bast2) {
                $stage = '';
                if ($tgl_kontraktor2) {
                    $stage = 'TTD Kontraktor (Selesai)';
                } elseif ($tgl_pusat2) {
                    $stage = 'TTD Pusat';
                } elseif ($tgl_pom) {
                    $stage = 'TTD POM';
                } else {
                    $stage = 'TTD PM/CM (Belum TTD POM/Pusat/Kontraktor)';
                }

                $desc = $keterangan_bast2 ?: $stage;
                return 'BAST 2 sudah diterima - ' . $desc;
            }

            // Logika 1: Status DONE Final BAST 2 (tanda tangan kontraktor)
            if ($tgl_kontraktor2) {
                return 'BAST 2 DONE';
            }

            // Logika 2: Status Proses TTD di Pusat
            if ($tgl_pusat2) {
                return 'BAST 2 Proses TTD di Pusat';
            }

            // Logika 3: Proses TTD POM
            if ($tgl_pom) {
                return 'BAST 2 Proses TTD POM';
            }
        }

        // Default jika tidak ada kondisi yang cocok
        return '';
    }


    public function simpanKeLaporanTable($data)
    {
        return $this->db->insert('laporan', $data);
    }
}