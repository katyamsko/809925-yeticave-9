create database YetiCave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE YetiCave;

CREATE TABLE category (
  id INT AUTO_INCREMENT primary key,
  name CHAR(128),
  code CHAR(128)
);
CREATE TABLE lot (
  id INT AUTO_INCREMENT primary key,
  lot_time TIMESTAMP,
  name CHAR(128),
  description TEXT,
  image CHAR(128),
  start_price INT,
  end_time TIMESTAMP NULL,
  step_rate INT,
  author_id INT,
  winner_id INT,
  category_id INT
);
CREATE TABLE rate (
  id INT AUTO_INCREMENT primary key,
  rate_time TIMESTAMP,
  price INT,
  user_id INT,
  lot_id INT
);
CREATE TABLE user (
  id INT AUTO_INCREMENT primary key,
  reg_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(128) NOT NULL UNIQUE,
  name CHAR(128),
  password CHAR(128),
  avatar CHAR(128),
  contacts TEXT,
  user_lot INT,
  user_rate INT
);

CREATE INDEX lot_name ON lot(name);
CREATE INDEX category_name ON category(name);
