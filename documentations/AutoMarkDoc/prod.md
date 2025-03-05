# Symfony Application in Production

Some brief considerations regarding the deployment of the application on a production server.

> [!CAUTION]
> Before deploying the application, make sure to:
> - **Disable debug mode**: Use `APP_ENV=prod` and `APP_DEBUG=0` in your configuration to prevent leaking sensitive information and to improve performance.
> - **Secure sensitive information**: Never store API keys or critical credentials in plain text. Use environment variables and a secrets manager.
> - **Properly configure permissions**: Ensure that only authorized users and processes have access to sensitive directories (e.g., `var`, `vendor`).
> - **Implement a backup and monitoring policy**: Ensure that logs are monitored and that regular backups of the database and critical files are performed.
> - **Use HTTPS**: Deploy the application behind a reverse proxy or a web server that handles HTTPS to secure communications.
> - **Verify dependencies and tools**: Remove or disable development-only tools and dependencies.
>
> For more details, refer to the [official documentation](https://symfony.com/doc/current/deployment.html).

## .env file
The .env file in development mode:
```dotenv
PHP_IDE_CONFIG="serverName=localhost"
NGINX_PORT=82
DOCUMENTATION_PROJECTS='{
"automarkdoc": {
"path": "documentations/AutoMarkDoc",
"segment": "automarkdoc",
"host": "localhost",
"name": "AutoMarkDoc"
}
}'
APP_ENV=dev
APP_DEBUG=1
```
The .env file in production mode:
```dotenv
PHP_IDE_CONFIG="serverName=localhost"
NGINX_PORT=82
DOCUMENTATION_PROJECTS='{
"automarkdoc": {
    "path": "documentations/AutoMarkDoc",
    "segment": "",
    "host": "doc.my-domain.com",
    "name": "AutoMarkDoc"
    }
}'
APP_ENV=prod
APP_DEBUG=0
```

## Composer commands & Asset-map compile
If for development you need to run the `composer install` command, for production deployment you will need a series of commands like:

```shell
composer install --no-dev --optimize-autoloader
php bin/console cache:warmup --env=prod
php bin/console asset-map:compile
```
