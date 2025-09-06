# CITEM Skills Test - Manila FAME Registration System

A full-stack multi-step registration system for the Manila FAME event, built with Laravel backend and Vue.js frontend. This application implements a comprehensive three-step registration process for collecting attendee information with robust validation and secure file handling.

## Project Overview

This is a **Single Page Application (SPA)** that provides a seamless user registration experience for the Manila FAME event. The application features:

- **3-Step Registration Process** with data persistence between steps
- **Server-side validation** for all form fields
- **File upload** capability for company brochures
- **Database transactions** to ensure data integrity
- **Responsive design** for optimal user experience

## Technology Stack

- **Backend**: Laravel 12 (latest stable)
- **Frontend**: Vue.js 3 (latest stable) 
- **Database**: SQLite (development) / MySQL (production ready)
- **Styling**: Tailwind CSS v4
- **Monorepo**: Turborepo with pnpm workspaces
- **Package Manager**: pnpm

## Registration Flow

### Step 1: Account Information (`AccountInformation.vue`)
**Required Fields:**
- First Name (text, required)
- Last Name (text, required) 
- Email Address (email, required, unique validation)
- Username (text, required, unique, alphanumeric only)
- Password (password, required, min 8 characters, show/hide toggle)
- Password Confirmation (password, required, must match)
- Type of Participation (dropdown: Buyer, Exhibitor, Visitor)

### Step 2: Company Information (`CompanyInformation.vue`)
**Required Fields:**
- Company Name (text, required)
- Address Line (text, required)
- Town/City (text, required)
- Region/State (text, required)
- Country (dropdown with countries API, required)
- Year Established (number, 4 digits, not future date)
- Website (URL, optional)
- Company Brochure (file upload, optional, max 2MB, PDF/DOC/DOCX)

### Step 3: Summary & Confirmation (`RegistrationSummary.vue`)
- **Read-only display** of all entered information
- **Final review** before submission
- **Submit Registration** button triggers database transaction

### Post-Submission
- **Success confirmation** page (`RegistrationSuccess.vue`)
- **Thank you message** with registration details
## API Endpoints

### Registration API
- **`POST /api/register`** - Comprehensive registration endpoint
  - Handles complete user and company registration in a single transaction
  - Accepts all form data from Steps 1 and 2
  - Processes file upload for company brochures
  - Ensures data integrity with database transactions
  - Returns success confirmation with user and company IDs

### Geographic Data API
- **`GET /api/countries`** - Retrieve countries list
  - Provides countries for dropdown population
  - Integrates with third-party Countries Now API
  - Includes fallback data for reliability

## Database Schema

### Users Table
- `id` (Primary Key)
- `first_name`, `last_name`
- `email` (unique)
- `username` (unique, alphanumeric)
- `password` (hashed)
- `participation_type` (Buyer/Exhibitor/Visitor)
- `created_at`, `updated_at`

### Companies Table
- `id` (Primary Key)
- `user_id` (Foreign Key to users.id)
- `company_name`
- `address_line`
- `town_city`
- `region_state`
- `country`
- `year_established`
- `website` (nullable)
- `brochure_path` (nullable)
- `created_at`, `updated_at`

## Security Features

- **Password hashing** using Laravel's bcrypt
- **Database transactions** for data integrity
- **Mass assignment protection** with fillable attributes
- **File upload validation** (type, size restrictions)
- **Input sanitization** and validation
- **CSRF protection** for API endpoints
- **Unique email/username validation**

## Prerequisites

- **Node.js 18+**
- **PHP 8.2+**
- **Composer**
- **pnpm** (install with: `npm install -g pnpm`)
- **Database**: SQLite (default) or MySQL 8.0+

## Installation & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd citem-skills-test
```

### 2. Install Dependencies
```bash
# Install all Node.js dependencies (frontend)
pnpm install

# Install PHP dependencies (backend)
cd apps/backend
composer install
cd ../..
```

### 3. Environment Configuration

#### Setup Laravel Environment
```bash
cd apps/backend

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### Configure Database (.env file)

**Option A: SQLite (Default - Recommended for Development)**
```bash
DB_CONNECTION=sqlite
# No additional database configuration needed
```

**Option B: MySQL (Production Ready)**
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citem_skills_test
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

If using MySQL, create the database first:
```sql
CREATE DATABASE citem_skills_test;
```

### 4. Run Database Migrations
```bash
cd apps/backend

# Create database tables
php artisan migrate

# (Optional) Seed with sample data
php artisan db:seed
```

### 5. Configure File Storage
```bash
cd apps/backend

# Create storage symlink for file uploads
php artisan storage:link
```

## Running the Application

### Development Mode (Recommended)
```bash
# From project root - starts both frontend and backend
pnpm dev
```

This will start:
- **Frontend**: http://localhost:5173 (Vue.js + Vite)
- **Backend**: http://localhost:8000 (Laravel API)

### Run Separately
```bash
# Frontend only
cd apps/frontend
pnpm dev

# Backend only  
cd apps/backend
php artisan serve
```

## Testing the Application

1. **Open Frontend**: Navigate to http://localhost:5173
2. **Complete Registration**: Test the 3-step registration process
3. **Verify Data**: Check database tables for saved records
4. **File Upload**: Test brochure upload functionality
5. **API Testing**: Use tools like Postman to test API endpoints

## Project Structure

```
citem-skills-test/
├── apps/
│   ├── frontend/                 # Vue.js SPA
│   │   ├── src/
│   │   │   ├── components/
│   │   │   │   └── registration/
│   │   │   │       ├── AccountInformation.vue
│   │   │   │       ├── CompanyInformation.vue
│   │   │   │       ├── RegistrationSummary.vue
│   │   │   │       └── RegistrationSuccess.vue
│   │   │   ├── stores/           # Pinia state management
│   │   │   └── App.vue
│   │   └── package.json
│   └── backend/                  # Laravel API
│       ├── app/
│       │   ├── Http/
│       │   │   ├── Controllers/Api/
│       │   │   │   └── RegistrationController.php
│       │   │   └── Requests/
│       │   │       └── RegistrationRequest.php
│       │   └── Models/
│       │       ├── User.php
│       │       └── Company.php
│       ├── database/
│       │   ├── migrations/
│       │   └── database.sqlite
│       ├── routes/api.php
│       └── composer.json
├── package.json                  # Root workspace config
├── pnpm-workspace.yaml
├── turbo.json
└── README.md
```

## Build for Production

```bash
# Build frontend
cd apps/frontend
pnpm build

# Optimize Laravel
cd apps/backend
php artisan optimize
php artisan config:cache
php artisan route:cache
```

## Key Features Implemented

✅ **Three-step registration process with data persistence**  
✅ **Comprehensive server-side validation**  
✅ **Single database transaction for data integrity**  
✅ **Secure file upload handling**  
✅ **Responsive design with Tailwind CSS**  
✅ **Countries API integration**  
✅ **User and Company relationship models**  
✅ **Password hashing and security measures**  
✅ **Error handling and user feedback**  
✅ **Single Page Application architecture**

## Troubleshooting

**Database Issues:**
- Ensure database service is running (if using MySQL)
- Verify database credentials in `.env`
- Check file permissions for SQLite

**File Upload Issues:**
- Ensure `storage/app/public` directory exists
- Run `php artisan storage:link`
- Check file size and type restrictions

**CORS Issues:**
- Verify CORS configuration in `config/cors.php`
- Ensure frontend URL is allowed

---

**Developed for CITEM Skills Test - Web Developer Position 2025 by Albert Layasan**
