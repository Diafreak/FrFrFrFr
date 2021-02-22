<?php


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
        $html  = "<div class='' style='color:red'>";
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


?>