# DOKUMENTASI FUNGSI NOTIFIKASI POM YANG BELUM DIKEMBALIKAN

## Deskripsi Umum

Fungsi ini dirancang untuk memberikan notifikasi ketika dokumen BAST 2 yang dikirim ke POM belum dikembalikan setelah melewati 7 hari. Sistem akan menampilkan peringatan dengan informasi lengkap tentang kontrak, PT, pekerjaan, dan jumlah hari yang sudah terlewat.

## Komponen Fungsi

### 1. **Helper Functions** (`application/helpers/login_helper.php`)

#### `cek_pom_overdue($tgl_pom, $kembali_pom = null)`

Fungsi untuk menghitung selisih hari dan menentukan status POM.

**Parameter:**

- `$tgl_pom` (string): Tanggal kirim POM (format: YYYY-MM-DD)
- `$kembali_pom` (string, optional): Tanggal kembali POM (format: YYYY-MM-DD)

**Return Value:**

```php
[
    'status' => 'BELUM_DIKIRIM' | 'SELESAI' | 'OVERDUE' | 'DALAM_PROSES' | 'ERROR',
    'hari_terlewat' => (int) jumlah hari,
    'pesan' => (string) pesan deskriptif
]
```

**Status Penjelasan:**

- `BELUM_DIKIRIM`: Tanggal POM masih kosong
- `SELESAI`: Sudah dikembalikan dari POM
- `OVERDUE`: Belum dikembalikan dan sudah melewati 7 hari
- `DALAM_PROSES`: Belum dikembalikan namun masih dalam periode 7 hari
- `ERROR`: Format tanggal tidak valid

**Contoh Penggunaan:**

```php
$status = cek_pom_overdue('2024-01-20', '0000-00-00');
if ($status['status'] == 'OVERDUE') {
    echo "Terlewat " . $status['hari_terlewat'] . " hari";
}
```

---

#### `get_pom_overdue_list()`

Fungsi untuk mendapatkan daftar semua POM yang belum dikembalikan dan sudah OVERDUE.

**Return Value:**

```php
[
    [
        'id_bast2' => (int),
        'no_kontrak' => (string),
        'tgl_pom' => (date),
        'kembali_pom' => (date),
        'nama_pt' => (string),
        'pekerjaan' => (string),
        'hari_terlewat' => (int),
        'pesan' => (string)
    ],
    ...
]
```

**Contoh Penggunaan:**

```php
$overdue_list = get_pom_overdue_list();
foreach ($overdue_list as $item) {
    echo $item['no_kontrak'] . " - " . $item['hari_terlewat'] . " hari";
}
```

---

### 2. **Model Functions** (`application/models/Bast2_model.php`)

#### `getPomBelumDikembalikan()`

Query untuk mendapatkan semua data POM yang belum dikembalikan (tanpa filter overdue).

**Return Value:**
Array berisi hasil query dari tabel `user_bast2` dan `user_final_account` yang di-join.

**SQL Query:**

```sql
SELECT
    ub2.id_bast2,
    ub2.no_kontrak,
    ub2.tgl_pom,
    ub2.kembali_pom,
    ufa.nama_pt,
    ufa.pekerjaan
FROM user_bast2 ub2
INNER JOIN user_final_account ufa ON ub2.no_kontrak = ufa.no_kontrak
WHERE ub2.tgl_pom != '0000-00-00'
AND ub2.tgl_pom IS NOT NULL
AND (ub2.kembali_pom = '0000-00-00' OR ub2.kembali_pom IS NULL)
ORDER BY ub2.tgl_pom ASC
```

---

#### `getStatusPom($tgl_pom, $kembali_pom = null)`

Fungsi untuk mendapatkan status POM dengan informasi badge dan pesan untuk display.

**Parameter:**

- `$tgl_pom` (string): Tanggal kirim POM
- `$kembali_pom` (string, optional): Tanggal kembali POM

**Return Value:**

```php
[
    'status' => 'BELUM_DIKIRIM' | 'SELESAI' | 'OVERDUE' | 'DALAM_PROSES' | 'ERROR',
    'hari_terlewat' => (int),
    'badge_class' => (string) CSS class untuk warna badge,
    'pesan' => (string)
]
```

**Badge Classes:**

- `BELUM_DIKIRIM`: `bg-gray-400`
- `SELESAI`: `bg-green-500`
- `OVERDUE`: `bg-red-600`
- `DALAM_PROSES`: `bg-yellow-500`
- `ERROR`: `bg-red-500`

**Contoh Penggunaan:**

```php
$status = $this->Bast2_model->getStatusPom('2024-01-20', null);
echo '<span class="' . $status['badge_class'] . '">' . $status['pesan'] . '</span>';
```

---

### 3. **Controller Functions** (`application/controllers/User.php`)

#### `getBAST2()`

Fungsi utama untuk menampilkan halaman BAST 2.

**Perubahan:**

- Menambahkan `$data['pom_overdue']` yang berisi daftar POM yang OVERDUE
- Data ini diambil dari fungsi `getPomOverdueData()`

**Data yang dikirim ke view:**

```php
$data['pom_overdue'] = array_of_overdue_pom_data
```

---

#### `getPomOverdueData()` (Private Function)

Fungsi private untuk memproses dan memfilter data POM yang OVERDUE.

**Logic:**

1. Mengambil semua POM yang belum dikembalikan dari model
2. Mengecek status setiap POM menggunakan `getStatusPom()`
3. Filter hanya yang memiliki status `OVERDUE`
4. Return array berisi data OVERDUE

**Return Value:**
Array berisi data POM yang OVERDUE dengan informasi status lengkap.

---

#### `get_pom_notification()` (API Endpoint)

Endpoint API untuk mendapatkan notifikasi POM via AJAX (JSON).

**URL:** `<?= base_url('User/get_pom_notification'); ?>`

**Method:** GET

**Return Value:**

```json
{
	"success": true,
	"count": 3,
	"data": [
		{
			"id_bast2": 1,
			"no_kontrak": "001/KK/2024",
			"tgl_pom": "2024-01-20",
			"kembali_pom": "0000-00-00",
			"nama_pt": "PT Maju Jaya",
			"pekerjaan": "Konstruksi Gedung",
			"hari_terlewat": 10,
			"status": "OVERDUE",
			"badge_class": "bg-red-600",
			"pesan": "OVERDUE 10 hari"
		}
	]
}
```

**Contoh Penggunaan dengan JavaScript:**

```javascript
fetch('<?= base_url("User/get_pom_notification"); ?>')
	.then((response) => response.json())
	.then((data) => {
		console.log("Total POM Overdue: " + data.count);
		data.data.forEach((item) => {
			console.log(item.no_kontrak + " - " + item.hari_terlewat + " hari");
		});
	});
```

---

### 4. **View Component** (`application/views/user/bast2.php`)

#### Notifikasi Alert Section

Sebuah section baru yang menampilkan notifikasi POM OVERDUE dengan styling Bootstrap + Tailwind.

**Fitur:**

- ✅ Menampilkan jumlah dokumen yang overdue
- ✅ Daftar lengkap kontrak dengan informasi:
  - Nomor Kontrak
  - Nama PT
  - Pekerjaan
  - Tanggal Kirim POM
  - Jumlah Hari Terlewat
- ✅ Styling merah untuk menarik perhatian
- ✅ Tombol close untuk dismiss notifikasi
- ✅ Icon Font Awesome untuk visual yang lebih baik

**Lokasi di View:**
Setelah Admin Tools alert, sebelum Table Section

**Kondisional:**
Hanya tampil jika ada data POM yang OVERDUE:

```php
<?php if (!empty($pom_overdue) && count($pom_overdue) > 0) : ?>
    <!-- Content -->
<?php endif; ?>
```

---

## Alur Kerja Lengkap

### 1. **Saat Halaman BAST 2 Dibuka**

```
User Akses URL: /User/getBAST2
    ↓
Controller getBAST2() dipanggil
    ↓
getPomOverdueData() dijalankan
    ↓
Bast2_model->getPomBelumDikembalikan() query database
    ↓
Filter status POM dengan getStatusPom()
    ↓
Data OVERDUE dimasukkan ke $data['pom_overdue']
    ↓
View bast2.php di-render dengan notifikasi
    ↓
Notifikasi ditampilkan (jika ada data OVERDUE)
```

### 2. **Logika Penentuan Status POM**

```
Tanggal Kirim POM Kosong (0000-00-00)?
    ├─ YA → Status: BELUM_DIKIRIM
    └─ TIDAK
        │
        Tanggal Kembali POM Terisi dan Tidak Kosong?
        ├─ YA → Status: SELESAI
        └─ TIDAK
            │
            Hitung Selisih = Hari Ini - Tanggal Kirim
            │
            Selisih >= 7 Hari?
            ├─ YA → Status: OVERDUE ⭐ (TAMPILKAN NOTIFIKASI)
            └─ TIDAK → Status: DALAM_PROSES
```

---

## Database Schema

Tabel yang terlibat:

1. **user_bast2**
   - `id_bast2` (PRIMARY KEY)
   - `id_bast`
   - `tgl_pom` (Tanggal kirim POM) ← **FIELD KUNCI**
   - `kembali_pom` (Tanggal kembali POM) ← **FIELD KUNCI**
   - `no_kontrak`
   - `keterangan2`
   - `tgl_pusat2`
   - `tgl_terima_bast2`
   - `tgl_kontraktor2`
   - `file_pdf_bast2`

2. **user_final_account**
   - `id` (PRIMARY KEY)
   - `no_kontrak`
   - `nama_pt` ← **FIELD KUNCI**
   - `pekerjaan` ← **FIELD KUNCI**
   - `status`
   - `is_active`

---

## Testing Checklist

- [ ] Buka halaman BAST 2
- [ ] Verifikasi notifikasi muncul jika ada POM OVERDUE
- [ ] Verifikasi jumlah hari yang ditampilkan akurat
- [ ] Verifikasi informasi kontrak, PT, dan pekerjaan benar
- [ ] Coba dismiss notifikasi dengan tombol X
- [ ] Test API endpoint `/User/get_pom_notification` di browser
- [ ] Verifikasi JSON response dari API
- [ ] Edit tanggal kembali POM dan refresh halaman
- [ ] Verifikasi notifikasi hilang setelah mengisi tanggal kembali

---

## Customization

### Mengubah Threshold Overdue (dari 7 hari ke jumlah lain)

Edit di `cek_pom_overdue()` dan `getStatusPom()`:

```php
if ($selisih >= 7) {  // Ubah 7 menjadi angka yang diinginkan
```

### Mengubah Styling Notifikasi

Edit di `bast2.php`, section notifikasi alert menggunakan Tailwind CSS classes.

### Menambah Informasi pada Notifikasi

1. Tambahkan field ke `Bast2_model->getPomBelumDikembalikan()`
2. Update query SELECT
3. Tampilkan di view menggunakan `<?= $item['field_name']; ?>`

---

## Troubleshooting

### Notifikasi tidak muncul padahal ada POM OVERDUE

- ✓ Cek apakah `tgl_pom` tidak kosong dan format YYYY-MM-DD
- ✓ Cek apakah `kembali_pom` kosong atau '0000-00-00'
- ✓ Cek apakah selisih hari >= 7
- ✓ Refresh halaman

### API endpoint error

- ✓ Pastikan helper 'login' di-load di function `get_pom_notification()`
- ✓ Cek koneksi database
- ✓ Lihat logs di `application/logs/`

### Tanggal tidak terhitung dengan benar

- ✓ Verifikasi format tanggal di database adalah YYYY-MM-DD
- ✓ Pastikan timezone di PHP sesuai dengan kebutuhan

---

## File yang Dimodifikasi

1. ✅ `application/helpers/login_helper.php` - Tambah 2 function helper
2. ✅ `application/models/Bast2_model.php` - Tambah 2 method model
3. ✅ `application/controllers/User.php` - Update 1 method, tambah 2 method
4. ✅ `application/views/user/bast2.php` - Tambah notifikasi section

---

## Versi

- **Versi:** 1.0
- **Tanggal:** 30 Januari 2026
- **Status:** ✅ Ready for Production

---

## Support

Untuk pertanyaan atau perbaikan, silakan hubungi tim development.
