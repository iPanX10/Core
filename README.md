
# CORE — Computer Hardware Store

A web-based e-commerce application for browsing and purchasing computer hardware components, built with Laravel.

CORE provides a convenient shopping experience for customers looking for computer hardware, including processors, RAM, graphics cards, motherboards, and other PC components.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [Testing](#testing)
- [Project Structure](#project-structure)
- [Development Workflow](#development-workflow)
- [Roadmap](#roadmap)
- [Limitations](#limitations)
- [Contributing](#contributing)
- [License](#license)

## Overview

CORE is a computer hardware e-commerce project developed to provide an organized product catalog and a straightforward online shopping workflow.

The application includes product discovery, category browsing, search and price sorting, shopping cart management, checkout, order creation, and order-related pages. It also includes an administrative panel for authorized users.

The project focuses on practical Laravel development, database integration, validation, access control, and automated testing.

## Features

### Customer Features

- **Product Catalog** — Browse available computer hardware products.
- **Product Categories** — Explore products by category.
- **Product Search** — Find products using search functionality.
- **Product Sorting** — Sort products by price.
- **Product Details** — View individual product information.
- **Shopping Cart** — Add, update, and remove products.
- **Discounted Pricing** — Calculate prices using active product discounts.
- **Checkout** — Submit orders with delivery or store pickup options.
- **Payment Simulation** — Display simulated payment options for bank transfer, QRIS, and e-wallet.
- **Order Confirmation** — View order confirmation after a successful checkout.
- **Order Invoice** — Access an invoice using the order number and access token.
- **Order History Lookup** — Search for an order using the required order details.

### Administrative Features

- **Admin Authentication** — Restrict access to authorized administrators.
- **Role-Based Access** — Prevent regular users from accessing the admin panel.
- **Product and Order Administration** — Administrative functionality depends on the features configured in the application.

## Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Backend programming language |
| Laravel | Web application framework |
| MySQL | Relational database |
| Blade | Server-side templating engine |
| Bootstrap 5 | Responsive frontend styling |
| JavaScript | Client-side interactions |
| Filament | Administrative panel |
| Composer | PHP dependency management |
| Git and GitHub | Version control and collaboration |
| XAMPP | Local development environment |

## Requirements

Ensure the following tools are installed before setting up CORE:

- PHP version compatible with the project dependencies
- Composer
- MySQL or MariaDB
- Git
- XAMPP or another compatible PHP and database environment
- Node.js and npm, if required by the frontend build configuration

Check the installed versions:

```bash
php -v
composer --version
node -v
npm -v
```

The Node.js and npm commands are only necessary if the project uses frontend dependencies that require them.

## Installation

Follow these steps to run CORE on a local development machine.

### 1. Clone the Repository

Replace the repository URL below with the actual URL of the CORE GitHub repository.

```bash
git clone https://github.com/iPanX10/Core
cd core
```

If Git creates a directory with a different name, navigate to that directory instead.

### 2. Install Dependencies

Install the PHP dependencies:

```bash
composer install
```

If the project requires frontend dependencies, install them as well:

```bash
npm install
```

Only run the npm commands if the project includes the corresponding package configuration.

### 3. Configure Environment Variables

Create a local environment file.

**Windows Command Prompt:**

```bat
copy .env.example .env
```

**PowerShell:**

```powershell
Copy-Item .env.example .env
```

Open `.env` and configure the application and database settings:

```env
APP_NAME=CORE
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=core
DB_USERNAME=root
DB_PASSWORD=
```

Adjust the values according to your local environment.

Do not commit `.env` or other files containing credentials and secrets to GitHub.

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Create the Database

1. Start MySQL through XAMPP or your preferred database service.
2. Open phpMyAdmin or another database management tool.
3. Create a database named `core`.
4. Ensure the database settings in `.env` match your configuration.

### 6. Run Database Migrations

```bash
php artisan migrate
```

This command creates the database tables defined by the project's migrations.

If you also need the sample data provided by the project's seeders, inspect the seeders first and then run:

```bash
php artisan db:seed
```

Some seeders may create sample products or initial accounts. Review their behavior before running them, especially when using a database that already contains data.

### 7. Start the Application

Run the Laravel development server:

```bash
php artisan serve
```

Open the URL displayed in the terminal, usually:

http://127.0.0.1:8000

## Running the Application

After the installation is complete:

1. Ensure the MySQL service is running.
2. Confirm the database connection in `.env`.
3. Start the Laravel development server using `php artisan serve`.
4. Open the application in your browser.
5. Browse products, manage the shopping cart, and test the checkout workflow.

### Administrative Panel

The administrative panel is configured at:

http://127.0.0.1:8000/admin

Access is restricted according to the application's authentication and authorization rules.

Use an administrator account that has been created through the project's approved setup process. Do not assume that a default administrator account exists.

## Testing

CORE includes automated tests for selected application features.

Run the complete test suite:

```bash
php artisan test
```

### Latest Recorded Test Results

The latest reported test run completed with:

- **13 tests passed**
- **42 assertions**
- **0 failed tests**

The test suite covers basic application behavior, administrative access control, and selected shopping cart and checkout scenarios.

These results describe the recorded test run, not a guarantee that every application feature is free of defects. Run the tests again after making code changes.

## Project Structure

The following is a simplified overview of the Laravel project structure:

```text
CORE/
├── app/
│   ├── Filament/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Providers/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   ├── js/
│   └── images/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env.example
├── artisan
├── composer.json
├── phpunit.xml
└── README.md
```

This structure is illustrative. The actual directories and files may differ depending on the current project configuration.

## Development Workflow

Contributors are encouraged to use separate branches for their changes.

### Create a Feature Branch

```bash
git checkout -b feature/your-feature
```

### Make and Test Changes

Implement the changes and run the automated test suite:

```bash
php artisan test
```

### Commit and Push

```bash
git add .
git commit -m "feat: describe your changes"
git push origin feature/your-feature
```

Open a pull request on GitHub if the repository uses pull requests for review.

Before committing, check that `.env`, credentials, private keys, and other sensitive files are not included.

## Roadmap

Potential future improvements include:

- [ ] Integrate a real payment gateway.
- [ ] Implement payment verification using a trusted payment provider.
- [ ] Expand automated test coverage for the complete shopping workflow.
- [ ] Improve order status tracking and administrative workflows.
- [ ] Add project screenshots and additional documentation.
- [ ] Prepare and validate a production deployment configuration.

The roadmap should be updated as features are completed or project priorities change.

## Limitations

- **Simulated Payments:** Payment methods currently represent a simulation and are not proof of a real payment transaction.
- **Payment Verification:** Real payment gateway callbacks, transaction verification, and reconciliation require an actual payment integration.
- **Development Environment:** The installation instructions are intended for local development, not a production deployment.
- **Test Coverage:** Automated tests cover selected scenarios and do not guarantee the absence of all defects.

Do not use simulated payment details to make real financial transactions.

## Contributing

Suggestions, bug reports, and improvements are welcome.

To contribute:

1. Fork or clone the repository, depending on the repository permissions.
2. Create a separate branch for your changes.
3. Implement and test your changes.
4. Commit your changes with a descriptive message.
5. Submit a pull request if the repository workflow supports it.

## License

No open-source license has been specified in this repository.

Unless a license is added, permission to reuse, modify, or redistribute the project should not be assumed.

---

**CORE — Computer Hardware Store**

*Built with Laravel, MySQL, and a passion for technology.*