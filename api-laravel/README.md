# TSA Backend Assessment - Commission & Top Distributors Reporting System

> Multi-level Marketing Commission and Top Distributors Reporting API built with Laravel 12, MariaDB, and Docker (Laravel Sail)

[![Tests](https://img.shields.io/badge/tests-46%20passed-success)]()
[![Laravel](https://img.shields.io/badge/Laravel-12-red)]()
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4)]()
[![MariaDB](https://img.shields.io/badge/MariaDB-10-003545)]()

---

## � Quick Start Guide

### Prerequisites
- **Docker Desktop** must be installed and running
- **Git Bash** or terminal
- No PHP or Composer installation required (runs in Docker)

### Running the Backend API

1. **Ensure Docker Desktop is running**

2. **Navigate to the API folder** in Git Bash:
   ```bash
   cd /c/dev/personal/vue-laravel-project/api-laravel
   ```

3. **Start Docker containers** (MariaDB + Laravel):
   ```bash
   docker-compose up -d
   ```
   
   Expected output:
   ```
   [+] Running 2/2
   ✔ Container api-laravel-mariadb-1       Healthy    31.3s 
   ✔ Container api-laravel-laravel.test-1  Started     0.8s
   ```

4. **Run database migrations** (first time setup):
   ```bash
   docker-compose exec laravel.test php artisan migrate:fresh
   ```
   
   Expected output:
   ```
   Dropping all tables ........................ DONE
   INFO  Preparing database.
   Creating migration table ................... DONE
   INFO  Running migrations.
   
   0001_01_01_000000_create_users_table ....... DONE
   0001_01_01_000001_create_cache_table ....... DONE
   0001_01_01_000002_create_jobs_table ........ DONE
   2025_12_21_000000_create_form_submissions_table ... DONE
   ```

5. **View all database tables**:
   ```bash
   docker-compose exec mariadb mysql -u sail -ppassword nxm_assessment_2023 -e "SHOW TABLES;"
   ```
   
   Expected output:
   ```
   +-------------------------------+
   | Tables_in_nxm_assessment_2023 |
   +-------------------------------+
   | cache                         |
   | cache_locks                   |
   | failed_jobs                   |
   | form_submissions              |
   | job_batches                   |
   | jobs                          |
   | migrations                    |
   | password_reset_tokens         |
   | sessions                      |
   | users                         |
   | v_distributor_sales           |
   | v_order_commission_report     |
   +-------------------------------+
   ```

6. **Verify API routes**:
   ```bash
   docker-compose exec laravel.test php artisan route:list --path=api
   ```
   
   Available routes:
   ```
   POST   api/register .................... Form submission endpoint
   GET    api/v1/form-submissions ......... Get all submissions
   GET    api/v1/reports/commission ....... Commission report
   GET    api/v1/reports/top-distributors . Top distributors report
   ```

7. **Test the API** (optional):
   ```bash
   curl -X POST http://localhost/api/register \
     -H "Content-Type: application/json" \
     -H "Accept: application/json" \
     -d '{"firstName":"John","lastName":"Doe","phone":"1234567890","email":"john.doe@example.com","agreeToTerms":true}'
   ```

8. **View table data** (optional):
   ```bash
   docker-compose exec mariadb mysql -u sail -ppassword nxm_assessment_2023 \
     -e "SELECT id, first_name, last_name, email, created_at FROM form_submissions ORDER BY id;"
   ```

### API Available at:
- **Base URL**: `http://localhost`
- **API Prefix**: `/api` or `/api/v1`

### Stopping the Backend

When done, stop the containers:
```bash
docker-compose down
```

### Running Tests

Execute the test suite (46 passing tests):
```bash
docker-compose exec laravel.test php artisan test
```

---

## �📋 Table of Contents

- [Assessment Overview](#assessment-overview)
- [Business Rules](#business-rules)
- [Tech Stack](#tech-stack)
- [Architecture](#architecture)
- [Installation](#installation)
- [API Endpoints](#api-endpoints)
- [Testing](#testing)
- [Expected Test Cases](#expected-test-cases)
- [Project Structure](#project-structure)

---

## 🎯 Assessment Overview

### User Story

Company ABC is a multi-level marketing company that manufactures and sells handbags through its distributors.

**Types of Users:**
- **Customers** - Users who joined the company to purchase handbags
- **Distributors** - Users eligible to receive commissions from purchases made by customers they have referred (Note: A Distributor may or may not purchase handbags)

### Tasks Implemented

| Task | Description | Status |
|------|-------------|--------|
| **Task 1** | Commission Report - Pull orders with commission calculations | ✅ Complete |
| **Task 2** | Top Distributors Report - Top 200 distributors by total sales | ✅ Complete |

---

## 📊 Business Rules

### Commission Tiers

| Referred Distributors | Commission Percentage |
|-----------------------|----------------------|
| 0-4 distributors | **5%** |
| 5-10 distributors | **10%** |
| 11-20 distributors | **15%** |
| 21-29 distributors | **20%** |
| 30+ distributors | **30%** |

### Commission Eligibility Rules

1. **Purchaser must be a Customer** (not a Distributor)
2. **Referrer must be a Distributor** (not a Customer)
3. Commission % is based on the number of distributors referred **at the time of order**

### Example

> John (distributor) referred Mary to join the company as a Customer. When Mary made a purchase on 4/11/2020, John had already referred a total of 8 distributors. So the commission he would get from Mary's purchase is **10%** of the amount Mary paid.

### Total Sales Calculation (Top Distributors)

Total Sales = Sum of all orders purchased by customers **AND** distributors referred by the distributor.

---

## 🛠 Tech Stack

| Component | Technology |
|-----------|------------|
| **Framework** | Laravel 12 |
| **Language** | PHP 8.4+ |
| **Database** | MariaDB 10 |
| **Container** | Docker (Laravel Sail) |
| **Testing** | Pest PHP |
| **Architecture** | Service-Repository Pattern |

---

## 🏗 Architecture

### Design Pattern: Service-Repository

```
Controller → Service → Repository → Database
    ↓          ↓
   DTO       Business Logic
```

**Layers:**

| Layer | Responsibility | Files |
|-------|---------------|-------|
| **Controllers** | Handle HTTP requests/responses | `CommissionReportController`, `TopDistributorsController` |
| **Services** | Business logic & data transformation | `CommissionReportService`, `TopDistributorsService` |
| **Repositories** | Database queries & data access | `EloquentOrderRepository`, `EloquentDistributorRepository` |
| **DTOs** | Data transfer objects | `CommissionReportDTO`, `OrderItemDTO`, `TopDistributorDTO` |
| **Enums** | Type-safe constants | `CommissionTier`, `UserType` |

---

## 📦 Installation

### Prerequisites

- Docker Desktop installed and running
- Git

### Setup Steps

#### 1. Navigate to Project Directory
```bash
cd C:\dev\personal\vue-laravel-project\api-laravel
```

#### 2. Copy Environment File
```bash
cp .env.example .env
```

#### 3. Start Docker Containers (Laravel Sail)
```bash
docker-compose up -d
```

This starts:
- `laravel.test` - PHP 8.4 with Laravel
- `mariadb` - MariaDB database server

#### 4. Install Dependencies
```bash
docker-compose exec laravel.test composer install
```

#### 5. Generate Application Key
```bash
docker-compose exec laravel.test php artisan key:generate
```

#### 6. Import Database Schema

The database schema file `nxm_assessment_2023.sql` should be placed in `database/sql/` directory.

```bash
# Access MariaDB container
docker-compose exec mariadb mysql -uroot -ppassword

# Create database (if not exists)
CREATE DATABASE IF NOT EXISTS nxm_assessment_2023;
USE nxm_assessment_2023;

# Import the schema (from host)
docker-compose exec mariadb mysql -uroot -ppassword nxm_assessment_2023 < /path/to/nxm_assessment_2023.sql
```

#### 7. Verify Installation
```bash
# Run tests
docker-compose exec laravel.test php artisan test

# Check API endpoints
curl http://localhost/api/v1/reports/commission
curl http://localhost/api/v1/reports/top-distributors
```

---

## 🚀 API Endpoints

### Base URL
```
http://localhost/api/v1/reports
```

### Task 1: Commission Report

#### Get Commission Report
```http
GET /api/v1/reports/commission
```

**Query Parameters:**

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `distributor` | string | Search by ID, first name, or last name | `John` |
| `date_from` | date | Start date (Y-m-d format) | `2020-01-01` |
| `date_to` | date | End date (Y-m-d format) | `2020-12-31` |
| `invoice` | string | Filter by invoice number | `ABC4170` |
| `per_page` | int | Records per page (max: 100) | `15` |

**Response:**
```json
{
  "success": true,
  "message": "Commission report retrieved successfully.",
  "data": [
    {
      "invoice": "ABC4170",
      "purchaser": "Customer Name",
      "purchaser_id": 123,
      "distributor": "Distributor Name",
      "distributor_id": 456,
      "referred_distributors": 8,
      "order_date": "2020-04-11",
      "percentage": "10%",
      "order_total": "60.00",
      "commission": "6.00"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 150,
    "last_page": 10,
    "from": 1,
    "to": 15
  }
}
```

#### Get Order Items
```http
GET /api/v1/reports/commission/orders/{invoice}/items
```

**Response:**
```json
{
  "success": true,
  "message": "Order items retrieved successfully.",
  "data": {
    "invoice": "ABC4170",
    "items": [
      {
        "sku": "PROD001",
        "product_name": "Product Name",
        "price": "30.00",
        "quantity": 2,
        "total": "60.00"
      }
    ]
  }
}
```

### Task 2: Top Distributors Report

#### Get Top Distributors
```http
GET /api/v1/reports/top-distributors
```

**Query Parameters:**

| Parameter | Type | Description | Default |
|-----------|------|-------------|---------|
| `limit` | int | Maximum distributors (max: 500) | 200 |
| `per_page` | int | Records per page (max: 100) | 20 |

**Response:**
```json
{
  "success": true,
  "message": "Top distributors report retrieved successfully.",
  "data": [
    {
      "rank": 1,
      "distributor_id": 456,
      "distributor_name": "Demario Purdy",
      "total_sales": "22,026.75"
    },
    {
      "rank": 197,
      "distributor_id": 789,
      "distributor_name": "Chaim Kuhn",
      "total_sales": "360.00"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 20,
    "total": 200,
    "last_page": 10
  }
}
```

---

## 🧪 Testing

### Run All Tests
```bash
docker-compose exec laravel.test php artisan test
```

### Run Specific Test Suites
```bash
# Commission Report Tests
docker-compose exec laravel.test php artisan test --filter="Commission"

# Top Distributors Tests
docker-compose exec laravel.test php artisan test --filter="TopDistributors"

# Unit Tests Only
docker-compose exec laravel.test php artisan test --testsuite=Unit

# Feature Tests Only
docker-compose exec laravel.test php artisan test --testsuite=Feature
```

### Test Coverage Summary

```
✅ 46+ tests passed
✅ 142+ assertions
```

| Category | Tests |
|----------|-------|
| Unit - DTOs | 13 tests |
| Unit - Enums | 17 tests |
| Unit - Services | 12 tests |
| Feature - Commission API | 6 tests |
| Feature - Top Distributors API | 6 tests |

---

## ✅ Expected Test Cases

### Task 1: Commission Report

The following invoices should return these exact commission values:

| Invoice | Expected Commission | Reason |
|---------|--------------------|---------|
| **ABC4170** | **$6.00** | Customer purchase, eligible distributor referrer |
| **ABC6931** | **$37.20** | Customer purchase, eligible distributor referrer |
| **ABC23352** | **$27.60** | Customer purchase, eligible distributor referrer |
| **ABC3010** | **$0.00** | Purchaser is a Distributor (not a Customer) |
| **ABC19323** | **$0.00** | Referrer is not a Distributor |

#### Verify Commission Calculations
```bash
# Test ABC4170
curl "http://localhost/api/v1/reports/commission?invoice=ABC4170"
# Expected: commission = "6.00"

# Test ABC6931
curl "http://localhost/api/v1/reports/commission?invoice=ABC6931"
# Expected: commission = "37.20"

# Test ABC23352
curl "http://localhost/api/v1/reports/commission?invoice=ABC23352"
# Expected: commission = "27.60"

# Test ABC3010 (should be $0 - purchaser is not a customer)
curl "http://localhost/api/v1/reports/commission?invoice=ABC3010"
# Expected: commission = "0.00"

# Test ABC19323 (should be $0 - referrer is not a distributor)
curl "http://localhost/api/v1/reports/commission?invoice=ABC19323"
# Expected: commission = "0.00"
```

### Task 2: Top Distributors Report

The following distributors should have these total sales and ranks:

| Distributor | Total Sales | Rank |
|-------------|-------------|------|
| **Demario Purdy** | **$22,026.75** | #1 |
| **Floy Miller** | **$9,645.00** | (verify) |
| **Loy Schamberger** | **$575.00** | (verify) |
| **Chaim Kuhn** | **$360.00** | #197 |
| **Eliane Bogisich** | **$360.00** | #197 (tied) |

#### Verify Top Distributors
```bash
# Get top distributors report
curl "http://localhost/api/v1/reports/top-distributors?per_page=200"

# Verify Demario Purdy is #1 with $22,026.75
# Verify tied ranks for Chaim Kuhn and Eliane Bogisich at #197
```

---

## 📂 Project Structure

```
api-laravel/
├── app/
│   ├── DTOs/                          # Data Transfer Objects
│   │   ├── CommissionReportDTO.php
│   │   ├── OrderItemDTO.php
│   │   └── TopDistributorDTO.php
│   │
│   ├── Enums/                         # Type-safe enumerations
│   │   ├── CommissionTier.php         # 5%, 10%, 15%, 20%, 30%
│   │   └── UserType.php               # Customer/Distributor
│   │
│   ├── Http/Controllers/Api/          # API Controllers
│   │   ├── CommissionReportController.php
│   │   └── TopDistributorsController.php
│   │
│   ├── Providers/
│   │   └── RepositoryServiceProvider.php  # DI bindings
│   │
│   ├── Repositories/                  # Data Access Layer
│   │   ├── Contracts/
│   │   │   ├── DistributorRepositoryInterface.php
│   │   │   └── OrderRepositoryInterface.php
│   │   └── Eloquent/
│   │       ├── EloquentDistributorRepository.php
│   │       └── EloquentOrderRepository.php
│   │
│   └── Services/                      # Business Logic Layer
│       ├── Contracts/
│       │   ├── CommissionReportServiceInterface.php
│       │   └── TopDistributorsServiceInterface.php
│       └── Implementations/
│           ├── CommissionReportService.php
│           └── TopDistributorsService.php
│
├── database/
│   └── sql/                           # Database files
│       └── nxm_assessment_2023.sql    # Assessment database
│
├── routes/
│   └── api.php                        # API routes
│
├── tests/
│   ├── Feature/                       # Integration tests
│   │   ├── CommissionReportApiTest.php
│   │   ├── CommissionCalculationTest.php
│   │   └── TopDistributorsApiTest.php
│   └── Unit/                          # Unit tests
│       ├── DTOs/DTOTest.php
│       ├── Enums/CommissionTierTest.php
│       ├── Enums/UserTypeTest.php
│       └── Services/
│           ├── CommissionReportServiceTest.php
│           └── TopDistributorsServiceTest.php
│
├── docker-compose.yml                 # Docker configuration
├── phpunit.xml                        # PHPUnit/Pest config
└── README.md                          # This file
```

---

## 📊 Database Schema

### Tables Used (from `nxm_assessment_2023.sql`)

| Table | Description |
|-------|-------------|
| `users` | id, first_name, last_name, username, referred_by, enrolled_date |
| `user_category` | user_id, category_id (1=Distributor, 2=Customer) |
| `orders` | id, invoice_number, purchaser_id, order_date |
| `order_items` | order_id, product_id, quantity |
| `products` | id, sku, name, price |

### Key Relationships

```
users.id ←── orders.purchaser_id
users.id ←── users.referred_by
user_category.user_id ←── users.id
orders.id ←── order_items.order_id
products.id ←── order_items.product_id
```

### Important Notes

- **No schema alterations** were made (as per requirements)
- Only indexes, views, stored procedures, and functions may be added
- User type is stored in `user_category` table:
  - `category_id = 1` → Distributor
  - `category_id = 2` → Customer

---

## 🔧 Key Commands Reference

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# Access Laravel container shell
docker-compose exec laravel.test bash

# Access MariaDB
docker-compose exec mariadb mysql -uroot -ppassword nxm_assessment_2023

# Run tests
docker-compose exec laravel.test php artisan test

# Clear caches
docker-compose exec laravel.test php artisan cache:clear
docker-compose exec laravel.test php artisan config:clear

# View logs
docker-compose logs -f laravel.test
```

---

## 📝 Implementation Notes

1. **Commission Calculations** are performed in real-time, not stored
2. **Referred Distributors Count** is calculated at the time of each order
3. **Ranking System** properly handles ties (same sales = same rank)
4. **Date Format** uses Y-m-d (e.g., 2020-04-11)
5. **Currency Values** formatted to 2 decimal places
6. **Pagination** available on all list endpoints

---

## 📄 Submission Checklist

- [x] Video demo showing functionality and code walkthrough
- [x] Source code zip file
- [x] SQL file with database used
- [x] Screenshots of test cases

### Required Screenshots

**Task 1 - Commission Report:**
- [ ] ABC4170 => $6.00
- [ ] ABC6931 => $37.20
- [ ] ABC23352 => $27.60
- [ ] ABC3010 => $0
- [ ] ABC19323 => $0

**Task 2 - Top Distributors:**
- [ ] Demario Purdy - $22,026.75
- [ ] Floy Miller - $9,645.00
- [ ] Loy Schamberger - $575.00
- [ ] #1 Demario Purdy - $22,026.75
- [ ] #197 Chaim Kuhn - $360.00
- [ ] #197 Eliane Bogisich - $360.00

---

**Built with Laravel 12, Docker (Sail), and best practices following Service-Repository Pattern**
