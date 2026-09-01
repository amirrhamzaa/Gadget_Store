CREATE DATABASE IF NOT EXISTS gadget_store;
USE gadget_store;

CREATE TABLE IF NOT EXISTS cart (
  id int(11) NOT NULL AUTO_INCREMENT,
  product_name varchar(100) NOT NULL,
  quantity int(11) NOT NULL DEFAULT 1,
  added_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  description text NOT NULL,
  status varchar(20) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS orders (
  id int(11) NOT NULL AUTO_INCREMENT,
  customer_name varchar(100) DEFAULT NULL,
  product_name varchar(255) DEFAULT NULL,
  quantity int(11) DEFAULT NULL,
  price decimal(10,2) DEFAULT NULL,
  total_price decimal(10,2) DEFAULT NULL,
  payment_method varchar(50) DEFAULT NULL,
  status varchar(30) NOT NULL DEFAULT 'Pending',
  order_date timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
  id int(11) NOT NULL AUTO_INCREMENT,
  product_name varchar(100) NOT NULL,
  description text NOT NULL,
  price int(11) NOT NULL,
  stock int(11) NOT NULL DEFAULT 0,
  category varchar(100) NOT NULL,
  image varchar(255) DEFAULT NULL,
  status varchar(20) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  email varchar(255) NOT NULL,
  phone varchar(255) NOT NULL,
  role varchar(255) NOT NULL DEFAULT 'Customer',
  password varchar(255) NOT NULL,
  status varchar(255) NOT NULL DEFAULT 'Active',
  address varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO products (product_name,description,price,stock,category,image,status) VALUES
('Dell Inspiron 15','15.6 FHD, Intel i5 12th Gen, 8GB RAM, 512GB SSD',85039,0,'Laptop','', 'Active'),
('Sony WH-CH520','Wireless On-Ear Headphones, Up to 50H Battery',7287,0,'Headphones','', 'Active'),
('boAt Wave Flex','1.83 Display, Bluetooth Calling, 100+ Sports Modes',3643,0,'Smart Watch','', 'Active'),
('Realme Buds T300','30dB ANC, 360 Spatial Audio, 40H Total Playback',6073,0,'Earbuds','', 'Active');

-- For your existing database, import only the missing rows/changes as needed.
