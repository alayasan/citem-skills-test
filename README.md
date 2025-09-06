# CITEM Skills Test - Turborepo Monorepo

A full-stack application built with Turborepo, featuring a Vue.js frontend and Laravel backend with SQLite database.

## Project Structure

```
citem-skills-test/
├── apps/
│   ├── frontend/          # Vue.js + Vite frontend
│   └── backend/           # Laravel API backend
├── packages/              # Shared packages (if needed)
├── .github/
├── package.json           # Root package.json with workspaces
├── pnpm-workspace.yaml    # pnpm workspace configuration
├── turbo.json            # Turborepo configuration
└── README.md
```

## Tech Stack

- **Monorepo**: Turborepo with pnpm workspaces
- **Frontend**: Vue.js 3 + TypeScript + Vite + Sass
- **Backend**: Laravel 12 + PHP 8.4
- **Database**: MySQL 8.0+
- **Package Manager**: pnpm

## Quick Start

### Prerequisites

- Node.js 18+ 
- PHP 8.4+
- Composer
- pnpm (`npm install -g pnpm`)
- **MySQL 8.0+** (required)

### MySQL Setup

1. Install MySQL 8.0+ on your system
2. Create a database:
```sql
CREATE DATABASE citem_skills_test;
CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON citem_skills_test.* TO 'laravel_user'@'localhost';
FLUSH PRIVILEGES;
```

3. Update the Laravel `.env` file with your MySQL credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citem_skills_test
DB_USERNAME=laravel_user
DB_PASSWORD=your_password
```

### Installation

1. Install dependencies:
```bash
pnpm install
```

2. Set up Laravel backend:
```bash
cd apps/backend
cp .env.example .env
# Update .env with your MySQL credentials (see MySQL Setup above)
php artisan key:generate
php artisan migrate
```

### Development

Run both frontend and backend in development mode:

```bash
# From project root
pnpm dev
```

Or run separately:

```bash
# Frontend (runs on http://localhost:5173)
cd apps/frontend
pnpm dev

# Backend (runs on http://localhost:8000)
cd apps/backend
php artisan serve
```

### API Testing

The backend includes a test API endpoint:
- `GET /api/hello` - Returns a JSON response with timestamp

The frontend automatically connects to this endpoint to test the full-stack setup.

## Project Features

- ✅ Turborepo monorepo setup
- ✅ Vue.js 3 + TypeScript frontend with Vite
- ✅ **Sass/SCSS styling** with variables and mixins
- ✅ Laravel 12 backend with API routes
- ✅ **MySQL database** with proper configuration
- ✅ CORS configured for local development
- ✅ Full-stack API connection example
- ✅ Hot reload for both frontend and backend

## Development Notes

- **MySQL database** connection configured in `apps/backend/.env`
- **Sass styles** located in `apps/frontend/src/assets/styles/main.scss`
- CORS is configured to allow requests from `http://localhost:5173`
- API routes are prefixed with `/api/`
- Frontend dev server runs on port 5173
- Backend dev server runs on port 8000

## Build for Production

```bash
# Build all apps
pnpm build

# Build specific app
cd apps/frontend && pnpm build
cd apps/backend && php artisan optimize
```
