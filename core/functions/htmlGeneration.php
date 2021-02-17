<?php


// =================================
// ========== SHOP-LAYOUT ==========
// =================================

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
    $total      = (float)$price * (int)$amount;
    $currentUrl = $_SERVER['REQUEST_URI'];

    $html  = "<tr>\n";

    // Picture
    $html .=     "<td>\n";
    $html .=         "<a href='?c=shop&a=productDetails&prodId={$prodId}' type='no-hover'>\n";
    $html .=             "<img src='{$imageUrl}' alt='{$altText}' width='25px' height='25px'>\n";        // !!! CSS !!!
    $html .=         "</a>\n";
    $html .=     "</td>\n";

    // Name & Amount
    $html .=     "<td>\n";
    $html .=         "<h3 class='produktname'>{$name}</h3>\n";
    $html .=         "<p>{$amount} x {$price}€/kg</p>\n";
    $html .=     "</td>\n";

    // Price
    $html .=     "<td>\n";
    $html .=         "<form method='get'>\n";
    $html .=             "<input type='hidden' name='removeItem' value='{$prodId}'>\n";
    $html .=             "<input type='hidden' name='currentUrl' value='{$currentUrl}'>\n";
    $html .=             "<button type='submit' class=''>[entfernen]</button>\n";
    $html .=         "</form>\n";
    $html .=         "<p>{$total}0€</p>\n";
    $html .=     "</td>\n";

    $html .= "</tr>\n";

    return $html;
}


?>
