## Getting Started

1. Clone this repo
1. Run composer.
   ```shell
    composer install
   ```
1. Run npm.
   ```shell
    npm install
    npm run watch
   ```
1. Create .env file based on env.example
1. Configure api project base url and request url in .env - see https://github.com/nurazimzahurin/interview-tri-e-marketing-project-2
1. Run artisan key:generate.
   ```shell
    php artisan key:generate
   ```
1. Run artisan serve.
   ```shell
    php artisan serve
   ```

## Features

This project will call api to generate n(user's input) number of unique random number of rows in db.
The performance and project flows is as below:
![image](https://user-images.githubusercontent.com/66508436/122061753-62b1e380-ce21-11eb-9f39-71c4d04a4a27.png)

