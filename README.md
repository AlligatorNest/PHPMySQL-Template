# PHPMySQL-Template
Project starter template

Step 1: Environment
* create a virtual directory for project
* create an empty database for project

Use code below to create a virtual directory.
Add code below to bottom of httpd.conf file in C:\Program Files\xampp\apache\conf
```
Alias /sources "D:/sources"

<Directory "D:/sources">
	Options Indexes FollowSymLinks Includes ExecCGI
	AllowOverride All
	Order allow,deny
	Allow from all
	Require all granted
</Directory>
```

Step 2: Use Git Shell to clone project to local directory with this command
```
cd to destination directory. Then
git clone https://github.com/AlligatorNest/PHPMySQL-Template.git .

(Note period - include that.)
```

Step 3: Set database variables in 
* localhost/assets/includes/global.php

Step 4: Define database tables and seed data
* resetdemo.php 

Step 5: run localhost/resetdemo.php
* this will create and seed database. 
* will drop / create / seed each time it is run.









