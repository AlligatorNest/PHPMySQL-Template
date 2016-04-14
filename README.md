# PHPMySQL-Template
Project starter template

run localhost/assets/database/seed.php
to create and seed database. Will drop and create tables each time it is run.

# Use code below to create a virtual directory.
Add code below to bottom of httpd.conf file in C:\Program Files\xampp\apache\conf

Alias /sources "D:/sources"

```
<Directory "D:/sources">
	Options Indexes FollowSymLinks Includes ExecCGI
	AllowOverride All
	Order allow,deny
	Allow from all
	Require all granted
</Directory>
```


# Use Git Shell to clone project to local directory with this command
cd to destination directory. Then
git clone https://github.com/AlligatorNest/PHPMySQL-Template.git .
(Note period - include that.)


