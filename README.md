<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://previews.123rf.com/images/yupiramos/yupiramos1509/yupiramos150904651/44820326-pet-shop-dise%C3%B1o-ilustraci%C3%B3n-vectorial-eps-10-.jpg" width="400"></a></p>

## Overview 

This project is written with PHP Laravel Framework. The framework is made for writting super API endpoints. It implements JSON Web Token for user  Authentication. Please take a look at  [JWT](https://jwt.io/). 
## Installation & Usage
<hr/>

### Downloading the Project


This framework requires PHP 8.0 and mysql database
.  
You can simply clone  `` pet-shop-api`` like below on your git bash

```bash
git clone https://github.com/angwa/pet-shop-api.git
```
After cloning the project, please run this command on the project directory
```
composer update
```
### Configure Environment
To run the application you must configure the ```.env``` environment file with your database details and mail configurations. Use the following directly if you are running the application on docker.

```
DB_CONNECTION=mysql
DB_HOST=petshop_db
DB_PORT=3306
DB_DATABASE=petshop_db
DB_USERNAME=root
DB_PASSWORD=secret

MAIL_DRIVER=smtp
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=//replace your email credentials
MAIL_PASSWORD=//replace your email credentials
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@pet_shop.test
MAIL_FROM_NAME="${APP_NAME}"

JWT_SECRET=

```
### Clearing Cache and Generating key
Run the following commands either on the project directory or on the docker container ```petshop_api```
```
php artisan optimize
php artisan key:generate
php artisan jwt:secret
```
Run the following command at this stage to run database migrations
```
php artisan migrate
```

If you are using docker you can ssh into the container like below
```
docker exec -it petshop_api bash
```
The above command will ssh you into the container to run the commands to clear cache and generate keys for your application  too.

### Note
If you dont use docker, please type ```php artisan serve```  on the project directory to start your application
### Running with  Docker
To run this application on docker container, run the following command on the project directory
```
docker-compose build
```
Wait for the application's image to be built completely on docker then run
```
docker-compose up
```

And your application should be live for test on the following 

If you use docker.

[http://127.0.0.1:8088/api/documentation]( http://127.0.0.1:8088/api/documentation) 

If you are not using docker 

[http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation)

## Note
If you run into error, run the command either on the directory or on your docker container
``` 
php artisan optimize
```

## Testing

To run test test, type the following on the project directory

``` bash
php artisan test
```

## Seeding DB
Once your database is correctly installed, you can seed your database by running
```
php artisan db:seed
```

There is a cron job that truncate and reseed database every day at midnight. It can be triggered by running
``` 
php artisan seeders:regenerate
```

## Security

If you discover any security related issues, please email angwamoses@gmail.com instead of using the issue tracker.

## Credits

- [Angwa Moses](https://github.com/angwa)


