# ccapi - cryptocurrency API 1.0 (develop branch)

### Requeriments

- Apache2 or another similar
- Composer
- Laravel 5.7
- Laravel requires PHP >= 7.1.3
- Laravel requires PHP Extensions: common, cli, mylsq,OpenSSL, PDO, Mbstring, XML, Ctype, JSON, BCMath
- Mysql 5.7
- Git

### Configuration (for UNIX, can be different for Windows or Apple)

> Virtual host configuration file content

```
<VirtualHost *:80>        
    ServerAdmin webmaster@localhost
    ServerName dev.cc
    DocumentRoot /home/zuljin/projects/ccapi/public
        
    <Directory />
        Options FollowSymLinks
        AllowOverride None
    </Directory>
        
    <Directory /home/zuljin/projects/ccapi/public>
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
```
> Add virtual host site to Apache following the next steps:

```
$ cd /etc/apache2/sites-available 
$ sudo vim ccapi.conf 
# copy paste Virtual host configuration file content in step 1
$ sudo a2ensite ccapi.conf 
$ sudo vim etc/hosts
# add a new line with: 
127.0.0.1 dev.cc
```
![alt text](https://media1.giphy.com/labs/images/laravel-wrapper.gif "Logo Title Text 1")

#### Laravel

- Please, download the project and use develop branch. Master branch is not maintained.
- Each command (php artisan) must be executed in the project folder

> Check <b>composer.json</b> file to install extra libraries used:

- <b>guzzle</b> for COINMARKETCAP API communication
- <b>carbon</b> to work with dates
- <b>laravel-iso8601-validator</b> specific validator for an isoiso8601 date
- <b>jwt-auth</b> to secure API
- <b>faker</b> to generate random users info (name, emails, etc..)

> Check <b>.env</b> file for <b>COINMARKETCAP_KEY</b>. Is my personal key, so, i will disable it in a few days.


> Run next command to generate tables:

```
$ php artisan migrate
```

> Populate tables in this order. We need cryptpcoins, some fake users, some cryptocoins historical movements and finally some user trades with coins. We will generate it with theses seeders <b>(more info inside each seeder)</b>:

```
$ php artisan db:seed --class=CryptocurrencyTableSeeder
$ php artisan db:seed --class=PopulateUsersTableSeeder          
$ php artisan db:seed --class=CryptocurrencyHistoricalTableSeeder
$ php artisan db:seed --class=PopulateUserTrade
```

> Using CCAPI and deal with JWT security

CCAPI is secured through a token, you can always use a master user test to obtain a token and use it in the requests, and copy-paste it in all requests:

<b>username:</b> saul.goodman
<b>password:</b> goodlawyer

<b>Recommendation</b>: Anyway, within the project, you have everything you need and automated to test it with <b>POSTMAN</b> with dynamic variables. JSON files are included in <b>postman folder</b>, you just need to import it. Then, when you call the <b>authenticate</b> endpoint, automatically the rest of endpoints will have assigned the Bearer token (jwt). Remember, before, to select <b>develop</b> enviroment variables in the top-right tab where you can read <b>no enviroment</b>. Any doubts, contact me!

> If you want to run tests, go terminal inside the project an execute:

```
$ ./vendor/bin/phpunit
```

<b>phpunit.xml</b> is an important file, also config/database.php because we force to write records not in really database, we use memory option




![alt text][logo]

[logo]: https://giphy.com/static/img/labs.gif "Logo Title Text 2"
