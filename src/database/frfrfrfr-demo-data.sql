
-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`category`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`category` (`name`) VALUES ('fruit');
INSERT INTO `frfrfrfr`.`category` (`name`) VALUES ('vegetable');

COMMIT;



-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`producttags`
-- -----------------------------------------------------
START TRANSACTION;

-- Obst --
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Kernobst');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Steinobst');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Beeren');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Zitrusfrucht, Zitrusfrüchte');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Südfrucht, Südfrüchte');

-- Gemüse --
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Fruchtgemüse');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Salat');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Kohlgemüse');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Knollengemüse');
INSERT INTO `frfrfrfr`.`producttags` (`tags`) VALUES ('Zwiebelgewächse');

COMMIT;



-- -----------------------------------------------------
-- Data for table `frfrfrfr`.`product`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Apfel',            '3.00',  10,  'Knackig, süß und saftig – Äpfel sind nicht grundlos beliebt.',                                                                                      1, 1);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Orange',           '3.20',  15,  'Die aromatischen Zitrusfrüchte eignen sich auch gut dafür, um daraus Saft zu pressen.',                                                             1, 4);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Pfirsich',         '5.00',   7,  'Pfirsiche sind sehr süß und saftig, was sie besonders im Sommer sehr beliebt macht.',                                                               1, 2);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Birne',            '3.10',   0,  'Diese weichen, süßen Früchte sind besonders im Herbst ein klarer Favorit.',                                                                         1, 1);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Gurke',            '2.80',  20,  'Gurken eignen sich gut für Salate, Sandwiches oder einfach nur als erfrischender Snack.',                                                           2, 6);
-- OBST --
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Grüner Apfel',     '3.00',   9,  'Diese Apfelsorte zeichnet sich durch eine gewisse Säure aus, die viele sehr schätzen.',                                                             1, 1);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Zitrone',          '2.90',   6,  'Allseits bekannt sind die gelben Zitronen für ihren sauren Geschmack, sind aber auch reich an Vitaminen und daher sehr gesund.',                    1, 4);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Limette',          '8.10',   3,  'Bekannt für ihre Säure eignen sich Limetten eher zum Verfeinern von Speisen und Getränken, als zum puren Verzehr.',                                 1, 4);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Ananas',           '3.50',   8,  'Reife Ananas sind saftig und süß und vor allem im Sommer ein wahrer Genuss.',                                                                       1, 5);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Mango',            '5.00',   5,  'Die zurecht beliebten Mangos sind wunderbar süß und aromatisch.',                                                                                   1, 5);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Banane',           '2.50',  10,  'Gelb und krumm – das Aussehen von Bananen ist ebenso ikonisch wie ihr Geschmack.',                                                                  1, 5);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Erdbeere',         '10.00',  3,  'Diese roten, leckeren Beeren sind sehr vielseitig. Ob pur, als Kuchen, in Marmelade oder Smoothies, sie sind bei Groß und Klein sehr geschätzt.',   1, 3);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Himbeere',         '15.00',  2,  'Himbeeren eignen sich hervorragend als süßer Sommersnack.',                                                                                         1, 3);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Blaubeere',        '16.00',  2,  'Blaubeeren sind ein leckerer Snack für zwischendurch, schmecken aber auch in Kuchen köstlich.',                                                     1, 3);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Brombeere',        '17.00',  2,  'Diese dunklen Beeren sind sehr vitaminreich und weniger süß als andere Beeren.',                                                                    1, 3);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Traube',           '12.00', 11,  'Die erfrischenden Weintrauben eignen sich nicht nur als süßer Snack, sondern passen auch hervorragend zu Käse.',                                    1, 3);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Nektarine',        '5.90',   9,  'Gerade im Sommer sind die süßen und saftigen Nektarinen eine echte Erfrischung.',                                                                   1, 2);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Aprikose',         '6.80',  12,  'Die kleinen Aprikosen sind herrlich süß und ein perfekter Snack für zwischendurch.',                                                                1, 2);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Pflaume',          '1.60',   5,  'Dieses herbstliche Obst eignet sich auch gut dafür, leckere Kuchen daraus zu backen. ',                                                             1, 2);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Wassermelone',     '1.90',  10,  'Es geht nichts über eine erfrischende Wassermelone, wenn es draußen so richtig heiß ist.',                                                          1, 5);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Honigmelone',      '4.70',   7,  'Die süßen Honigmelonen eignen sich besonders gut für einen sommerlichen Obstsalat.',                                                                1, 5);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Mandarine',        '2.30',   5,  'Mandarinen sind süß, saftig und kernarm und daher sehr beliebt zur Weihnachtszeit.',                                                                1, 4);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Kirschen',         '14.00',  3 , 'Die roten, süßen Früchte sind sehr beliebt in Kuchen, aber auch roh ein wahrer Genuss. Aber Vorsicht vor dem Stein!',                               1, 2);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Kiwi',             '5.80',   2,  'Das grüne Fruchtfleisch der Kiwi ist sehr gesund und perfekt zum Auslöffeln geeignet.',                                                             1, 5);
-- GEMÜSE --
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Tomate',           '4.50',  10,  'Die leckeren roten Früchte sind perfekt für Saucen und Salate.',                                                                                    2,  6);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Eisbergsalat',     '1.40',  12,  'Eisbergsalat ist recht geschmacksneutral, aber dafür sehr erfrischend und knackig.',                                                                2,  7);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Gartensalat',      '1.40',   9,  'Dieser Blattsalat ist eine gute Basis für verschiedenste Salate.',                                                                                  2,  7);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Weißkohl',         '2.60',   8,  'Weißkohl eignet sich hervorragend zum Kochen, beispielsweise für Gerichte wie Kohlrouladen oder Sauerkraut.',                                       2,  8);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Rotkohl',          '2.90',   6,  'Rotkohl ist als Rohkost sehr lecker und gesund, aber auch gekocht eine beliebte Beilage zu Braten.',                                                2,  8);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Paprika',          '5.60',   7,  'Paprika sind sowohl roh als erfrischender Snack, aber auch in warmen Gerichten sehr beliebt und gesund.',                                           2,  6);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Zucchini',         '3.00',  10,  'Zucchini sind eine beliebte und gesunde Zutat für viele mediterrane Gerichte.',                                                                     2,  6);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Kohlrabi',         '2.30',   7,  'Dieses Gemüse eignet sich hervorragend als knackiger und gesunder Snack.',                                                                          2,  9);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Blumenkohl',       '3.40',  12,  'Blumenkohl ist gesund und sowohl als Rohkost als auch gekocht sehr schmackhaft.',                                                                   2,  8);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Brokkoli',         '5.00',   6,  'Der grüne Brokkoli ist sehr vitaminreich und gesund und hat völlig zu Unrecht einen schlechten Ruf.',                                               2,  8);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Kartoffel',        '2.00',  25,  'Kartoffeln sind äußerst vielseitig und daher als verschiedenste Beilagen geeignet.',                                                                2,  9);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Zwiebel',          '2.20',  13,  'Zwiebeln sind essenziell zum Würzen allerlei herzhafter Speisen.',                                                                                  2, 10);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Knoblauch',        '8.40',   3,  'Knoblauch gibt Gerichten einen gewissen Kick, verursacht aber leider unschönen Mundgeruch.',                                                        2, 10);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Radieschen',       '6.50',   4,  'Diese kleinen roten Knöllchen eignen sich perfekt als kleiner, aber auch recht scharfer Snack.',                                                    2,  9);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Avocado',          '7.50',   3,  'Dieses Superfood erlangte recht jüngst eine große Beliebtheit, da es sehr gesunde Fette enthält.',                                                  2,  6);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Sellerie',         '2.70',   5,  'Dieses Suppengemüse ist eine wichtige Basis für Suppen und Brühen.',                                                                                2,  9);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Lauch',            '4.90',   6,  'Lauch dient einerseits als Suppengemüse, kann aber auch beispielsweise als Beilage serviert werden.',                                               2, 10);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Frühlingszwiebel', '2.30',   4,  'Frühlingszwiebeln sind eine mildere Alternative zu Zwiebeln und somit gut zum Würzen von Speisen geeignet.',                                        2, 10);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Süßkartoffel',     '4.30',  10,  'Der Name ist Programm: Süßkartoffeln haben einen sehr süßlichen Eigengeschmack und somit sehr einzigartig.',                                        2,  9);
INSERT INTO `frfrfrfr`.`product` (`name`, `price`, `numberInStock`, `description`, `category_id`, `productTags_id`) VALUES ('Karotte',          '2.20',  17,  'Orange, knackig und gesund – dieses Wurzelgemüse eignet sich sehr gut zum rohen Verzehr und in Salaten, aber auch gekocht ist es ein Genuss.',      2,  9);

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
-- OBST --
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/apple_green.jpg', 'Grüner Apfel',  6);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/lemon.jpg',       'Zitrone',       7);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/lime.jpg',        'Limette',       8);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/pineapple.jpg',   'Ananas',        9);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/mango.jpg',       'Mango',        10);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/banana.jpg',      'Banane',       11);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/strawberry.jpg',  'Erdbeere',     12);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/raspberry.jpg',   'Himbeere',     13);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/blueberry.jpg',   'Blaubeere',    14);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/blackberry.jpg',  'Brombeere',    15);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/grape.jpg',       'Weintraube',   16);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/nectarine.jpg',   'Nektarine',    17);
-- to test placeholder:
-- INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/apricot.jpg',    'Aprikose',     18);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/plum.jpg',        'Pflaume',      19);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/melon.jpg',       'Wassermelone', 20);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/rockmelon.jpg',   'Honigmelone',  21);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/tangerine.jpg',   'Mandarine',    22);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/cherry.jpg',      'Kirschen',     23);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/kiwi.jpg',        'Kiwi',         24);
-- GEMÜSE --
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/tomato.jpg',         'Tomate',           25);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/iceberglettuce.jpg', 'Eisbergsalat',     26);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/gardensalad.jpg',    'Gartensalat',      27);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/whitecabbage.jpg',   'Weißkohl',         28);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/redcabbage.jpg',     'Rotkohl',          29);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/bellpepper.jpg',     'Paprika',          30);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/zucchini.jpg',       'Zucchini',         31);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/kohlrabi.jpg',       'Kohlrabi',         32);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/cauliflower.jpg',    'Blumenkohl',       33);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/broccoli.jpg',       'Brokkoli',         34);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/potato.jpg',         'Kartoffel',        35);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/onion.jpg',          'Zwiebel',          36);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/garlic.jpg',         'Knoblauch',        37);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/radish.jpg',         'Radieschen',       38);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/avocado.jpg',        'Avocado',          39);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/greenonion.jpg',     'Sellerie',         40);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/leek.jpg',           'Lauch',            41);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/rootcelery.jpg',     'Frühlingszwiebel', 42);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/sweetpotato.jpg',    'Süßkartoffel',     43);
INSERT INTO `frfrfrfr`.`image` (`imageUrl`, `altText`, `product_id`) VALUES ('assets/images/products/carrot.jpg',         'Karotte',          44);

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