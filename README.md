# Cruder
CRUD Query Builder with PDO

The Cruder Project is a CRUD system for working with databases based on the Query Builder principle and using PDO. This project is primarily developed for the eMarket project: https://github.com/musicman3/eMarket

At the same time, the library is extracted into a separate project to allow anyone who likes Cruder to use it in their own projects.

The main advantages of this project are the small size of the library and its good performance. Additionally, Cruder initially checks all outgoing data for XSS injections. Since we use PDO, this allows us to eliminate SQL injections through built-in methods.