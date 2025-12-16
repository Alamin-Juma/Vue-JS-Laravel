# Quick Start Guide - TSA Backend Assessment

## ✅ Current Status
- All code implementation: **COMPLETE** ✅
- All tests passing: **46/46 PASSED** ✅  
- Database setup: **AWAITING DATA FILE** ⏳

## 🚀 Quick Commands

### Start Docker Containers
```bash
cd C:\dev\personal\vue-laravel-project\api-laravel
docker-compose up -d
```

### Run All Tests
```bash
docker-compose exec laravel.test php artisan test
```

### Access API
The API is available at: `http://localhost/api/v1/reports/`

### Import Database (When You Have the Data File)
```bash
# 1. Place nxm_assessment_2023.sql in database/sql/ folder as 00_data.sql
# 2. Run this command:
docker-compose exec mariadb bash -c "mysql -uroot -ppassword nxm_assessment_2023 < /docker-entrypoint-initdb.d/00_data.sql"
```

### Verify Expected Outputs
```bash
docker-compose exec laravel.test php verify_requirements.php
```

---

## 📊 Test the API Endpoints

### 1. Commission Report
```bash
# Get all commissions
curl "http://localhost/api/v1/reports/commission"

# Filter by distributor
curl "http://localhost/api/v1/reports/commission?distributor=John"

# Filter by date range
curl "http://localhost/api/v1/reports/commission?date_from=2020-01-01&date_to=2020-12-31"

# Filter by invoice
curl "http://localhost/api/v1/reports/commission?invoice=ABC4170"

# Get order items
curl "http://localhost/api/v1/reports/commission/orders/ABC4170/items"
```

### 2. Top Distributors
```bash
# Get top 200 distributors
curl "http://localhost/api/v1/reports/top-distributors"

# Get top 50 with custom pagination
curl "http://localhost/api/v1/reports/top-distributors?limit=50&per_page=10"
```

---

## 📋 Expected Test Results (Once Data is Imported)

### Task 1: Commission Calculations
When you run the verification script, you should see:

| Invoice   | Expected Commission | Status |
|-----------|---------------------|--------|
| ABC4170   | $6.00              | ✓ PASS |
| ABC6931   | $37.20             | ✓ PASS |
| ABC23352  | $27.60             | ✓ PASS |
| ABC3010   | $0.00              | ✓ PASS |
| ABC19323  | $0.00              | ✓ PASS |

### Task 2: Top Distributors
| Distributor Name   | Expected Sales | Expected Rank | Status |
|-------------------|----------------|---------------|--------|
| Demario Purdy     | $22,026.75    | #1            | ✓ PASS |
| Floy Miller       | $9,645.00     | -             | ✓ PASS |
| Loy Schamberger   | $575.00       | -             | ✓ PASS |
| Chaim Kuhn        | $360.00       | #197          | ✓ PASS |
| Eliane Bogisich   | $360.00       | #197          | ✓ PASS |

---

## 🎥 Video Demo Checklist

When recording your video, cover these points:

### Part 1: Functionality Demo (5-7 minutes)
- [ ] Show Commission Report API working
  - [ ] Demonstrate filtering by distributor
  - [ ] Demonstrate filtering by date range
  - [ ] Demonstrate filtering by invoice
  - [ ] Show pagination working
  - [ ] Show order items endpoint
  
- [ ] Show Top Distributors API working
  - [ ] Show top 200 list
  - [ ] Demonstrate limit parameter
  - [ ] Show pagination working
  - [ ] Point out rank ties (same sales = same rank)

- [ ] Run verification script showing all expected values match

### Part 2: Code Walkthrough (5-7 minutes)
- [ ] Explain project structure (Service-Repository pattern)
- [ ] Walk through Commission Report implementation:
  - [ ] Controller
  - [ ] Service (commission calculation logic)
  - [ ] Repository (query optimization)
  - [ ] DTOs and Enums
  
- [ ] Walk through Top Distributors implementation:
  - [ ] Controller
  - [ ] Service (rank calculation)
  - [ ] Repository (total sales calculation)
  - [ ] DTO

### Part 3: Testing (2-3 minutes)
- [ ] Run Pest tests showing all 46 tests passing
- [ ] Briefly explain test coverage:
  - [ ] Unit tests for business logic
  - [ ] Feature tests for API endpoints
  - [ ] Edge cases covered

---

## 📸 Screenshots Needed

Take screenshots of these outputs:

### Task 1 Screenshots:
1. API response showing ABC4170 with $6.00 commission
2. API response showing ABC6931 with $37.20 commission
3. API response showing ABC23352 with $27.60 commission
4. API response showing ABC3010 with $0 commission
5. API response showing ABC19323 with $0 commission

### Task 2 Screenshots:
1. API response showing Demario Purdy at rank #1 with $22,026.75
2. API response showing Floy Miller with $9,645.00
3. API response showing Loy Schamberger with $575.00
4. API response showing Chaim Kuhn at rank #197 with $360.00
5. API response showing Eliane Bogisich at rank #197 with $360.00
6. Screenshot showing rank ties (multiple distributors with same rank)

### Additional Screenshots:
7. All tests passing (46/46)
8. Database structure/tables

---

## 📦 Final Submission Checklist

### Files to Include in ZIP:
- [ ] All source code (api-laravel folder)
- [ ] .env.example file
- [ ] docker-compose.yml
- [ ] README.md or PROJECT_STATUS.md
- [ ] All SQL files in database/sql/

### Files to Submit Separately:
- [ ] Video demo (YouTube link)
- [ ] Screenshots (organized in folder)
- [ ] SQL dump of final database (with data + indexes)

---

## 🆘 Troubleshooting

### Docker containers not starting
```bash
docker-compose down
docker-compose up -d
```

### Tests failing
```bash
# Clear cache
docker-compose exec laravel.test php artisan cache:clear
docker-compose exec laravel.test php artisan config:clear

# Restart containers
docker-compose restart
```

### Database connection issues
Check `.env` file has these settings:
```
DB_CONNECTION=mariadb
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=nxm_assessment_2023
DB_USERNAME=sail
DB_PASSWORD=password
```

---

## 📞 Quick Reference

### Access Docker Containers
```bash
# Laravel application
docker-compose exec laravel.test bash

# MariaDB database
docker-compose exec mariadb bash

# Run artisan commands
docker-compose exec laravel.test php artisan <command>
```

### Useful Artisan Commands
```bash
# Check database connection
docker-compose exec laravel.test php artisan tinker

# View routes
docker-compose exec laravel.test php artisan route:list

# Clear all caches
docker-compose exec laravel.test php artisan optimize:clear
```

---

**You're almost there!** 

The implementation is solid and tests are passing. Once you import the database with sample data, you can:
1. Run the verification script ✅
2. Record your video demo 🎥  
3. Take screenshots 📸
4. Submit everything 🚀

Good luck! 🎉
