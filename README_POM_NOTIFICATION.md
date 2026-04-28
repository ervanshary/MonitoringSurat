# 🎯 POM NOTIFICATION SYSTEM - README

## 📌 Apa Itu?

Sistem notifikasi otomatis yang **menampilkan alert/peringatan** di halaman BAST 2 ketika:

- ✅ Dokumen BAST 2 dikirim ke POM (tgl_pom terisi)
- ✅ Belum dikembalikan oleh POM (kembali_pom kosong)
- ✅ Sudah **7 hari atau lebih** sejak tanggal pengiriman

Sistem akan menampilkan:

- 📄 **Nomor Kontrak**
- 🏢 **Nama PT** (Perusahaan)
- 🔨 **Jenis Pekerjaan**
- 📅 **Tanggal Kirim ke POM**
- ⚠️ **Berapa Hari Sudah Terlewat**

---

## 🚀 Fitur

### 1. Alert Visual di Halaman BAST 2

```
┌─────────────────────────────────────────────────┐
│ 🔴 PERHATIAN: POM BELUM DIKEMBALIKAN             │
│                                                 │
│ Terdapat 3 dokumen yang OVERDUE:                │
│ ├─ 001/KK/2024 - PT ABC - 41 hari terlewat     │
│ ├─ 002/KK/2024 - PT XYZ - 35 hari terlewat     │
│ └─ 003/KK/2024 - PT DEF - 28 hari terlewat     │
└─────────────────────────────────────────────────┘
```

### 2. Perhitungan Otomatis Hari

Sistem **otomatis menghitung** berapa hari POM belum mengembalikan:

- Tanggal Hari Ini - Tanggal Kirim = Hari Terlewat
- Contoh: 30-01-2026 - 20-01-2026 = 10 hari

### 3. Status Tracking

Sistem mendeteksi 5 status POM:
| Status | Tampilan | Kondisi |
|--------|----------|---------|
| ⚪ Belum Dikirim | - | tgl_pom kosong |
| ⏳ Dalam Proses | - | < 7 hari |
| 🔴 OVERDUE | Alert | ≥ 7 hari |
| ✅ Selesai | - | kembali_pom terisi |
| ❌ Error | - | Tanggal invalid |

### 4. API Endpoint

Dapatkan data JSON untuk integrasi mobile/external apps:

```
GET: /User/get_pom_notification

Response:
{
    "success": true,
    "count": 3,
    "data": [
        {
            "no_kontrak": "001/KK/2024",
            "nama_pt": "PT ABC",
            "pekerjaan": "Konstruksi",
            "tgl_pom": "2024-01-20",
            "hari_terlewat": 41,
            "status": "OVERDUE"
        }
    ]
}
```

---

## 📍 Dimana Letaknya?

### Alert di Halaman

- **Halaman:** `/User/getBAST2` (BAST 2 Menu)
- **Lokasi:** Atas tabel, setelah admin tools
- **Styling:** Alert box merah dengan icon warning

### File yang Dimodifikasi

```
application/
├─ helpers/
│  └─ login_helper.php          ← Helper functions
├─ models/
│  └─ Bast2_model.php           ← Model methods
├─ controllers/
│  └─ User.php                  ← Controller logic
└─ views/user/
   └─ bast2.php                 ← Alert section
```

---

## 💡 Cara Kerja Singkat

### Alur Proses

```
1. User membuka halaman BAST 2
         ↓
2. Controller mengambil data POM dari database
         ↓
3. Sistem cek: apakah ada yang tgl_pom kosong? TIDAK
         ↓
4. Sistem cek: apakah kembali_pom terisi? TIDAK
         ↓
5. Sistem hitung: today - tgl_pom = berapa hari?
         ↓
6. Sistem cek: >= 7 hari? YA
         ↓
7. Sistem tandai sebagai OVERDUE
         ↓
8. Alert ditampilkan di halaman
         ↓
9. User melihat peringatan dengan detail lengkap
```

### Status Decision Flowchart

```
Cek Tanggal POM
│
├─ Kosong/Null?
│  └─ Status: BELUM_DIKIRIM (tidak ditampilkan)
│
├─ Kembali_pom terisi?
│  └─ Status: SELESAI ✅ (tidak ditampilkan)
│
└─ Hitung selisih hari
   │
   ├─ >= 7 hari?
   │  └─ Status: OVERDUE 🔴 (TAMPILKAN ALERT)
   │
   └─ < 7 hari?
      └─ Status: DALAM_PROSES (tidak ditampilkan)
```

---

## 🎯 Use Cases

### Use Case 1: Pantau POM Terlambat

**Scenario:** Setiap hari staff membuka BAST 2
**Hasil:** Otomatis melihat POM mana yang terlambat
**Action:** Hubungi POM untuk minta kembali dokumen

### Use Case 2: Management Review

**Scenario:** Manager membuka dashboard
**Hasil:** Melihat berapa POM yang OVERDUE
**Action:** Monitor dan follow-up ke POM

### Use Case 3: Laporan Harian

**Scenario:** Generate report POM overdue
**Hasil:** List lengkap dokumen yang belum kembali
**Action:** Kirim ke stakeholder

### Use Case 4: Mobile Integration

**Scenario:** App mobile hit API endpoint
**Hasil:** Dapatkan JSON data OVERDUE POM
**Action:** Display notifikasi di mobile app

---

## ⚙️ Cara Menggunakan

### Untuk End User

1. Buka menu **BAST 2**
2. Lihat halaman data BAST 2
3. Jika ada yang OVERDUE, akan ada **alert merah** di atas tabel
4. Baca detail: No Kontrak, PT, Pekerjaan, Hari Terlewat
5. Hubungi POM untuk minta kembali dokumen

### Untuk Developer (Extend Fitur)

#### Di Controller

```php
// Get list overdue
$overdue_list = get_pom_overdue_list();

// Process each item
foreach ($overdue_list as $item) {
    // Send email, SMS, or log
    send_notification($item);
}
```

#### Di Model

```php
// Get status
$status = $this->Bast2_model->getStatusPom($tgl_pom, $kembali_pom);

// Use badge class
echo '<span class="' . $status['badge_class'] . '">';
```

#### Di View

```php
// Loop data
<?php foreach ($pom_overdue as $item) : ?>
    <p><?= $item['no_kontrak']; ?> -
       <?= $item['hari_terlewat']; ?> hari</p>
<?php endforeach; ?>
```

#### Via AJAX

```javascript
// Fetch data
fetch("/User/get_pom_notification")
	.then((r) => r.json())
	.then((data) => console.log(data.count + " overdue"));
```

---

## 🔧 Customization

### Mengubah Threshold (7 hari ke lain)

Edit di `login_helper.php`:

```php
if ($selisih >= 7) {  // ← Ubah 7 menjadi angka lain
    return ['status' => 'OVERDUE', ...];
}
```

### Mengubah Styling

Edit di `bast2.php`, section alert:

```php
<div class="bg-red-100 ...">  // ← Ubah color
```

### Menambah Informasi

1. Edit `Bast2_model->getPomBelumDikembalikan()`
2. Tambah field di SELECT query
3. Update view untuk tampilkan field

---

## 🐛 Troubleshooting

### Alert tidak muncul

**Check:**

- [ ] Ada data dengan tgl_pom terisi?
- [ ] Formatnya YYYY-MM-DD? (contoh: 2024-01-20)
- [ ] kembali_pom kosong atau '0000-00-00'?
- [ ] Selisih >= 7 hari?
- [ ] Clear browser cache & refresh

### Angka hari salah

**Check:**

- [ ] Timezone PHP benar?
- [ ] Tanggal di database benar?
- [ ] Hitung manual: today - tgl_pom

### API error

**Check:**

- [ ] URL benar: `/User/get_pom_notification`
- [ ] Method: GET
- [ ] Check browser console (F12)
- [ ] Check logs: `application/logs/`

---

## 📊 Database Schema

### Tabel: user_bast2

```sql
CREATE TABLE user_bast2 (
    id_bast2 INT PRIMARY KEY AUTO_INCREMENT,
    id_bast INT,
    tgl_pom DATE,              -- ← TANGGAL KIRIM (FIELD PENTING)
    kembali_pom DATE,          -- ← TANGGAL KEMBALI (FIELD PENTING)
    tgl_terima_bast2 DATE,
    tgl_pusat2 DATE,
    tgl_kontraktor2 DATE,
    no_kontrak VARCHAR(128),
    keterangan2 VARCHAR(128),
    file_pdf_bast2 VARCHAR(250),
    ...
);
```

### Tabel: user_final_account

```sql
CREATE TABLE user_final_account (
    id INT PRIMARY KEY AUTO_INCREMENT,
    no_kontrak VARCHAR(128),   -- ← JOIN KEY
    nama_pt VARCHAR(128),       -- ← TAMPILAN DI ALERT
    pekerjaan VARCHAR(128),     -- ← TAMPILAN DI ALERT
    status VARCHAR(128),
    is_active VARCHAR(1),
    ...
);
```

---

## 📚 Dokumentasi Lengkap

| File                                       | Isi                    |
| ------------------------------------------ | ---------------------- |
| **IMPLEMENTASI_RINGKASAN.md**              | Overview & summary     |
| **DOKUMENTASI_FUNGSI_POM.md**              | Lengkap semua function |
| **QUICK_START_POM_NOTIFICATION.md**        | Panduan setup cepat    |
| **CONTOH_PENGGUNAAN_POM_NOTIFICATION.php** | Code examples          |
| **RINGKASAN_TEKNIS_POM_NOTIFICATION.md**   | Technical details      |
| **DEPLOYMENT_CHECKLIST.md**                | Deploy & testing       |

**Baca dokumentasi sebelum modify code!**

---

## ✅ Testing

Jalankan test ini sebelum production:

```bash
✓ Buka /User/getBAST2
  → Lihat apakah alert muncul (jika ada overdue)

✓ Verifikasi data detail
  → Cek no kontrak, PT, pekerjaan, tgl kirim

✓ Hitung hari manual
  → Bandingkan dengan perhitungan sistem

✓ Test API endpoint
  → curl -s https://yoursite.com/User/get_pom_notification
  → Cek JSON response

✓ Test update data
  → Edit kembali_pom, refresh
  → Alert harus hilang

✓ Mobile responsive
  → Buka di mobile, tablet, desktop
  → Harus tampil dengan baik
```

---

## 🎯 Next Steps

### Fitur yang bisa ditambah:

- [ ] Email reminder otomatis
- [ ] SMS notification
- [ ] Dashboard widget
- [ ] Export ke Excel
- [ ] Escalation ke manager
- [ ] History tracking

---

## 📞 Support

Jika ada pertanyaan:

1. Baca dokumentasi (4 files)
2. Lihat code examples di file .php
3. Check CodeIgniter logs
4. Hubungi developer team

---

## 🎉 Summary

Anda sekarang punya sistem **notifikasi POM otomatis** yang:

- ✅ Deteksi POM overdue (>= 7 hari)
- ✅ Tampilkan alert dengan detail lengkap
- ✅ Perhitungan akurat
- ✅ Interface menarik
- ✅ Siap production

**Status: ✅ READY TO USE**

---

_Last Updated: 30 Januari 2026_  
_Version: 1.0_  
_Status: Production Ready_
