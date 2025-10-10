# Cruder Query Builder

Project installation: `composer require musicman3/cruder`

### System requirements: 
  - OS Unix, Linux or Windows
  - Apache Web Server >= 2.4 or Nginx >= 1.17
  - PHP >= 8.2
  - MySQL || MariaDB || PostgreSQL || SQLite

### PHP extensions and settings: 
  - pdo_mysql (for MySQL or MariaDB)
  - pdo_pgsql (for PostgreSQL)
  - pdo_sqlite (for SQLite)

The Cruder Project is a CRUD system for working with databases based on the Query Builder principle and using PDO. This project is primarily developed for the eMarket project: https://github.com/musicman3/eMarket

At the same time, the library is extracted into a separate project to allow anyone who likes Cruder to use it in their own projects.

The main advantages of this project are the small size of the library and its good performance. Additionally, Cruder initially checks all outgoing data for XSS injections. Since we use PDO, this allows us to eliminate SQL injections through built-in methods.

To start using Cruder, you need to initialize database settings. After initialization, you can perform CRUD operations. Upon completion of the work, you need to close the database connection. Here's an example of how it looks:

```php

use \Cruder\Db;

// DB settings
Db::set([
        'db_type' => 'mysql', // pgsql, sqlite
        'db_server' => 'localhost',
        'db_name' => 'my_base',
        'db_username' => 'root',
        'db_password' => 'my_password',
        'db_prefix' => 'emkt_',
        'db_port' => '3306',
        'db_family' => 'innodb', // myisam
        'db_charset' => 'utf8mb4',
        'db_collate' => 'utf8mb4_unicode_ci',
        'db_error_url' => '/my_error_page/?error_message=' // optional
    ]);

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

```
If you need to connect to another database, you must specify its settings and then return the previous settings after you have finished working with this database. This allows one project to use unlimited connections to different databases located on different servers.

```php
use \Cruder\Db;

// DB settings
Db::set([
        'db_type' => 'mysql', // pgsql, sqlite
        'db_server' => 'localhost',
        'db_name' => 'my_base',
        'db_username' => 'root',
        'db_password' => 'my_password',
        'db_prefix' => 'emkt_',
        'db_port' => '3306',
        'db_family' => 'innodb', // myisam
        'db_charset' => 'utf8mb4',
        'db_collate' => 'utf8mb4_unicode_ci',
        'db_error_url' => '/my_error_page/?error_message=' // optional
    ]);

// We execute queries to the master database

Db::connect()
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->save();

// Close DB connect
Db::close();

$masterDB = Db::set; // Save master settings

// Creating settings for a new database (SQLite)

$slaveDB = [
        'db_type' => 'sqlite',
        'db_name' => 'my_base',
        'db_username' => 'root',
        'db_password' => 'my_password',
        'db_prefix' => 'emkt_',
        'db_path' => 'localhost/storage/databases/sqlite.db3'
    ];

//Save settings
Db::set($slaveDB);

//We execute queries to the slave database

Db::connect()
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->save();

// Close DB connect
Db::close();

//Returning to master settings
Db::set($masterDB);

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

A list of available database functions used in SQL queries (the basic functionality is identical to their MySQL counterparts). These functions operate identically across all supported databases, allowing you to perform specific actions within the SQL query. This reduces the burden on subsequent PHP processing in your project.

```
YEAR, MONTH, DAYOFWEEK, DAY, DAYOFYEAR, QUARTER, HOUR, UNIX_TIMESTAMP, LIKE, CAST AS CHAR, MIN, MAX
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
create(string $table) - analog INSERT INTO
read(string $table) - analog SELECT
update(string $table - analog UPDATE
delete(string $table) - analog DELETE FROM
readDistinct(string $table) - analog SELECT DISTINCT
drop(string $table) - analog DROP TABLE
---------------------------------------
set(string $identificator, mixed $value) - SET Column
where(string $identificator, mixed $value) - WHERE operator
and(string $identificator, mixed $value) - AND operator
or(string $identificator, mixed $value) - OR operator
as(string $identificator) - AS operator
---------------------------------------
groupBy(string $identificator) - analog GROUP BY
orderBy(string $identificator) - analog ORDER BY
orderByDesc(string $identificator) - analog ORDER BY identificator DESC
orderByAsc(string $identificator) - analog ORDER BY identificator ASC
limit(mixed $offset, mixed $limit) - analog LIMIT (a,b)
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
----------------------------------------
dbInstall(string $path, string $db_prefix = 'emkt_') - Install DB-file
exec(string $data) - PDO exec() operator

```

### PHP Standards Recommendations Used: 
  - PSR-1 (Basic Coding Standard)
  - PSR-4 (Autoloading Standard)
  - PSR-5 (PHPDoc Standard)
  - PSR-12 (Extended Coding Style Guide)
  - PSR-19 (PHPDoc tags)
