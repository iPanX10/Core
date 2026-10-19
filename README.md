# CORE — Computer Hardware E-Commerce

A web-based e-commerce application for computer hardware products, built with Laravel. CORE provides a streamlined shopping experience for browsing hardware components, managing shopping carts, placing orders, and tracking order status through an administrative dashboard.

**Repository:** [https://github.com/iPanX10/Core](https://github.com/iPanX10/Core)

---

## Overview

CORE is an e-commerce web application focused on computer hardware components, including RAM, CPUs, graphics cards, and motherboards. The project is designed to demonstrate a complete shopping workflow, from product discovery and checkout to order management and administrative operations.

The application includes a customer-facing storefront and an admin dashboard powered by Filament.

## Features

### Customer Features

- **Product Catalog** — Browse computer hardware products and view product details.
- **Search and Filtering** — Search products, filter by category, and sort by price.
- **Shopping Cart** — Add products to the cart and manage product quantities.
- **Checkout System** — Choose between store pickup and delivery.
- **Payment Simulation** — Select simulated payment methods, including Virtual Account, QRIS, and e-wallets.
- **Order History** — Access order information and track order status.
- **Order Status Tracking** — Follow the order lifecycle based on the selected fulfillment method.

### Admin Features

- **Administrative Dashboard** — Manage store operations through Filament.
- **Product Management** — Manage product information, prices, stock, and discounts.
- **Category Management** — Organize products by category.
- **Order Management** — View and update customer orders.
- **Payment Status Management** — Manage payment status with validation rules.
- **Fulfillment Management** — Apply different order status transitions for pickup and delivery.
- **Stock Management** — Restore product stock when an eligible order is cancelled.
- **Order Validation** — Prevent invalid status transitions and unauthorized order reactivation.

## Technology Stack

| Technology | Purpose |
|---|---|
| PHP 8.4 | Backend programming language |
| Laravel 13 | Web application framework |
| Blade | Server-rendered templates |
| Bootstrap 5.3 | Frontend styling |
| Filament 5 | Administrative dashboard |
| MySQL | Relational database |
| Composer | PHP dependency management |
| Node.js & npm | Frontend asset tooling |
| XAMPP | Local development environment |

## Order Workflow

CORE supports two fulfillment methods with different status transitions.

**Store Pickup**

`Pending → Processing → Completed`

**Delivery**

`Pending → Processing → Shipped → Completed`

Orders can also be cancelled when permitted by the application's validation rules. Paid orders require the appropriate refund process before cancellation.

## Payment Methods

The application currently provides simulated payment options:

- Virtual Account / Bank Transfer
- QRIS
- E-Wallet

**Note:** Payment processing is simulated. CORE does not currently represent a production-integrated payment gateway.

## Installation and Setup

### Prerequisites

Ensure the following tools are installed:

- PHP 8.4 or a compatible version supported by the project dependencies
- Composer
- Node.js and npm
- MySQL
- Git

### 1. Clone the Repository

```bash
git clone https://github.com/iPanX10/Core.git
cd Core
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment Variables

Copy the example environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Configure the Database

Create a MySQL database named `core`, or use another database name and update your `.env` configuration accordingly.

Example configuration:

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

Adjust the database username and password to match your local MySQL configuration.

### 5. Run Database Migrations

```bash
php artisan migrate
```

If the repository includes database seeders for sample categories, products, or administrator accounts, run the appropriate seeders after reviewing their configuration.

### 6. Build Frontend Assets

```bash
npm run build
```

For frontend development with automatic asset rebuilding:

```bash
npm run dev
```

### 7. Start the Application

```bash
php artisan serve
```

Open the application in your browser:

- **Storefront:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Admin Dashboard:** [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

The administrator account must be created or seeded according to the project's existing authentication configuration.

## Project Structure

```text
Core/
├── app/
│   ├── Filament/       # Admin resources, pages, forms, and tables
│   ├── Http/           # Controllers and request handling
│   └── Models/         # Eloquent models
├── database/
│   ├── migrations/     # Database schema
│   └── seeders/        # Initial or sample data
├── resources/
│   └── views/          # Blade templates
├── routes/
│   └── web.php         # Web routes
├── public/             # Public assets
├── .env.example        # Environment configuration template
├── composer.json       # PHP dependencies
└── package.json        # Frontend dependencies
```

## Business Rules and Data Integrity

CORE implements validation rules to protect order and inventory data:

- Order status transitions depend on the selected fulfillment method.
- Store pickup orders do not use the `Shipped` status.
- Completed and cancelled orders cannot be reactivated through the normal status workflow.
- Paid orders cannot be marked unpaid.
- Cancellation of paid orders requires the appropriate refund process.
- Stock restoration is performed when an eligible order is cancelled, while preventing duplicate restoration.

These rules are enforced through the application's order management logic and administrative validation.

## Development Status

CORE is an ongoing development project. The current implementation focuses on the core e-commerce workflow, including product browsing, cart management, checkout, simulated payments, and order administration.

Further development may include production payment gateway integration, additional security hardening, automated testing, and improvements to the customer and administrator experience.

## Future Improvements

- Integrate a real payment gateway.
- Improve automated testing coverage.
- Enhance order notifications.
- Strengthen customer authentication and account management.
- Improve reporting and sales analytics.
- Optimize performance and production deployment configuration.

## Contributing

Contributions, suggestions, and feedback are welcome.

1. Fork the repository.
2. Create a feature branch.
3. Commit your changes.
4. Push your branch.
5. Open a pull request describing your changes.

Please ensure that your changes are tested before submitting a pull request.

## Disclaimer

CORE is a development project intended for learning and demonstration purposes. Payment methods and payment status workflows are simulated and should not be considered production-ready financial processing.

## Author

**iPanX10**

GitHub: [@iPanX10](https://github.com/iPanX10)

---

*CORE — Computer Hardware E-Commerce*
