<?php

require_once 'htmlGeneration.php';


// =====================================
// ========== PRODUCT-DETAILS ==========
// =====================================

function getProductDetails($prodId, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCurrentProduct = "SELECT    p.id, p.name, p.price, p.numberInStock, p.description,
                                        i.imageUrl, i.altText,
                                        c.name as catName
                              FROM      product  p
                              LEFT JOIN image    i ON p.id = i.product_id
                              JOIN      category c ON c.id = p.category_id
                              WHERE     p.id = {$prodId};";

        $prodDetails = $db->query($sqlCurrentProduct)->fetchAll();

        // display an error if an ID is called that doesn't exist
        if (empty($prodDetails))
        {
            $errors['prodId'] = "Zu dieser ID existiert kein Produkt.";
            return null;
        }

        // display a placeholder if the image is missing
        if (!file_exists($prodDetails[0]['imageUrl']))
        {
            $prodDetails[0]['imageUrl'] = IMAGESPATH.'placeholder.png';
            $prodDetails[0]['altText']  = 'Placeholder';

        }

        return $prodDetails;
    }
    catch (\PDOException $e)
    {
        $errors['prodId'] = "Zu dieser ID existiert kein Produkt.";
        return null;
    }
}


// generates the amount-selection on the product-details page based on how many are in stock
function generateAmountHTML($numberInStock)
{
    // only generate a selectable amount if there are items in stock
    if ($numberInStock > 0)
    {
        $html = "<select name='amount' id='amount'>";

        for ($option = 1; $option <= $numberInStock; $option++ )
        {
            $html .= "<option value='{$option}'>{$option}</option>";
        }

        $html .= "</select>";
    }
    else
    {
        // if there are 0 items in stock it will display an error instead of a selection
        $html  = "<div class='' style='color:red'>";                                        // !!! CLASS RED !!!
        $html .= "Keine Produkte auf Lager.";
        $html .= "</div>";
    }

    return $html;
}



function getNumberInStock($prodId)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlProdAmount = "SELECT numberInStock FROM product WHERE id = '{$prodId}';";
        $prodAmount = $db->query($sqlProdAmount)->fetchAll()[0];

        return $prodAmount['numberInStock'] ?? null;
    }
    catch (\PDOException $e)
    {
        $errors['productId'] = "Zu dieser ID gibt es kein Produkt.";
    }
}




// ==========================
// ========== CART ==========
// ==========================

function addItemToCart($prodId, $productDetails)
{
    if ($_SESSION['loggedIn'] === true)
    {
        $userId    = $_SESSION['userId'];
        $cartId    = $_SESSION['cartId'];
        $amount    = $_POST['amount'];

        $noInStock = getNumberInStock($prodId);

        // if the selected amount is higher than the numberInStock, the amount is set to the numberInStock
        if ($amount > $noInStock)
        {
            $amount = $noInStock;
        }

        // if the item is already in your cart, update the amount of it instead of creating a new entry
        if (isProductAlreadyInCart($cartId, $prodId, $amount))
        {
            if ($amount > $noInStock) $amount = $noInStock;
            updateAmountInCart($cartId, $prodId, $amount);
        }
        else
        {
            addItem($amount, $noInStock, $prodId, $cartId);
        }

        $action = $productDetails['catName'] . 's';
        header("Location: ?c=shop&a={$action}#success");             // !!! CHANGE DYNAMIC URL !!!
    }
    else
    {
        // redirect to login if the user wants to add an item to their cart
        header('Location: ?c=account&a=login');                         //!!! CHANGE !!!
    }
}



// check if the added item is already in your cart
// if yes, the selected amount and amount in the cart will be added together
function isProductAlreadyInCart($cartId, $prodId, &$amount)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlProdInCart = "SELECT quantity
                          FROM   productinshoppingcart
                          WHERE  shoppingCart_id = '{$cartId}' AND product_id = '{$prodId}';";
        $prodInCart = $db->query($sqlProdInCart)->fetchAll();

        if (!empty($prodInCart))
        {
            (int) $amount += (int) $prodInCart[0]['quantity'];
            return true;
        }
    }
    catch (\PDOException $e)
    {
        $errors['prodInCart'] = "In diesem Cart sind keine Produkte mit der ID {$prodId} vorhanden.";
    }

    return false;
}



// if an item is already in the cart the amount of it will be updated instead of adding a new entry
function updateAmountInCart($cartId, $prodId, $amount)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUpdateAmount = "UPDATE productinshoppingcart
                            SET    quantity = '{$amount}'
                            WHERE  shoppingCart_id = '{$cartId}' AND product_id = '{$prodId}';";
        $updateStatement = $db->prepare($sqlUpdateAmount);
        $updateStatement->execute();
    }
    catch (\PDOException $e)
    {
        $errors['updateAmount'] = "Menge vom Produkt (ID: {$prodId}) konnte nicht aktualisiert werden.";
    }
}




// ==========================
// ========== SHOP ==========
// ==========================

// generates the HTML-Code for the given product-category
function generateShopLayout($catName, $tags = "", &$errors = [])
{
    // get the category-ID from the given category-name (fruit or vegetable)
    $catId = getCatId($catName, $errors);

    if ($catId != null)
    {
        // stores all products that are in the given category
        // if tags are given, only products with the passed tags are returned
        $productsFromSameCategory = getProductsFromSameCategory($catId, $tags, $errors);

        // store the images for the products in $imagesArray
        // only stores images from the current category so no unnecessary images are in the array
        $imagesArray = getProductImages($catId, $errors);
    }


    if (empty($errors))
    {
        // $itemsInRow  - counts how many items are currently in the row to prevent empty columns
        //              - loops through $position because every column in each row has a special
        //                css-format so they have to be handled separately
        // $productsHTMLLayout  stores the html for the shop as a string
        $itemsInRow = 0;
        $position = [ 0 => 'left',
                      1 => 'middle',
                      2 => 'right', ];

        $productsHTMLLayout = "";


        // loop through all products of the given category and print the html on the shop page
        foreach ($productsFromSameCategory as $productData)
        {
            $productId   = $productData['id'];
            $productName = $productData['name'];
            $price       = $productData['price'];

            // get the correct picture from the $imagesArray for each product
            foreach($imagesArray as $imageData)
            {
                if (file_exists($imageData['imageUrl']) && $imageData['product_id'] == $productId)
                {
                    $imageSrc = $imageData['imageUrl'];
                    $altText  = $imageData['altText'];
                    break;
                }
                else
                {
                    // display a placeholder-image if there is no picture for the product
                    // or there is no image for the path stored in the database
                    $imageSrc = IMAGESPATH . "placeholder.png";
                    $altText  = "Placeholder";
                }
            }

            // calls the generateProductHTML function based on the current position and arguments from the product/image
            switch ($position[$itemsInRow])
            {
                case "left":
                    $productsHTMLLayout .= generateProductHTML("links", $productId, $imageSrc, $altText, $productName, $price);
                    ++$itemsInRow;
                    break;

                case "middle":
                    $productsHTMLLayout .= generateProductHTML("mitte", $productId, $imageSrc, $altText, $productName, $price);
                    ++$itemsInRow;
                    break;

                case "right":
                    $productsHTMLLayout .= generateProductHTML("rechts", $productId, $imageSrc, $altText, $productName, $price);
                    $itemsInRow = 0;
                    break;

                default:
                    echo("This direction does not exist.");
                    break;
            }
        }
        // print the entire html for the products on the shop page
        return $productsHTMLLayout;
    }
}




// =========================================
// ========== EXTRACTED FUNCTIONS ==========
// =========================================

function getCatId($catName, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCategoryId = "SELECT id FROM category WHERE name = '{$catName}';";
        $catIdArray    = $db->query($sqlCategoryId)->fetchAll();

        if (!empty($catIdArray[0]['id'])) return $catIdArray[0]['id'];

        $errors['catId'] = "Zu dieser Kategorie gibt es keine Produkte.";
        return null;
    }
    catch (\PDOException $e)
    {
        $errors['catId'] = "Zu dieser Kategorie gibt es keine Produkte.";
    }
}



function getProductsFromSameCategory($catId, $tags = "", &$errors)
{
    $db = $GLOBALS['db'];

    if ($tags == "")
    {
        try
        {
            $sqlProducts = "SELECT * FROM product WHERE category_id = '{$catId}' ORDER BY name;";
            return $db->query($sqlProducts)->fetchAll();
        }
        catch (\PDOException $e)
        {
            $errors['prodOfSameCat'] = "Zu dieser Kategorie gibt es keine Produkte.";
        }
    }
    else
    {
        // if at least 1 tag is set
        try
        {
            $maxNumberOfTags = 2;

            // check how many tags an user is searching for
            if (substr_count($tags, ' ') >= $maxNumberOfTags)
            {
                $errors['maxTags'] = "Max. {$maxNumberOfTags} Suchbegriffe möglich.";
            }
            else
            {
                $productArray = [];

                // put all tags into separate array indices
                $separatedTags = explode(' ', $tags, $maxNumberOfTags);

                // if searching for multiple tags you want a product that has all of them
                // so first we get all products that fit the first tag, then we search these products for the other tag
                $firstTag  = $separatedTags[0];
                $secondTag = $separatedTags[1] ?? null;

                // look through all tags in the "productTags"-table and all product-names and get the ones having the tags and save the prodId
                // "category_id = $catId" is needed because e.g. if we search in fruits we don't want results from vegetables
                $sqlProductFirstTag = " SELECT   p.*
                                        FROM     producttags pt
                                        JOIN     product p ON pt.id = p.productTags_id
                                        WHERE    category_id = '{$catId}' AND (pt.tags LIKE '%{$firstTag}%' OR p.name LIKE '%{$firstTag}%');
                                        ORDER BY p.name;";
                // all products that fit the first tag
                $productsFirstTag = $db->query($sqlProductFirstTag)->fetchAll();

                // check if a second tag is set
                if ($secondTag != null)
                {
                    $sqlProductSecondTag = " SELECT   p.*
                                             FROM     producttags pt
                                             JOIN     product p ON pt.id = p.productTags_id
                                             WHERE    category_id = '{$catId}' AND (pt.tags LIKE '%{$secondTag}%' OR p.name LIKE '%{$secondTag}%')
                                             ORDER BY p.name;";
                    // all products that fit the second tag
                    $productsSecondTag = $db->query($sqlProductSecondTag)->fetchAll();


                    // loop through booth arrays and save products they have in common in $productArray
                    foreach ($productsFirstTag as $firstTagProd)
                    {
                        foreach ($productsSecondTag as $secondTagProd)
                        {
                            if ($firstTagProd['name'] == $secondTagProd['name'])
                            {
                                array_push($productArray, $firstTagProd);
                            }
                        }
                    }

                    if (!empty($productArray)) return $productArray;
                }
                else
                {
                    // if no 2. tag is set only return items from the first search
                    if (!empty($productsFirstTag)) return $productsFirstTag;
                }

                $errors['prodTags'] = "Zu dieser Suchanfrage konnte nichts gefunden werden.";
            }
        }
        catch (\PDOException $e)
        {
            $errors['prodTags'] = "Zu dieser Suchanfrage konnte nichts gefunden werden.";
        }
    }

}



function getProductImages($catId, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlImages   = "SELECT imageUrl, altText, product_id
                        FROM   image i
                        JOIN   product p ON i.product_id = p.id
                        WHERE  category_id = {$catId};";

        return $db->query($sqlImages)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['prodImage'] = "Die angegebene Kategorie existiert nicht.";
        return null;
    }
}



function addItem($amount, $noInStock, $prodId, $cartId)
{
    // create array with all necessary info of the product so it can be added to the cart
    $prodInfo = [ 'product_id'      => $prodId,
                  'quantity'        => $amount,
                  'shoppingCart_id' => $cartId ];

    // add item and amount to your shopping cart
    $prodInCart = new ProductInShoppingCart($prodInfo);
    $prodInCart->insert();
    unset($prodInCart);
}

?>