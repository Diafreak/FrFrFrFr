
-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`category`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`category` (`name`) VALUES ('fruit');
INSERT INTO `frfrfrfr`.`category` (`name`) VALUES ('vegetable');

COMMIT;


-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`product`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`) VALUES ('Apfel',    '1.00', 10, 'This is a Äpfel',   1);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`) VALUES ('Orange',   '0.90', 15, 'This is a Oränge',  1);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`) VALUES ('Pfirsich', '1.20',  7, 'This is a Pfirsch', 1);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`) VALUES ('Birne',    '1.10',  5, 'This is a Birnä',   1);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`) VALUES ('Gurke',    '0.80', 20, 'This is a Gurkä',   2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`image`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/apple.jpg',    'Apfel',    1);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/orange.jpg',   'Orange',   2);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/peach.jpg',    'Pfirsich', 3);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/pear.jpg',     'Birne',    4);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/cucumber.jpg', 'Gurke',    5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`user`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`user` (`email`, `passwordHash`, `firstName`, `lastName`, `address_id`) VALUES ('max@max.de', '12345', 'Max', 'Mustermann', NULL);
INSERT INTO `frfrfrfr`.`user` (`email`, `passwordHash`, `firstName`, `lastName`, `address_id`) VALUES ('tom@tom.de', '98765', 'Tom', 'Tommy',      NULL);

COMMIT;