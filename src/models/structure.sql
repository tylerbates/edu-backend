CREATE TABLE customers (
    customer_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(255) COLLATE utf8_bin NULL,
    rating DECIMAL(10,2) NULL,

   PRIMARY KEY (customer_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;


CREATE TABLE sellers (
    seller_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
    name VARCHAR(255) COLLATE utf8_bin NULL,
    city VARCHAR(255) COLLATE utf8_bin NULL,
    comission DECIMAL(10,2) NULL,

   PRIMARY KEY (seller_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1;

CREATE TABLE orders (
    order_id  INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
    created_at DATETIME  NULL,
    amount DECIMAL(10,2) NULL,
    customer_id INT(11) UNSIGNED  NOT NULL,
    seller_id INT(11) UNSIGNED  NOT NULL,

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