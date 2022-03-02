DROP DATABASE IF EXISTS crowdsource_website_db;

CREATE DATABASE crowdsource_website_db;

  use crowdsource_website_db;

  CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    date TIMESTAMP
  );
