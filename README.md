# Notification Management System

<p align="center">An application that allows users to see special posts as a one-time notification.</p>

## Features

-   **Authentication & Authorization** - Complete auth system with Laravel Breeze
-   **User Management** - Admin dashboard to manage users
-   **Notification System** - Multi-type notifications (Marketing, System, Invoices)
-   **Twilio Integration** - Phone number validation and SMS notifications via Twilio
-   **User Impersonation** - Admin ability to impersonate users

## Tech Stack

-   **Framework**: Laravel 12.x
-   **Authentication**: Laravel Breeze
-   **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
-   **Database**: MySQL
-   **SMS Service**: Twilio
-   **PHP Version**: 8.2+

## Prerequisites

Before you begin, ensure you have the following installed:

-   PHP >= 8.2
-   Composer
-   Node.js & npm
-   MySQL
-   Twilio Account (for phone number validation)

## Installation

### 1. Clone the Repository

```php
git clone <your-repository-url>
cd laravel-notification-system
```

### 2. Install Dependencies

-   Install PHP dependencies

```php
composer install
```

-   Install JavaScript dependencies

```php
npm install
```

### 3. Environment Setup

```php
    cp .env.example .env
```

-Generate application key

```php
php artisan key:generate
```

### 4. Database Configuration

Update your `.env` file with database credentials:

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Twilio Configuration

-   Add your Twilio credentials to `.env`:

```php
TWILIO_SID=your_twilio_account_sid
TWILIO_TOKEN=your_twilio_auth_token
TWILIO_FROM=your_twilio_phone_number
```

### 6. Run Migrations

```php
php artisan migrate
```

### 7. Seed Database

```php
php artisan db:seed
```

### 8. Install Laravel Breeze

```php
composer require laravel/breeze --dev
```

-   Install Breeze scaffolding

```php
php artisan breeze:install blade
```

-   Build assets

```php
npm run build
```

### 9. Install User Impersonation Package

```php
composer require lab404/laravel-impersonate
```

Publish the configuration:

```php
php artisan vendor:publish --provider="Lab404\Impersonate\ImpersonateServiceProvider"
```

### 10. Start Development Server

```php
php artisan serve
```
