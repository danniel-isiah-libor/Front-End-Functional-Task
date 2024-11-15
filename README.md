# Danniel Libor - Functional Task

A Laravel and Quasar Project

## Setup

### Backend

1. Navigate to the backend directory:

   ```bash
   cd backend
   ```

2. Copy the example environment file and configure it:

   ```bash
   cp .env.example .env
   ```

3. Build the Docker image:

   ```bash
   make build
   ```

4. Start the Docker containers:

   ```bash
   make up
   ```

5. Access the running container:

   ```bash
   make shell
   ```

6. Install PHP dependencies:

   ```bash
   composer install
   ```

7. Generate the application key:

   ```bash
   php artisan key:generate
   ```

8. Run database migrations:
   ```bash
   php artisan migrate
   ```

### Frontend

1. Navigate to the frontend directory:

   ```bash
   cd frontend
   ```

2. Copy the example environment file and configure it:

   ```bash
   cp .env.example .env.local
   ```

3. Build the Docker image:

   ```bash
   make build
   ```

4. Start the Docker containers:

   ```bash
   make up
   ```

5. Access the running container:

   ```bash
   make shell
   ```

6. Install Node.js dependencies:
   ```bash
   npm install
   ```

## Generate Token

1. Navigate to the backend directory:

   ```bash
   cd backend
   ```

2. Access the running container:

   ```bash
   make shell
   ```

3. Generate the token:

   ```bash
   php artisan token:generate
   ```

4. Copy and paste the token into the `.env.local` file inside the `frontend` folder.
