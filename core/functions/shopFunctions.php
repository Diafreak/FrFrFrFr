<?php


function getProductDetails($prodId, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCurrentProduct = "  SELECT p.name, p.price, p.numberInStock, p.description,
                                       i.imageUrl, i.altText
                                FROM   product p
                                JOIN   image i ON p.id = i.product_id
                                WHERE  p.id = {$prodId};";

        $prodDetails = $db->query($sqlCurrentProduct)->fetchAll();

        if (empty($prodDetails))
        {
            $errors['prodId'] = "Zu dieser ID existiert kein Produkt.";
            return null;
        }
        return $prodDetails;
    }
    catch (\PDOException $e)
    {
        $errors['prodId'] = "Zu dieser ID existiert kein Produkt.";
        return null;
    }

}


// generates the HTML-Code for the given product-category
function generateShopLayout($catName, &$errors = [])
{
    $db = $GLOBALS['db'];

    // get the category-ID from the given category-name
    $catId = getCatId($catName, $db, $errors);


    if ($catId !== null)
    {
        // $productsFromSameCategory: stores all products that are in the given category
        $productsFromSameCategory = getProductsFromSameCategory($catId, $db, $errors);

        // store the images for the products in $imagesArray
        // only stores images from the current category so no unnecessary images are in the array
        $imagesArray = getProductImages($catId, $db, $errors);

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
        foreach($productsFromSameCategory as $productData)
        {
            $productId   = $productData['id'];
            $productName = $productData['name'];
            $price       = $productData['price'];

            // get the correct picture from the $imagesArray for each product
            foreach($imagesArray as $imageData)
            {
                if ($imageData['product_id'] == $productId)
                {
                    $imageSrc = $imageData['imageUrl'];
                    $altText  = $imageData['altText'];
                    break;
                }
            }

            // calls the generateProductHTML function based on the current position and arguments form the product/image
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
        echo($productsHTMLLayout);
    }
    else
    {
        $errors['catId'] = "Zu dieser Kategorie gibt es keine Produkte.";
    }
}



// ==================================
// ===== GENERATE PRODUCT HTML  =====
// ==================================

// generates the HTML for the given position
function generateProductHTML($position, $productId, $imageSrc, $altText, $productName, $price)
{
    $html  = "<li class='{$position}'>\n";

    $html .=     "<div class='product-showcase'>\n";
    $html .=         "<a href='?c=shop&a=productDetails&prodId={$productId}'>\n";
    $html .=             "<img class='product-picture' src='{$imageSrc}' alt='{$altText}' width='80%' height='55%'>\n";   //!!! width-height in css !!!
    $html .=         "</a>\n";
    $html .=     "</div>\n";

    $html .=     "<div class='produkt-details'>\n";
    $html .=         "<div class='produkt-name'>\n";
    $html .=             "<a href='?c=shop&a=productDetails&prodId={$productId}'>\n";
    $html .=                 "{$productName}\n";
    $html .=             "</a>\n";
    $html .=         "</div>\n";
    $html .=         "<div class='produkt-preis'>\n";
    $html .=             "{$price} €\n";
    $html .=         "</div>\n";
    $html .=     "</div>\n";

    $html .= "</li>\n";

    return $html;
}



// ===============================
// ===== EXTRACTED FUNCTIONS =====
// ===============================

function getCatId($catName, $db, &$errors)
{
    try
    {
        $sqlCategoryId = "SELECT id FROM category WHERE name = '{$catName}';";
        $catIdArray    = $db->query($sqlCategoryId)->fetchAll();

        return $catIdArray[0]['id'] ?? null;
    }
    catch (\PDOException $e)
    {
        $errors['catId'] = "Zu dieser Kategorie gibt es keine Produkte.";
    }
}


function getProductsFromSameCategory($catId, $db, &$errors)
{
    try
    {
        $sqlProducts = "SELECT * FROM product WHERE category_id = '{$catId}';";
        return $db->query($sqlProducts)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['prodOfSameCat'] = "Zu dieser Kategorie gibt es keine Produkte.";
    }
}


function getProductImages($catId, $db, &$errors)
{
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
        $errors['prodImage'] = "Die angegebene Kategorie existiert nicht.";         //!!! return placeholder !!!
    }
}

?>