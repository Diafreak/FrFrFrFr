<?php

// ==============================
// ========== PRODUCTS ==========
// ==============================

function getProductDetails($prodId, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCurrentProduct = "  SELECT p.id, p.name, p.price, p.numberInStock, p.description,
                                       i.imageUrl, i.altText
                                FROM   product p
                                JOIN   image i ON p.id = i.product_id
                                WHERE  p.id = {$prodId};";

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
        $html  = "<div class='' style='color:red'>";                            // !!! CLASS RED !!!
        $html .= "Keine Produkte auf Lager.";
        $html .= "</div>";
    }

    return $html;
}



// ==========================
// ========== SHOP ==========
// ==========================

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
    // number of tabs that are used until "<ul class="produkt-tabelle">"
    // $start, nTabs(x) & \n are only for better readability of the shop-code when inspecting the page
    $start = 3;

    $html  = "\n";
    $html .= nTabs($start)."<li class='{$position}'>\n";

    $html .= nTabs($start).nTabs(1)."<div class='product-showcase'>\n";
    $html .= nTabs($start).nTabs(2).    "<a href='?c=shop&a=productDetails&prodId={$productId}'>\n";
    $html .= nTabs($start).nTabs(3).        "<img class='product-picture' src='{$imageSrc}' alt='{$altText}'>\n";
    $html .= nTabs($start).nTabs(2).    "</a>\n";
    $html .= nTabs($start).nTabs(1)."</div>\n";

    $html .= nTabs($start).nTabs(1)."<div class='produkt-details'>\n";
    $html .= nTabs($start).nTabs(2).    "<div class='produkt-name'>\n";
    $html .= nTabs($start).nTabs(3).        "<a href='?c=shop&a=productDetails&prodId={$productId}'>\n";
    $html .= nTabs($start).nTabs(4).            "{$productName}\n";
    $html .= nTabs($start).nTabs(3).        "</a>\n";
    $html .= nTabs($start).nTabs(2).    "</div>\n";
    $html .= nTabs($start).nTabs(2).    "<div class='produkt-preis'>\n";
    $html .= nTabs($start).nTabs(3).        "{$price} €\n";
    $html .= nTabs($start).nTabs(2).    "</div>\n";
    $html .= nTabs($start).nTabs(1)."</div>\n";

    $html .= nTabs($start)."</li>\n";

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
        $errors['prodImage'] = "Die angegebene Kategorie existiert nicht.";
        return null;
    }
}


// this function is just for better readability when inspecting the sourcecode of the shop-page ("Seitenquelltext anzeigen")
// otherwise the entire html-layout would be in one line
function nTabs($numberOfTabs)
{
    static $TAB = "    ";
    $tabs = "";

    if ($numberOfTabs > 0)
    {
        for ($tabIndex = 0; $tabIndex < $numberOfTabs; $tabIndex++)
        {
            $tabs .= $TAB;
        }
        return $tabs;
    }
    else
    {
        return "";
    }
}

?>