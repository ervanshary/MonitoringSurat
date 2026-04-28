# ✅ DEPLOYMENT CHECKLIST - POM NOTIFICATION SYSTEM

## 📋 Pre-Deployment Checklist

### Phase 1: Preparation (Sebelum Deploy)

#### Backup Existing Files

- [ ] Backup `application/helpers/login_helper.php`
- [ ] Backup `application/models/Bast2_model.php`
- [ ] Backup `application/controllers/User.php`
- [ ] Backup `application/views/user/bast2.php`
- [ ] Create git branch: `git checkout -b feature/pom-notification`

#### Verify Files Modified

```bash
# Check which files have been modified
git status

# Expected output:
# - application/helpers/login_helper.php (modified)
# - application/models/Bast2_model.php (modified)
# - application/controllers/User.php (modified)
# - application/views/user/bast2.php (modified)
```

#### Review Code Changes

- [ ] Review helper functions syntax
- [ ] Review model methods syntax
- [ ] Review controller methods syntax
- [ ] Review view HTML structure
- [ ] Check for any hardcoded values
- [ ] Verify error handling

### Phase 2: Testing (Di Development Environment)

#### Local Testing Setup

- [ ] Clear browser cache
- [ ] Clear CodeIgniter cache: `rm -rf application/cache/*`
- [ ] Verify database connection working
- [ ] Verify database tables exist

#### Test Case 1: No Overdue POM

```
Condition: No POM with tgl_pom filled and >= 7 days without kembali_pom
Expected: Alert section not visible
Action: Open /User/getBAST2
Result: [ ] PASS / [ ] FAIL
```

#### Test Case 2: With Overdue POM

```
Condition: At least one POM with tgl_pom >= 7 days ago, empty kembali_pom
Expected: Alert section visible with data
Action: Open /User/getBAST2
Result: [ ] PASS / [ ] FAIL
Details:
  - [ ] Alert header visible
  - [ ] Count correct
  - [ ] Item details correct
  - [ ] Badge shows correct days
```

#### Test Case 3: API Endpoint

```
Condition: Call /User/get_pom_notification
Expected: JSON response with status:success
Action: Open /User/get_pom_notification in browser
Result: [ ] PASS / [ ] FAIL
JSON Fields:
  - [ ] success: true
  - [ ] count: correct number
  - [ ] data: array populated
```

#### Test Case 4: Dismiss Functionality

```
Condition: Click X button on alert
Expected: Alert disappears
Action: Click dismiss button
Result: [ ] PASS / [ ] FAIL
Note: Should reappear after refresh
```

#### Test Case 5: Data Accuracy

```
Condition: Verify calculations
Expected: Days calculated correctly
Action: Manually count days from tgl_pom
Result: [ ] PASS / [ ] FAIL
Formula: TODAY - TGL_POM = DAYS
Example: 30-01-2026 - 20-01-2024 = 41 days
```

#### Test Case 6: Browser Compatibility

- [ ] Chrome (Latest)
- [ ] Firefox (Latest)
- [ ] Safari (Latest)
- [ ] Edge (Latest)
- [ ] Mobile Chrome
- [ ] Mobile Safari

#### Test Case 7: Database Operations

```
Test: Create new POM entry with old date
SQL: INSERT INTO user_bast2 (tgl_pom, kembali_pom, ...)
     VALUES ('2025-12-01', '0000-00-00', ...)
Expected: Shows in notification
Result: [ ] PASS / [ ] FAIL

Test: Update kembali_pom field
SQL: UPDATE user_bast2 SET kembali_pom = CURDATE()
Expected: Disappears from notification
Result: [ ] PASS / [ ] FAIL
```

#### Test Case 8: Edge Cases

- [ ] Empty database (no POM data)
- [ ] All POM with return date filled
- [ ] Mixed status (some overdue, some not)
- [ ] Very old dates (2020-2021)
- [ ] Invalid date format (if any)

#### Test Case 9: Performance

- [ ] Page loads in < 3 seconds
- [ ] API response in < 1 second
- [ ] No console errors (F12)
- [ ] No SQL errors in logs
- [ ] Memory usage stable

### Phase 3: Security Audit

#### Code Review

- [ ] No hardcoded credentials
- [ ] No sensitive data in logs
- [ ] SQL queries using proper escaping
- [ ] XSS protection in place
- [ ] CSRF tokens (if applicable)

#### Database Security

- [ ] Check user permissions
- [ ] Verify foreign key constraints
- [ ] Check for NULL handling
- [ ] Test error messages (no info leakage)

#### API Security

- [ ] Test without authentication (should inherit from controller)
- [ ] Verify response doesn't expose sensitive data
- [ ] Test rate limiting (if applicable)
- [ ] Check for data leakage

### Phase 4: Staging Deployment

#### Deploy to Staging Server

```bash
# SSH into staging server
ssh user@staging.server

# Navigate to app directory
cd /path/to/application

# Pull changes or upload files
git pull origin feature/pom-notification
# OR
scp -r files/ user@staging:/path/to/application/

# Clear cache
rm -rf application/cache/*
rm -rf application/logs/*

# Verify deployment
php index.php
```

#### Staging Environment Testing

- [ ] Verify files uploaded correctly
- [ ] Check file permissions (755 for dirs, 644 for files)
- [ ] Test all features again
- [ ] Check logs for errors
- [ ] Monitor resource usage
- [ ] Load test if applicable

#### Staging Sign-off

- [ ] QA team approved
- [ ] Product owner verified
- [ ] Performance acceptable
- [ ] Security passed
- [ ] Documentation reviewed

### Phase 5: Production Deployment

#### Pre-Production Checklist

- [ ] Maintenance window scheduled
- [ ] Team members notified
- [ ] Rollback plan documented
- [ ] Backup created
- [ ] All tests passed

#### Production Deployment Steps

```bash
# 1. Create backup
cd /path/to/application
tar -czf backup_$(date +%Y%m%d_%H%M%S).tar.gz .

# 2. Verify backup size (should be > 0)
ls -lh backup_*.tar.gz

# 3. Deploy new code (choose one method)

# Method A: Git (if using version control)
git checkout main  # or production branch
git merge feature/pom-notification
git push origin main

# Method B: Direct upload
scp -r files/* user@prod:/path/to/application/

# 4. Set correct permissions
chmod 755 application/helpers/
chmod 755 application/models/
chmod 755 application/controllers/
chmod 755 application/views/

# 5. Clear cache
rm -rf application/cache/*

# 6. Run any migrations (if applicable)
php index.php

# 7. Verify deployment
curl -s https://yoursite.com/User/getBAST2 | grep "PERHATIAN"
```

#### Post-Deployment Verification

- [ ] Application loads without errors
- [ ] Homepage accessible
- [ ] BAST 2 page loads
- [ ] Notification displays (if has overdue POM)
- [ ] API endpoint working
- [ ] No 500 errors in logs
- [ ] No 404 errors
- [ ] Database operations normal

#### Monitoring Post-Deployment

```bash
# Monitor logs
tail -f application/logs/log-$(date +%Y-%m-%d).php

# Expected: No ERROR or CRITICAL messages
# If found: Immediately rollback
```

---

## 🔄 Rollback Plan

### If Issues Found

#### Immediate Rollback

```bash
# Stop application (if needed)
# service apache2 stop  # or nginx

# Restore backup
cd /path/to/
tar -xzf backup_20260130_120000.tar.gz

# Restart application
# service apache2 start

# Verify
curl -s https://yoursite.com/User/getBAST2 | head -20
```

#### Verify Rollback

- [ ] Application loads
- [ ] Notification gone (until re-deployed)
- [ ] All features working
- [ ] No errors in logs
- [ ] Users can access

#### Post-Rollback Analysis

- [ ] Identify root cause
- [ ] Review logs for errors
- [ ] Fix issues in code
- [ ] Re-test thoroughly
- [ ] Schedule re-deployment

---

## 📊 Deployment Checklist Matrix

| Phase      | Task               | Status | Sign-off |
| ---------- | ------------------ | ------ | -------- |
| Pre-Deploy | Backup files       | ☐      | **\_**   |
| Pre-Deploy | Review code        | ☐      | **\_**   |
| Testing    | Unit tests         | ☐      | **\_**   |
| Testing    | Integration tests  | ☐      | **\_**   |
| Testing    | API tests          | ☐      | **\_**   |
| Testing    | Browser tests      | ☐      | **\_**   |
| Security   | Code audit         | ☐      | **\_**   |
| Security   | DB security        | ☐      | **\_**   |
| Staging    | Deploy to staging  | ☐      | **\_**   |
| Staging    | Full testing       | ☐      | **\_**   |
| Staging    | Performance check  | ☐      | **\_**   |
| Staging    | QA approval        | ☐      | **\_**   |
| Production | Notify team        | ☐      | **\_**   |
| Production | Deploy code        | ☐      | **\_**   |
| Production | Post-deploy verify | ☐      | **\_**   |
| Production | Monitor logs       | ☐      | **\_**   |
| Production | User acceptance    | ☐      | **\_**   |

---

## 📝 Sign-Off Form

```
DEPLOYMENT SIGN-OFF FORM
POM Notification System v1.0

Date: _______________
Deployed by: _______________
Verified by: _______________

Pre-Deployment:
  [ ] Backup completed
  [ ] Code reviewed
  [ ] Tests passed

Deployment:
  [ ] Files uploaded correctly
  [ ] Cache cleared
  [ ] Database OK
  [ ] Logs checked

Post-Deployment:
  [ ] Application loads
  [ ] Features working
  [ ] Notification displays
  [ ] No errors
  [ ] Performance acceptable

Known Issues (if any):
_________________________________
_________________________________

Approval:
  Development: _______________
  QA: _______________
  DevOps: _______________
  Management: _______________

Go-live Date: _______________
```

---

## 🆘 Emergency Contact

### If Issues Occur

| Role            | Name     | Phone    | Email    |
| --------------- | -------- | -------- | -------- |
| DevOps Lead     | **\_\_** | **\_\_** | **\_\_** |
| Backend Dev     | **\_\_** | **\_\_** | **\_\_** |
| QA Lead         | **\_\_** | **\_\_** | **\_\_** |
| Project Manager | **\_\_** | **\_\_** | **\_\_** |

### Escalation Path

1. First Response: DevOps Lead (15 min)
2. Second Response: Backend Developer (15 min)
3. Final Escalation: Project Manager (immediate)

---

## 📚 Related Documentation

Before deployment, read:

- [ ] IMPLEMENTASI_RINGKASAN.md (Overview)
- [ ] DOKUMENTASI_FUNGSI_POM.md (Complete docs)
- [ ] QUICK_START_POM_NOTIFICATION.md (Setup guide)
- [ ] RINGKASAN_TEKNIS_POM_NOTIFICATION.md (Technical)

---

## ✅ Final Verification

Before considering deployment complete:

```
Production Verification Checklist:
├─ [ ] Page loads without errors
├─ [ ] Notification displays correctly
├─ [ ] All data fields populated
├─ [ ] Calculations accurate
├─ [ ] API endpoint working
├─ [ ] No console errors
├─ [ ] Database operations normal
├─ [ ] Logs show no critical errors
├─ [ ] Performance acceptable
├─ [ ] Mobile responsive
└─ [ ] Users can access and use

All items must be checked ✓ before sign-off
```

---

## 📞 Deployment Support

Questions or issues?

1. Check documentation files
2. Review code comments
3. Check CodeIgniter logs
4. Contact DevOps team

---

## 🎉 Success Criteria

Deployment is successful when:

- ✅ All tests pass
- ✅ Notification displays for overdue POM
- ✅ No errors in logs
- ✅ Users can access the feature
- ✅ Performance meets SLA
- ✅ Team is satisfied

**Expected Go-live: [Date to be filled]**

---

_Document Version: 1.0_
_Last Updated: 30 Januari 2026_
_Status: Ready for Deployment_
