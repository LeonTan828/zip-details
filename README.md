# Search location details using Zip Codes

This web app uses an API to retrieve the location details for the zip code that was inputed
and stores the result in a database.

Since this web app is built using Laravel Valet, this web app only works on Mac.
This is because Valet only supports Mac

## Setup

Here are the steps to setup this web app on your local machine

Valet requires macOS and Homebrew. Before installation, please make sure that no other programs
such as Apache or Nginx are binding to your local machine's port 80

### Setting up Laravel Valet

1. Install and setup Laravel Valet by following the instructions under **Installation** and **Database** of [this](https://laravel.com/docs/8.x/valet) document

### Setting up the database

2. Download Sequel Pro [here](https://sequelpro.com)
3. Connect to SQL by setting
    - Host = 127.0.0.1
    - username = root
    - password = (empty)
4. On Sequel Pro, create a new database and call it _laravel-zip_

### Setting up the web app

5. Go back to terminal, create a directory where you will clone the repo into
6. cd into the directory and run `valet park`. Now every Valet project that are saved in this directory will be recognized and run by Valet
7. Clone the repo into this directory and cd into the project
8. Go to .env.example, rename it to .env and set the values below
    - DB_DATABASE = laravel-zip
    - DB_USERNAME = root
    - DB*PASSWORD = *(leave empty)\_
    - ZIPCODEAPIKEY = Get latest key from http://www.zipcodeapi.com/API#zipToLoc
9. run `php artisan migrate`. This sets up the tables for the database that we created
10. Open a browser, and type in `zip-details.test`. This web app should run in browser now

## Running Test

Running test is easy in Laravel Valet. Here are the steps to do so

1. cd into the project directory
2. Run `php artisan test`

## Using the Web app

To use the web app, simply open a browser and type in the project name with `.test` at
the end

In this case, it would be `zip-details.test`

## Using the application

This is how the front page will look like

There are 2 functionality that this web app provides. You may access them by clicking on
any of the buttons

### Get Zip Code Details

Clicking on _Get Zip Code Details_ will bring you to a page that display the location
details of the zip code that you submit

### Check Zip Code Match

Clicking on _Check Zip Code Match_ will check if the 2 zip codes that you enter are within the distance that you provided. If they are, it will proceed to display the location details
of the 2 zip codes

## Design choice
