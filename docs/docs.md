# ScheduleAI — Project Documentation

> **University Schedule Management System** built with Laravel 11, Tailwind CSS, Alpine.js, and the Google Gemini API.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Tech Stack](#2-tech-stack)
3. [Architecture Overview](#3-architecture-overview)
4. [Database Schema](#4-database-schema)
5. [Models](#5-models)
6. [Middleware](#6-middleware)
7. [Services — GeminiService](#7-services--geminiservice)
8. [Controllers](#8-controllers)
9. [Routes](#9-routes)
10. [Views & Frontend](#10-views--frontend)
11. [Environment Configuration](#11-environment-configuration)
12. [Seeded Accounts](#12-seeded-accounts)
13. [Running Locally](#13-running-locally)
14. [Implementation Task Checklist](#14-implementation-task-checklist)

---

## 1. Project Overview

**ScheduleAI** is a role-based web application that allows a university to manage courses and student schedules. Students can upload their timetable files (images or PDFs), and the system automatically sends those files to the **Google Gemini 1.5 Flash** AI model for conflict detection and optimization recommendations. Admins can manage courses, review all submitted schedules, and monitor students.

**Key Features:**

| Feature | Description |
|---|---|
| Role-based authentication | Admin and Student roles with dedicated dashboards |
| Course management (CRUD) | Admins can create, read, update, and delete courses |
| Schedule file upload | Students upload image/PDF timetables (max 10 MB) |
| AI analysis via Gemini | Immediate analysis for conflicts and scheduling recommendations |
| Status tracking | Schedules move through `pending → analyzed / failed` states |
| Dark mode | Toggle-able via Alpine.js in the app layout |
| Collapsible sidebar | Responsive sidebar with icon + label toggle |

---

## 2. Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 11 |
| Authentication | Laravel Breeze (Blade / Alpine.js scaffold) |
| Frontend styling | Tailwind CSS v3 |
| Frontend interactivity | Alpine.js v3 |
| Template engine | Blade |
| AI integration | Google Gemini 1.5 Flash REST API |
| Database | MySQL (configurable; SQLite bundled for quick dev) |
| Asset bundling | Vite |
| HTTP client | Laravel's built-in `Http` facade (Guzzle) |

---

## 3. Architecture Overview

```
┌─────────────────────────────────────────────┐
│                  Browser                    │
│  (Blade + Tailwind CSS + Alpine.js)         │
└────────────────────┬────────────────────────┘
                     │  HTTP
┌────────────────────▼────────────────────────┐
│             Laravel Application             │
│                                             │
│  routes/web.php                             │
│       │                                     │
│       ├── RoleMiddleware (auth, role)       │
│       │                                     │
│       ├── AdminController                   │
│       │     ├── dashboard()                 │
│       │     ├── courses CRUD               │
│       │     ├── schedules (read-only)       │
│       │     └── students (read-only)        │
│       │                                     │
│       └── StudentController                 │
│             ├── dashboard()                 │
│             ├── uploadForm()                │
│             ├── upload()  ─────────────┐   │
│             ├── show()                  │   │
│             └── destroy()              │   │
│                                        │   │
│  Services/GeminiService ◄──────────────┘   │
│      analyzeSchedule(path, mimeType)        │
│            │                               │
└────────────┼───────────────────────────────┘
             │  HTTPS (REST)
┌────────────▼───────────────────────────────┐
│       Google Gemini 1.5 Flash API          │
│  generativelanguage.googleapis.com         │
└────────────────────────────────────────────┘
```

---

## 4. Database Schema

### `users` table *(Laravel default + `role` column)*

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | Auto-increment |
| `name` | varchar(255) | |
| `email` | varchar(255) | Unique |
| `email_verified_at` | timestamp | Nullable |
| `password` | varchar(255) | Bcrypt hashed |
| `role` | varchar(255) | `'admin'` or `'student'` |
| `remember_token` | varchar(100) | Nullable |
| `created_at` / `updated_at` | timestamp | |

### `courses` table

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `name` | varchar(255) | Course full name |
| `code` | varchar(255) | Unique course code (e.g. `CS101`) |
| `credits` | integer | Default `3`, range 1–6 |
| `description` | text | Nullable |
| `created_at` / `updated_at` | timestamp | |

### `schedules` table

| Column | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `user_id` | bigint FK | References `users.id`, cascade delete |
| `file_path` | varchar(255) | Storage-relative path (`schedules/xxx.pdf`) |
| `file_disk` | varchar(255) | Default `'public'` |
| `ai_analysis_report` | longtext | Nullable — HTML output from Gemini |
| `status` | enum | `'pending'`, `'analyzed'`, `'failed'` |
| `created_at` / `updated_at` | timestamp | |

---

## 5. Models

### `User` — `app/Models/User.php`

Standard Breeze user model extended with:

- **`role`** added to `$fillable` — values: `'admin'` or `'student'`.
- **`schedules()`** — `hasMany(Schedule::class)` relationship.

```php
// Relationship
public function schedules()
{
    return $this->hasMany(Schedule::class);
}
```

### `Course` — `app/Models/Course.php`

Simple Eloquent model with mass-assignable fields:

```php
protected $fillable = ['name', 'code', 'credits', 'description'];
```

> **Note:** The `Course` model currently has no relationships. If courses are later linked to schedules or students, a `schedules()` or `students()` relationship should be added here.

### `Schedule` — `app/Models/Schedule.php`

Represents one uploaded timetable file + its Gemini analysis result.

```php
protected $fillable = [
    'user_id', 'file_path', 'file_disk', 'ai_analysis_report', 'status',
];

// Relationship
public function user()
{
    return $this->belongsTo(User::class);
}
```

**Status lifecycle:**

```
upload() called
     │
     ▼
 [pending] ──► Gemini success ──► [analyzed]
     │
     └──────► Gemini failure ──► [failed]
```

---

## 6. Middleware

### `RoleMiddleware` — `app/Http/Middleware/RoleMiddleware.php`

Guards routes by comparing the authenticated user's `role` column against the required role string passed in the route definition.

```php
public function handle(Request $request, Closure $next, string $role): Response
{
    if (!auth()->check() || auth()->user()->role !== $role) {
        abort(403, 'Unauthorized action.');
    }
    return $next($request);
}
```

**Registration** — registered as the `'role'` alias in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
})
```

**Usage in routes:**

```php
Route::middleware('role:admin')->group(...)
Route::middleware('role:student')->group(...)
```

---

## 7. Services — GeminiService

**File:** `app/Services/GeminiService.php`

Wraps all communication with the Google Gemini REST API. It is injected via Laravel's service container (constructor injection in `StudentController`).

### Configuration

| Setting | Source | Default |
|---|---|---|
| API Key | `GEMINI_API_KEY` in `.env` | *(empty — must be set)* |
| Model endpoint | Hardcoded | `gemini-1.5-flash:generateContent` |

### `analyzeSchedule(string $path, string $mimeType): ?array`

Reads the file at `$path`, base64-encodes it, and sends a multipart (text + inline_data) request to the Gemini API.

**Prompt sent to Gemini:**

> *"You are a university scheduling assistant. Please analyze the provided document (an image or PDF of a student's course timetable).*
> *1. Extract all the courses along with their timings and days.*
> *2. Check if there are any time conflicts between courses.*
> *3. Recommend any optimizations or note if the schedule is clear of conflicts.*
> *Format your response as a clean, readable HTML summary. Do not use markdown tags like \`\`\`html."*

**Return value:**

```php
// Success
['success' => true, 'analysis' => '<html string from Gemini>']

// API-level failure
['success' => false, 'error' => 'Error message from API']

// Misconfiguration
['error' => 'API Key missing']
```

**Supported MIME types** (enforced at the controller validation layer):
- `image/jpeg`, `image/png`
- `application/pdf`
- `application/vnd.openxmlformats-officedocument.spreadsheetml.sheet` (xlsx)

> **Important:** Base64-encoding large files in-process is synchronous. For files larger than ~2 MB, consider dispatching a queued job (`Queue::push(new AnalyzeScheduleJob($schedule))`) to avoid request timeouts.

---

## 8. Controllers

### `AdminController` — `app/Http/Controllers/AdminController.php`

All methods are protected by `auth + verified + role:admin` middleware.

| Method | Route | Description |
|---|---|---|
| `dashboard()` | `GET /admin/dashboard` | Shows stats (student count, course count, pending/analyzed schedule counts) and 5 most recent schedules |
| `courses()` | `GET /admin/courses` | Paginated list of all courses (15 per page) |
| `createCourse()` | `GET /admin/courses/create` | Blank course creation form |
| `storeCourse(Request)` | `POST /admin/courses` | Validates & persists a new course |
| `editCourse(Course)` | `GET /admin/courses/{course}/edit` | Pre-filled edit form |
| `updateCourse(Request, Course)` | `PUT /admin/courses/{course}` | Validates & updates course |
| `destroyCourse(Course)` | `DELETE /admin/courses/{course}` | Deletes a course |
| `schedules(Request)` | `GET /admin/schedules` | Paginated schedule list with optional `status` filter (20 per page) |
| `showSchedule(Schedule)` | `GET /admin/schedules/{schedule}` | Detailed schedule view with AI report |
| `students()` | `GET /admin/students` | Paginated student list with schedule count (20 per page) |

**Validation rules for courses:**

```php
'name'        => 'required|string|max:255',
'code'        => 'required|string|max:20|unique:courses[,code,{id on edit}]',
'credits'     => 'required|integer|min:1|max:6',
'description' => 'nullable|string',
```

---

### `StudentController` — `app/Http/Controllers/StudentController.php`

All methods are protected by `auth + verified + role:student` middleware.  
`GeminiService` is injected via constructor (Laravel DI).

| Method | Route | Description |
|---|---|---|
| `dashboard()` | `GET /student/dashboard` | Paginated list of the authenticated student's schedules (10 per page) |
| `uploadForm()` | `GET /student/upload` | File upload form |
| `upload(Request)` | `POST /student/upload` | Stores the file, creates a `pending` Schedule record, calls Gemini, updates status |
| `show(Schedule)` | `GET /student/schedule/{schedule}` | Displays a schedule and its AI report. Aborts 403 if `user_id !== auth()->id()` |
| `destroy(Schedule)` | `DELETE /student/schedule/{schedule}` | Deletes file from storage and the DB record. Aborts 403 if not owner |

**File upload validation:**

```php
'schedule_file' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf,xlsx', 'max:10240']
```

**Upload flow:**

1. File stored to `storage/app/public/schedules/` via `Storage::disk('public')`.
2. A `Schedule` record is created with `status = 'pending'`.
3. `GeminiService::analyzeSchedule()` is called synchronously.
4. On success → `status = 'analyzed'`, `ai_analysis_report` populated, redirect to schedule detail.
5. On failure → `status = 'failed'`, redirect to dashboard with a warning flash.

---

## 9. Routes

**File:** `routes/web.php`

### Public

| Method | URI | Action |
|---|---|---|
| `GET` | `/` | Redirects authenticated users to their role-specific dashboard; guests see the welcome page |

### Authenticated (all require `auth + verified`)

#### Profile

| Method | URI | Route name | Controller |
|---|---|---|---|
| `GET` | `/profile` | `profile.edit` | `ProfileController@edit` |
| `PATCH` | `/profile` | `profile.update` | `ProfileController@update` |
| `DELETE` | `/profile` | `profile.destroy` | `ProfileController@destroy` |

#### Admin (`prefix: /admin`, middleware: `role:admin`)

| Method | URI | Route name | Controller method |
|---|---|---|---|
| `GET` | `/admin/dashboard` | `admin.dashboard` | `AdminController@dashboard` |
| `GET` | `/admin/courses` | `admin.courses` | `AdminController@courses` |
| `GET` | `/admin/courses/create` | `admin.courses.create` | `AdminController@createCourse` |
| `POST` | `/admin/courses` | `admin.courses.store` | `AdminController@storeCourse` |
| `GET` | `/admin/courses/{course}/edit` | `admin.courses.edit` | `AdminController@editCourse` |
| `PUT` | `/admin/courses/{course}` | `admin.courses.update` | `AdminController@updateCourse` |
| `DELETE` | `/admin/courses/{course}` | `admin.courses.destroy` | `AdminController@destroyCourse` |
| `GET` | `/admin/schedules` | `admin.schedules` | `AdminController@schedules` |
| `GET` | `/admin/schedules/{schedule}` | `admin.schedules.show` | `AdminController@showSchedule` |
| `GET` | `/admin/students` | `admin.students` | `AdminController@students` |

#### Student (`prefix: /student`, middleware: `role:student`)

| Method | URI | Route name | Controller method |
|---|---|---|---|
| `GET` | `/student/dashboard` | `student.dashboard` | `StudentController@dashboard` |
| `GET` | `/student/upload` | `student.upload` | `StudentController@uploadForm` |
| `POST` | `/student/upload` | `student.upload.store` | `StudentController@upload` |
| `GET` | `/student/schedule/{schedule}` | `student.schedule.show` | `StudentController@show` |
| `DELETE` | `/student/schedule/{schedule}` | `student.schedule.destroy` | `StudentController@destroy` |

Auth routes (login, register, password reset, etc.) are loaded from `routes/auth.php` via Laravel Breeze.

---

## 10. Views & Frontend

### Layout — `resources/views/layouts/app.blade.php`

The primary authenticated layout. Features:

- **Collapsible sidebar** (Alpine.js `sidebarOpen` toggle, `w-64 ↔ w-16`).
- **Dark mode** (Alpine.js `darkMode` toggle; applies `dark` class to `<html>`).
- **Role-aware sidebar nav** — renders admin links (`Dashboard`, `Courses`, `Schedules`, `Students`) or student links (`Dashboard`, `Upload Schedule`) based on `auth()->user()->role`.
- **Flash messages** — auto-dismissing `success` (4 s), `warning` (5 s), and `error` (5 s) banners.
- **Page title slot** — set via `$title` variable in child views.

### Blade Component — `x-sidebar-link`

A reusable sidebar navigation link that accepts:
- `href` — the URL
- `icon` — icon name (Heroicons)
- `label` — display text
- `:active` — boolean to highlight current route
- `:open` — whether the sidebar is expanded (controls label visibility)

### Dashboards

| File | Purpose |
|---|---|
| `resources/views/dashboard/admin.blade.php` | Admin overview with 4 stat cards + recent schedule table |
| `resources/views/dashboard/student.blade.php` | Student's schedule history with status badges |

### Admin Views

| File | Purpose |
|---|---|
| `resources/views/admin/courses/index.blade.php` | Paginated course list with edit/delete actions |
| `resources/views/admin/courses/create.blade.php` | New-course form |
| `resources/views/admin/courses/edit.blade.php` | Edit-course form |
| `resources/views/admin/schedules/index.blade.php` | All schedules with status filter |
| `resources/views/admin/schedules/show.blade.php` | Single schedule detail with embedded AI report |
| `resources/views/admin/students.blade.php` | Student list with schedule count |

### Student Views

| File | Purpose |
|---|---|
| `resources/views/student/upload.blade.php` | Drag-and-drop file upload form with accept-type filtering |
| `resources/views/student/schedule-show.blade.php` | Full schedule detail with rendered HTML AI report |

### Welcome Page

`resources/views/welcome.blade.php` — the public landing page shown to unauthenticated visitors.

---

## 11. Environment Configuration

Relevant `.env` keys for this project:

```dotenv
APP_NAME=Laravel
APP_ENV=local
APP_URL=http://localhost

# Database (MySQL in production; SQLite available for quick dev)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schedule_app
DB_USERNAME=root
DB_PASSWORD=

# Session & cache stored in database (run migrations first)
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Google Gemini API key — get yours at https://aistudio.google.com/
GEMINI_API_KEY="your-api-key-here"
```

> **Security Note:** The `GEMINI_API_KEY` in this repository is a sample key. Replace it with your own key and **never commit real API keys to version control.**

---

## 12. Seeded Accounts

Run `php artisan db:seed` to create the following default accounts:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@scheduleai.com` | `password` |
| Student | `student@scheduleai.com` | `password` |

---

## 13. Running Locally

```bash
# 1. Install PHP dependencies
composer install

# 2. Install Node dependencies
npm install

# 3. Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env, then run migrations + seed
php artisan migrate --seed

# 5. Create the storage symlink (for uploaded files)
php artisan storage:link

# 6. Build frontend assets
npm run build
# Or watch for changes during development:
# npm run dev

# 7. Start the dev server
php artisan serve
```

The app will be available at **http://localhost:8000**.

---

## 14. Implementation Task Checklist

- `[x]` 1. Install Laravel Breeze (Blade/Alpine) and setup database
- `[x]` 2. Modify User model & create Role Middleware
- `[x]` 3. Create Models & Migrations (Course, Schedule)
- `[x]` 4. Run migrations
- `[x]` 5. Build Gemini API Integration Service (`GeminiService.php`)
- `[x]` 6. Implement Controllers (Admin, Student, Dashboard)
- `[x]` 7. Setup Routing in `routes/web.php`
- `[x]` 8. Build Frontend UI (Admin Dashboard, Student Dashboard, File Upload Component, AI Modal)
- `[x]` 9. Compile frontend assets (`npm run build`)
- `[x]` 10. Verification and final checks
