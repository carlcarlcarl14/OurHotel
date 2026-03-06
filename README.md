# OurHotel - Hotel Booking and Admin Management System

OurHotel is a PHP + MySQL web application for hotel room booking with a user-facing site and an admin dashboard for managing rooms, users, bookings, and admins.

## Features
- User registration and login
- Room listing and booking form
- Admin login and dashboard
- Admin CRUD for rooms, users, bookings, and admins
- Room image upload support (`admin/upload_img/`)

## Tech Stack
- PHP (procedural)
- MySQL / MariaDB
- Bootstrap 5 (CDN)
- Font Awesome (CDN)

## Project Structure
- `index.php` - Main user landing page (protected by login)
- `login.php`, `signup.php`, `logout.php` - User authentication flow
- `admin/` - Admin panel pages
- `config/database.php` - Database connection using env vars
- `database/ourhotel.sql` - SQL schema file

## Setup (Local / XAMPP)
1. Put this project in your web root (example: `htdocs/OurHotel`).
2. Create a MySQL database and import:
   - `database/ourhotel.sql`
3. Configure database env vars (recommended):
   - `DB_HOST`
   - `DB_USER`
   - `DB_PASS`
   - `DB_NAME`
   - `DB_PORT` (optional, default `3306`)
4. Ensure upload directory exists and is writable:
   - `admin/upload_img/`
5. Run via browser:
   - `http://localhost/OurHotel`
   - Admin login page: `http://localhost/OurHotel/admin/login.php`

## Notes
- Uploaded room images are excluded from git via `.gitignore`.
- Keep credentials and environment-specific values out of source control.

