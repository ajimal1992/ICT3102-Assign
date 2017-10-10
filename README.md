# ICT3102 Assignment
This project was taken from an Assignment done on module ICT1004
## SQL file
I have modified the `shawdb.sql` file found in the repository to pretty much do everything for easy-install:
- Creates a database with name `shawdb`
- Creates a user with name `shawread` and password `12345678`
- Creates relevant tables and populates data
## Pre-installation
- Ensure xampp is installed on your operating system with Apache and mySQL server
## Installation
1. Browse to your `htdocs` folder and clone this repository into there 
    - `git clone https://github.com/ajimal1992/ICT3102-Assign.git`
2. Open the Xampp control panel and start the Apache and MySQL webserver
3. Browse to myphpadmin panel - http://localhost/phpmyadmin/
4. Click `Import`
5. Click `Browse...`
6. Browse to `shawdb.sql` found in this repository
7. Click `Go` - All imported queries should be successful
8. Browse to index page - http://localhost/ICT3102-Assign/index.php
9. Browse to admin page - http://localhost/ICT3102-Assign/admin.php
    - Username: `admin`
    - Password: `mypass`
