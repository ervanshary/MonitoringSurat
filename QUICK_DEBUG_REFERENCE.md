# QUICK DEBUG REFERENCE

## Problem: Form submits but page resets to 1

### Step 1: Check Console Output

Press F12, go to Console tab, submit form.
Look for:

```
=== FORM SUBMIT DEBUG ===
```

**If not found:**

- Form handler tidak jalan
- Paste di console: `console.log(typeof $)` → should be "function"
- If not: jQuery error

**If found:**

- Check values:

```
URL params - page: [should be 2 or more]
URL params - search: [should be search text]
After setting - page field value: [should match URL]
After setting - search field value: [should match URL]
```

- If all values correct: Problem di form POST atau controller
- If values wrong: Problem di URLSearchParams atau form handler

### Step 2: Check Network Tab

Press F12, go to Network tab. Submit form.

Look for POST request to "update_bast2_data"

Click it, go to "Request" tab, scroll down to "Form Data"

Check if this exists:

```
page: 2
search: kontrak
```

**If NOT found:**

- Form handler tidak set hidden fields
- Debug hidden fields:

```javascript
var pageField = document.getElementById("editPage");
var searchField = document.getElementById("editSearch");
console.log("editPage exists:", pageField !== null);
console.log("editSearch exists:", searchField !== null);
console.log("editPage name attr:", pageField.getAttribute("name"));
console.log("editSearch name attr:", searchField.getAttribute("name"));
```

**If found:**

- Problem di controller atau redirect
- Check server logs (next step)

### Step 3: Check Server Logs

Open: `application/logs/log-YYYY-MM-DD.php`

Search for: "update_bast2_data - page"

Should find lines like:

```
[DEBUG] 2024-01-15 10:30:45 --> update_bast2_data - page: 2, search: kontrak
[DEBUG] 2024-01-15 10:30:45 --> Redirect - page: 2, search: kontrak
[DEBUG] 2024-01-15 10:30:45 --> Redirecting to: User/getBAST2?page=2&search=kontrak
```

**If NOT found:**

- Method tidak diakses
- Form action URL mungkin salah
- Paste di console: `console.log(document.querySelector('#editForm').action)`
- Should output: `http://localhost/login/user/update_bast2_data`

**If found but page=1 dan search empty:**

- Form tidak send hidden field values
- Go back to Step 2

**If found with correct values but redirect URL wrong:**

- Controller redirect logic issue
- Check User.php update_bast2_data() method lines 1180-1225

---

## Problem: Checkbox not loading state

### Check 1: Data Attribute

Inspect the Edit button in HTML:

Open F12 → Elements tab
Find edit button (class="edit-btn")
Check attribute: `data-isrevisi="1"` or `data-isrevisi="0"`

**If shows "1" but checkbox unchecked:**

- JavaScript loader problem
- Paste di console:

```javascript
var btn = document.querySelector(".edit-btn");
console.log("data-isrevisi:", btn.getAttribute("data-isrevisi"));
console.log("Checkbox element:", document.getElementById("editIsRevisi2"));
console.log(
	"Checkbox checked:",
	document.getElementById("editIsRevisi2").checked,
);
```

**If data-isrevisi is "0" but should be "1":**

- Database value wrong
- Query database: `SELECT id_bast2, is_revisi FROM user_bast2`
- Check if is_revisi = 0 when should be 1

### Check 2: Form Handler

Submit form dan check Network tab:

- POST data should include: `is_revisi: 1` (jika checkbox checked)
- If shows `is_revisi: 0` atau missing: Checkbox form binding error

### Check 3: Database After Submit

Query: `SELECT id_bast2, is_revisi FROM user_bast2 WHERE id_bast2=123`
Verify is_revisi updated ke value yang baru

**If not updated:**

- Model updateBast2Data() problem
- Check Bast2_model.php updateBast2Data() method

---

## Problem: Search filter cleared after submit

### Issue Analysis

**Expected:** URL `?page=2&search=kontrak` → after submit → `?page=2&search=kontrak`
**Actual:** URL `?page=2&search=kontrak` → after submit → `?page=1`

### Root Cause Check

1. Is form submit handler running?
   - Check Console output (see Problem 1, Step 1)
2. Is hidden fields populated?
   - Check Network POST data (see Problem 1, Step 2)
3. Is controller receiving correct values?
   - Check Server logs (see Problem 1, Step 3)
4. Is redirect using parameters?
   - Check logs untuk "Redirecting to:" line
   - Should show: `...getBAST2?page=2&search=kontrak`

### If problem at Step 4

Controller redirect URL construction wrong.

Open User.php, find method update_bast2_data()

Check lines around redirect:

```php
$redirect_url = 'User/getBAST2?page=' . $page;
if (!empty($search)) $redirect_url .= '&search=' . urlencode($search);
redirect($redirect_url);
```

Verify: `$page` dan `$search` variables correctly extracted from POST

---

## Quick Test Commands

### Test 1: Check jQuery

```javascript
console.log("jQuery version:", $.fn.jquery);
console.log("Form exists:", document.getElementById("editForm") !== null);
```

### Test 2: Check Hidden Fields

```javascript
var pageField = document.getElementById("editPage");
var searchField = document.getElementById("editSearch");
console.log("Page field value:", pageField.value);
console.log("Search field value:", searchField.value);
pageField.value = "2";
searchField.value = "test";
console.log("After setting - Page:", pageField.value);
console.log("After setting - Search:", searchField.value);
```

### Test 3: Check URL Extraction

```javascript
var urlParams = new URLSearchParams(window.location.search);
console.log("URL page param:", urlParams.get("page"));
console.log("URL search param:", urlParams.get("search"));
console.log("Full URL:", window.location.href);
```

### Test 4: Check Form Data

```javascript
var form = document.getElementById("editForm");
var formData = new FormData(form);
console.log("Form data:");
for (var pair of formData.entries()) {
	console.log(pair[0] + ":", pair[1]);
}
```

### Test 5: Check Database (SQL query)

```sql
SELECT id_bast2, is_revisi FROM user_bast2 WHERE id_bast2=123;
```

### Test 6: Check Log File

```
Open: application/logs/log-YYYY-MM-DD.php
Search for: update_bast2_data
Look at: page and search values in log messages
```

---

## Common Error Messages & Solutions

### Error: "Uncaught TypeError: $ is not defined"

- **Cause:** jQuery not loaded
- **Solution:**
  - Add `<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>`
  - Ensure jQuery loaded BEFORE form handler code

### Error: "Cannot read property 'value' of null"

- **Cause:** Hidden field ID mismatch
- **Solution:**
  - Check form HTML: `<input ... id="editPage">`
  - Check handler code: `document.getElementById('editPage')`
  - Must match exactly (case-sensitive)

### Error: "Form submission cancelled"

- **Cause:** Form handler preventing default submission
- **Solution:**
  - Check form handler: Should NOT have `e.preventDefault()`
  - Current handler should NOT have `return false;`
  - Let form submit normally via POST

### Message: "Data berhasil diupdate!" but page didn't change

- **Cause:** Form submitted but redirect didn't work
- **Solution:**
  - Check redirect URL di controller
  - Verify page/search parameters in log
  - Check browser redirect blocking settings

---

## Network Tab Analysis

### What to look for

1. Request URL: Should be `POST /user/update_bast2_data`
2. Status code: Should be 302 (redirect) or 200 (success)
3. Form Data: Should include page, search, is_revisi
4. Response headers: Location should show redirect URL

### If status 404

- URL mismatch: Check form action attribute
- Method: Check if using POST (not GET)

### If status 500

- Server error: Check server logs untuk error message
- Check syntax di controller method

### If status 200 but form data empty

- Hidden fields not populated
- Form submission happening but not including hidden field values

---

## Server Log Analysis

### Log location

`application/logs/log-YYYY-MM-DD.php`

### Search patterns

```
update_bast2_data
Redirect
page:
search:
Update successful
Update failed
```

### Expected log entries

```
[DEBUG] ... --> update_bast2_data - page: 2, search: kontrak
[DEBUG] ... --> Redirect - page: 2, search: kontrak
[DEBUG] ... --> Redirecting to: User/getBAST2?page=2&search=kontrak
[DEBUG] ... --> Update successful for ID BAST2: 123
```

### If logs show page: 1

- Form handler tidak set values correctly
- atau POST data tidak include page/search
- or form submission happened before handler finished

---

## Final Verification Checklist

After implementation, verify:

- [ ] F12 Console shows "=== FORM SUBMIT DEBUG ===" message
- [ ] Console log shows correct page number (not 1)
- [ ] Console log shows correct search value (not empty)
- [ ] Network tab shows POST data with page and search
- [ ] Server logs show correct page and search values
- [ ] Final URL after redirect includes page and search parameters
- [ ] Page number correct in displayed table (showing page 2, not page 1)
- [ ] Search filter still active in search box
- [ ] Success message displayed ("Data berhasil diupdate!")
- [ ] Checkbox state persisted (submit, then edit again, check state)

If all ✅: Implementation SUCCESS

If any ❌: Follow troubleshooting steps above
