
# Student Management System - SMP
A Laravel Application With React Frontend


# Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.6/installation#installation)


Clone the repository
Generate a new application key

    php artisan key:generate

Generate JWT Secret

    php artisan jwt:secret

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeders

    php artisan db:seed

Install the javascript dependencies using npm(node v8.10, npm v5.6)

    npm install

Compile the dependencies

    npm run dev
   
Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**Command list**

    git clone https://github.com/bvipul/student-management-system.git
    cd student-management-system
    cp .env.example .env
    composer install
    npm install
    npm run dev
    php artisan key:generate
    php artisan jwt:secret
    php artisan migrate
    php artisan db:seed
    php artisan serve

## Logging In

`php artisan db:seed` adds two users. The credentials are as follows:

* Administrator: `admin@admin.com`
* Student: `student@student.com`

Password: `password`
