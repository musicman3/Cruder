# Cruder Query Builder

Project installation: `composer require musicman3/cruder`

The Cruder Project is a CRUD system for working with databases based on the Query Builder principle and using PDO. This project is primarily developed for the eMarket project: https://github.com/musicman3/eMarket

At the same time, the library is extracted into a separate project to allow anyone who likes Cruder to use it in their own projects.

The main advantages of this project are the small size of the library and its good performance. Additionally, Cruder initially checks all outgoing data for XSS injections. Since we use PDO, this allows us to eliminate SQL injections through built-in methods.

To start using Cruder, you need to initialize database settings. After initialization, you can perform CRUD operations. Upon completion of the work, you need to close the database connection. Here's an example of how it looks:

```php

use \Cruder\{
    Cruder,
    Pdo
};

// DB settings
Pdo::$set = [
        'db_type' => 'mysql',
        'db_server' => 'localhost',
        'db_name' => 'my_base',
        'db_username' => 'root',
        'db_password' => 'my_password',
        'db_prefix' => 'emkt_',
        'db_port' => '3306',
        'db_family' => 'innodb'
    ];

// Here we perform various actions that you will need for your project.
$this->db = new Cruder();

// Close DB connect
Pdo::connect('close');

```
There are various methods for working with a database. All of them are documented using PHPDoc and PHPDoc tags according to PSR-5 and PSR-19 standards. A call chain is used when forming a query. Here's an example of what it looks like:

```php

$this->db = new Cruder();

// Read (SELECT)
$id = $this->db
                ->read('my_table')
                ->selectAssoc('id')
                ->where('order >=', 5)
                ->orderByDesc('id')
                ->save();

// Create (INSERT INTO)
$this->db
         ->create('my_table')
         ->set('id', 10)
         ->set('order', 5)
         ->set('text', 'This is my text')
         ->save();

// Update
$this->db
         ->update('my_table')
         ->set('text', 'This is my new text')
         ->where('id =', 10)
         ->or('order >=' 5)
         ->save();

// Delete
$this->db
         ->delete('my_table')
         ->where('id =', 10)
         ->save();

// use DB-functions -> for example YEAR(date_created)
$data = $this->db
                ->read('my_table')
                ->selectAssoc('id, name, {{YEAR->date_created}}')
                ->where('{{YEAR->date_created}} =', '2021-04-21 20:38:40')
                ->orderByDesc('id')
                ->save();

// DB Install
$this->db->dbInstall('/full_path_to_db_file/db.sql', 'db_prefix');

// DROP TABLE
$this->db->drop('my_table')->save();

```
Using your own syntax to work with database functions allows you to use multiple types of databases simultaneously. For example, you can use MySQL or Postgres. New functions can always be added through the pattern located in the database adapter section. For MySQL, this pattern is located in `Mysql/DbFunctions->pattern()`.

All available methods can be viewed in the files CrudInterface.php or by viewing the description of these methods using tooltips in your IDE.

### PHP Standards Recommendations Used: 
  - PSR-1 (Basic Coding Standard)
  - PSR-4 (Autoloading Standard)
  - PSR-5 (PHPDoc Standard)
  - PSR-12 (Extended Coding Style Guide)
  - PSR-19 (PHPDoc tags)