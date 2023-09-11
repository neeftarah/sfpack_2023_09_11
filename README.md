Projet de la formation Symfony PACK - Jour 1
===============================================

Cette formation combine les deux modules « SF6START /
Démarrer avec Symfony 6 » et « SF6MASTER / Maîtrise de Symfony 6 » et
couvre tous les concepts importants de Symfony. De l'installation à
l'affichage de vos premières pages web dynamiques avec Twig, en passant
par les formulaires, la sécurité et le cache HTTP, vous apprendrez à utiliser et
maîtriser tous les outils majeurs de Symfony afin de devenir entièrement
autonome avec le framework.

Projet du jour 1


Requirements
------------
Before creating running the application you must:

* Install **PHP 8.1** or higher and these PHP extensions *(which are installed
and enabled by default in most PHP 8 installations)*:  
    **Ctype**, **iconv**, **PCRE**, **Session**, **SimpleXML**, and **Tokenizer**;
* Install **Composer**, which is used to install PHP packages.
* Optionally, you can also install **Symfony CLI**.  
    This creates a binary called symfony that provides all the tools you need to develop and run your Symfony application locally.

The symfony binary also provides a tool to check if your computer meets all requirements. Open your console terminal and run this command:

```bash
symfony check:requirements
```

Installation
------------

If you've just downloaded the code, congratulations!!

To get it working, follow these steps:

### Download Composer dependencies

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```bash
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

### Database Setup

The code comes with a `docker-compose.yaml` file and we recommend using
Docker to boot a database container. You will still have PHP installed
locally, but you'll connect to a database inside Docker. This is optional,
but I think you'll love it!

First, make sure you have [Docker installed](https://docs.docker.com/get-docker/)
and running. To start the container, run:

```bash
docker-compose up -d
```

Next, create the database and the schema with:

```bash
# "symfony console" is equivalent to "bin/console"
# but its aware of your database container
symfony console doctrine:database:create --if-not-exists
```

Run migrations to create and populate tables with:
```bash
symfony console doctrine:migrations:migrate
```

Create fakes datas (optional) with:
```bash
symfony console doctrine:fixtures:load
```

If you're using something other than Postgresql, you can replace
`doctrine:migrations:migrate` with `doctrine:schema:update --force`.

If you do *not* want to use Docker, just make sure to start your own
database server and update the `DATABASE_URL` environment variable in
`.env` or `.env.local` before running the commands above.

### Webpack Encore Assets

This app uses Webpack Encore for the CSS, JS and image files, which we use
a bit near the beginning to test out our login flow.

First, make sure you have `npm` installed (`npm` comes with Node) and then :

Install node dependencies
```bash
npm install
```

Run watcher in order to compile any changes automatically
```bash
npm run watch
```

### Start the Symfony web server

You can use Nginx or Apache, but Symfony's local web server
works even better.

To install the Symfony local web server, follow
"Downloading the Symfony client" instructions found
here: https://symfony.com/download - you only need to do this
once on your system.

Then, to start the web server, open a terminal, move into the
project, and run:

```bash
symfony serve -d
```

(If this is your first time using this command, you may see an
error that you need to run `symfony server:ca:install` first).

Now check out the site at `https://localhost:8000`

Have fun!
