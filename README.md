# Search location details using ZIP Codes

This web app uses an API to retrieve the location details for the ZIP Code that was inputed
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
8. Run `composer install`
9. Go to .env.example, rename it to .env and set the values below

    - DB_DATABASE = laravel-zip
    - DB_USERNAME = root
    - DB*PASSWORD = *(leave empty)\_
    - ZIPCODEAPIKEY = Get latest key from http://www.zipcodeapi.com/API#zipToLoc

10. run `php artisan migrate`. This sets up the tables for the database that we created. The output should look like this
    ![alt text](https://github.com/LeonTan828/zip-details/blob/master/screenshots/migrate.png)
11. Open a browser, and type in `zip-details.test`. This web app should run in browser now

## Running Test

Running test is easy in Laravel Valet. Here are the steps to do so

1. cd into the project directory
2. Run `php artisan test`

The output should look like this
![alt text](https://github.com/LeonTan828/zip-details/blob/master/screenshots/runtest.png)

## Using the Web app

To use the web app, simply open a browser and type in the project name with `.test` at
the end

In this case, it would be `zip-details.test`

## Using the application

This is how the front page will look like
![alt text](https://github.com/LeonTan828/zip-details/blob/master/screenshots/runtest.png)

There are 2 functionality that this web app provides. You may access them by clicking on
any of the buttons

### Get ZIP Code Details

Clicking on _Get ZIP Code Details_ will bring you to a page that display the location
details of the ZIP Code that you submit
![alt text](https://github.com/LeonTan828/zip-details/blob/master/screenshots/zipdetails.png)

### Check ZIP Codes Match

Clicking on _Check ZIP Code Match_ will check if the 2 ZIP Codes that you enter are within the distance that you provided. If they are, it will proceed to display the location details
of the 2 ZIP Codes
![alt text](https://github.com/LeonTan828/zip-details/blob/master/screenshots/zipmatch.png)

## How it works

This web apps primarily gets the information from the API at http://www.zipcodeapi.com/API#zipToLoc. Once the ZIP Code details has been requested from the API, it will be stored in the database. Any subsequent request for details for the same ZIP Code will have the details pulled from the database, reducing the number of requests to be made to the API

As for ZIP Codes Match, it takes the 2 Zip codes and distance that was inputed and makes a request to the api at http://www.zipcodeapi.com/API#matchClose. If the ZIP Codes are within the range of the distance that the user gave, it will then display the details of both ZIP Codes, either by pulling the information from the API or the datase depending if the information already exists in the database or not
