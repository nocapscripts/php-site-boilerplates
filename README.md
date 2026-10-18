# PHP Starters

Three tiny PHP 8.1+ boilerplates. Each is the same notes app (list, add, delete) with a different storage layer, so you can pick one, copy the folder and start building.

| Starter | Storage | Needs | Pick it when |
|---|---|---|---|
| [`php-sql`](php-sql/) | MySQL / MariaDB (PDO) | PHP + a MySQL server | You want relational data, joins and the most common hosting setup |
| [`php-mongodb`](php-mongodb/) | MongoDB (local or Atlas) | `ext-mongodb` + Composer | Your data is document-shaped or the schema changes often |
| [`php-nosql-flatfile`](php-nosql-flatfile/) | JSON file, no database | Just PHP | Prototypes, demos, tiny sites with one writer |

## Quick start

```bash
cd php-sql            # or php-mongodb / php-nosql-flatfile
cp .env.example .env  # fill in values if the starter needs any
php -S localhost:8000 -t public public/index.php
```

Then open http://localhost:8000. Each folder's own README lists the extra step (import `schema.sql`, or `composer install`).

## What's in every starter

```
public/index.php    front controller + tiny router (/, /add, /delete)
public/.htaccess    Apache rewrite to index.php
src/App.php         .env loader, sessions, CSRF, flash messages, view helper
src/Notes.php       the only file that differs between starters (storage layer)
views/layout.php    page shell (Tailwind via CDN)
views/notes.php     list + add form
.env.example        copy to .env
```

Built in: CSRF tokens on every POST, output escaping (`App::h()`), prepared statements in the SQL version, errors logged rather than displayed.

## Extending

1. Add a class next to `src/Notes.php` with the same style (`all()`, `add()`, `delete()`).
2. Add a route in `public/index.php` and a view in `views/`.
3. Swapping storage later only means replacing `Notes.php`; the router and views stay the same.

## Deploying

Point the web root at `public/` only, never the project root, so `.env`, `src/` and `data/` are not web-accessible. Apache works out of the box with `public/.htaccess`. For Nginx or Caddy, send every non-file request to `public/index.php`.

## Not included (on purpose)

Authentication, migrations tooling, an ORM and a build step, to keep these small. Add them as the project needs them.
