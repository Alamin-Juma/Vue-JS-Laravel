# TSA Backend Assessment - Commission & Top Distributors Reporting System

> Multi-level Marketing Commission and Top Distributors Reporting API built with Laravel 12, MariaDB, and Docker

[![Tests](https://img.shields.io/badge/tests-46%20passed-success)]()
[![Laravel](https://img.shields.io/badge/Laravel-12-red)]()
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4)]()
[![MariaDB](https://img.shields.io/badge/MariaDB-10-003545)]()

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Architecture](#architecture)
- [Installation](#installation)
- [API Endpoints](#api-endpoints)
- [Testing](#testing)
- [Project Structure](#project-structure)

---

## 🎯 Overview

This project implements a comprehensive reporting system for a multi-level marketing company that tracks:
1. **Commission Reports** - Calculate distributor commissions based on referred customers and distributors
2. **Top Distributors** - Rank distributors by total sales from their referral network

### Business Logic

**Commission Tiers:**
- 0-4 referred distributors: **5%**
- 5-10 referred distributors: **10%**
- 11-20 referred distributors: **15%**
- 21-29 referred distributors: **20%**
- 30+ referred distributors: **30%**

**Rules:**
- Only **Customers** generate commissions (not Distributors purchasing for themselves)
- Only **Distributors** who referred the customer earn commissions
- Commission percentage is based on the number of distributors referred **at the time of order**

---

## ✨ Features

### Task 1: Commission Report
- ✅ Filter by Distributor (ID, First Name, or Last Name)
- ✅ Filter by Order Date Range
- ✅ Filter by Invoice Number
- ✅ Pagination support
- ✅ Accurate commission calculation based on referred distributors count
- ✅ Order items detail endpoint

### Task 2: Top Distributors Report
- ✅ Top 200 distributors by total sales (configurable)
- ✅ Correct ranking (tied sales = same rank)
- ✅ Total sales aggregation from entire referral network
- ✅ Pagination support

### Additional Features
- ✅ Service-Repository Design Pattern
- ✅ Comprehensive test coverage (46 tests, 142 assertions)
- ✅ Request validation
- ✅ Optimized database queries with indexes
- ✅ RESTful API design
- ✅ Docker containerization

---

## 🛠 Tech Stack

- **Framework:** Laravel 12
- **Language:** PHP 8.4+
- **Database:** MariaDB 10
- **Container:** Docker (Laravel Sail)
- **Testing:** Pest PHP
- **Architecture:** Service-Repository Pattern

---

## 🏗 Architecture

### Design Pattern: Service-Repository

```
Controller → Service → Repository → Database
    ↓          ↓
   DTO       Business Logic
```

**Layers:**
- **Controllers:** Handle HTTP requests/responses
- **Services:** Business logic and data transformation
- **Repositories:** Database queries and data access
- **DTOs:** Data transfer objects for consistent data structure
- **Enums:** Type-safe constants (CommissionTier, UserType)

---

## 📦 Installation

### Prerequisites
- Docker Desktop installed
- Git

### Setup Steps

1. **Clone the repository**
   ```bash
   cd C:\dev\personal\vue-laravel-project\api-laravel
   ```

2. **Start Docker containers**
   ```bash
   docker-compose up -d
   ```

3. **Install dependencies** (if needed)
   ```bash
   docker-compose exec laravel.test composer install
   ```

4. **Set up environment**
   ```bash
   cp .env.example .env
   docker-compose exec laravel.test php artisan key:generate
   ```

5. **Import database**
   ```bash
   # Place your nxm_assessment_2023.sql file in database/sql/ as 00_data.sql
   docker-compose exec mariadb bash -c "mysql -uroot -ppassword nxm_assessment_2023 < /docker-entrypoint-initdb.d/00_data.sql"
   ```

6. **Verify setup**
   ```bash
   docker-compose exec laravel.test php artisan test
   ```

---

## 🚀 API Endpoints

### Base URL
```
http://localhost/api/v1/reports
```

### 1. Commission Report

**Get Commission Report**
```http
GET /api/v1/reports/commission
```

**Query Parameters:**
| Parameter   | Type   | Description                              | Example       |
|-------------|--------|------------------------------------------|---------------|
| distributor | string | Search by ID, first name, or last name   | John          |
| date_from   | date   | Start date (Y-m-d)                       | 2020-01-01    |
| date_to     | date   | End date (Y-m-d)                         | 2020-12-31    |
| invoice     | string | Filter by invoice number                 | ABC4170       |
| per_page    | int    | Records per page (max: 100)              | 15            |

**Response Example:**
```json
{
  "success": true,
  "message": "Commission report retrieved successfully.",
  "data": [
    {
      "invoice": "ABC4170",
      "purchaser": "Mary Johnson",
      "distributor": "John Smith",
      "referred_distributors": 8,
      "order_date": "2020-04-11",
      "percentage": 10,
      "order_total": 60.00,
      "commission": 6.00
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 150,
    "last_page": 10
  }
}
```

**Get Order Items**
```http
GET /api/v1/reports/commission/orders/{invoice}/items
```

**Response Example:**
```json
{
  "success": true,
  "message": "Order items retrieved successfully.",
  "data": {
    "invoice": "ABC4170",
    "items": [
      {
        "sku": "SK22",
        "product_name": "Product A",
        "price": 25.00,
        "quantity": 1,
        "total": 25.00
      }
    ]
  }
}
```

### 2. Top Distributors Report

**Get Top Distributors**
```http
GET /api/v1/reports/top-distributors
```

**Query Parameters:**
| Parameter | Type | Description                      | Default |
|-----------|------|----------------------------------|---------|
| limit     | int  | Max distributors (max: 500)      | 200     |
| per_page  | int  | Records per page (max: 100)      | 20      |

**Response Example:**
```json
{
  "success": true,
  "message": "Top distributors report retrieved successfully.",
  "data": [
    {
      "rank": 1,
      "distributor_id": 456,
      "distributor_name": "Demario Purdy",
      "total_sales": "$22,026.75",
      "total_sales_raw": 22026.75
    },
    {
      "rank": 2,
      "distributor_id": 789,
      "distributor_name": "Floy Miller",
      "total_sales": "$9,645.00",
      "total_sales_raw": 9645.00
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

### Run Specific Test Suite
```bash
docker-compose exec laravel.test php artisan test --filter="Commission Report API"
docker-compose exec laravel.test php artisan test --filter="Top Distributors API"
```

### Test Coverage
```
✅ 46 tests passed
✅ 142 assertions
✅ Duration: ~14 seconds
```

**Test Breakdown:**
- 13 Unit tests for DTOs
- 17 Unit tests for Enums & business logic
- 12 Unit tests for Services
- 6 Feature tests for Commission Report API
- 6 Feature tests for Top Distributors API

### Verify Expected Outputs
```bash
docker-compose exec laravel.test php verify_requirements.php
```

This script verifies all the expected test cases from the requirements:
- ABC4170 => $6.00
- ABC6931 => $37.20
- ABC23352 => $27.60
- ABC3010 => $0
- ABC19323 => $0
- Demario Purdy => $22,026.75 (Rank #1)
- And more...

---

## 📂 Project Structure

```
api-laravel/
├── app/
│   ├── DTOs/                     # Data Transfer Objects
│   │   ├── CommissionReportDTO.php
│   │   ├── OrderItemDTO.php
│   │   └── TopDistributorDTO.php
│   │
│   ├── Enums/                    # Type-safe enumerations
│   │   ├── CommissionTier.php    # Commission percentage tiers
│   │   └── UserType.php          # Customer/Distributor types
│   │
│   ├── Http/Controllers/Api/     # API Controllers
│   │   ├── CommissionReportController.php
│   │   └── TopDistributorsController.php
│   │
│   ├── Models/                   # Eloquent Models
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Product.php
│   │   └── User.php
│   │
│   ├── Repositories/             # Data Access Layer
│   │   ├── Contracts/
│   │   │   ├── DistributorRepositoryInterface.php
│   │   │   └── OrderRepositoryInterface.php
│   │   └── Eloquent/
│   │       ├── EloquentDistributorRepository.php
│   │       └── EloquentOrderRepository.php
│   │
│   └── Services/                 # Business Logic Layer
│       ├── Contracts/
│       │   ├── CommissionReportServiceInterface.php
│       │   └── TopDistributorsServiceInterface.php
│       └── Implementations/
│           ├── CommissionReportService.php
│           └── TopDistributorsService.php
│
├── database/sql/                 # Database files
│   ├── 01_schema.sql            # Table structures
│   └── 02_indexes.sql           # Performance indexes
│
├── routes/
│   └── api.php                  # API route definitions
│
├── tests/
│   ├── Feature/                 # Integration tests
│   │   ├── CommissionReportApiTest.php
│   │   └── TopDistributorsApiTest.php
│   └── Unit/                    # Unit tests
│       ├── DTOs/
│       ├── Enums/
│       └── Services/
│
├── docker-compose.yml           # Docker configuration
├── phpunit.xml                  # Test configuration
├── verify_requirements.php      # Verification script
├── PROJECT_STATUS.md            # Detailed status report
└── QUICK_START.md              # Quick reference guide
```

---

## 📊 Database Schema

### Tables
- **users** - Customers and Distributors
- **orders** - Purchase orders
- **order_items** - Order line items
- **products** - Product catalog

### Key Indexes (Added for Performance)
- `idx_user_type` on users(user_type)
- `idx_referred_by` on users(referred_by)
- `idx_invoice` on orders(invoice)
- `idx_order_date` on orders(order_date)
- `idx_order_id` on order_items(order_id)

---

## 📝 Notes

- No database schema alterations were made (only indexes added as allowed)
- All commission calculations are done in real-time
- Referred distributors count is calculated at order time
- Ranking system properly handles ties
- All dates use Y-m-d format
- Currency values use 2 decimal places

---

## 📚 Documentation

- [PROJECT_STATUS.md](PROJECT_STATUS.md) - Detailed implementation status
- [QUICK_START.md](QUICK_START.md) - Quick reference guide
- [API Documentation](#api-endpoints) - API endpoint details

---

## 👨‍💻 Development

### Key Commands
```bash
# Access Laravel container
docker-compose exec laravel.test bash

# Access database
docker-compose exec mariadb mysql -uroot -ppassword nxm_assessment_2023

# View logs
docker-compose logs -f laravel.test

# Restart containers
docker-compose restart
```

---

## 📄 License

This project was created for the TSA Backend Assessment.

---

**Built with ❤️ using Laravel, Docker, and best practices**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
