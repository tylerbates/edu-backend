CREATE TABLE customers (
    customer_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(255) COLLATE utf8_bin NOT NULL UNIQUE,
    surname VARCHAR(255) COLLATE utf8_bin NOT NULL,
    email VARCHAR(255) COLLATE utf8_bin NOT NULL,
    password VARCHAR(255) COLLATE utf8_bin NOT NULL,
    rating DECIMAL(10,2) NULL,

   PRIMARY KEY (customer_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

alter table customers add column surname VARCHAR(255) COLLATE utf8_bin NOT NULL;
alter table customers add column email VARCHAR(255) COLLATE utf8_bin NOT NULL;

CREATE TABLE admins (
  admin_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  name VARCHAR(255) COLLATE utf8_bin NOT NULL UNIQUE,
  password VARCHAR(255) COLLATE utf8_bin NOT NULL,

  PRIMARY KEY (admin_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

insert into admins (name,password) values ('tylerbates', md5('123123'));

CREATE TABLE sellers (
    seller_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(255) COLLATE utf8_bin NULL,
    city VARCHAR(255) COLLATE utf8_bin NULL,
    comission DECIMAL(10,2) NULL,

   PRIMARY KEY (seller_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

CREATE TABLE orders (
  order_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  created_at DATETIME NULL,
  customer_id INT(11) UNSIGNED  NOT NULL,
  shipping_method VARCHAR(255) COLLATE utf8_bin NULL,
  payment_method VARCHAR(255) COLLATE utf8_bin NULL,
  address VARCHAR(255) COLLATE utf8_bin NULL,
  items VARCHAR(255) COLLATE utf8_bin NULL,
  subtotal DECIMAL(10,2) NULL,
  shipping DECIMAL(10,2) NULL,
  grand_total DECIMAL(10,2) NULL,

  PRIMARY KEY (order_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

CREATE TABLE products (
    product_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(255) COLLATE utf8_bin NULL,
    sku VARCHAR(255) COLLATE utf8_bin NULL,

   PRIMARY KEY (product_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;


CREATE TABLE order_products (
    link_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
    product_id  INT(11) UNSIGNED  NOT NULL,
    order_id  INT(11) UNSIGNED  NOT NULL,

   PRIMARY KEY (link_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

CREATE INDEX PRODUCT_ID_INDEX ON order_products(product_id);

CREATE INDEX ORDER_ID_INDEX ON order_products(order_id);

CREATE INDEX CUSTOMER_ID_INDEX ON orders(customer_id);

CREATE INDEX ORDER_ID_INDEX ON orders(order_id);

CREATE UNIQUE INDEX SKU_INDEX ON products(sku);


ALTER TABLE order_products ADD CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(product_id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE order_products ADD CONSTRAINT FOREIGN KEY (order_id) REFERENCES orders(order_id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE orders ADD CONSTRAINT FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE orders ADD CONSTRAINT FOREIGN KEY (seller_id) REFERENCES sellers(seller_id) ON UPDATE CASCADE ON DELETE CASCADE;


insert into sellers (name,city,comission) values ('Ivan','Rostov',6.2),('Sergey','Rostov',6.0),('Vika','Mokow',3.4),('Lexa','Taganrog',5.3);

insert into customers (name,rating) values ('Ivan',5.6),('Tanya',4.2),('Katya',2.1),('Yulia',10.0),('Andrey',7.9),('Margo',5.6),('Kirill',0.1),('Dasha',6.5);

insert into products (name,sku) values ('nokla 5210','nkl_5210'),('motorobla razor v690','mtr_v690'),('Iphcne 5','iph_5');

insert into orders (created_at,amount,customer_id,seller_id) values (now(),2456.99,1,4),(now(),5968.99,2,2),(now(),4587.99,3,2),(now(),1452.99,2,3),(now(),9856.99,8,4),(now(),100.99,6,1);

insert into order_products (product_id,order_id) values (1,1),(1,2),(2,5),(3,6),(3,3),(1,3),(2,3),(2,4),(3,4);

ALTER TABLE products ADD COLUMN image VARCHAR(255) COLLATE utf8_bin NULL;

ALTER TABLE products ADD COLUMN price DECIMAL(10,2) NULL;

ALTER TABLE products ADD COLUMN special_price DECIMAL(10,2) NULL;

update products set image='http://www.ferra.ru/images/320/320657.jpg', price=1000, special_price=999.99 where product_id = 1;
update products set image='http://paulov.ru/files/2011/02/motorola_L7.jpg', price=2000, special_price=1999.99 where product_id = 2;
update products set image='http://img81.imageshack.us/img81/5471/img1135jpg.jpg', price=10000, special_price=9999.99 where product_id = 3;

CREATE TABLE reviews (
  review_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  name VARCHAR(255) COLLATE utf8_bin NULL,
  email VARCHAR(255) COLLATE utf8_bin NULL,
  text TEXT COLLATE utf8_bin NULL,
  rating INT(2) UNSIGNED NULL,
  product_id INT(11) UNSIGNED NOT NULL,

  CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(product_id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (review_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

insert into reviews (name, email,text,rating,product_id) values ('asfa','sadgsadg','sdasdgsadasd',2,1),('asfa','sadgsadg','sdasdgsadasd',2,2),('asfa','sadgsadg','sdasdgsadasd',2,3);
insert into reviews (name, email,text,rating,product_id) values ('asfa','sadgsadg','sdasdgsadasd',3,1);


CREATE TABLE addresses (
  address_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  region  VARCHAR(255) COLLATE utf8_bin NULL,
  city  VARCHAR(255) COLLATE utf8_bin NULL,
  mail_index  INT(11) UNSIGNED  NULL,
  street  VARCHAR(255) COLLATE utf8_bin NULL,
  flat  VARCHAR(255) COLLATE utf8_bin NULL,

  PRIMARY KEY (address_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;



CREATE TABLE quotes (
  quote_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  customer_id  INT(11) UNSIGNED  NULL,
  address_id  INT(11) UNSIGNED NULL,
  shipping_code varchar(255) COLLATE utf8_bin NULL,

  PRIMARY KEY (quote_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

ALTER TABLE quotes ADD CONSTRAINT FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE quotes ADD CONSTRAINT FOREIGN KEY (address_id) REFERENCES addresses(address_id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE TABLE quote_products (
  link_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  quote_id  INT(11) UNSIGNED  NOT NULL,
  product_id  INT(11) UNSIGNED  NOT NULL,
  qty INT(11) UNSIGNED  NOT NULL,

  PRIMARY KEY (link_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

ALTER TABLE quote_products ADD CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(product_id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE quote_products ADD CONSTRAINT FOREIGN KEY (quote_id) REFERENCES quotes(quote_id) ON UPDATE CASCADE ON DELETE CASCADE;


SELECT p.*  FROM products as p
  INNER JOIN customer_products as cp on p.product_id = cp.product_id;

CREATE TABLE shipping_rate (
  rate_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  city  VARCHAR(255) COLLATE utf8_bin NULL,
  price DECIMAL(10,2) NULL,

  PRIMARY KEY (rate_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

alter table shipping_rate add column courier bool null;
alter table shipping_rate add column pbd bool null;

update shipping_rate set courier = true where rate_id=1;
update shipping_rate set courier = true, pbd=true where rate_id=2;

insert into shipping_rate (city,price) values ('Rostov',100),('Taganrog',200);

alter table quotes add  column shipping_code varchar(255) COLLATE utf8_bin NULL;
alter table quotes add  column payment_code varchar(255) COLLATE utf8_bin NULL;
alter table quotes add column subtotal decimal(10,2) null;
alter table quotes add column shipping decimal(10,2) null;
alter table quotes add column grand_total decimal(10,2) null;

CREATE TABLE cities (
  city_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  name  VARCHAR(255) COLLATE utf8_bin NULL,

  PRIMARY KEY (city_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

alter table cities add column region_id INT(11) UNSIGNED NULL;
alter table cities add column name  VARCHAR(255) COLLATE utf8_bin NULL;

CREATE TABLE regions (
  region_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  name  VARCHAR(255) COLLATE utf8_bin NULL,

  PRIMARY KEY (region_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

INSERT INTO cities (name,region_id) VALUES ('Ростов',15789406),('Таганрог',15789406),('Москва',15789407);

INSERT INTO regions (name) VALUES ('Ростовская обл'),('Московская обл.');

INSERT INTO shipping_rate (city,price,courier,pbd) VALUES ('Москва',99,1,1);
insert INTO shipping_rate (city,price,pbd) values ('Таганрог',1000,1);