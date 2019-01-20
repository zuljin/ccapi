ccapi

cryptocurrency API example 1.0

-----
0) CREAR LAS TABLAS!!
1) VER el tema de modelos CORE
2) VER el tema de las interfaces para DDD
3) VER como testear una tabla MYSQL
4) VER como hacer una paginacion bien chula! 
https://laravel.com/docs/5.7/pagination
https://laravel.com/docs/5.7/eloquent-resources
5) REVISAR vendors (jwt, cors)
6) Generate random users

# Requeriments Steps

# Configurations Steps


# Laravel Steps

1) Generate tables

$ php artisan migrate

2) Populate tables in exactle this order

$ php artisan db:seed --class=CryptocurrencyTableSeeder
$ php artisan db:seed --class=PopulateUsersTableSeeder
$ php artisan db:seed --class=CryptocurrencyHistoricalTableSeeder

3) Using CCAPI. JWT security

CCAPI is secured through a token, you can always use the test user to obtain a token and use it in the requests:

username: saul.goodman
password: goodlawyer

Recommendation: POSTMAN with dynamic variables. JSON files with endpoints and variables are included in the repository. From POSTMAN you can call the
AUTH endpoint and automatically the endpoints will have assigned the JWT token. Remember to select 'develop' enviroment variables in the top-right tab.


Requeriments


APACHE - Virtual host configuration file content and Steps

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

# Possible values include: debug, info, notice, warn, error, crit,
# alert, emerg.
LogLevel warn

CustomLog ${APACHE_LOG_DIR}/ccapi-access.log combined

add virtual host site to Apache steps:

$ cd /etc/apache2/sites-available $ sudo vim ccapi.conf (copy paste virtual host configuration) $ sudo a2ensite ccapi.conf $ sudo vim etc/hosts

add a new line with: 127.0.0.1 dev.cc
DATA STRUCTRUE EXAMPLES

Coin { "id": 2, "name": "Ethereum", "symbol": "ETH", "logo": null, "rank": 2, "price_usd": "719.98600000", "price_btc": "0.07797240", "24h_volume_usd": 3014730000, "market_cap_usd": 71421998446, "available_supply": 99199149, "total_supply": 99199149, "percent_change_1h": "0.28000000", "percent_change_24h": "5.52000000", "percent_change_7d": "14.58000000", "created_at": "2018-05-03T08:54:02+00:00", "updated_at": "2018-05-03T08:54:02+00:00" }

Historical { "price_usd": "2962.04162456", "snapshot_at": "2018-04-03T10:54:02+00:00" }

Individual Trade { "coin_id": 2, "user_id": 1, "amount": "-2.2183", "price_usd": "675.982", "total_usd": -1499.5308706, "notes": null, "id": 3, "created_at": "2018-05-03T09:00:07+00:00", "updated_at": "2018-05-03T09:00:07+00:00", "traded_at": "2018-04-20T16:40:51+00:00" }

Grouped Trades { "coin_id": 2, "amount": "-11.09150000", "price_usd": "-7497.65435300" }
ENDPOINTS

Get the list of coins GET /coins

    Request
        Headers Accept: 'application/json'
        Body { "page": 1 }

    Response 200 { "coins": { "total": 100, "per_page": 25, "current_page": 1, "last_page": 4, "first_page_url": "http://dev.cryptos.com/coins?page=1", "last_page_url": "http://dev.cryptos.com/coins?page=4", "next_page_url": "http://dev.cryptos.com/coins?page=2", "prev_page_url": null, "path": "http://dev.cryptos.com/coins", "from": 1, "to": 25, "data":[ { // Coin Object }, { // Coin Object }, ... ] } } Get a coin details GET /coins/{coin_id}

    Parameters
        coin_id (number) - Coin ID

    Request
        Headers Accept: 'application/json'

    Response 200 { "coin": { // Coin Object } }

    Response 404 { error: "Coin {coin_id} not found" } Get a coin historical GET /coins/{coin_id}/historical

    Parameters
        coin_id (number) - Coin ID

    Request
        Headers Accept: 'application/json'

    Response 200 { "historical": [ { // Historical Object }, ... ] }

    Response 404 { error: "Coin {coin_id} not found" } Get authed user portfolio GET /portfolio

    Request
        Headers Accept: 'application/json' Authorization: Basic richard@rich.com:secret

    Response 200 { coins: [ { coin_id: int, amount: float, price_usd: float }, ... ] }

    Response 401 Unauthorized Store a new trade in the authed user portfolio POST /portfolio

    Request

        Headers Accept: 'application/json' Authorization: Basic richard@rich.com:secret

        Body { coin_id: int amount: float, (could be negative) price_usd: float, traded_at: date, ('2018-04-20T16:40:51.620Z', Iso8601) notes: 'I want that lambo!' (optional) }

    Response 200 { trade: { "coin_id": "2", "user_id": 1, "amount": "-2.2183", "price_usd": "675.982", "total_usd": -1499.5308706, "notes": null, "traded_at": "2018-04-20T16:40:51+00:00", "updated_at": "2018-05-03T09:08:26+00:00", "created_at": "2018-05-03T09:08:26+00:00", "id": 5 } }

    Response 400 { coin_id: [ "The coin id field is required.", "The selected coin id is invalid." ], amount: [ "The amount field is required.", "The amount must be a number." ], price_usd: [ "The price usd field is required.", "The price usd must be a number.", "The price usd must be at least 0." ], traded_at: [ "The traded at field is required.", "The traded at must be a date before 2018-05-03T09:14:39+00:00." ] }

    Response 401 Unauthorized