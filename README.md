## Installation instructions

- Clone the repository to your machine
- Create a new MYSQL database 
- using Terminal / Command Prompt navigate to the project and then run "composer install"
- copy .env.example to .env
- open .env and find this line "DB_DATABASE=" and type in the database name you created on step 2
- provide you MYSQL username  and Password as well
- on the Terminal run "php artisan:key generate" and then follow with "php artisan migrate"
- inside the project "database/seeders" there's a seeder which adds 4 users in the db
- to seed these users run "php artisan db:seed --class=AdminUsers"
- now run the project by starting the artisan serve, run "php artisan serve"
- open your browser and navigate to "http://127.0.0.1:8000", click on login on the right side of the navbar 
- provide the login details from one of the users you seeded