# CORE — Computer Hardware Store

A web-based e-commerce application for browsing and purchasing computer hardware components, built with Laravel.

CORE is a computer hardware e-commerce project designed to provide a simple and convenient shopping experience for users looking for components such as RAM, processors, graphics cards, motherboards, and other PC hardware.

## Overview

CORE aims to simplify the process of exploring computer hardware products through an organized product catalog, category filtering, search functionality, and a streamlined shopping experience.

This project is developed using Laravel and related web technologies, with a focus on clean application structure, database integration, and maintainable code.

## Features

### Customer Features

- **Product Catalog** — Browse available computer hardware products.
- **Product Categories** — Explore products by category.
- **Product Search** — Find products using search functionality.
- **Product Sorting** — Sort products by price.
- **Product Details** — View detailed information about individual products.
- **Shopping Cart** — Add, update, and remove products from the cart.
- **Checkout** — Choose between store pickup and delivery options.
- **Payment Simulation** — Support for simulated payment methods, including bank transfer/virtual account, QRIS, and e-wallet, as implemented in the application.

### Development Status

CORE is actively being developed. Features and functionality may change as development progresses.

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP | Backend programming language |
| Laravel | Web application framework |
| MySQL | Relational database |
| Blade | Server-side templating engine |
| Bootstrap 5 | Frontend styling and responsive layout |
| JavaScript | Client-side interactions |
| Composer | PHP dependency management |
| Git & GitHub | Version control and collaboration |
| XAMPP | Local development environment |

## Project Structure

```text
CORE/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   ├── js/
│   └── images/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── products/
│       └── ...
├── routes/
│   └── web.php
├── .env.example
├── artisan
├── composer.json
└── README.md
```

*Note: The structure above is a simplified overview. Actual directories and files may vary as the project develops.*

## Requirements

Before installing CORE, make sure the following tools are available:

- PHP 8.4 or a compatible version supported by the project dependencies
- Composer
- MySQL or MariaDB
- Node.js and npm, if frontend dependencies need to be installed or compiled
- Git
- XAMPP or another local PHP and database environment

## Installation & Setup

Follow these steps to run CORE on your local machine.

### 1. Clone the Repository

```bash
git clone https://github.com/Audhril/Core
```

Navigate to the project directory:

```bash
cd CORE
```

Replace `https://github.com/Audhril/Core` with the actual URL of this repository. If the cloned folder has a different name, use that folder name instead.

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Configure Environment Variables

Copy the example environment file.

For Windows Command Prompt:

```bash
copy .env.example .env
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

Adjust the database credentials according to your local MySQL configuration.

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Create the Database

Start MySQL through XAMPP or your preferred database management tool.

Create a database named `core`, or use another name and update `DB_DATABASE` in your `.env` file accordingly.

### 6. Run Database Migrations and Seeders

```bash
php artisan migrate --seed
```

This command creates the database tables and runs the configured seeders.

If you encounter a migration or seeder error, check your database connection and the project's current migration status before retrying.

### 7. Run the Application

```bash
php artisan serve
```

Open the application in your browser:

**http://127.0.0.1:8000**

## Development Workflow

For contributors who want to work on the project:

1. Clone the repository.
2. Create a separate branch for your changes.
3. Implement and test your changes locally.
4. Commit your changes with a descriptive message.
5. Push your branch to GitHub.
6. Open a pull request for review.

Example:

```bash
git checkout -b feature/your-feature
git add .
git commit -m "feat: describe your changes"
git push origin feature/your-feature
```

Do not commit your `.env` file or other secrets to the repository.

## Roadmap

Planned improvements may include:

- [ ] Complete the checkout and order management workflow.
- [ ] Improve the shopping cart and order validation.
- [ ] Finalize payment simulation and payment verification.
- [ ] Develop an administration page for managing products and orders.
- [ ] Improve order status tracking and invoice presentation.
- [ ] Enhance responsive design and user experience.
- [ ] Add automated tests for important application features.

*Roadmap items should be updated to reflect the actual development status.*

## Contributing

Contributions, suggestions, and bug reports are welcome.

If you would like to contribute, create a branch, make your changes, and submit a pull request with a clear description of the proposed improvements.

## Disclaimer

CORE is a development project intended for learning and portfolio purposes. Payment methods described as simulations should not be considered real payment processing integrations unless explicitly implemented and verified.

## License

No license has been specified yet. All rights are reserved by the project owner unless a license is added to this repository.

---

**CORE — Computer Hardware Store**  
*Built with Laravel, MySQL, and a passion for technology.*
