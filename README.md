# Installation & Setup

## Prerequisites

Make sure the following are installed:

* PHP 8.2+
* Composer
* Node.js 20+
* npm
* MySQL 8+
* Git

---

## Clone the Repository

```bash
git clone https://github.com/yourusername/inventiq.git
```

```bash
cd inventiq
```

---

## Install Dependencies

### PHP Dependencies

```bash
composer install
```

### JavaScript Dependencies

```bash
npm install
```

---

## Environment Setup

Copy the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database credentials inside `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventiq
DB_USERNAME=root
DB_PASSWORD=
```

---

## Database

Run the migrations:

```bash
php artisan migrate
```

Seed the database:

```bash
php artisan db:seed
```

Or run everything from scratch:

```bash
php artisan migrate:fresh --seed
```

---

# Running the Project

### Start the Laravel Server

```bash
php artisan serve
```

The application will be available at:

```
http://127.0.0.1:8000
```

---

### Start the Vite Development Server

Open a second terminal and run:

```bash
npm run dev
```

---

### Production Build

```bash
npm run build
```

---

# Useful Artisan Commands

Clear all caches:

```bash
php artisan optimize:clear
```

Clear configuration cache:

```bash
php artisan config:clear
```

Clear route cache:

```bash
php artisan route:clear
```

Clear view cache:

```bash
php artisan view:clear
```

Cache configuration:

```bash
php artisan config:cache
```

List all routes:

```bash
php artisan route:list
```

---

# Development URLs

Laravel Application

```
http://127.0.0.1:8000
```

Vite Development Server

```
http://localhost:5173
```

---

# Author

## Edson Hermosa

**Software Developer**
