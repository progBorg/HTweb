<img alt="HVO logo" align="right" width="150" height="150" src="https://raw.githubusercontent.com/progBorg/HVOweb/master/public/assets/img/logo/logo.svg">

# HVOweb

FuelPHP-based web application for dorm administration.

Originally developed by [Melcher Stikkelorum](https://github.com/MelcherSt/HTweb).

Forked, further developed and maintained by Tom Veldman.

## Features
* Complete point based diner tracking module including enrollments of guests, cooks and dishwashers. 
* Product module for easy cost logging
* Receipt module including cost distribution tools
* Bilingual user interface (Dutch and English)

## Dependencies
### PHP 7.4
Get the latest release of PHP 7.4 on your device. If you're on Linux, use your system's package manager. If you're on Windows, take a look at [XAMPP](https://www.apachefriends.org/download.html). Make sure to download the 7.4 version, 8.0 doesn't work with FuelPHP yet.

PHP 7.4 is recommended, but not strictly required. However, it's a good habit to keep your software up-to-date. PHP 7.3 is currently receiving security fixes only, and will reach its end-of-life in December 2021.

### Composer
Get the latest release of Composer on your device, preferably using your system's package manager. For detailed instructions, please refer to the [Composer Installation Manual](https://getcomposer.org/doc/00-intro.md).

## Installing

### FuelPHP
Browse to the root of the project (where the `composer.json` file lives).
Download and install FuelPHP using `composer update`.

For production environments, you may consider appending the `--no-dev` option.

## Configuration

### Database
Create an empty database. Edit the configuration files that reside in the `/fuel/app/config` directory.
Be sure to enter your database credentials in the `db.php` file. Perhaps also have a look at `auth.php`, `ormauth.php` and `config.php`.

### Production environments
For production environments, please be sure to configure and update the salts in both `auth.php` and `ormauth.php` as well.

## Migrations
Run all migrations. You can edit and use the accompanying script `auto-migrate.sh` for this, or you can do it by hand.

Please note there's a strict order in which to run migrations:
1. auth tables and others: `oil r migrate --packages=auth` 
3. session tables: `oil r migrate --modules=sessions`
   - (some other modules depend on sessions' functionality)
4. all other migrations: `oil r migrate --all`

## Run it
Oil has a built-in web server. Run the server using `oil s`.

Alternatively you can use any webserver that uses the `/public/` directory as document root.

## Notes

### Autocompletion in IDEs
FuelPHP core classes are aliased to the global namespace, which means that for example \\View refers to \\Fuel\\Core\\View if no \\View already exists.
Most IDEs are not aware of this.

To make them aware, the file `autocomplete.php` is included at the root of the project.
Fuelphp doesn't use this file, but it allows your IDE to be able to autocomplete code and understand the origins of Fuel classes.

Although the file already exists, a task is included to generate it, which may be run with the command below.
This will output to the terminal. You may copy-paste or redirect it to a file, but check it first!

```bash
php oil r ccc -core -packages -without=tasks+migrations+vendor+tests+oil+orm+parser
```
