# Danniel Libor - Functional Task

A Laravel and Quasar Project

## Setup

### Backend

```bash
cd backend

cp .env.example .env

composer install

php artisan key:generate

php artisan migrate

php artisan serve
```

### Frontend

```bash
cd frontend

cp .env.example .env.local

npm install

npm run dev
```

To generate token:

```bash
cd backend

php artisan token:generate
```

Copy and paste the token to `.env.local` file inside `frontend` folder
