# TSA Task 2 - Screenshots Checklist

## Required Screenshots for Submission

### Task 1: Commission Report Test Cases

Navigate to: https://vue-js-laravel.vercel.app/reports/commission

Take individual screenshots for each test case:

#### ✅ Test Case 1: Invoice ABC4170
- [ ] Filter by invoice: ABC4170
- [ ] Expected Commission: **$6.00**
- [ ] Screenshot showing: Invoice, Purchaser, Distributor, Commission
- [ ] Filename: `task1_ABC4170_$6.00.png`

#### ✅ Test Case 2: Invoice ABC6931
- [ ] Filter by invoice: ABC6931
- [ ] Expected Commission: **$37.20**
- [ ] Screenshot showing: Invoice, Purchaser, Distributor, Commission
- [ ] Filename: `task1_ABC6931_$37.20.png`

#### ✅ Test Case 3: Invoice ABC23352
- [ ] Filter by invoice: ABC23352
- [ ] Expected Commission: **$27.60**
- [ ] Screenshot showing: Invoice, Purchaser, Distributor, Commission
- [ ] Filename: `task1_ABC23352_$27.60.png`

#### ✅ Test Case 4: Invoice ABC3010
- [ ] Filter by invoice: ABC3010
- [ ] Expected Commission: **$0.00** (Purchaser is Distributor)
- [ ] Screenshot showing: Invoice, Purchaser, Distributor, Commission
- [ ] Filename: `task1_ABC3010_$0.00.png`

#### ✅ Test Case 5: Invoice ABC19323
- [ ] Filter by invoice: ABC19323
- [ ] Expected Commission: **$0.00** (Referrer not Distributor)
- [ ] Screenshot showing: Invoice, Purchaser, Distributor, Commission
- [ ] Filename: `task1_ABC19323_$0.00.png`

---

### Task 2: Top Distributors Report Test Cases

Navigate to: https://vue-js-laravel.vercel.app/reports/top-distributors

#### ✅ Test Case 1: Rank #1 - Demario Purdy
- [ ] Screenshot showing: Rank #1, Name: Demario Purdy, Total Sales: **$22,026.75**
- [ ] Filename: `task2_rank1_demario_purdy_$22026.75.png`

#### ✅ Test Case 2: Floy Miller
- [ ] Search/scroll to find: Floy Miller
- [ ] Expected Total Sales: **$9,645.00**
- [ ] Screenshot showing: Rank, Name, Total Sales
- [ ] Filename: `task2_floy_miller_$9645.00.png`

#### ✅ Test Case 3: Loy Schamberger
- [ ] Search/scroll to find: Loy Schamberger
- [ ] Expected Total Sales: **$575.00**
- [ ] Screenshot showing: Rank, Name, Total Sales
- [ ] Filename: `task2_loy_schamberger_$575.00.png`

#### ✅ Test Case 4: Tied Rankings at #197
- [ ] Navigate to page showing rank #197
- [ ] Expected tied ranks:
  - Chaim Kuhn - $360.00 - Rank #197
  - Eliane Bogisich - $360.00 - Rank #197
- [ ] Screenshot showing both entries with same rank
- [ ] Filename: `task2_tied_rank197_$360.00.png`

---

## Additional Recommended Screenshots

### Backend/Database Verification
- [ ] Docker containers running: `docker-compose ps`
- [ ] Database tables: `SHOW TABLES;` output
- [ ] Test suite passing: `php artisan test` results
- [ ] API response example (Commission Report)
- [ ] API response example (Top Distributors)

### File Structure
- [ ] VS Code project structure showing folders
- [ ] Service-Repository architecture folders

---

## Files in This Folder

- `nxm_assessment_2023.sql` - Complete database dump used in development (1.6MB)
- `SCREENSHOTS_CHECKLIST.md` - This file
- (Add your screenshot images here)

---

## How to Take Screenshots

### Windows:
- **Snipping Tool**: Windows + Shift + S (capture specific area)
- **Full screen**: Print Screen key
- Save as PNG format for best quality

### Chrome DevTools (for responsive design):
- F12 → Toggle device toolbar (Ctrl + Shift + M)
- Show the responsive layout

---

## Screenshot Tips

1. **Clear and readable**: Make sure text is visible
2. **Highlight key values**: Circle or highlight the commission/sales amounts
3. **Include full context**: Show the complete row with all columns
4. **No clutter**: Close unnecessary tabs/windows
5. **Proper resolution**: 1920x1080 or higher
6. **Consistent naming**: Use the filenames suggested above

---

## Quick Access URLs

- **Commission Report**: https://vue-js-laravel.vercel.app/reports/commission
- **Top Distributors**: https://vue-js-laravel.vercel.app/reports/top-distributors
- **GitHub Repository**: https://github.com/Alamin-Juma/Vue-JS-Laravel

---

**Note**: These screenshots demonstrate that all test cases pass with exact expected values, proving the implementation is correct.
