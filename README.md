Breaking Stack
=========
This is a webb app build with the help of Anax-MVC as a result of the project in the course phpmvc. It focuses on the tv-series Breaking Bad.

Installation
----------------------------------------
Download as .zip or clone the repo. After you have made the database writable it should all be working. The database is located in webroot/database.
If you want to start with a fresh database, go ahead and erase all the data in the database and just keep the tables as is. 

You have to fiddle with the .htacces-file and the RewriteBase to get Breaking Stack to work locally. Change the row:
```
RewriteBase /~dave14/phpmvc/kmom10/webroot/
```
to:
```
# RewriteBase /~dave14/phpmvc/kmom10/webroot/
``
