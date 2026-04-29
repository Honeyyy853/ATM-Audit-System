# ATM Audit System

A secure, web-based ATM Audit Management System built with HTML/JS, vanilla CSS (Light Theme), and PHP + MySQL. It manages ATM terminal auditing states, tracking terminal locations, and addresses using Google Maps integration.

## 🔐 Security Notice

This repository has been sanitized for public display:
- **No hardcoded credentials** are present in the frontend or backend.
- Authentication relies exclusively on **PHP Sessions** and a secure backend using `password_hash()` and `password_verify()`.
- API endpoints are protected using session validation.
- Database credentials must be provided via a local `config.php` file, which is deliberately `.gitignore`d.

---

## 🚀 Setup Instructions

Follow these steps to run the project locally or deploy it to a server.

### 1. Database Setup

1. Open your database tool (e.g., phpMyAdmin, MySQL CLI).
2. Create a new database or just run the provided `database.sql` script to create the schema and initial data.
   ```sql
   SOURCE database.sql;
   ```
3. The SQL script will create two tables:
   - `atms`: Stores terminal information and audit status.
   - `users`: Stores secure login credentials.
4. By default, a demo user is inserted:
   - **Username**: `demo_user`
   - **Password**: `your_password_here`

### 2. Configuration Setup

1. In the project root, copy the example configuration file:
   ```bash
   cp config.example.php config.php
   ```
2. Open `config.php` and update the database credentials to match your local or server environment:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'atm_audit');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```
   *(Note: `config.php` is ignored by Git to prevent accidental commits of your credentials)*

### 3. Running the Project

Since this project relies on PHP for backend API processing and session management, you must run it through a PHP-enabled server (such as Apache via XAMPP, WAMP, or Nginx).

**Using Built-in PHP Server (for development):**
```bash
php -S localhost:8000
```
Then visit `http://localhost:8000` in your web browser.

## 👩‍💻 Usage

1. Open the application in your browser.
2. Sign in using the default credentials (`demo_user` / `your_password_here`) or any other user you add directly to the database.
3. Manage the ATMs by adding new records, clicking checkboxes to mark them as audited, editing existing fields, or previewing maps dynamically.

## 🗄️ Project Structure

- `index.html`: The monolithic Single Page Application frontend containing CSS and Javascript.
- `database.sql`: MySQL export for schema and seeded user data.
- `api/`:
  - `auth.php`: Authentication enforcement middleware.
  - `login.php` / `logout.php` / `check_auth.php`: Secure session logic.
  - `connection.php`: PDO database connection file.
  - `add_atm.php`, `delete_atm.php`, `update_atm.php`, etc.: Core application endpoints.
