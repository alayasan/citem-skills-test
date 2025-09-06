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
- **Frontend**: Vue.js 3 + TypeScript + Vite
- **Backend**: Laravel 12 + PHP 8.4
- **Database**: SQLite (development-ready)
- **Package Manager**: pnpm

## Quick Start

### Prerequisites

- Node.js 18+ 
- PHP 8.4+
- Composer
- pnpm (`npm install -g pnpm`)

### Installation

1. Install dependencies:
```bash
pnpm install
```

2. Set up Laravel backend:
```bash
cd apps/backend
cp .env.example .env
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
- ✅ Vue.js 3 + TypeScript frontend
- ✅ Laravel 12 backend with API routes
- ✅ SQLite database (no setup required)
- ✅ CORS configured for local development
- ✅ Full-stack API connection example
- ✅ Hot reload for both frontend and backend

## Development Notes

- SQLite database file is located at `apps/backend/database/database.sqlite`
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
