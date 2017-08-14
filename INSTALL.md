# Installation instructions

Installing ecDB requires following steps:
* get the code
* install dependencies
* setup mysql database
* setup web server

## Getting the code

:point_right: this installation instruction expects files to be extracted into /var/www/ecdb folder.

Download [latest ZIP file](https://github.com/petslane/ecDB/archive/master.zip) and extract to desired folder
```bash
wget https://github.com/petslane/ecDB/archive/master.zip
unzip master.zip -d ecdb
```
or do git clone
```bash
git clone https://github.com/petslane/ecDB.git
```

## Installing dependencies

:point_right: Dependencies are handled by [Composer](https://getcomposer.org/) and expects it's already installed. If not, [here](https://getcomposer.org/download/) is how to do it.

Install dependencies with Composer:
```bash
composer install
```
## Setup MySQL database

Start MySQL command-line tool and connect to db server with admin user:
```bash
mysql -u admin_user -p
```

In MySQL cli tool, create database:
```bash
mysql> CREATE DATABASE ecdb;
```

create new user:
```bash
mysql> CREATE USER 'ecdb'@'localhost' IDENTIFIED BY 'some_strong_password';
```

grant user access to `dcdb` database:
```bash
mysql> GRANT ALL PRIVILEGES ON ecdb.* TO 'ecdb'@'localhost';
```

## Setup web server

### Apache

Example apache configuration can be found in `config/apache.conf`. ecDB uses rewrite rules and `AllowOverride` must be
allowed. If you want to ecDB be accessible from base path (eg. http://domain/myecdb/), then configure `RewriteBase` to
specify base path in `htdocs/.htaccess`.

### PHP built-in server

PHP built-in server is supported. Run following command to start webserver on localhost with port 8888:
```bash
php -S localhost:8888 -t htdocs htdocs/index.php
```
If you want to start server on port 80 (or any port below 1024), then change "8888" appropriately and run this command with root privileges.

# Configurations

On first install MySQL must be configured. Got to file `config/config.php` and make appropriate changes in `$confg['db']`.

Rest of configs are optionals and should work as is.

In case Apache web server was used and ecDB was installed under subpath, then `RewriteBase` must be configured in `.htdocs/.htaccess`.

