# Installation

> [!NOTE]
> This is the quick installation note for local - dev - review 



## Checkout the project
```shell
mkdir AutoMarkdoc
git clone https://github.com/partITech/AutoMarkDoc .
```
## Local server instance
> [!CAUTION]
> Install docker and docker compose if not already done.

Firstly build images, then launch
```shell
docker compose build
docker compose up -d
```

## Update dependencies

As this project is made with [PHP 8.4](https://www.php.net/) and the framework [Symfony](https://symfony.com/), some few commands are required to checkout all needed files.

```shell
docker compose exec php composer install
```

> [!IMPORTANT]
> By default project load this documentation. 
> This is configured by the env 
> `DOCUMENTATION_DIR_PATH=documentations/AutoMarkDoc`
> 
> 
> Update this in the .env{.dev,.test} to use your files. 
> 
> See the [Quick Start](quick_start.md) section to learn more about basic configurations