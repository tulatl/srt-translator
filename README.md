# SRT Translator

SRT Translator is a Laravel-based web application for uploading, managing, and translating `.srt` subtitle files.

This project is intended to make subtitle translation workflows easier by keeping subtitle timing intact while allowing subtitle text to be processed and translated.

## Features

* Upload `.srt` subtitle files
* Parse subtitle blocks and preserve timing information
* Translate subtitle text
* Download or manage translated subtitle output
* Laravel-based backend structure
* Simple environment-based configuration

## Requirements

* PHP 8.1 or higher
* Composer
* Node.js and npm
* MySQL or MariaDB
* Git

## Installation

Clone the repository:

```bash
git clone git@github.com:tulatl/srt-translator.git
cd srt-translator
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=srt_translator
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
php artisan migrate
```

Create the storage symlink:

```bash
php artisan storage:link
```

Build frontend assets:

```bash
npm run build
```

Start the local development server:

```bash
php artisan serve
```

Open the application:

```text
http://127.0.0.1:8000
```

## Development

For local development, run the Laravel server:

```bash
php artisan serve
```

If you are working on frontend assets, run:

```bash
npm run dev
```

## Testing

Run the test suite:

```bash
php artisan test
```

Run PHP syntax checks manually:

```bash
find app config database routes tests -name "*.php" -print0 | xargs -0 -n1 php -l
```

## Environment Variables

Important environment variables:

```env
APP_NAME="SRT Translator"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=srt_translator
DB_USERNAME=root
DB_PASSWORD=
```

If the project uses admin seeding, configure these values before running seeders:

```env
ADMIN_NAME="Admin"
ADMIN_EMAIL="admin@example.com"
ADMIN_PASSWORD="change-this-password"
```

Do not commit your real `.env` file.

## Security

Before deploying or making this project public, make sure that:

* `.env` is not committed
* Real passwords, API keys, tokens, and private keys are not committed
* Database dumps are not committed
* `APP_DEBUG=false` is used in production
* A strong `APP_KEY` is generated
* Production credentials are stored securely

If you discover a security issue, please open a private report or contact the maintainer directly.

## Contributing

Contributions are welcome.

To contribute:

1. Fork the repository
2. Create a new feature branch
3. Make your changes
4. Run tests
5. Open a pull request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
