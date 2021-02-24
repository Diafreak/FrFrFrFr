<?php


// =================================
// ========== FORM-ERRORS ==========
// =================================

function printErrors($errors)
{
    if (isset($errors))
    {
        echo("<div style='color:red'>");
        foreach($errors as $error)
        {
            echo("<li>{$error}</li>");
        }
        echo("</div>");
    }
}




// =================================
// ========== SHOP-LAYOUT ==========
// =================================

// generates the HTML for the given position
function generateProductHTML($position, $productId, $imageSrc, $altText, $productName, $price)
{
    $productName = ucfirst($productName);

    // number of tabs that are used until "<ul class="produkt-tabelle">"
    // $start, nTabs(x) & \n are only for better readability of the shop-code when inspecting the page
    $start = 3;

    $html  = "\n";
    $html .= nTabs($start)."<li class='{$position}'>\n";
    // -- Image --
    $html .= nTabs($start).nTabs(1)."<div class='product-showcase'>\n";
    $html .= nTabs($start).nTabs(2).    "<a href='?c=shop&a=productDetails&prodId={$productId}'>\n";
    $html .= nTabs($start).nTabs(3).        "<img class='product-picture' src='{$imageSrc}' alt='{$altText}'>\n";
    $html .= nTabs($start).nTabs(2).    "</a>\n";
    $html .= nTabs($start).nTabs(1)."</div>\n";
    // -- Name --
    $html .= nTabs($start).nTabs(1)."<div class='produkt-details'>\n";
    $html .= nTabs($start).nTabs(2).    "<div class='produkt-name'>\n";
    $html .= nTabs($start).nTabs(3).        "<a href='?c=shop&a=productDetails&prodId={$productId}'>\n";
    $html .= nTabs($start).nTabs(4).            "{$productName}\n";
    $html .= nTabs($start).nTabs(3).        "</a>\n";
    $html .= nTabs($start).nTabs(2).    "</div>\n";
    // -- Price --
    $html .= nTabs($start).nTabs(2).    "<div class='produkt-preis'>\n";
    $html .= nTabs($start).nTabs(3).        "{$price} € / kg\n";
    $html .= nTabs($start).nTabs(2).    "</div>\n";
    $html .= nTabs($start).nTabs(1)."</div>\n";

    $html .= nTabs($start)."</li>\n";

    return $html;
}



// ===================================
// ========== SHOPPING CART ==========
// ===================================

function generateCartHTML($prodId, $name, $amount, $price, $imageUrl, $altText)
{
    $name = ucfirst($name);

    $start = 7;
    $html  = "\n";

    $total      = (float)$price * (int)$amount;
    $total      = number_format_drop_zero_decimals($total, 2);
    $currentUrl = $_SERVER['REQUEST_URI'];


    $html .= nTabs($start)."<tr>\n";
    // Picture
    $html .= nTabs($start).nTabs(1)."<td>\n";
    $html .= nTabs($start).nTabs(2).    "<a href='?c=shop&a=productDetails&prodId={$prodId}' type='no-hover'>\n";
    $html .= nTabs($start).nTabs(3).        "<img src='{$imageUrl}' alt='{$altText}' class='shoppin-cart-item-picture'>\n";
    $html .= nTabs($start).nTabs(2).    "</a>\n";
    $html .= nTabs($start).nTabs(1)."</td>\n";
    // Name & Amount
    $html .= nTabs($start).nTabs(1)."<td>\n";
    $html .= nTabs($start).nTabs(2).    "<h3 class='produktname'>{$name}</h3>\n";
    $html .= nTabs($start).nTabs(2).    "<p>{$amount} x {$price}€/kg</p>\n";
    $html .= nTabs($start).nTabs(1)."</td>\n";
    // Price
    $html .= nTabs($start).nTabs(1)."<td>\n";
    $html .= nTabs($start).nTabs(2).    "<form method='get'>\n";
    $html .= nTabs($start).nTabs(3).        "<input type='hidden' name='removeItem' value='{$prodId}'>\n";
    $html .= nTabs($start).nTabs(3).        "<input type='hidden' name='currentUrl' value='{$currentUrl}'>\n";
    $html .= nTabs($start).nTabs(3).        "<button type='submit' class='shopping-cart-remove-item-btn noHover'><b>[entfernen]</b></button>\n";
    $html .= nTabs($start).nTabs(2).    "</form>\n";
    $html .= nTabs($start).nTabs(2).    "<p>{$total}€</p>\n";
    $html .= nTabs($start).nTabs(1)."</td>\n";

    $html .= nTabs($start)."</tr>\n";


    return $html;
}



// ===============================
// ===== EXTRACTED FUNCTIONS =====
// ===============================

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

    return "";
}


// from : https://www.php.net/manual/en/function.money-format.php#112890
// rounds the decimal numbers depending on $n_decimals
// if the price is x.0 or x.00 the decimal is dropped
function number_format_drop_zero_decimals($n, $n_decimals)
{
    return ((floor($n) == round($n, $n_decimals)) ? number_format($n) : number_format($n, $n_decimals));
}


?>
