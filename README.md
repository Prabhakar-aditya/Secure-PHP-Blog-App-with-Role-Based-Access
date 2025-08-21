# Secure Blog App

A simple PHP blog application developed during my **Cybersecurity Internship at Pinnacle Labs**.

## Features
- User authentication (admin & editor roles)
- Secure password hashing
- CSRF protection
- Role-based access control (only admins/editors can manage posts)
- SQL injection prevention with prepared statements

## Tech Stack
- PHP
- MySQL (MariaDB)
- Bootstrap

## Setup
1. Clone this repo into your XAMPP `htdocs` folder.
2. Import `blog.sql` into phpMyAdmin.
3. Update `config.php` with your database credentials.
4. Run `http://localhost/blog-app`.

## Admin Credentials
- **Username**: admin  
- **Password**: Admin@123
