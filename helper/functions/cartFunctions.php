<?php

require_once 'htmlGeneration.php';


// returns URL of the page you were on before the cart was clicked
function getUrlWithoutCart()
{
    // get current URL
    $currentURL = $_SERVER['REQUEST_URI'];

    // remove the "&cart=show" after the c&a so the page you were on is loaded without the cart
    return str_replace("&cart=show", "", $currentURL);
}



function generateCartItems()
{
    $cartId = $_SESSION['cartId'] ?? null;

    // get all items that are in your shopping cart
    $cartItems = getCartItems($cartId);

    if (empty($cartItems))
    {
        echo("Noch keine Produkte im Warenkorb");
    }
    else
    {
        $cartHTML = "";

        // go through all items on your shopping cart and generate html to display them in the cart
        foreach ($cartItems as $item => $prodInfo)
        {
            if (!file_exists($prodInfo['imageUrl']))
            {
                $prodInfo['imageUrl'] = IMAGESPATH.'placeholder.png';
            }
            $cartHTML .= generateCartHTML($prodInfo['product_id'], $prodInfo['name'], $prodInfo['quantity'], $prodInfo['price'],
                                          $prodInfo['imageUrl'],   $prodInfo['altText']);
        }

        return $cartHTML;
    }
}



function removeItemFromCart($id, $url)
{
    removeItemFromDatabase($id, $_SESSION['cartId']);
    header("Location: {$url}");
}




// ===============================
// ===== EXTRACTED FUNCTIONS =====
// ===============================

function getCartItems($cartId)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCartItems = "SELECT    pisc.product_id, pisc.quantity,
                                   p.name, p.price,
                                   i.imageUrl, i.altText
                         FROM      productinshoppingcart pisc
                         JOIN      product p ON pisc.product_id = p.id
                         LEFT JOIN image   i ON i.product_id    = p.id
                         WHERE     pisc.shoppingCart_id = '{$cartId}';";

        return $db->query($sqlCartItems)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['cartItems'] = "Zu dieser CartID sind keine ProductsInShoppingCart vorhanden.";
    }
}



function removeItemFromDatabase($prodId, $cartId)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCartItem = "DELETE FROM productinshoppingcart WHERE shoppingCart_id = '{$cartId}' AND product_id = '{$prodId}';";

        $deleteSatement = $db->prepare($sqlCartItem);
        $deleteSatement->execute();
    }
    catch (\PDOException $e)
    {
        $errors['cartItems'] = "Dieses Item befindet sich nicht in Ihrem Warenkorb.";
    }
}

?>