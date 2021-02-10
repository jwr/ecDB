README
====

## ecDB and PartsBox

ecDB, or Electronics Component DataBase, is a project that was created by [Nils Fredriksson](http://nilsf.se) aka. ElectricMan, and designed by [Buildlog](http://buildlog.se).

In May 2018 ecDB.net was acquired by PartsBox (https://partsbox.com/) and users of the online ecDB service were offered to upgrade/migrate their data.

PartsBox is an online app that lets you take control of your electronic parts inventory, BOM pricing, and small-scale production. It keeps track of where components are stored, what the current stock levels are, and which components are used in which projects/BOMs. PartsBox significantly expands what ecDB offered, with lots of new features and a blazingly fast parts search. It is available commercially (with features like BOM pricing, barcode scanning, sub-assemblies, file uploads and lots more), but there is also a free hobbyist/maker version, with everything the hobbyist needs.

PartsBox lets you export everything you entered, anytime. Data export is a fundamental feature: export a JSON data file with a single click.

## ecDB Source Code

While the ownership of ecDB was transferred to PartsBox, there is no intention of pulling the code from the Internet. It will continue to remain freely available for anyone that wishes to build on it, or run their own ecDB instance. This repository will remain public and accessible.

## Support

Please note that this code is unsupported. Please do not try to file issues or issue pull requests, as we have no resources to deal with them.

## Documentation

Currently there is no documentation available. Please feel free to create it!

## Installation

- Check out the git repository.
- Create a MySQL database.
- Import `ecdb_databse.sql` database structure to your MySQL-database.
- Insert your MySQL data in the configuration file, `include/mysql_connect.php`.
- **You are now set to go!** The default username is `demo` and password `demo`.

### Requirements

-  Web Server.
-  PHP Version 5.2.4 or above.
-  MySQL Version 5.0 or above.

## License

-  ecDB is licensed under a Creative Commons [Attribution-NonCommercial-ShareAlike 3.0 Unported License](http://creativecommons.org/licenses/by-nc-sa/3.0/).
-  The ecDB code is not allowed for public use.
-  You are allowed to set up a private ecDB database for yourself, or whithin an organisation.
