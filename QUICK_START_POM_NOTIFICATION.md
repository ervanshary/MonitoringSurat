# QUICK START GUIDE - POM NOTIFICATION SYSTEM

## 🚀 Instalasi & Setup (5 Menit)

### Step 1: Update Files ✅ SUDAH DILAKUKAN

File-file berikut telah dimodifikasi/ditambahkan:

- ✅ `application/helpers/login_helper.php`
- ✅ `application/models/Bast2_model.php`
- ✅ `application/controllers/User.php`
- ✅ `application/views/user/bast2.php`

### Step 2: Clear Cache (Opsional)

Jika menggunakan caching, clear cache CodeIgniter:

```bash
# Hapus folder application/cache
rm -rf application/cache/*
```

### Step 3: Test Sistem

1. Login ke aplikasi
2. Buka halaman **BAST 2** → `/User/getBAST2`
3. Cek apakah notifikasi muncul (jika ada POM OVERDUE)

---

## 📋 Fitur Utama

### ✅ Notifikasi Alert

- Tampil otomatis di halaman BAST 2 jika ada POM OVERDUE
- Menampilkan:
  - Jumlah dokumen yang overdue
  - Nomor kontrak
  - Nama PT
  - Pekerjaan
  - Tanggal kirim
  - Jumlah hari terlewat

### ✅ Status POM

Sistem mengecek 5 status:

1. **BELUM_DIKIRIM** - Tanggal POM masih kosong
2. **DALAM_PROSES** - Sudah dikirim, kurang dari 7 hari
3. **OVERDUE** - Belum dikembalikan, 7 hari atau lebih ⭐
4. **SELESAI** - Sudah dikembalikan
5. **ERROR** - Format tanggal tidak valid

### ✅ API Endpoint

Endpoint untuk mendapatkan data POM via JSON:

```
GET: /User/get_pom_notification
```

**Response:**

```json
{
	"success": true,
	"count": 2,
	"data": [
		{
			"id_bast2": 52,
			"no_kontrak": "001/KK/MBM-ANAMI/III/2019",
			"tgl_pom": "2024-01-20",
			"kembali_pom": "0000-00-00",
			"nama_pt": "GEOTECHNICAL ENGINEERING",
			"pekerjaan": "PEKERJAAN SOIL TEST",
			"hari_terlewat": 10,
			"status": "OVERDUE",
			"badge_class": "bg-red-600",
			"pesan": "OVERDUE 10 hari"
		}
	]
}
```

---

## 🔧 Cara Menggunakan

### Menggunakan Helper Function

**Cek status satu POM:**

```php
<?php
$this->load->helper('login'); // Di controller __construct()

$tgl_pom = '2024-01-20';
$tgl_kembali = null;

$status = cek_pom_overdue($tgl_pom, $tgl_kembali);
echo $status['pesan']; // Output: Belum dikembalikan dari POM - Terlewat 41 hari
?>
```

**Dapatkan daftar semua POM OVERDUE:**

```php
<?php
$overdue_list = get_pom_overdue_list();

foreach ($overdue_list as $item) {
    echo $item['no_kontrak'] . ' - ' . $item['hari_terlewat'] . ' hari';
}
?>
```

### Menggunakan Model Function

```php
<?php
// Di controller
$pom_list = $this->Bast2_model->getPomBelumDikembalikan();

foreach ($pom_list as $item) {
    $status = $this->Bast2_model->getStatusPom($item['tgl_pom'], $item['kembali_pom']);

    if ($status['status'] == 'OVERDUE') {
        echo '<span class="' . $status['badge_class'] . '">';
        echo $status['pesan'];
        echo '</span>';
    }
}
?>
```

### Menggunakan AJAX

```javascript
// Ambil data POM overdue
fetch("/User/get_pom_notification")
	.then((response) => response.json())
	.then((data) => {
		if (data.count > 0) {
			console.log("Ada " + data.count + " POM yang overdue");

			data.data.forEach((item) => {
				console.log(item.no_kontrak + ": " + item.hari_terlewat + " hari");
			});
		}
	});
```

---

## 🎨 Customization

### Mengubah Threshold (dari 7 hari ke lain)

Edit di `application/helpers/login_helper.php`:

```php
// Cari bagian ini:
if ($selisih >= 7) {  // ← Ubah 7 ke angka yang diinginkan
    return [
        'status' => 'OVERDUE',
        ...
    ];
}
```

Lakukan hal yang sama di `application/models/Bast2_model.php`.

### Mengubah Styling Notifikasi

Edit di `application/views/user/bast2.php`, section "NOTIFIKASI POM YANG BELUM DIKEMBALIKAN":

```php
<!-- Warna background alert -->
<div class="bg-red-100 border-l-4 border-red-600 ...">

<!-- Badge OVERDUE -->
<span class="inline-block bg-red-600 text-white ...">

<!-- Sesuaikan dengan color scheme Anda -->
```

Gunakan Tailwind CSS classes untuk styling.

### Menambah Informasi pada Alert

1. Edit `Bast2_model->getPomBelumDikembalikan()`:

```php
// Tambahkan field baru di SELECT
SELECT
    ub2.id_bast2,
    ... field yang ada ...
    ub2.tgl_pusat2,  // ← Tambahan
    ...
```

2. Edit view `bast2.php`, sesuaikan struktur HTML alert.

---

## 📊 Testing Checklist

Jalankan test berikut untuk verifikasi:

- [ ] Buka halaman BAST 2
- [ ] Verifikasi notifikasi muncul (jika ada POM OVERDUE)
- [ ] Cek jumlah hari yang ditampilkan akurat
- [ ] Cek informasi kontrak, PT, pekerjaan
- [ ] Coba dismiss notifikasi dengan tombol X
- [ ] Refresh halaman, apakah notifikasi masih ada?
- [ ] Buka `/User/get_pom_notification` di browser
- [ ] Verifikasi JSON response
- [ ] Edit salah satu data, isikan tanggal kembali POM
- [ ] Refresh halaman, verifikasi notifikasi hilang

---

## 🐛 Troubleshooting

### Notifikasi tidak muncul

**Check List:**

- [ ] Pastikan ada data dengan `tgl_pom` yang tidak kosong
- [ ] Cek format tanggal: harus YYYY-MM-DD (mis: 2024-01-20)
- [ ] Cek `kembali_pom` harus kosong atau '0000-00-00'
- [ ] Cek selisih tanggal >= 7 hari
- [ ] Clear browser cache dan refresh
- [ ] Check browser console untuk error

**Debug:**

```php
<?php
// Di controller, cek apakah ada data
$pom_list = $this->Bast2_model->getPomBelumDikembalikan();
echo '<pre>';
print_r($pom_list);
echo '</pre>';
?>
```

### API endpoint error

**Solution:**

1. Pastikan helper 'login' di-load di `get_pom_notification()`
2. Cek URL path benar: `/User/get_pom_notification`
3. Cek browser console untuk error detail
4. Check CodeIgniter logs: `application/logs/`

### Tanggal tidak akurat

**Reason:** Timezone PHP mungkin berbeda
**Solution:** Set timezone di `config/config.php`:

```php
$config['date_default_timezone'] = 'Asia/Jakarta'; // Sesuaikan timezone Anda
```

---

## 📱 Integrasi Tambahan (Opsional)

### Dashboard Widget

Tambahkan widget status POM di dashboard:

```php
<?php
// Lihat CONTOH_PENGGUNAAN_POM_NOTIFICATION.php
// Contoh 6: Dashboard Widget
?>
```

### Email Notification

Setup cron job untuk mengirim email notifikasi:

```php
<?php
// Lihat CONTOH_PENGGUNAAN_POM_NOTIFICATION.php
// Contoh 5: Scheduled Task/Cron
?>
```

### Report Generator

Generate laporan POM overdue otomatis:

```bash
# Setup cron job untuk:
https://yoursite.com/cron/generate_pom_report

# Jalankan setiap hari pada jam tertentu
```

---

## 📚 Dokumentasi Lengkap

Untuk dokumentasi lebih detail, buka:

```
/DOKUMENTASI_FUNGSI_POM.md
```

File ini berisi:

- Penjelasan setiap function
- Parameter dan return value
- SQL queries
- Database schema
- Alur kerja lengkap

---

## 🎯 Fitur Tambahan yang Bisa Dikembangkan

1. **Reminder Email** - Kirim email reminder setiap hari jika ada OVERDUE
2. **SMS Alert** - Kirim SMS ke contact person jika overdue
3. **Custom Alert Sound** - Suara notifikasi untuk OVERDUE
4. **Escalation** - Auto-escalate ke manager jika overdue > 14 hari
5. **Export Report** - Export daftar OVERDUE ke Excel/PDF
6. **Status History** - Log perubahan status POM
7. **Multi-level Alert** - Alert berbeda untuk 7, 14, 21+ hari
8. **User Permission** - Kontrol siapa yang bisa lihat notifikasi

---

## 📞 Support

Jika ada issue atau pertanyaan:

1. Check dokumentasi di `/DOKUMENTASI_FUNGSI_POM.md`
2. Check contoh di `/CONTOH_PENGGUNAAN_POM_NOTIFICATION.php`
3. Check CodeIgniter logs di `application/logs/`
4. Hubungi tim development

---

## ✅ Checklist Implementasi

- [x] Helper functions dibuat
- [x] Model methods ditambahkan
- [x] Controller functions diupdate
- [x] View notifikasi ditambahkan
- [x] API endpoint dibuat
- [x] Dokumentasi lengkap disiapkan
- [x] Contoh penggunaan disiapkan
- [x] Quick start guide disiapkan

**Status: ✅ READY FOR PRODUCTION**

---

_Terakhir diupdate: 30 Januari 2026_
