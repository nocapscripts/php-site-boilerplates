# PHP + MySQL/MariaDB starter (PHP 8.1+, PDO, no Composer)

1. `cp .env.example .env` and fill in the DB credentials
2. `mysql -u USER -p DBNAME < schema.sql`
3. `php -S localhost:8000 -t public public/index.php`

Add a table = add a class like `src/Notes.php`. Always use prepared statements.
Production: point the web root at `public/` only.
