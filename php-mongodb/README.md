# PHP + MongoDB starter (PHP 8.1+)

Needs the `mongodb` PHP extension (`pecl install mongodb`, then enable it in php.ini) and Composer.

1. `composer install`
2. `cp .env.example .env` (Atlas: `MONGO_URI=mongodb+srv://user:pass@cluster.mongodb.net`)
3. `php -S localhost:8000 -t public public/index.php`

No schema or migrations: the `notes` collection is created on first insert.
