<?php


// generates the HTML-Code for the given product-category
function generateShopLayout($catName)
{
    $db = $GLOBALS['db'];

    // get the category-ID from the given category-name
    $sqlCategoryId = "SELECT id FROM category WHERE name = '{$catName}';";                      //??? auslagern ???
    $catIdArray    = $db->query($sqlCategoryId)->fetchAll();
    $catId         = $catIdArray[0]['id'] ?? null;


    if ($catId !== null)
    {
        // store all the products that are in that category in $productsFromSameCategory
        $sqlProducts              = "SELECT * FROM product WHERE category_id = '{$catId}';";    //??? auslagern ???
        $productsFromSameCategory = $db->query($sqlProducts)->fetchAll();

        // store the images for the products in $imagesArray
        // only stores images from the current category so no unnecessary images are in the array
        $sqlImages   = "SELECT imageUrl, altText, product_id
                        FROM image i
                        JOIN product p ON i.product_id = p.id
                        WHERE category_id = {$catId};";
        $imagesArray = $db->query($sqlImages)->fetchAll();


        // because the layout has 3 products in a row $itemsInRow is required to count
        // the products in the array so no uneccessary columns will be generated
        // $itemsInRow loops through $position because every column in each row
        // has a special css-format so they have to be handled separately
        $itemsInRow = 0;
        $position = [ 0 => 'left',
                      1 => 'middle',
                      2 => 'right', ];

        $productsHTMLLayout = "";

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

        echo($productsHTMLLayout);                                       //???besser???
    }
    else
    {
        echo("Zu dieser Kategorie gibt es keine Produkte im Shop.");
    }
}


// generates the HTML for the given position
function generateProductHTML($position, $productId, $imageSrc, $altText, $productName, $price)
{
    $html = "<li class='{$position}'>";

    $html .=     "<div class='product-showcase'>";
    $html .=         "<a href='?c=shop&a=productDetails&prodId={$productId}'>";
    $html .=             "<img class='product-picture' src='{$imageSrc}' alt='{$altText}' width='80%' height='55%'>";   //!!! width-height in css !!!
    $html .=         "</a>";
    $html .=     "</div>";

    $html .=     "<div class='produkt-details'>";
    $html .=         "<div class='produkt-name'>";
    $html .=             "<a href='?c=shop&a=productDetails&prodId={$productId}'>";
    $html .=                 "{$productName}";
    $html .=             "</a>";
    $html .=         "</div>";
    $html .=         "<div class='produkt-preis'>";
    $html .=             "{$price} €";
    $html .=         "</div>";
    $html .=     "</div>";

    $html .= "</li>";

    return $html;
}


?>