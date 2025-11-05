# Symfony Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

Since running the project with docker imply using a .env file which is the file docker-compose check about for context,
we need to defined the env file at first [#4223 🐋 .env file is not read](https://github.com/docker/compose/issues/4223#issuecomment-280077263)

1. You need to copy the .env.[dev|prod] into your .env.[dev|prod].local

2. Now you need to decrypt the encrypted data to your .env.[dev|prod].local

__Fetch the decrypt key from the project administrator__ and place it inside the config/secrets/[dev|prod]

3. and run the one-time container such as

```sh
docker compose build --pull --no-cache \
&& touch .env
&& docker compose run --rm -it -v ${PWD}:/app php php bin/console secrets:decrypt-to-local --force
```

⚠️ Check that the environment variables are indeed decrypted correctly through your .env.[dev|prod].local (you should see something like MERCURE_JWT_SECRET)

4. Now, you'll need to run the following (so docker-compose have environment context defined)

```
cat .env.dev.local | grep -E 'SERVER_NAME|MERCURE_JWT_SECRET|MERCURE_PUBLIC_URL|MERCURE_URL|DEFAULT_URI' > .env
```

7. Run `docker compose build` to build fresh images
6. Run `docker compose up --env-file=.env.[dev|prod].local --wait` to set up and start a fresh Symfony project
8. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)

### In prod environment

The following line will generate the production-ready env .env.local.php

⚠️ Real environment variables always win over env vars created by any of the .env files.

```
docker pull composer/composer
docker run --rm -it -v "$(pwd):/app" composer/composer dump-env prod
```

## Features

- Production, development and CI ready
- Just 1 service by default
- Blazing-fast performance thanks to [the worker mode of FrankenPHP](https://frankenphp.dev/docs/worker/)
- [Installation of extra Docker Compose services](docs/extra-services.md) with Symfony Flex
- Automatic HTTPS (in dev and prod)
- HTTP/3 and [Early Hints](https://symfony.com/blog/new-in-symfony-6-3-early-hints) support
- Real-time messaging thanks to a built-in [Mercure hub](https://symfony.com/doc/current/mercure.html)
- [Vulcain](https://vulcain.rocks) support
- Native [XDebug](docs/xdebug.md) integration
- Super-readable configuration

**Enjoy!**

## Docs

1. [Options available](docs/options.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using MySQL instead of PostgreSQL](docs/mysql.md)
8. [Using Alpine Linux instead of Debian](docs/alpine.md)
9. [Using a Makefile](docs/makefile.md)
10. [Updating the template](docs/updating.md)
11. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
