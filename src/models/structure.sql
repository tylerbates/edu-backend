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