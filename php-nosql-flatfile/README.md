# PHP no-database starter (JSON file storage, PHP 8.1+)

1. `cp .env.example .env`
2. `php -S localhost:8000 -t public public/index.php`

Data lives in `data/notes.json` (auto-created, git-ignored). Make sure `data/` is writable by the web server.
Good for prototypes and small sites; move to the SQL or MongoDB starter once you need concurrent writes or lots of data.
