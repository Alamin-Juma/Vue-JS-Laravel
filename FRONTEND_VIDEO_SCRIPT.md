# TSA 1 Frontend Assessment - Video Walkthrough Script
**Submitted to:** Yen Desierto, HR Champ  
**SCRUM MASTER:** Alamin Juma  
**Date:** December 21, 2025  
**Project:** NXM Landing Page - Vue.js Frontend with Laravel Backend

---

## 📹 VIDEO STRUCTURE (Estimated Duration: 8-12 minutes)

---

## 🎬 SECTION 1: INTRODUCTION (1 minute)

### Script:

> "Hello! My name is [Your Name], and this is my submission for TSA 1 - Frontend Assessment.
>
> In this video, I will demonstrate a pixel-perfect implementation of the NXM landing page based on the provided Figma design.
>
> The project consists of:
> - A **Vue 3 frontend** with TypeScript and Tailwind CSS
> - **Laravel 11 backend API** for form submission
> - **MySQL database** integration
> - **Complete form validation** (client-side and server-side)
> - **Fully responsive design** matching the Figma design
> - **Cross-browser compatibility**
>
> The code is fully optimized and follows best practices for both frontend and backend development."

### Actions:
- Open the project in VS Code
- Show the browser with the landing page loaded
- Open the Figma design in another tab for comparison

---

## 🎬 SECTION 2: FIGMA DESIGN COMPARISON (2 minutes)

### Script:

> "Let me first show you how our implementation matches the Figma design pixel-perfect.
>
> Here's the Figma design file, and here's our live implementation. As you can see:
>
> **Hero Section:**
> - The heading 'COLLAGEN IS THE FOUNTAIN OF YOUTH' matches exactly
> - The typography, colors (#416887 for blue text), and spacing are identical
> - The 'Connect with Ben' button is positioned correctly with the avatar
> - The background image of the half face and feather are properly positioned
>
> **Congratulations Section:**
> - Text layout and spacing match the design
> - Font sizes and line heights are accurate
>
> **What's Your Influence Section:**
> - The three influencer cards display correctly
> - Hover effects work as expected
> - Spacing and borders match the design
>
> **Footer:**
> - Background color #456276 matches exactly
> - Links are properly spaced and styled
>
> **Registration Popup Modal:**
> - Opens when 'Connect with Ben' is clicked
> - Image on the left side (person with phone)
> - Title 'REGISTER TO learn more' with correct styling (27px, #416887, -2% letter spacing)
> - Close icon (X) positioned in top-right corner (11.41px, #888888)
> - Form fields with proper styling (14px, font-light, 100% line height)
> - Border lines are 1.5px with #4FA0D5 color
> - reCAPTCHA box has 8px border radius with #4FA0D5 border
> - Register button uses #456276 color matching the footer"

### Actions:
- Show Figma design side-by-side with live site
- Scroll through both to show matching sections
- Click "Connect with Ben" to show the popup
- Point out specific design elements and their exact match

---

## 🎬 SECTION 3: RESPONSIVE DESIGN DEMONSTRATION (2 minutes)

### Script:

> "Now let me demonstrate the responsive behavior across different devices.
>
> **Desktop View (1920px):**
> - Full layout displays properly
> - Images are positioned correctly
> - Form modal is centered and properly sized
>
> **Tablet View (768px):**
> - Navigation adapts appropriately
> - Card grid adjusts to available space
> - Modal remains functional and well-positioned
>
> **Mobile View (375px):**
> - Single column layout
> - Touch-friendly button sizes
> - Modal adapts to small screen (image hides, form takes full width)
> - All content remains readable and accessible
>
> The page maintains its design integrity across all breakpoints."

### Actions:
- Open Chrome DevTools
- Toggle device toolbar
- Switch between different device sizes (iPhone, iPad, Desktop)
- Scroll through the page on each device size
- Open the modal on each device size
- Rotate to landscape on mobile

---

## 🎬 SECTION 4: FORM VALIDATION DEMONSTRATION (2 minutes)

### Script:

> "Let me demonstrate the comprehensive form validation.
>
> **Client-Side Validation (Vue):**
> - Clicking 'Register Now' with empty fields shows validation errors
> - First Name - required field validation
> - Last Name - required field validation
> - Phone Number - required and format validation
> - Email - required and valid email format validation
> - Checkbox - must be checked to proceed
>
> **Real-Time Validation:**
> - Errors appear on blur (when leaving a field)
> - Error messages are clear and helpful
> - Invalid fields show red borders
> - Valid fields show blue borders
>
> **Successful Submission:**
> - Fill all fields correctly
> - Check the 'I'm not a robot' checkbox
> - Click 'Register Now'
> - Loading state shows 'Registering...'
> - Success message appears: 'Thank you for registering! We will contact you soon.'
> - Modal closes automatically after 2 seconds
> - Form resets for next submission"

### Actions:
- Open the modal
- Try to submit empty form - show all errors
- Fill fields one by one, showing validation on blur
- Show invalid email format error
- Show invalid phone format error
- Fill form correctly and submit
- Show success message
- Wait for modal to close

---

## 🎬 SECTION 5: BACKEND API & DATABASE (3 minutes)

### Script:

> "Now let's dive into the backend implementation and see how everything connects.
>
> **Backend Architecture:**
> - Laravel 11 API running in Docker containers
> - MariaDB database for data persistence
> - RESTful API design with proper validation
>
> **Let me show you the validation layer:**
> 
> Opening `api-laravel/app/Http/Controllers/FormSubmissionController.php`
> - Here's our controller with server-side validation
> - Lines 17-23: Validation rules for each field
>   - firstName: required, string, max 255 characters
>   - lastName: required, string, max 255 characters
>   - phone: required, string, max 20 characters
>   - email: required, valid email format, max 255 characters
>   - agreeToTerms: required, boolean, must be accepted
> - If validation fails, it returns a 422 error with specific error messages
> - If validation passes, we save to the database and return success
>
> **Database Model:**
> Opening `api-laravel/app/Models/FormSubmission.php`
> - This is our Eloquent model
> - Fillable fields protect against mass assignment vulnerabilities
> - The model maps to the `form_submissions` table
>
> **API Routes:**
> Opening `api-laravel/routes/api.php`
> - Line 12: POST `/api/register` route configured
> - Maps to FormSubmissionController@store method
> - CORS is enabled in `config/cors.php` to allow frontend requests
>
> **Testing the API Locally:**
> Let me demonstrate by submitting a form from the frontend...
> [Submit form with name 'Ali Juma', email 'ali@gmail.com', phone '1234567890']
> - Form submitted successfully!
> - You can see the success message
>
> **Now let's verify in the database:**
> Opening terminal and running:
> ```bash
> docker-compose exec mariadb mysql -u sail -ppassword nxm_assessment_2023 -e "SELECT * FROM form_submissions ORDER BY created_at DESC;"
> ```
>
> And here's the result - we can see our data:
> - ID: 2
> - First Name: Ali
> - Last Name: Juma  
> - Phone: 1234567890
> - Email: ali@gmail.com
> - Agree to Terms: 1 (true)
> - Created at: 2025-12-20 22:37:10
>
> We also have a previous test record showing the system has been working.
>
> **Frontend-Backend Connection:**
> Opening `ui/src/services/api.ts`
> - This is our API service layer
> - Base URL configured: `http://localhost/api`
> - POST method handles form submission
> - Proper headers: Content-Type and Accept as application/json
>
> Opening `ui/src/services/index.ts`
> - formService.submitRegistration sends the data
> - Transforms Vue form data to API format
> - Handles success and error responses
>
> **The Complete Flow:**
> 1. User fills form in Vue component
> 2. Client-side validation checks (Vue)
> 3. Form data sent to API service
> 4. API service makes POST request to Laravel
> 5. Laravel validates data (server-side)
> 6. If valid: saves to database, returns success
> 7. If invalid: returns 422 with error messages
> 8. Frontend displays result to user
>
> **Docker Setup:**
> - Laravel app running on port 80
> - MariaDB running on port 3306
> - Both containers managed by docker-compose
> - Persistent database storage"

### Actions:
- Open FormSubmissionController.php in VS Code (show validation rules lines 17-23)
- Open FormSubmission model (show fillable fields)
- Open routes/api.php (show the register route)
- Open config/cors.php (show CORS configuration)
- Switch to browser, submit form with real data
- Open terminal and run the MySQL query command
- Show the database results with new records
- Open ui/src/services/api.ts (show API configuration)
- Open ui/src/services/index.ts (show submitRegistration method)
- Open browser DevTools Network tab
- Submit another form and show the API request/response
- Show Status: 201 Created
- Show response JSON with success message

---

## 🎬 SECTION 6: CODE ARCHITECTURE & FILE STRUCTURE (2 minutes)

### Script:

> "Let me walk through the complete code architecture and how everything is organized.
>
> **Frontend Structure (Vue 3):**
> Opening the project in VS Code...
> 
> `ui/src/components/`
> - FormModal.vue - The popup modal container with image and form
> - RegistrationForm.vue - Form component with client-side validation
> - HeroSection.vue - Hero with 'Connect with Ben' button
> - Other sections: BodyOne, InfluenceSection, CTASection, FooterSection
>
> `ui/src/composables/`
> - useRegistrationForm.ts - Main form logic, handles submission
> - useRegistrationFormComponent.ts - Form component utilities
> - Notice the TypeScript interfaces for type safety
>
> `ui/src/services/`
> - api.ts - HTTP client with GET/POST/PUT/DELETE methods
> - index.ts - formService that calls the API
> - Centralized API configuration
>
> `ui/src/stores/`
> - formModal.ts - Pinia store managing modal open/close state
> - Reactive state management
>
> **Backend Structure (Laravel):**
> 
> `api-laravel/app/Http/Controllers/`
> - FormSubmissionController.php
>   - store() method handles POST requests
>   - Validates incoming data (lines 17-23)
>   - Creates database record (lines 31-37)
>   - Returns JSON response (lines 39-45)
>
> `api-laravel/app/Models/`
> - FormSubmission.php
>   - Eloquent model for database operations
>   - $fillable array (lines 18-24) specifies which fields can be mass-assigned
>   - $casts array (lines 31-35) defines data type conversions
>
> `api-laravel/database/migrations/`
> - 2025_12_21_000000_create_form_submissions_table.php
>   - Defines table schema
>   - Creates indexes for performance
>   - up() method creates table, down() method drops it
>
> `api-laravel/routes/`
> - api.php - API route definitions
>   - Line 12: POST route to FormSubmissionController
>   - Automatically prefixed with /api
>
> `api-laravel/config/`
> - cors.php - CORS configuration allowing frontend requests
> - database.php - Database connection settings
>
> **Configuration Files:**
> 
> `ui/.env`
> - VITE_API_URL=http://localhost/api
> - Connects Vue frontend to Laravel backend
>
> `api-laravel/.env`
> - Database credentials
> - DB_DATABASE=nxm_assessment_2023
> - DB_USERNAME=sail
> - DB_PASSWORD=password
>
> **Docker Configuration:**
> - docker-compose.yml manages both Laravel and MariaDB containers
> - Ensures consistent development environment
>
> **Key Architecture Patterns:**
> - Service Layer Pattern - API calls separated from components
> - Repository Pattern ready for expansion
> - Dependency Injection with TypeScript
> - RESTful API design
> - MVC pattern in Laravel
> - Component-based architecture in Vue
>
> This architecture ensures:
> - Maintainability - Easy to update and extend
> - Testability - Components can be tested independently
> - Scalability - Can add more features easily
> - Type Safety - TypeScript catches errors at compile time
> - Security - Validation on both client and server"

### Actions:
- Show VS Code explorer with ui/src folder structure
- Open and briefly scroll through each key file:
  - FormModal.vue
  - RegistrationForm.vue
  - useRegistrationForm.ts
  - api.ts
  - formModal.ts
- Show api-laravel folder structure
- Open and show key sections:
  - FormSubmissionController.php (validation section)
  - FormSubmission.php (fillable and casts)
  - routes/api.php (the register route)
  - migration file (table schema)
- Open both .env files side by side
- Show docker-compose.yml file
- Show the clean separation between frontend and backend

### Script:

> "Let me walk through the code architecture.
>
> **Frontend Structure (Vue 3):**
> - Components are modular and reusable
> - FormModal.vue - the popup modal component
> - RegistrationForm.vue - form with validation logic
> - useRegistrationForm composable - handles form submission
> - apiService - centralized API calls
> - Pinia store for modal state management
> - TypeScript for type safety
> - Tailwind CSS for styling
>
> **Backend Structure (Laravel):**
> - RESTful API design
> - FormSubmissionController - handles form submissions
> - FormSubmission model - database representation
> - Migration file - database schema
> - Service layer pattern (ready for expansion)
> - Request validation
> - JSON responses with proper status codes
>
> **Best Practices:**
> - Type-safe TypeScript interfaces
> - Composable pattern for reusability
> - Error handling on both frontend and backend
> - Environment variables for configuration
> - Clean, readable, and maintainable code"

### Actions:
- Show project structure in VS Code explorer
- Open key files one by one
- Highlight important code sections
- Show TypeScript interfaces
- Show validation logic
- Show API service layer

---

## 🎬 SECTION 7: BROWSER COMPATIBILITY & CONSOLE CHECK (1 minute)

### Script:

> "Let's verify cross-browser compatibility and check for console errors.
>
> **Google Chrome:**
> - Opening DevTools Console... No errors!
> - Network tab shows successful API calls
> - All functionality works perfectly
>
> **Mozilla Firefox:**
> - Opening the site in Firefox
> - Console is clean, no errors
> - Form submission works
> - Styling is consistent
>
> **Microsoft Edge:**
> - Opening the site in Edge
> - No console errors
> - All features functional
> - Design remains pixel-perfect
>
> The application works flawlessly across all major browsers."

### Actions:
- Open Chrome DevTools Console
- Show no errors (clean console)
- Open Firefox
- Show clean console in Firefox
- Test form submission in Firefox
- Open Edge
- Show clean console in Edge
- Test a feature in Edge

---

## 🎬 SECTION 8: CLOSING & DELIVERABLES (0.5 minutes)

### Script:

> "To summarize, I have delivered:
>
> ✅ **Pixel-perfect Figma implementation** - Every detail matches the design
> ✅ **Fully responsive design** - Works on mobile, tablet, and desktop
> ✅ **Complete form validation** - Client-side and server-side
> ✅ **Laravel backend API** - RESTful endpoints with validation
> ✅ **MySQL database integration** - Form submissions are saved
> ✅ **Cross-browser compatibility** - Chrome, Firefox, Edge
> ✅ **No console errors** - Clean, error-free code
> ✅ **Comprehensive documentation** - README with setup instructions
> ✅ **SQL dump included** - Database schema ready to use
>
> All source code is fully optimized and follows best practices.
>
> Thank you for watching this demonstration!"

### Actions:
- Show the project folder structure one last time
- Show README.md file
- Show database_schema.sql file
- Show package.json and composer.json files

---

## 📋 CHECKLIST FOR VIDEO RECORDING

### Pre-Recording Setup:
- [ ] Close unnecessary browser tabs
- [ ] Clear browser history/cache
- [ ] Reset database (optional, for clean demo)
- [ ] Prepare Figma design in a tab
- [ ] Have all browsers ready (Chrome, Firefox, Edge)
- [ ] Test form submission once to verify API works
- [ ] Set up screen recording software (OBS, Loom, etc.)
- [ ] Ensure good microphone quality
- [ ] Practice the script once

### During Recording:
- [ ] Speak clearly and at a moderate pace
- [ ] Show enthusiasm and confidence
- [ ] Point out key features explicitly
- [ ] Use mouse to highlight important elements
- [ ] Pause briefly between sections
- [ ] Zoom in on small text if needed
- [ ] Show all validation errors clearly
- [ ] Display success message clearly

### Post-Recording:
- [ ] Review video for clarity
- [ ] Check audio quality
- [ ] Verify all requirements were demonstrated
- [ ] Upload to YouTube (unlisted or public)
- [ ] Add video title: "NXM Frontend Assessment - [Your Name]"
- [ ] Add description with project details
- [ ] Copy YouTube link for submission

---

## 🎯 VIDEO MUST INCLUDE (DONE-DONE CRITERIA):

✅ Overview of the webpage and layout  
✅ Proof that the page perfectly matches the Figma  
✅ Form validation demo (all fields)  
✅ Submission → successful data save  
✅ Responsive behavior walkthrough  
✅ Console log (showing no errors)  
✅ Browser compatibility showcase  

---

## 📦 DELIVERABLES CHECKLIST:

✅ Full source code (Vue files + PHP endpoint + config files)  
✅ Database schema or SQL dump  
✅ Video walkthrough (YouTube link)  
✅ README file with setup instructions  

---

## 💡 TIPS FOR A GREAT VIDEO:

1. **Be Confident** - You built this, be proud!
2. **Be Thorough** - Show all features, don't rush
3. **Be Clear** - Explain what you're doing and why
4. **Show, Don't Just Tell** - Actually demonstrate each feature
5. **Test Before Recording** - Make sure everything works
6. **Keep It Professional** - Good lighting, clear audio, organized desktop
7. **Stay Within Time** - Aim for 8-12 minutes
8. **End Strong** - Summarize achievements confidently

---

Good luck with your video recording! 🎥🚀
