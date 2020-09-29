# Search location details using Zip Codes

This project uses an API to retrieve the location details for the zip code that was inputed
and stores the result in a database.

This works on Mac only

## Setup

Here are the steps to setup this project on your local machine

Valet requires macOS and Homebrew. Before installation, please make sure that no other programs
such as Apache or Nginx are binding to your local machine's port 80

1. Install or update Homebrew to the latest bersion using `brew update`
2. Install PHP 7.4 using Homebrew via `brew install php`
3. Install Composer
4. Install Valet with Composer via `Composer global require laravel/valet`. Make sure the
   `~/.composer/vendor/bin` directory is in your system's "Path"
5. Run the `valet install` command.
6. Run `brew install mysql@5.7` on the terminal
7. Start it with `brew services start mysql@5.7`
8. Create a new directory where you will keep the project at
9. cd into the directory and run `valet park`
10. Clone the repo into this directory
11. Create a database for this project
12. Go to .env file, change DB_DATABASE, DB_USERNAME, DB_PASSWORD AND ZIPCODEAPIKEY
13. cd into this directory and run `php artisan migrate`
