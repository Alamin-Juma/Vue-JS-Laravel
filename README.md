# NXM Assessment 2023 - Vue + Laravel Project

![NXM Landing Page](image-1.png)

## 🚀 Project Overview

This is a full-stack web application built with **Vue.js 3** (frontend) and **Laravel 11** (backend API), created as part of the NXM Assessment 2023. The project features a pixel-perfect implementation of the Figma design with a responsive layout, form validation, and MySQL database integration.

### Features

- ✅ Pixel-perfect Figma design implementation
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Vue 3 with Composition API and TypeScript
- ✅ Tailwind CSS for styling
- ✅ Form validation with custom Vue logic
- ✅ "Connect with Ben" popup modal with registration form
- ✅ Laravel 11 API backend
- ✅ MySQL database integration
- ✅ CORS enabled for cross-origin requests
- ✅ RESTful API endpoints
- ✅ Cross-browser compatibility (Chrome, Firefox, Edge)

---

## 📁 Project Structure

```
vue-laravel-project/
├── ui/                          # Vue.js Frontend
│   ├── src/
│   │   ├── components/          # Vue components
│   │   │   ├── FormModal.vue    # Registration popup modal
│   │   │   ├── RegistrationForm.vue  # Form with validation
│   │   │   ├── HeroSection.vue
│   │   │   ├── FooterSection.vue
│   │   │   └── ...
│   │   ├── composables/         # Vue composables
│   │   ├── services/            # API service layer
│   │   ├── stores/              # Pinia stores
│   │   └── views/               # Page views
│   ├── public/                  # Static assets
│   ├── .env                     # Environment variables
│   └── package.json
│
├── api-laravel/                 # Laravel Backend
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── FormSubmissionController.php
│   │   └── Models/
│   │       └── FormSubmission.php
│   ├── database/
│   │   └── migrations/
│   │       └── 2025_12_21_000000_create_form_submissions_table.php
│   ├── routes/
│   │   └── api.php
│   ├── .env
│   └── docker-compose.yml
│
└── database_schema.sql          # SQL dump for form_submissions table
```

---

## 🛠️ Tech Stack

### Frontend
- **Vue 3** - Progressive JavaScript framework
- **TypeScript** - Type-safe JavaScript
- **Tailwind CSS** - Utility-first CSS framework
- **Pinia** - State management
- **Vite** - Build tool

### Backend
- **Laravel 11** - PHP framework
- **MySQL** - Database
- **Docker** - Containerization (optional)

---

## 📋 Prerequisites

- **Node.js** >= 20.19.0
- **PHP** >= 8.2
- **Composer**
- **MySQL** >= 8.0
- **Docker & Docker Compose** (optional)

---

## 🚦 Setup Instructions

### 1. Clone the Repository

```bash
git clone <repository-url>
cd vue-laravel-project
```

### 2. Frontend Setup (Vue.js)

```bash
cd ui
npm install
```

#### Configure Environment Variables

Create or update `.env` file:
```env
VITE_API_URL=http://localhost:8000/api
```

#### Run Development Server

```bash
npm run dev
```

The frontend will be available at `http://localhost:5173`

### 3. Backend Setup (Laravel)

```bash
cd ../api-laravel
composer install
```

#### Configure Environment Variables

Copy `.env.example` to `.env` and update database credentials:

```env
APP_NAME=NXM-API
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nxm_assessment_2023
DB_USERNAME=root
DB_PASSWORD=

CORS_ALLOWED_ORIGINS=*
```

#### Generate Application Key

```bash
php artisan key:generate
```

#### Run Migrations

```bash
php artisan migrate
```

This will create the `form_submissions` table in your database.

#### Run Development Server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

---

## 🐳 Docker Setup (Alternative)

If you prefer using Docker:

```bash
cd api-laravel
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate
```

---

## 📊 Database Schema

The `form_submissions` table structure:

```sql
CREATE TABLE form_submissions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  phone VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  agree_to_terms TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX(email),
  INDEX(created_at)
);
```

See `database_schema.sql` for the complete SQL dump.

---

## 🔌 API Endpoints

### Form Submission

**POST** `/api/register`

Submit registration form data.

**Request Body:**
```json
{
  "firstName": "John",
  "lastName": "Doe",
  "phone": "+1234567890",
  "email": "john.doe@example.com",
  "agreeToTerms": true
}
```

**Response:**
```json
{
  "success": true,
  "message": "Thank you for registering! We will contact you soon.",
  "data": {
    "id": 1,
    "email": "john.doe@example.com",
    "created_at": "2025-12-21T10:30:00.000000Z"
  }
}
```

### Get Submissions (Admin)

**GET** `/api/v1/form-submissions`

Retrieve paginated list of form submissions.

---

## ✅ Form Validation

The registration form includes comprehensive validation:

- ✅ **First Name** - Required field
- ✅ **Last Name** - Required field
- ✅ **Phone Number** - Required, valid phone format
- ✅ **Email** - Required, valid email format
- ✅ **Agreement Checkbox** - Must be checked

Validation is performed:
1. **Client-side** (Vue) - Real-time validation on blur
2. **Server-side** (Laravel) - Additional validation before database insertion

---

## 🎨 Features Walkthrough

### Homepage
- Hero section with "Collagen is the Fountain of Youth" message
- "Connect with Ben" button triggers registration popup
- Responsive grid layout
- What's Your Influence section with influencer cards
- CTA section
- Footer with links

### Registration Popup Modal
- Opens when "Connect with Ben" is clicked
- Image on left side (person with phone)
- Form on right side
- Close button (X) in top-right corner
- Form fields with validation
- Real-time error messages
- Success message on submission
- Auto-closes after successful submission

---

## 🧪 Testing

### Run Unit Tests
```bash
cd ui
npm run test:unit
```

### Run E2E Tests
```bash
npm run test:e2e
```

### Backend Tests
```bash
cd api-laravel
php artisan test
```

---

## 📱 Responsive Design

The application is fully responsive and tested on:
- Mobile (320px - 768px)
- Tablet (768px - 1024px)
- Desktop (1024px+)

---

## 🌐 Browser Compatibility

Tested and working on:
- ✅ Google Chrome (latest)
- ✅ Mozilla Firefox (latest)
- ✅ Microsoft Edge (latest)
- ✅ Safari (latest)

---

## 📝 Development Notes

### Code Quality
- TypeScript for type safety
- ESLint for code linting
- Prettier for code formatting
- Clean, modular component structure
- Reusable composables

### Performance
- Lazy loading components
- Optimized images
- Efficient state management with Pinia
- Vite for fast HMR

---

## 🎥 Video Demonstration

Please refer to the submitted YouTube link for:
- Complete webpage walkthrough
- Figma design comparison
- Form validation demonstration
- Successful data submission
- Responsive behavior on different devices
- Console log (no errors)
- Browser compatibility showcase

---

## 📦 Build for Production

### Frontend
```bash
cd ui
npm run build
```

Build output will be in `ui/dist/`

### Backend
```bash
cd api-laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🤝 TSA Team

- **HR CHAMP:** Yen Desierto
- **SCRUM MASTER:** Alamin Juma

---

## 📄 License

This project is part of the NXM Assessment 2023.

---

## 🐛 Troubleshooting

### CORS Issues
Ensure CORS is enabled in `api-laravel/config/cors.php` and the frontend URL is allowed.

### Database Connection
Verify MySQL is running and credentials in `.env` are correct.

### Port Conflicts
If ports 5173 or 8000 are in use, update the port in the respective configuration files.

---

## 📧 Contact

For any questions or issues, please contact the development team.

![Landing Page](image.png)