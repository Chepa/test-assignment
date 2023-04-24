
## Test Assignment

Laravel 10 Vue 3 TypeScript Vite

`/resources/js/`

To working correctly, need to add in .env file new variables:

`VITE_BASE_URL` - the same as APP_URL

`OXFORD_API_BASE_URI` 

`OXFORD_APP_ID`

`OXFORD_APP_KEY`

### Usage
The project comes with a Docker image, that helps to initialize a web server, phpFpm, and necessary databases.

### Building
1) `docker-compose up --build` - build project environment
2) `docker-compose run php-fpm composer install` - install packages
3) `docker-compose run php-fpm php artisan migrate:refresh --seed` - migrating tables and populating default data
4) [visit webpage](http://127.0.0.1)

### Structure
 - `components` for single file components, common component
 - `models` for object interfaces
 - `pages` for parent components corresponding to pages on the site
 - `router` for routes by Vue-router
 - `use` for composable and helper functions

