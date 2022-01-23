-- Don't use these default values.  Create a user and update config.php accordingly.

CREATE USER 'dbuser'@localhost IDENTIFIED BY 'mypassword';
GRANT ALL privileges ON `player`.* TO 'dbuser'@localhost;
FLUSH PRIVILEGES;