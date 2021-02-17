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
    $total = (float)$price * (int)$amount;
    $html  = "<tr>";

    // Picture
    $html .=     "<td>";
    $html .=         "<a href='?c=shop&a=productDetails&prodId={$prodId}' type='no-hover'>";
    $html .=             "<img src='{$imageUrl}' alt='{$altText}' width='25px' height='25px'>";        // !!! CSS !!!
    $html .=         "</a>";
    $html .=     "</td>";

    // Name & Amount
    $html .=     "<td>";
    $html .=         "<h3 class='produktname'>{$name}</h3>";
    $html .=         "<p>{$amount} x {$price}€/kg</p>";
    $html .=     "</td>";

    // Price
    $html .=     "<td>";
    $html .=         "{$total}0€";
    $html .=     "</td>";

    $html .= "</tr>";

    return $html;
}


?>