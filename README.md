# Inventory Manager

Simplified inventory management system.

---

## Setup & Installation

```bash
# 1. Clone the repository
git clone https://github.com/sherifnabil/inventory-manager.git
cd inventory-manager

# 2. Install dependencies
composer install

# 3. Create your environment file
cp .env.example .env

# 4. Set up your environment variables
# - Set your DB connection credentials
# - Set DB_DATABASE to your database name

# 5. Generate the app key
php artisan key:generate

# 6. Run migrations and seeders
php artisan migrate --seed
```

## Running Tests

```bash
php artisan test
```

## Using Postman Collection
 Import the collection appended in the project root to your postman
 Login using Auth Login request add the response token as a Global variable with name token to get access to other requests



