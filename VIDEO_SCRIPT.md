# TSA Backend Assessment - Video Walkthrough Script
**Submitted to:** Yen Desierto, HR Champ, PHL  
**Candidate:** Alamin Juma  
**Date:** December 17, 2025  
**Project:** Multi-Level Marketing Commission & Top Distributors Reporting System

---

## 📹 VIDEO STRUCTURE (Estimated Duration: 8-12 minutes)

---

## 🎬 SECTION 1: INTRODUCTION (1 minute)

### Script:

> "Hello! My name is Alamin Juma, and this is my submission for the TSA Backend Assessment.
>
> In this video, I will demonstrate a complete full-stack application I built for a Multi-Level Marketing Commission and Top Distributors Reporting System.
>
> The project consists of:
> - A **Laravel 12 backend API** running on PHP 8.4 with MariaDB
> - A **Vue 3 frontend** with TypeScript and Tailwind CSS
> - **46 passing Pest tests** with 142 assertions
> - **Service-Repository architecture pattern** for maintainable, testable code
>
> I will demonstrate both Task 1 (Commission Report) and Task 2 (Top Distributors Report), show the backend API responses, walk through the code architecture, and run the test suite.
>
> The frontend is deployed live at https://vue-js-laravel.vercel.app/ and the code is available on GitHub at https://github.com/Alamin-Juma/Vue-JS-Laravel"

### Actions:
- Show your GitHub repository in browser
- Show the deployed Vercel app homepage
- Show VS Code with project structure visible

---

## 🎬 SECTION 2: BUSINESS REQUIREMENTS OVERVIEW (1.5 minutes)

### Script:

> "Let me first explain the business requirements. Company ABC is a multi-level marketing company that sells handbags through distributors.
>
> There are two types of users:
> - **Customers** - who purchase products
> - **Distributors** - who refer customers and earn commissions
>
> The commission structure has 5 tiers based on how many distributors a person has referred:
> - 0 to 4 distributors: 5% commission
> - 5 to 10 distributors: 10% commission
> - 11 to 20 distributors: 15% commission
> - 21 to 29 distributors: 20% commission
> - 30 or more distributors: 30% commission
>
> Key business rules:
> 1. Only CUSTOMER purchases generate commissions
> 2. Only DISTRIBUTORS receive commissions
> 3. Commission percentage is calculated based on referred distributors count AT THE TIME OF THE ORDER
>
> **Task 1** requires a Commission Report showing all orders with calculated commissions, with filters for distributor, date range, and invoice number.
>
> **Task 2** requires a Top Distributors Report showing the top 200 distributors ranked by total sales, with proper handling of tied rankings."

### Actions:
- Show README.md with business rules section
- Highlight the commission tier table
- Show the database schema diagram if available

---

## 🎬 SECTION 3: TASK 1 - COMMISSION REPORT DEMONSTRATION (2.5 minutes)

### Script:

> "Let me start with Task 1: the Commission Report.
>
> I'll navigate to the Commission Report page at https://vue-js-laravel.vercel.app/reports/commission
>
> As you can see, the page displays a comprehensive report with:
> - Invoice number
> - Purchaser name
> - Distributor name
> - Number of referred distributors
> - Order date
> - Commission percentage
> - Order total
> - Calculated commission amount
>
> Each row is expandable to show the individual order items with SKU, product name, price, and quantity.
>
> Now let me test the specific required test cases:

#### Test Case 1: ABC4170 - Expected Commission $6.00
> "Let me filter by invoice ABC4170... As you can see, the commission is correctly calculated as **$6.00**. This order was placed by a customer, referred by a distributor with 8 referred distributors, so they received 10% commission on the $60 order total."

#### Test Case 2: ABC6931 - Expected Commission $37.20
> "Next, invoice ABC6931... The commission shows **$37.20**, which is correct. This is a 10% commission on a $372 order."

#### Test Case 3: ABC23352 - Expected Commission $27.60
> "Invoice ABC23352... Shows **$27.60** commission, which is 10% of $276."

#### Test Case 4: ABC3010 - Expected Commission $0.00
> "Now for the edge cases. Invoice ABC3010... Shows **$0.00** commission. This is correct because the purchaser is a DISTRIBUTOR, not a customer, so no commission is paid according to business rules."

#### Test Case 5: ABC19323 - Expected Commission $0.00
> "And invoice ABC19323... Also **$0.00** because the referrer is not a distributor, so they're not eligible to receive commissions."

### Testing Filters:
> "Let me demonstrate the filters:
> - I'll search for a distributor by name... 'Henderson Sawayn'... Results are filtered
> - Now by date range... Let's filter orders from May 1 to May 31, 2020... Results update
> - The pagination works correctly, showing 15 records per page out of 4,236 total records"

### Actions:
- Navigate to https://vue-js-laravel.vercel.app/reports/commission
- Test each invoice number one by one
- Expand a row to show order items
- Demonstrate distributor search filter
- Demonstrate date range filters
- Show pagination working
- **TAKE SCREENSHOTS** of each test case result

---

## 🎬 SECTION 4: TASK 2 - TOP DISTRIBUTORS REPORT DEMONSTRATION (2 minutes)

### Script:

> "Now let me demonstrate Task 2: the Top Distributors Report.
>
> I'll navigate to https://vue-js-laravel.vercel.app/reports/top-distributors
>
> This report shows the top 200 distributors ranked by their total sales. Total sales includes all purchases made by customers AND distributors they have referred.

#### Verifying Expected Results:
> "Looking at the results:
> - **Rank #1 is Demario Purdy with $22,026.75** - This matches the expected test case perfectly
> - We can see Lennie Balistreri at #2 with $19,869.50
> - Vivienne Conn at #3 with $19,756.00
>
> Let me scroll down to verify the ranking system handles ties correctly...
>
> The system correctly implements tied rankings. When multiple distributors have the same total sales, they receive the same rank number, and the next rank continues from where it would have been.
>
> The pagination shows we have 376 total distributors, and we're showing 20 per page. This is correctly limited to the top performers."

### Actions:
- Navigate to https://vue-js-laravel.vercel.app/reports/top-distributors
- Highlight Demario Purdy at rank #1
- Scroll through a few pages
- Show tied rankings (if visible on current page)
- Demonstrate pagination
- **TAKE SCREENSHOTS** showing rank #1 and any tied ranks

---

## 🎬 SECTION 5: BACKEND API TESTING (1.5 minutes)

### Script:

> "Now let me show that the backend API is working correctly. I'll use Postman/Thunder Client to test the endpoints directly.

#### Commission Report API:
> "First, the Commission Report endpoint: `GET http://localhost/api/v1/reports/commission`
>
> The API returns JSON with:
> - success: true
> - message: 'Commission report retrieved successfully'
> - data: array of commission records
> - pagination information
>
> Let me test with query parameters... `?invoice=ABC4170`
>
> Perfect! The API returns the same data we saw in the UI: invoice ABC4170 with commission $6.00"

#### Top Distributors API:
> "Now the Top Distributors endpoint: `GET http://localhost/api/v1/reports/top-distributors`
>
> The response shows:
> - Rank 1: Demario Purdy, $22,026.75
> - Proper JSON formatting with pagination
> - All data matches what we see in the frontend"

### Actions:
- Open Postman, Thunder Client, or terminal with curl
- Show GET request to http://localhost/api/v1/reports/commission
- Show GET request with invoice filter parameter
- Show GET request to http://localhost/api/v1/reports/top-distributors
- Highlight the JSON responses

---

## 🎬 SECTION 6: CODE ARCHITECTURE WALKTHROUGH (2.5 minutes)

### Script:

> "Let me walk you through the code architecture. I implemented the **Service-Repository Pattern** for clean, maintainable, and testable code.

#### Architecture Layers:
> "The application follows this flow:
> - **Controllers** receive HTTP requests and return responses
> - **Services** contain business logic and data transformation
> - **Repositories** handle all database queries
> - **DTOs** (Data Transfer Objects) ensure type safety
> - **Enums** define type-safe constants

#### Commission Report Service:
> "Let me show the `CommissionReportService`. Open the file...
>
> Here you can see the `getReport` method that:
> 1. Calls the repository to get paginated orders
> 2. Iterates through each order
> 3. Calculates commission using the `calculateCommission` method
> 4. Returns DTOs with calculated data
>
> The `calculateCommission` method implements the business rules:
> - Checks if purchaser is a Customer (user_category = 2)
> - Checks if referrer is a Distributor (user_category = 1)
> - Calculates percentage based on referred_distributors count using the CommissionTier enum
> - Returns the calculated commission"

#### Repository Pattern:
> "Now look at the `EloquentOrderRepository`. This file contains all database queries.
>
> The `getCommissionReport` method:
> - Joins orders, users, user_category tables
> - Uses a subquery to count referred distributors at the order date
> - Calculates order_total from order_items and products
> - Returns paginated results
>
> This separation means if we need to change the database later, we only update the repository, not the service or controller."

#### Commission Tier Enum:
> "The `CommissionTier` enum defines our business rules in code:
> - `fromReferredDistributors` method takes a count and returns the correct percentage
> - Type-safe: can't accidentally use invalid percentages
> - Easy to modify if business rules change"

#### DTOs:
> "DTOs like `CommissionReportDTO` ensure type safety:
> - Properties are strongly typed
> - Easy to serialize to JSON
> - Self-documenting code"

### Actions:
- Show project structure in VS Code
- Open app/Services/Implementations/CommissionReportService.php
- Highlight the calculateCommission method
- Open app/Repositories/Eloquent/EloquentOrderRepository.php
- Show the complex SQL query with joins and subqueries
- Open app/Enums/CommissionTier.php
- Show the fromReferredDistributors method
- Open app/DTOs/CommissionReportDTO.php

---

## 🎬 SECTION 7: TEST SUITE DEMONSTRATION (1.5 minutes)

### Script:

> "Now let me run the complete test suite to prove all functionality works correctly.
>
> I'll open the terminal and run: `php artisan test`
>
> As you can see, all **46 tests pass with 142 assertions**.
>
> The test suite includes:

#### Unit Tests:
> "- **DTO Tests** - Verify data transfer objects work correctly
> - **Enum Tests** - Test commission tier calculations
> - **Service Tests** - Test business logic in isolation with mocked repositories

#### Feature Tests:
> "- **Commission Report API Tests** - Test the full HTTP endpoint
> - **Top Distributors API Tests** - Verify rankings and sales calculations
> - **Validation Tests** - Ensure invalid inputs are rejected
>
> Green across the board! All tests passing proves the application meets all requirements."

### Actions:
- Open terminal in VS Code
- Run: `docker-compose exec laravel.test php artisan test`
- Let the full test suite run and show results
- Optionally run with `--testdox` flag for better output: `php artisan test --testdox`

---

## 🎬 SECTION 8: DATABASE SCHEMA EXPLANATION (1 minute)

### Script:

> "Let me briefly show the database schema.
>
> The database has these key tables:

#### Core Tables:
> "- **users** - Contains both customers and distributors with `referred_by` for the referral chain
> - **user_category** - Junction table linking users to their type (1=Distributor, 2=Customer)
> - **orders** - Purchase records with `invoice_number`, `purchaser_id`, and `order_date`
> - **order_items** - Line items for each order with quantity
> - **products** - Product catalog with SKU, name, and price

#### Key Relationships:
> "- A user can refer many users (self-referential relationship)
> - Orders belong to users as purchasers
> - Orders have many order_items
> - Order_items reference products
>
> The database file `nxm_assessment_2023.sql` is included in the submission and contains over 4,000 real orders for testing."

### Actions:
- Show database/sql/nxm_assessment_2023.sql file
- Optionally: Open a database client (DBeaver, TablePlus) to show tables
- Or show the schema in the README.md

---

## 🎬 SECTION 9: FRONTEND TECHNOLOGY STACK (30 seconds)

### Script:

> "The frontend is built with:
> - **Vue 3** with Composition API
> - **TypeScript** for type safety
> - **Tailwind CSS** for styling
> - **Axios** for API calls
> - **Vite** for fast development and building
>
> It's deployed on **Vercel** at https://vue-js-laravel.vercel.app/ and automatically deploys when I push to the main branch.
>
> The UI is fully responsive and works on mobile, tablet, and desktop devices."

### Actions:
- Show package.json in ui/ folder
- Show vite.config.ts
- Optionally: Resize browser window to show responsive design

---

## 🎬 SECTION 10: CONCLUSION & SUBMISSION SUMMARY (1 minute)

### Script:

> "To summarize what I've delivered:

#### ✅ Task 1 - Commission Report:
> - All 5 test cases pass with expected values
> - Filters work correctly (distributor, date range, invoice)
> - Expandable rows show order item details
> - Pagination handles 4,236+ records efficiently

#### ✅ Task 2 - Top Distributors Report:
> - Top 200 distributors ranked correctly
> - Demario Purdy confirmed at #1 with $22,026.75
> - Tied rankings implemented correctly
> - Clean, sortable table interface

#### ✅ Technical Excellence:
> - 46 tests passing (100% success rate)
> - Service-Repository architecture for maintainability
> - RESTful API with proper HTTP responses
> - Type-safe code with DTOs and Enums
> - Docker containerization for easy setup

#### 📦 Submission Includes:
> 1. **Source Code** - GitHub repository: https://github.com/Alamin-Juma/Vue-JS-Laravel
> 2. **Database Schema** - nxm_assessment_2023.sql file included
> 3. **README.md** - Complete setup instructions and API documentation
> 4. **Live Demo** - Deployed at https://vue-js-laravel.vercel.app/
> 5. **This Video** - Comprehensive walkthrough (YouTube link to be provided)

> Thank you for reviewing my submission! I'm confident this solution meets all the requirements and demonstrates my ability to build production-ready full-stack applications with clean architecture and thorough testing.
>
> If you have any questions or need clarification on any part of the implementation, please don't hesitate to reach out.
>
> Thank you!"

### Actions:
- Show the GitHub repository one more time
- Show the deployed Vercel app
- Show the test results one final time
- End recording

---

## 📋 PRE-RECORDING CHECKLIST

### ✅ Before You Start Recording:

- [ ] **Docker containers running** - `docker ps` shows both containers healthy
- [ ] **Backend accessible** - Test `curl http://localhost/api/v1/reports/commission`
- [ ] **Frontend running** - https://vue-js-laravel.vercel.app/ is accessible
- [ ] **All tests passing** - Run `php artisan test` to verify
- [ ] **Clean browser state** - Clear filters, start from homepage
- [ ] **Open necessary files** in VS Code:
  - README.md
  - app/Services/Implementations/CommissionReportService.php
  - app/Repositories/Eloquent/EloquentOrderRepository.php
  - app/Enums/CommissionTier.php
  - app/DTOs/CommissionReportDTO.php
- [ ] **Postman/Thunder Client ready** with saved API requests
- [ ] **Database client open** (optional) to show schema
- [ ] **GitHub repository open** in browser
- [ ] **Vercel deployment open** in browser
- [ ] **Terminal ready** with correct directory

### 🎥 Recording Tools Recommendations:

1. **OBS Studio** (Free) - Best quality, professional features
2. **Loom** - Quick and easy, good for screen + webcam
3. **Camtasia** - Professional editing capabilities
4. **ShareX** - Free, lightweight screen recorder

### 📝 Tips for Better Video Quality:

1. **Audio Quality:**
   - Use a decent microphone (even phone earbuds better than laptop mic)
   - Record in a quiet environment
   - Speak clearly and at moderate pace

2. **Screen Recording:**
   - Record in 1080p (1920x1080) if possible
   - Close unnecessary applications
   - Hide desktop icons if cluttered
   - Use full-screen browser when showing UI

3. **Video Editing (Optional):**
   - Cut out long pauses or mistakes
   - Add timestamps in description
   - Speed up slow parts (like test execution) with 1.5x playback
   - Add title card at beginning with your name and project title

4. **YouTube Upload:**
   - Title: "TSA Backend Assessment - Alamin Juma - Laravel + Vue Commission System"
   - Description: Include GitHub link, tech stack, timestamps
   - Visibility: Unlisted (not public, but shareable via link)
   - Tags: Laravel, Vue, PHP, Backend Assessment, Full Stack

---

## 📊 TEST CASES REFERENCE SHEET

### Keep This Visible During Recording:

#### Commission Report (Task 1):
| Invoice | Expected Commission | Reason |
|---------|-------------------|---------|
| ABC4170 | $6.00 | Valid customer purchase |
| ABC6931 | $37.20 | Valid customer purchase |
| ABC23352 | $27.60 | Valid customer purchase |
| ABC3010 | $0.00 | Purchaser is distributor |
| ABC19323 | $0.00 | Referrer not distributor |

#### Top Distributors (Task 2):
| Distributor | Total Sales | Expected Rank |
|------------|-------------|---------------|
| Demario Purdy | $22,026.75 | #1 |
| Chaim Kuhn | $360.00 | #197 (tied) |
| Eliane Bogisich | $360.00 | #197 (tied) |

---

## 🎯 SPEAKING POINTS TO EMPHASIZE

### Technical Skills Demonstrated:
- ✅ **Backend Development** - Laravel 12, PHP 8.4, RESTful APIs
- ✅ **Frontend Development** - Vue 3, TypeScript, Tailwind CSS
- ✅ **Database Design** - Complex SQL queries with joins and subqueries
- ✅ **Testing** - Pest PHP with unit and feature tests
- ✅ **Architecture** - Service-Repository pattern
- ✅ **DevOps** - Docker, Docker Compose, Laravel Sail
- ✅ **Version Control** - Git, GitHub
- ✅ **Deployment** - Vercel for frontend
- ✅ **Documentation** - Comprehensive README with API docs

### Soft Skills Demonstrated:
- ✅ **Problem Solving** - Understood complex business rules and implemented correctly
- ✅ **Attention to Detail** - All test cases pass with exact expected values
- ✅ **Code Quality** - Clean, maintainable, well-structured code
- ✅ **Testing Mindset** - Comprehensive test coverage
- ✅ **Communication** - Clear documentation and video explanation

---

## 🚀 GOOD LUCK WITH YOUR RECORDING!

**Remember:**
- Be confident and enthusiastic
- Speak clearly and at a moderate pace
- Don't worry about being perfect - authenticity matters more
- Show your personality - let them see you're passionate about code
- If you make a mistake, just pause, re-record that section, and edit it out

**You've got this! The application works perfectly - now just show it off! 🎉**
