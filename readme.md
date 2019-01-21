ccapi

cryptocurrency API example 1.0

-----
2) VER el tema de las interfaces para DDD
3) VER como testear una tabla MYSQL
4) VER como hacer una paginacion bien chula! 
https://laravel.com/docs/5.7/pagination
https://laravel.com/docs/5.7/eloquent-resources
5) REVISAR vendors (jwt, cors)

# Requeriments Steps

    - Laravel 5.7

# Configurations Steps  (for UNIX, can be different for Windows or Apple)

1) Virtual host configuration file content:

    <VirtualHost *:80>
        
        ServerAdmin webmaster@localhost
        ServerName dev.cc
        DocumentRoot /home/zuljin/projects/ccapi
        
        <Directory />
            Options FollowSymLinks
            AllowOverride None
        </Directory>
        
        <Directory /home/zuljin/projects/ccapi>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride None
            Order allow,deny
            allow from all
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/ccapi-error.log
        CustomLog ${APACHE_LOG_DIR}/ccapi-access.log combined

        # Possible values include: debug, info, notice, warn, error, crit, alert, emerg.
        LogLevel warn
        
    </VirtualHost>
    add virtual host site to Apache steps:

2) Follow the next steps:

$ cd /etc/apache2/sites-available 
$ sudo vim ccapi.conf 
    Copy paste Virtual host configuration file content in step 1
$ sudo a2ensite ccapi.conf 
$ sudo vim etc/hosts
    Add a new line with: 
    127.0.0.1 dev.cc

# Laravel Steps

1) Check composer.json to install libraries dependencies like guzzle, carbon, jwt, etc...
   Check .env for COINMARKETCAP_KEY (my personal key, i will disable in a couple of days)

2) Generate tables

$ php artisan migrate

3) Populate tables in this order. We need Cryptocoins, some fake users, some Cryptocoins historical movements and finally son user trades with coins:

$ php artisan db:seed --class=CryptocurrencyTableSeeder             OK
$ php artisan db:seed --class=PopulateUsersTableSeeder              OK
$ php artisan db:seed --class=CryptocurrencyHistoricalTableSeeder   OK
$ php artisan db:seed --class=PopulateUserTrade

4) Time to run tests if you want. Go terminal inside project an execute:

$ ./vendor/bin/phpunit

5) Using CCAPI. JWT security

CCAPI is secured through a token, you can always use the a master test user to obtain a token and use it in the requests:

username: saul.goodman
password: goodlawyer

Recommendation: POSTMAN with dynamic variables. JSON files with endpoints and variables are included in the repository. From POSTMAN you can call the AUTH endpoint and automatically the endpoints will have assigned the JWT token. Remember to select 'develop' enviroment variables in the top-right tab. Chech POSTMAN folder attached.