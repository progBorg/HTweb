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
Get the latest release of PHP 7.4 on your device, preferably using your system's package manager. For detailed instructions, please refer to the [PHP Installation Manual](https://www.php.net/manual/en/install.php).

### Composer
Get the latest release of Composer on your device, preferably using your system's package manager. For detailed instructions, please refer to the [Composer Installation Manual](https://getcomposer.org/doc/00-intro.md).

### FuelPHP
Browse to the root of the project (where the `composer.json` file lives).
Download and install FuelPHP using `composer update`.

## Configuration
Configuration files reside in the `fuel\app\config` directory.
Be sure to enter your database credentials in the `db.php` file.
For production environments, please be sure to configure and update the salts in both `auth.php` and `ormauth.php` as well.

## Migrations
Run all migrations. Please note there's a strict order in which to run migrations:
1. auth tables and others: `oil r migrate --packages=auth` 
3. session tables: `oil r migrate --modules=sessions`
   - (some other modules depend on sessions' functionality)
4. all other migrations: `oil r migrate --all`

## Run it
Oil has a built-in web server. Run the server using `oil s`
