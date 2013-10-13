README
====

## What is ecDB

[ecDB.net](http://www.ecdb.net) is basically a place where you, as an electronics hobbyist (or professional) can add your own components 
to your personal database to keep track of what components you own, where they are, how many you own and so on. 

## Who and Why

ecDB is created by [Nils Fredriksson](http://nilsf.se) aka. ElectricMan, and designed by [Buildlog](http://buildlog.se). 

The reason I publish the code for [ecDB.net](http://www.ecdb.net) is that I simply don't have enough time, 
and my knowledge is not sufficient to develop [ecDB.net](http://www.ecdb.net) to the point I wish. Therefore 
I need help from the community to make [ecDB.net](http://www.ecdb.net) better!

## Contact and Discussion

* Twitter: [@ecDBnet](http://twitter.com/ecDBnet)
* Website: [www.ecDB.net](http://www.ecdb.net)
* IRC: [irc.freenode.net, #ecDB ](http://webchat.freenode.net?channels=ecdb)
* Github: [https://github.com/ElectricMan/ecDB](https://github.com/ElectricMan/ecDB)
* E-mail: [info@ecdb.net](mailto:info@ecdb.net)

## Release Information

This repo contains in development code for future releases. To download the
latest release please download a zip-file of this repo [here](https://github.com/ElectricMan/ecDB/archive/master.zip).

## Changelog and New Features

You can find a list of all changes in the [Github commits](https://github.com/ElectricMan/ecDB/commits/master).

## Documentation

Currently there is no documentation available. Please feel free to create it!

## Installation

- Either download the latest stable release from the [download page](https://github.com/ElectricMan/ecDB/downloads). Or download this git.
- Create a MySQL database.
- Import `ecdb_databse.sql` database structure to your MySQL-database.
- Insert your MySQL data in the configuration file, `include/mysql_connect.php`.
- **You are now set to go!** The default username is `demo` and password `demo`.

### Requirements

-  Web Server.
-  PHP Version 5.2.4 or above.
-  MySQL Version 5.0 or above.

## Contributing

ecDB is a community driven project and accepts contributions of code
and documentation from the community. These contributions are made in the form
of Issues or [Pull Requests](http://help.github.com/send-pull-requests/) on
the [ElectricMan ecDB repository](https://github.com/ElectricMan/ecDB) on GitHub.

Issues are a quick way to point out a bug. If you find a bug or documentation
error in ecDB then please check a few things first:

- There is not already an open Issue
- The issue has already been fixed (check the develop branch, or look for
  closed Issues)
- Is it something really obvious that you fix it yourself?

Reporting issues is helpful but an even better approach is to send a Pull
Request, which is done by "Forking" the main repository and committing to your
own copy. This will require you to use the version control system called Git.

One thing at a time: A pull request should only contain one change. That does
not mean only one commit, but one change - however many commits it took. The
reason for this is that if you change X and Y but send a pull request for both
at the same time, we might really want X but disagree with Y, meaning we
cannot merge the request. Using the Git-Flow branching model you can create
new branches for both of these features and send two requests.

## How-to Guide

There are two ways to make changes, the easy way and the hard way. Either way
you will need to [create a GitHub account](https://github.com/signup/free).

Easy way GitHub allows in-line editing of files for making simple typo changes
and quick-fixes. This is not the best way as you are unable to test the code
works. If you do this you could be introducing syntax errors, etc, but for a
Git-phobic user this is good for a quick-fix.

Hard way The best way to contribute is to "clone" your fork of ecDB to
your development area. That sounds like some jargon, but "forking" on GitHub
means "making a copy of that repo to your account" and "cloning" means
"copying that code to your environment so you can work on it".

-  Set up Git (Windows, Mac & Linux)
-  Go to the ecDB repo
-  Fork it
-  Clone your ecDB repo: git@github.com:<your-name>/ecDB.git
-  Checkout the "develop" branch At this point you are ready to start making
   changes. 
-  Fix existing bugs on the Issue tracker after taking a look to see nobody
   else is working on them.
-  Commit the files
-  Push your develop branch to your fork
-  Send a pull request http://help.github.com/send-pull-requests/

The Reactor Engineers will now be alerted about the change and at least one of
the team will respond. If your change fails to meet the guidelines it will be
bounced, or feedback will be provided to help you improve it.

Once the Reactor Engineer handling your pull request is happy with it they
will post it to the internal ecDB discussion area to be double checked by
the other Engineers and ecDB developers. If nobody has a problem with the
change then it will be merged into develop and will be part of the next
release.

## License

-  ecDB is licensed under a Creative Commons [Attribution-NonCommercial-ShareAlike 3.0 Unported License](http://creativecommons.org/licenses/by-nc-sa/3.0/).
-  The ecDB code is not allowed for public use, other than on [www.ecDB.net](http://www.ecdb.net). 
-  You are allowed to set up a private ecDB database for yourself, or whithin an organisation.

###### Parts of this readme originates from [CodeIgniter](https://github.com/EllisLab/CodeIgniter)