# MagicMirror-Website

This is the source of the [MagicMirror Website](https://magicmirror.builders). 
Feel free to send Pull Request if you stumble into a typo, improved or new feature.


# Developement mode

If you are interested  contributing with some code, Thanks!


Clone this repository, take the following steps to get it up and running:

 * Run: `composer install`
 * Run `npm install`
 * Create an environment configuration: `cp .env.example .env`
 * Run `php artisan key:generate`
 * Modify the database and GitHub settings in the .env file. (You need to create a GitHub app for testing.)
 * Run php artisan migrate --seed to setup the database.
