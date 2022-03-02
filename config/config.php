<?php

/**
  * Configuration for database connection
  *
  */

$host       = "127.0.0.1";
$username   = "db_admin";
$password   = "password";
$dbname     = "crowdsource_website_db";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
