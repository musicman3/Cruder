# Cruder Query Builder

### Project installation:
`composer require musicman3/cruder`

### System requirements: 
  - OS Unix, Linux or Windows
  - Apache Web Server >= 2.4 or Nginx >= 1.17
  - PHP >= 8.3
  - MySQL || MariaDB || PostgreSQL || SQLite

### PHP extensions and settings: 
  - pdo_mysql (for MySQL or MariaDB)
  - pdo_pgsql (for PostgreSQL)
  - pdo_sqlite (for SQLite)

The Cruder Project is a CRUD system for working with databases based on the Query Builder principle and using PDO. This project is primarily developed for the eMarket project: https://github.com/musicman3/eMarket

Cruder currently supports MySQL/MariaDB, Postgree, and SQLite databases. The syntax is the same for all databases, making it easy to switch between different database types on the fly.

At the same time, the library is extracted into a separate project to allow anyone who likes Cruder to use it in their own projects.

The main advantages of this project are the small size of the library and its good performance. Additionally, Cruder initially checks all outgoing data for XSS injections. Since we use PDO, this allows us to eliminate SQL injections through built-in methods.

To start using Cruder, you need to initialize database settings. After initialization, you can perform CRUD operations. Upon completion of the work, you need to close the database connection. Here's an example of how it looks:

```php

use \Cruder\Db;

// DB settings

    Db::config(
            [
                'mysql' =>
                [
                    'db_type' => 'mysql', // pgsql, sqlite
                    'db_server' => 'localhost', // optional, not required for sqlite
                    'db_name' => 'my_base',
                    'db_username' => 'root',
                    'db_password' => 'my_password',
                    'db_prefix' => 'emkt_',
                    'db_port' => '3306', // optional, not required for sqlite
                    'db_family' => 'innodb', // myisam, only for MySQL or empty
                    'db_charset' => 'utf8mb4', // only for MySQL or empty
                    'db_collate' => 'utf8mb4_unicode_ci', // only for MySQL or empty
                    'db_error_url' => '/my_error_page/?error_message=', // optional
                    'db_path' => 'localhost/storage/databases/sqlite.db3' // optional, path to SQLite DB
                ]
            ]
    );
Db::use('mysql');
Db::transactions('on'); //Transactions On

// Here we perform various actions that you will need for your project.
Db::connect()->read('my_table')
                ->selectAssoc('id')
                ->where('order >=', 5)
                ->orderByDesc('id')
                ->save();

// Close DB connect
Db::close();

```
There are various methods for working with a database. All of them are documented using PHPDoc and PHPDoc tags according to PSR-5 and PSR-19 standards. A call chain is used when forming a query. Here's an example of what it looks like:

```php

// Create (INSERT INTO)
Db::connect()
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->save();

// Read (SELECT)
$id = Db::connect()
                ->read('my_table')
                ->selectAssoc('id')
                ->where('order >=', 5)
                ->orderByDesc('id')
                ->save();

// Read with use LEFT JOIN
$data = Db::connect()
                ->read('customers')
                ->selectAssoc('customers.customer_id, customers.first_name, orders.amount')
                ->leftJoin('orders')
                ->on('customers.customer_id =', 'orders.customer')
                ->where('orders.amount >=', '500')
                ->save();

// Update
Db::connect()
         ->update('my_table')
         ->set('text', 'This is my new text')
         ->where('id =', 10)
         ->or('order >=' 5)
         ->save();

// Delete
Db::connect()
         ->delete('my_table')
         ->where('id =', 10)
         ->save();

// use DB-functions -> for example YEAR(date_created)
$data = Db::connect()
                ->read('my_table')
                ->selectAssoc('id, name, {{YEAR->date_created}}')
                ->where('{{YEAR->date_created}} =', '2021-04-21 20:38:40')
                ->orderByDesc('id')
                ->save();

// DB Install
Db::connect()->dbInstall('/full_path_to_db_file/db.sql', 'db_prefix');

// DROP TABLE
Db::connect()->drop('my_table')->save();

// Debug
Db::connect()
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->debug();

//Transactions On/Off
Db::transactions('off'); //Transactions Off

Db::connect()
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->debug();

Db::transactions('on'); //Transactions On

```
If you need to connect to another database, you must specify its settings and then return the previous settings after you have finished working with this database. This allows one project to use unlimited connections to different databases located on different servers.

```php
use \Cruder\Db;

Db::config(
            [
                'mysql' =>
                [
                    'db_type' => 'mysql', // pgsql, sqlite
                    'db_server' => 'localhost', // optional, not required for sqlite
                    'db_name' => 'my_base',
                    'db_username' => 'root',
                    'db_password' => 'my_password',
                    'db_prefix' => 'emkt_',
                    'db_port' => '3306', // optional, not required for sqlite
                    'db_family' => 'innodb', // myisam, only for MySQL or empty
                    'db_charset' => 'utf8mb4', // only for MySQL or empty
                    'db_collate' => 'utf8mb4_unicode_ci', // only for MySQL or empty
                    'db_error_url' => '/my_error_page/?error_message=', // optional
                    'db_path' => 'localhost/storage/databases/sqlite.db3' // optional, path to SQLite DB
                ],
                'sqlite' =>
                [
                    'db_type' => 'sqlite',
                    'db_name' => 'my_base',
                    'db_username' => 'root',
                    'db_password' => 'my_password',
                    'db_prefix' => 'emkt_',
                    'db_path' => 'localhost/storage/databases/sqlite.db3'
                ]
            ]
    );

//---------------------------------------------------------- MySQL

// MySQL DB settings
Db::use('mysql');
Db::transactions('on'); //Transactions On

// We execute queries to the master database
Db::connect()
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->save();

//---------------------------------------------------------- SQLite

// SQLite DB settings
Db::use('sqlite');
Db::transactions('on'); //Transactions On

//We execute queries to the slave database
Db::connect()
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->save();

//---------------------------------------------------------- MySQL

// MySQL DB settings
Db::use('mysql');
Db::transactions('on'); //Transactions On

// We execute queries to the master database
$id = Db::connect()
                ->read('my_table')
                ->selectAssoc('id')
                ->where('order >=', 5)
                ->orderByDesc('id')
                ->save();

// Close DB connect
Db::close();

```

Get current Cruder settings:
```php
Db::get()
```

A list of available database functions used in SQL queries (the basic functionality is identical to their MySQL counterparts). These functions operate identically across all supported databases, allowing you to perform specific actions within the SQL query. This reduces the burden on subsequent PHP processing in your project.

```
YEAR - similar to the YEAR(datetime) function in MySQL
MONTH - similar to the MONTH(datetime) function in MySQL
DAYOFWEEK - similar to the DAYOFWEEK(datetime) function in MySQL
DAY - similar to the DAY(datetime) function in MySQL
DAYOFYEAR - similar to the DAYOFYEAR(datetime) function in MySQL
QUARTER - similar to the QUARTER(datetime) function in MySQL
HOUR - similar to the HOUR(datetime) function in MySQL
UNIX_TIMESTAMP - similar to the UNIX_TIMESTAMP(datetime) function in MySQL
LIKE - similar to the LIKE function in MySQL
CAST AS CHAR - similar to the CAST(value AS CHAR) function in MySQL
MIN - similar to the MIN(value) function in MySQL
MAX - similar to the MAX(value) function in MySQL
COUNT - similar to the COUNT(column) function in MySQL

-----------------------------------------------------------------------
These functions in Cruder are identical for MySQL, Postgree and SQLite, 
so when changing the database on the fly, the result remains the same.
-----------------------------------------------------------------------

Syntax: {{YEAR->date_created}} - YEAR (function name), date_created (function argument)
```
Example
```php
$data = Db::connect()
                ->read('my_table')
                ->selectAssoc('id, name, {{YEAR->date_created}}')
                ->where('{{YEAR->date_created}} =', '2021-04-21 20:38:40')
                ->orderByDesc('id')
                ->save();

```

Using your own syntax to work with database functions allows you to use multiple types of databases simultaneously. For example, you can use MySQL or Postgres. New functions can always be added through the pattern located in the database adapter section. For MySQL, this pattern is located in `Mysql/DbFunctions->pattern()`.

All available methods can be viewed in the files CrudInterface.php or by viewing the description of these methods using tooltips in your IDE.

```php
create(string $table) - INSERT INTO
read(string $table) - SELECT
update(string $table) - UPDATE
delete(string $table) - DELETE FROM
readDistinct(string $table) - SELECT DISTINCT
drop(string $table) - DROP TABLE
---------------------------------------
set(string $identificator, mixed $value) - SET
where(string $identificator, mixed $value) - WHERE
and(string $identificator, mixed $value) - AND
or(string $identificator, mixed $value) - OR
on(string $identificator, mixed $value) - ON
using(string $identificator) - USING
as(string $identificator) - AS
limit(mixed $offset, mixed $limit) - LIMIT
offset(mixed $offset) - OFFSET
---------------------------------------
groupBy(string $identificator) - GROUP BY
orderBy(string $identificator) - ORDER BY
orderByDesc(string $identificator) - ORDER BY identificator DESC
orderByAsc(string $identificator) - ORDER BY identificator ASC
innerJoin(string $identificator) - INNER JOIN
leftJoin(string $identificator) - LEFT JOIN
----------------------------------------
Any other operator that you can specify yourself
operator(string $operator, string $identificator, mixed $value)
----------------------------------------
selectAssoc(string $identificator) - Get associated array
selectIndex(string $identificator) - Get an indexed array
selectValue(string $identificator) - Get value
selectObj(string $identificator) - Get object
selectColCount(string $identificator) - Count the number of columns
selectRowCount(string $identificator) - Count the number of rows
lastInsertId() - Last Insert ID
----------------------------------------
save() - Query Termination Operator. Terminates a query chain.
debug() - If set instead of save(), the SQL query string will be output 
to the browser and then the save() method will be executed.
----------------------------------------
dbInstall(string $path, string $db_prefix = 'emkt_') - Install DB-file (.sql)
exec(string $data) - PDO exec() operator

```

### PHP Standards Recommendations Used: 
  - PSR-1 (Basic Coding Standard)
  - PSR-4 (Autoloading Standard)
  - PSR-5 (PHPDoc Standard)
  - PSR-12 (Extended Coding Style Guide)
  - PSR-19 (PHPDoc tags)
