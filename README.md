# ScheduleAI — University Schedule Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/Gemini-3.5_Flash-4285F4?style=for-the-badge&logo=google&logoColor=white" alt="Gemini AI">
</p>

A role-based web application for university course schedule management. Students upload their timetable files and receive instant AI-powered conflict analysis powered by **Google Gemini 3.5 Flash**.
  
---

## Features

- 🔐 **Role-based authentication** — Admin and Student roles with separate dashboards
- 📚 **Course management** — Full CRUD for university courses (Admin)
- 📤 **Schedule upload** — Students upload image/PDF timetables (max 10 MB)
- 🤖 **AI conflict detection** — Gemini API analyzes schedules for time conflicts and recommends optimizations
- 📊 **Status tracking** — Schedules progress through `pending → analyzed / failed`
- 🌙 **Dark mode** — Toggle via Alpine.js
- 📱 **Collapsible sidebar** — Responsive navigation

---

## Quick Start

```bash
# Install dependencies
composer install && npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then:
php artisan migrate --seed

# Link public storage (for uploaded schedules)
php artisan storage:link

# Build assets
npm run build

# Start development server
php artisan serve
```

App runs at **http://localhost:8000**

---

## Default Accounts (after seeding)

| Role    | Email                       | Password   |
|---------|-----------------------------|------------|
| Admin   | `admin@scheduleai.com`      | `password` |
| Student | `student@scheduleai.com`    | `password` |

---

## Environment Variables

Add your Gemini API key to `.env`:

```dotenv
GEMINI_API_KEY="your-api-key-here"
```

Get a free API key at [https://aistudio.google.com/](https://aistudio.google.com/)

---

## Full Documentation

See [`docs.md`](docs.md) for complete documentation including:
- Architecture diagram
- Database schema
- All controllers, routes, models, and services
- Frontend view reference

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 |
| Auth scaffold | Laravel Breeze |
| Frontend | Tailwind CSS v3 + Alpine.js v3 |
| AI | Google Gemini 1.5 Flash |
| Database | MySQL / SQLite |
| Assets | Vite |

---

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
