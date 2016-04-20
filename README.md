# PHPMySQL-Template
Project starter template (using xampp and MySql)

Step 1: Environment
* create a directory for project. For example: c:/xampp/apps/newsite
* create an empty database for project

Use code below to create a virtual directory.
Add code below to bottom of httpd.conf file in C:\Program Files\xampp\apache\conf
```
Alias /survey "C:/xampp/apps/survey"

<Directory "C:/xampp/apps/survey">
	Options Indexes FollowSymLinks Includes ExecCGI
	AllowOverride All
	Order allow,deny
	Allow from all
  	Require all granted
</Directory>
```
Note: you will need to restart Apache after making this change

Step 2: Use Git Shell to clone project to local directory with this command
```
cd to destination directory. Then
git clone https://github.com/AlligatorNest/PHPMySQL-Template.git .

(Note period - include that.)
```

Step 3: Publish new project to GitHub
* use git hub desktop
* select create
* Specify Local Path
* Give the repository a name
* publish it using same name as above
* use git hub desktop
* Project now has a corresponding repository on Git Hub

Step 3: Set database variables in 
* localhost/assets/includes/global.php

Step 4: Define database tables and seed data
* resetdemo.php 

Step 5: run localhost/resetdemo.php
* this will create and seed database. 
* will drop / create / seed each time it is run.









