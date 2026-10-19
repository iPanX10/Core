# CORE — Computer Hardware Store

<p align="center">
  <strong>Modern Computer Hardware E-Commerce Platform</strong>
</p>

<p align="center">
  Aplikasi e-commerce untuk penjualan dan pengelolaan perangkat keras komputer, dibangun menggunakan Laravel dan Filament.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/Filament-5-FDAE4B?style=for-the-badge" alt="Filament 5">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.3">
</p>

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Environment Configuration](#environment-configuration)
- [Running the Application](#running-the-application)
- [Admin Panel](#admin-panel)
- [Payment Simulation](#payment-simulation)
- [Development Workflow](#development-workflow)
- [Troubleshooting](#troubleshooting)
- [Future Improvements](#future-improvements)
- [Repository](#repository)

## Overview

**CORE (Computer Hardware Store)** is a web-based e-commerce application designed to provide an online shopping experience for computer hardware products.

The application focuses on the sale of computer components and peripherals, including RAM, processors, graphics cards, motherboards, laptops, monitors, and other accessories.

CORE provides a customer-facing storefront and an administrative panel for managing products, inventory, discounts, orders, and payment statuses.

The project is built with Laravel, Blade, Bootstrap, MySQL, and Filament, combining a structured backend with an administrative interface for day-to-day store operations.

## Features

### Customer Storefront

- **Product Catalog** — Browse available computer hardware products.
- **Product Details** — View product information, prices, images, and stock availability.
- **Product Search** — Search for products by name.
- **Category Filtering** — Filter products by category.
- **Price Sorting** — Sort products by price.
- **Shopping Cart** — Add products to the cart and manage quantities.
- **Checkout** — Submit orders with the available fulfillment and payment options.
- **Order Tracking** — Access order information through the order history/search functionality.

### Order Management

- **Order Number Generation** — Identify orders using unique order numbers.
- **Pickup and Delivery** — Choose between store pickup and delivery.
- **Payment Method Selection** — Choose a supported simulated payment method.
- **Order Status Management** — Manage pending, processing, shipped, completed, and cancelled orders, subject to fulfillment rules.
- **Payment Status Management** — Track whether a payment is unpaid or paid.
- **Order Details** — Store customer information, fulfillment details, payment information, and order totals.

### Product and Inventory Management

- **Product CRUD** — Create, view, update, and delete products through the administration panel.
- **Category Management** — Organize products by category.
- **Stock Management** — Maintain product stock quantities.
- **Discount Management** — Configure discount percentages and activate or deactivate discounts.
- **Product Search and Filtering** — Find products more efficiently in the admin panel.

### Administrative Dashboard

Powered by Filament, the admin panel provides tools to:

- Manage products and categories.
- Review and manage customer orders.
- Update order and payment statuses.
- Search and filter order records.
- Review product prices, stock, and discounts.
- Access a dark-themed administrative interface.

## Technology Stack

| Technology | Purpose |
|---|---|
| PHP 8.4 | Backend programming language |
| Laravel 13 | Application framework |
| Blade | Server-rendered views |
| Bootstrap 5.3 | Frontend styling |
| Filament 5 | Administrative panel |
| MySQL | Relational database |
| Composer | PHP dependency management |
| Node.js and npm | Frontend dependency and asset management |
| Vite | Frontend asset build tooling |

## Project Structure

The project follows Laravel's application structure, with additional directories for Filament resources.

```text
CORE/
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       ├── Orders/
│   │       └── Products/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

*Note: The structure above highlights the main application directories. Individual files may vary as the project evolves.*

## Requirements

Make sure the following tools are installed before setting up the project:

- PHP 8.4 or a compatible version required by the project dependencies.
- Composer.
- Node.js and npm.
- MySQL or MariaDB.
- Git.
- XAMPP is recommended for local development on Windows.

## Installation

Follow these steps to run CORE on your local machine.

### 1. Clone the Repository

```bash
git clone https://github.com/iPanX10/Core.git
```

Navigate to the project directory:

```bash
cd Core
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Configure Environment Variables

On Windows Command Prompt:

```bat
copy .env.example .env
```

On macOS, Linux, or Git Bash:

```bash
cp .env.example .env
```

If a `.env` file already exists, preserve your current configuration rather than overwriting it.

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Create the Database

Start MySQL through XAMPP or your preferred database service.

Create a database named:

```sql
CREATE DATABASE core;
```

### 6. Configure the Database Connection

Open `.env` and configure the database settings for your local environment.

Example:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=core
DB_USERNAME=root
DB_PASSWORD=
```

Update the username and password if your MySQL configuration differs.

### 7. Run Database Migrations

```bash
php artisan migrate
```

If the project provides seeders for the required initial data, run:

```bash
php artisan db:seed
```

Only run the seeder if it is configured and appropriate for your local database. Avoid using `migrate:fresh` on a database containing data you want to preserve.

### 8. Install Frontend Dependencies

```bash
npm install
```

For local frontend development:

```bash
npm run dev
```

Alternatively, compile the assets for a production-style build:

```bash
npm run build
```

### 9. Start the Laravel Development Server

Open another terminal in the project directory and run:

```bash
php artisan serve
```

The application will normally be available at:

- Storefront: `http://127.0.0.1:8000`
- Admin panel: `http://127.0.0.1:8000/admin`

## Environment Configuration

The `.env` file contains environment-specific settings, including:

- Application environment and URL.
- Database connection details.
- Application key.
- Other services configured by the application.

**Important:** Never commit your `.env` file, database passwords, application secrets, or real customer information to a public repository.

Use `.env.example` to document the configuration variables required by other developers.

## Running the Application

Once the installation is complete:

1. Ensure MySQL is running.
2. Start the Laravel server using `php artisan serve`.
3. Run `npm run dev` if developing with Vite, or use the compiled assets generated by `npm run build`.
4. Open the storefront in your browser.
5. Navigate to `/admin` to access the administrative panel.

Use an administrator account that has been created and configured for your local environment. Do not assume that default login credentials exist.

## Admin Panel

The Filament admin panel is used to manage the operational side of CORE.

### Products

Administrators can manage product records, categories, prices, stock quantities, images, and discount settings.

### Orders

Administrators can inspect order details and manage fulfillment and payment statuses.

Available order statuses include:

| Status | Description |
|---|---|
| Pending | Order is waiting for further processing |
| Processing | Order is being prepared |
| Shipped | Order has been dispatched for delivery |
| Completed | Order has been completed |
| Cancelled | Order has been cancelled |

For pickup orders, the application restricts the use of the shipped status.

### Payment Status

| Status | Description |
|---|---|
| Unpaid | Payment has not been confirmed |
| Paid | Payment has been confirmed by the administrator |

Payment status should only be changed to paid after the payment has been verified.

## Payment Simulation

CORE currently supports simulated payment options such as:

- Bank Transfer / Virtual Account (VA).
- QRIS.
- E-Wallet.

These options are intended to demonstrate the checkout and order management workflow.

**The payment options are simulations, not a claim of live payment gateway integration.** A successful order submission does not by itself establish that a real payment has been received.

## Development Workflow

For developers who want to contribute or continue development:

1. Clone the repository.
2. Create a separate feature branch.
3. Implement and test your changes.
4. Commit the changes with a descriptive message.
5. Push the branch to GitHub.
6. Open a Pull Request for review.

Example:

```bash
git checkout -b feature/product-improvements
git add .
git commit -m "feat: improve product management"
git push -u origin feature/product-improvements
```

Avoid committing directly to `main` for feature development.

## Troubleshooting

### Database Connection Error

Check that:

- MySQL is running.
- The database `core` exists.
- The database credentials in `.env` are correct.
- The configured MySQL port matches your local setup.

### Application Key Error

Run:

```bash
php artisan key:generate
```

### Changes Are Not Reflected

Clear Laravel's cached configuration and compiled files:

```bash
php artisan optimize:clear
```

Refresh the browser after the command finishes.

### Missing Frontend Assets

Install dependencies and rebuild the assets:

```bash
npm install
npm run build
```

### Admin Login Issues

Verify that the administrator account exists and is configured according to the project's authentication setup. Check the Laravel logs in `storage/logs/laravel.log` for relevant errors.

## Future Improvements

Potential enhancements for future versions include:

- Integration with a real payment gateway.
- Automated payment verification and callbacks.
- Shipping cost calculation and delivery tracking.
- Customer account management.
- Sales reports and inventory analytics.
- Automated invoice generation and downloadable receipts.
- Automated tests for checkout and order management.
- Deployment to a production environment with appropriate security controls.

These items are potential improvements and are not necessarily part of the current implementation.

## Repository

**GitHub:** [https://github.com/iPanX10/Core](https://github.com/iPanX10/Core)

---

<p align="center">
  <strong>CORE — Computer Hardware Store</strong><br>
  Built with Laravel, Filament, and MySQL.
</p>
