# cmdb-app

A contact management database (from 2008)

Half-finished and desperately in need of a rewrite. What would this look like in 2018?

## How to run

From the project root, run `docker-compose up -d`.

After containers are running, navigate to http://localhost:8080

## Notes

A .gitignore'd file in root (\_db.php) is required by PHP pages needing a database connection, here's an example:

```php
<?php
  $hostname="mysql";
  $username="cmdb_user";
  $password="cmdb_password";
  $dbname="cmdb";

  $connection = mysql_connect($hostname, $username, $password);
  $db_select = mysql_select_db($dbname);
?>
```


