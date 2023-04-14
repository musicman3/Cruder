# Cruder Query Builder
The Cruder Project is a CRUD system for working with databases based on the Query Builder principle and using PDO. This project is primarily developed for the eMarket project: https://github.com/musicman3/eMarket

At the same time, the library is extracted into a separate project to allow anyone who likes Cruder to use it in their own projects.

The main advantages of this project are the small size of the library and its good performance. Additionally, Cruder initially checks all outgoing data for XSS injections. Since we use PDO, this allows us to eliminate SQL injections through built-in methods.

To start using Cruder, you need to initialize database settings. After initialization, you can perform CRUD operations. Upon completion of the work, you need to close the database connection. Here's an example of how it looks:

```php

<?php 

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
        'db_family' => 'myisam'
    ];

$this->db = new Cruder();

// Close DB connect
Pdo::connect('close');

?>

```
There are various methods for working with a database. All of them are documented using PHPDoc and PHPDoc tags according to PSR-5 and PSR-19 standards. A call chain is used when forming a query. Here's an example of what it looks like:

```php

<?php 

$this->db = new Cruder();
$id = $this->db
                ->read('my_table')
                ->selectGetValue('id')
                ->where('order >=', 5)
                ->orderByDesc('id')
                ->save();

?>

```
All available methods can be viewed in the file CrudInterface.php or by viewing the description of these methods using tooltips in your IDE.