DROP DATABASE IF EXISTS crowdsource_website_db;

CREATE DATABASE crowdsource_website_db;

  use crowdsource_website_db;

  CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(100) NOT NULL,
    date TIMESTAMP
  );

  CREATE TABLE internalDatasets (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(5000) NOT NULL,
    tags VARCHAR(500),
    owner_id INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES users(id)
  );

  CREATE TABLE externalDatasets (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(5000) NOT NULL,
    tags VARCHAR(500) NOT NULL,     -- '+' seperated string of tags
    url VARCHAR(150) NOT NULL,
    web_source VARCHAR(30) NOT NULL, -- "Kaggle, ICS, Our Site"
    licenses VARCHAR(100) NOT NULL, -- space seperated string of each license
    infoKey1 VARCHAR(30), -- kaggle = usability rating  ics = number of rows
    infoValue1 VARCHAR(30),       --
    infoKey2 VARCHAR(30), -- kaggle = number of downloads  ics = number of columns
    infoValue2 VARCHAR(30)
  );

  CREATE TABLE userExternalDatasets (
    user_id INT NOT NULL,
    external_id INT NOT NULL,
    PRIMARY KEY(user_id, external_id)
  );

  CREATE TABLE userInternalDatasets (
    user_id INT NOT NULL,
    internal_id INT NOT NULL,
    PRIMARY KEY(user_id, internal_id)
  );
