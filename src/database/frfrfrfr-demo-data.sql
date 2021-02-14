
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

INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Apfel',    '1.00', 10, 'This is a Äpfel',   1, null);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Orange',   '0.90', 15, 'This is a Oränge',  1, null);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Pfirsich', '1.20',  7, 'This is a Pfirsch', 1, null);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Birne',    '1.10',  0, 'This is a Birnä',   1, null);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Gurke',    '0.80', 20, 'This is a Gurkä',   2, null);

COMMIT;


-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`image`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/appl.jpg',     'Apfel',    1);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/orange.jpg',   'Orange',   2);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/peach.jpg',    'Pfirsich', 3);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/pear.jpg',     'Birne',    4);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/cucumber.jpg', 'Gurke',    5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`role`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`role` (`name`) VALUES ('admin');
INSERT INTO `frfrfrfr`.`role` (`name`) VALUES ('customer');

COMMIT;


-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`user`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`user` (`email`, `passwordHash`, `firstName`, `lastName`, `address_id`, `role_id`) VALUES ('admin', '12345', 'admin', 'admin', NULL, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`shoppingcart`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`shoppingcart` (`user_id`) VALUES (1);

COMMIT;