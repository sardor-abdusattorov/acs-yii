# Aral Culture Summit

Multilingual website and CMS for the [Aral Culture Summit](https://aralculturesummit.uz) — a platform for managing cultural events, articles, publications, and event registrations.

Built on **Yii2 Advanced Template**.

## Features

- **Multilingual support** — English, Russian, Uzbek, Karakalpak
- **Event management** — programs, sessions, dates, locations
- **Content management** — articles, books, pages, sections
- **Registration system** — event registration with attendance tracking
- **Subscriber management** — email subscriptions
- **Archive** — historical event tracking by year
- **Role Based Access Control (RBAC)**
- **Light/Dark mode**
- **Responsive design** (Bootstrap 5)
- **Rich server-side datatables**
- **Modal forms, bulk actions, toast notifications**

## Tech Stack

- **PHP** >= 8.0
- **Yii2** Framework (Advanced Template)
- **MySQL**
- **Apache**
- **Bootstrap 5**
- **jQuery**

## Project Structure

```
├── backend/        # Admin panel (/admin)
├── frontend/       # Public website
├── common/         # Shared models, components, configs
├── console/        # Console commands and migrations
└── environments/   # Dev/Prod environment configs
```

## Requirements

- PHP 8.2
- Composer
- MySQL
- Apache with mod_rewrite

## Installation

```bash
git clone <repository-url>
cd acs-yii

composer install

# Initialize environment (choose dev or prod)
php init
```

### Database Setup

1. Create a MySQL database
2. Configure DB connection in `common/config/main-local.php`:

```php
'db' => [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=localhost;dbname=your_database',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8',
],
```

3. Run migrations:

```bash
php yii migrate --migrationPath=@yii/rbac/migrations/
php yii migrate --migrationPath=@yii/i18n/migrations/
php yii migrate
```

## Default Login

```
Username: admin
Password: 123456
```

## Supported Languages

| Code | Language     |
|------|--------------|
| en   | English      |
| ru   | Русский      |
| uz   | O'zbekcha    |
| ka   | Qaraqalpaqsha |
