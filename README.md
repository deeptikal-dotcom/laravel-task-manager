# Laravel Task Manager

A small task-manager built for the youbloom practical coding test. Users can create, view, edit, delete, and toggle the status (**Pending** / **Completed**) of tasks. The UI is styled with **Bootstrap 4**, forms are validated server-side with Laravel form requests, and deletion is guarded by a confirmation modal.

## Overview of my approach

- **Framework**: Laravel 10 (PHP 8.1+), using resource routing + Eloquent.
- **Model**: single `Task` model with `title`, `description` (nullable), `status` (`pending` | `completed`). Status values are held as constants on the model so the migration, controller, form requests, and views all reference one source of truth.
- **Controller**: `TaskController` implements `index`, `create`, `store`, `edit`, `update`, `destroy` plus an extra `toggle` action wired to `POST /tasks/{task}/toggle` for the quick "Mark Completed / Mark Pending" button on the list page.
- **Validation**: dedicated `StoreTaskRequest` and `UpdateTaskRequest` form request classes, with friendly custom messages. Title required, status required and constrained to the allowed set, description optional.
- **Views**: single Blade layout (`layouts/app.blade.php`) loading Bootstrap 4 from CDN. Task index uses cards with badge-based status distinction (green "Completed" / yellow "Pending"), completed tasks get a strike-through title and dimmed card. Delete confirmation uses a Bootstrap 4 modal.
- **Error handling**: flash `success` messages on successful writes; global error list plus inline `is-invalid` feedback for each field.
- **Tests**: `tests/Feature/TaskCrudTest.php` covers index render, create, required-field validation, invalid status, update, toggle, and delete.

## Assumptions

- SQLite is used out of the box so the app runs with zero DB configuration. To switch to MySQL/Postgres just edit `.env`.
- No authentication is required by the brief, so tasks are global (single-user).
- "Bootstrap 4" is loaded via public CDN — no build step required.
- Timestamps are shown in the app timezone (UTC by default).

## Requirements

- PHP 8.1+
- Composer 2+
- SQLite (default) or MySQL / PostgreSQL

## Setup instructions

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
# open http://127.0.0.1:8000  (auto-redirects to /tasks)
```

To use MySQL instead, edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

then run `php artisan migrate --seed`.

## Running tests

```bash
php artisan test
```

Uses an in-memory SQLite database so tests are self-contained.

## Bonus features implemented

- **Search bar** on the index page — filters by title *or* status text.
- **Status filter** dropdown (Any / Pending / Completed).
- **Pagination** — 10 tasks per page, query string preserved across page links.
- **Quick status toggle** — one-click "Mark Completed" / "Mark Pending" button on each card.
- **Flash success messages** after every write.
- **Feature tests** covering the full CRUD path plus validation edge cases.

## License

MIT
