# Test Form Submission untuk Preserve Page & Search

## 1. Setup untuk Testing

Buka Developer Tools di browser:

- Press F12 untuk open Developer Console
- Tab: Console, Network, dan Application (untuk check localStorage/sessionStorage)

## 2. Test Steps untuk BAST2

### Step 1: Go to BAST2 Page dengan Search dan Page

```
URL: http://localhost/login/user/getBAST2?page=2&search=test
```

- Verify URL shows page=2 dan search=test
- Check di console: `console.log(window.location.href)`

### Step 2: Click Edit Button

- Click salah satu edit button
- Modal muncul dengan data
- Check di console sebelum submit:

```javascript
document.getElementById("editPage").value;
document.getElementById("editSearch").value;
```

### Step 3: Sebelum Submit, Paste di Console:

```javascript
var pageField = document.getElementById("editPage");
var searchField = document.getElementById("editSearch");
var urlParams = new URLSearchParams(window.location.search);
console.log("Current URL:", window.location.href);
console.log("URL params - page:", urlParams.get("page"));
console.log("URL params - search:", urlParams.get("search"));
console.log("Before submit - editPage value:", pageField.value);
console.log("Before submit - editSearch value:", searchField.value);
```

### Step 4: Submit Form

- Click "Simpan Perubahan"
- Check Console untuk output dari form submit handler:
  - "=== FORM SUBMIT DEBUG ===" messages
  - "After setting - page field value:"
  - "After setting - search field value:"
  - "Form data akan dikirim:" + all form fields

### Step 5: Setelah Redirect, Verify

- Check URL apakah berisi page=2&search=test
- Expected: `http://localhost/login/user/getBAST2?page=2&search=test`
- If redirected to page 1: form submission tidak preserve parameters

## 3. Check Network Tab

### Di Network Tab saat form submit:

1. Filter: XHR atau "update_bast2_data"
2. Click pada request
3. Tab: "Request" lihat POST data:
   - Should include: `page=2` dan `search=test`
   - If tidak ada: form fields not being populated correctly

### Contoh POST data yang benar:

```
id_bast2: 123
tgl_terima_bast2: 2024-01-15
tgl_pom: 2024-01-16
page: 2
search: test
is_revisi: 1
```

## 4. Check Server Logs

Di file `application/logs/log-2024-XX-XX.php`:

```
DEBUG - update_bast2_data - page: 2, search: test
DEBUG - Redirect - page: 2, search: test
DEBUG - Redirecting to: User/getBAST2?page=2&search=test
```

Jika log tidak muncul atau page=1:

- Form fields tidak ter-populate
- atau JavaScript error blocking form submission

## 5. If Issue Persists

### A. Form fields tidak ter-populate

- Verify HTML structure di form:
  ```html
  <input type="hidden" name="page" id="editPage" value="1" />
  <input type="hidden" name="search" id="editSearch" value="" />
  ```
- Check element inspector: apakah field value berubah setelah form submit handler?

### B. JavaScript error blocking submission

- Check console untuk JavaScript errors
- If ada error, fix dulu sebelum lanjut

### C. Form action URL salah

- Inspect form element:
  ```html
  <form id="editForm" action="..." method="post"></form>
  ```
- Verify action URL = `<?= base_url('user/update_bast2_data') ?>`

## 6. Expected Behavior

1. User di page 2, search "test"
2. User click edit, modal muncul
3. User change checkbox revisi dan click "Simpan"
4. Form submit handler capture page=2, search=test dari URL
5. Form POST include page dan search parameters
6. Controller update data dan redirect dengan page=2&search=test
7. User kembali ke BAST2 page 2 dengan search "test" masih aktif

## 7. Debugging Checklist

- [ ] URL includes page dan search parameters sebelum edit
- [ ] Form handler logs appear di console saat submit
- [ ] POST data di Network tab include page dan search
- [ ] Server logs menunjukkan correct page dan search values
- [ ] Final URL setelah redirect include page dan search
