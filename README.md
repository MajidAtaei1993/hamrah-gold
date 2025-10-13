<h1 align="center">
  🟡 Hamrah Gold
</h1>

<p align="center">
  A modern full-stack web application built with <b>Laravel 12</b>, <b>Inertia.js</b>, <b>Vue 3</b>, <b>Vite</b>, <b>Tailwind CSS</b>, and <b>Wayfinder</b>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/Vue.js-3.x-42B883?logo=vue.js&logoColor=white" />
  <img src="https://img.shields.io/badge/Inertia.js-Server%20Driven%20SPA-6A0DAD?logo=inertia&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Vite-Plugin%20Ready-646CFF?logo=vite&logoColor=white" />
  <img src="https://img.shields.io/badge/pnpm-9.x-F69220?logo=pnpm&logoColor=white" />
</p>

<p align="center">
  <img src="./docs/screenshot-1.png" alt="Hamrah Gold Screenshot" width="700" style="border-radius:12px;">
  <img src="./docs/screenshot-2.png" alt="Hamrah Gold Screenshot" width="700" style="border-radius:12px;">
</p>

---

## 🚀 Overview

**Hamrah Gold** is a modern, fast, and scalable full-stack web application using Laravel as the backend and Vue 3 (via Inertia.js) as the frontend.  
It provides a smooth SPA experience without losing the power of server-side routing and validation.

---

## 🧩 Tech Stack

| Layer | Technology |
|:------|:------------|
| Backend | Laravel 12 |
| Frontend | Vue 3 + Inertia.js |
| Build Tool | Vite |
| Styling | Tailwind CSS |
| Package Manager | pnpm |
| Form & UI Generator | Wayfinder |

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the repository
```bash
git clone https://github.com/MajidAtaei1993/hamrah-gold.git
cd hamrah-gold
```

### 2️⃣ Install dependencies
```bash
composer install
composer update
pnpm install
```

### 3️⃣ Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` file:
```env
APP_NAME=HamrahGold
APP_ENV=local
APP_DEBUG=true
APP_URL=http://hamrah-gold.test

VITE_APP_NAME="${APP_NAME}"
VITE_API_URL="${APP_URL}/api/"
```

### 4️⃣ Run migrations and seeders
```bash
php artisan migrate --seed
```

### 5️⃣ Generate Wayfinder components
```bash
php artisan wayfinder:generate --with-form
```

---

## 🧠 Development Workflow

Start backend:
```bash
php artisan serve
```

Start frontend:
```bash
pnpm dev
```

Access URLs:
- Backend → [http://127.0.0.1:8000](http://127.0.0.1:8000)
- Frontend → [http://localhost:5173](http://localhost:5173)

---

## 🗂️ Project Structure

```
hamrah-gold/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   └── images/
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   ├── Components/
│   │   ├── composables/
│   │   └── app.ts
│   ├── css/
│   └── views/
├── routes/
│   ├── web.php
│   └── api.php
├── docs/
│   ├── screenshot-1.png
│   └── screenshot-2.png
├── vite.config.ts
├── package.json
├── composer.json
└── README.md
```

---

## 🧰 Useful Commands

| Command | Description |
|:---------|:-------------|
| `php artisan serve` | Start Laravel backend |
| `pnpm dev` | Start frontend dev server |
| `php artisan migrate --seed` | Run database migrations |
| `php artisan wayfinder:generate --with-form` | Generate forms & components |
| `composer install / update` | Install PHP dependencies |

---

## 🖼️ Screenshots

| Dashboard | Example Page |
|------------|--------------|
| ![Dashboard](./docs/screenshot-1.png) | ![Example Page](./docs/screenshot-2.png) |

---

## 🧑‍💻 Author

**Majid Ataei**  
Fullstack Developer — Laravel / Vue / Nuxt / NestJS  

[![GitHub](https://img.shields.io/badge/GitHub-MajidAtaei1993-181717?logo=github)](https://github.com/MajidAtaei1993)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-MajidAtaei-0077B5?logo=linkedin&logoColor=white)](https://www.linkedin.com/in/majidataei)
[![Email](https://img.shields.io/badge/Email-majid.ataie79%40gmail.com-D14836?logo=gmail&logoColor=white)](mailto:majid.ataie79@gmail.com)

---

## 🪪 License
Released under the **MIT License**.

---

<p align="center">
  <sub>Built with ❤️ by <b>Majid Ataei</b></sub>
</p>
