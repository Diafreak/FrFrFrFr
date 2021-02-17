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
    $start = 7;
    $html  = "\n";

    $total      = (float)$price * (int)$amount;
    $total      = number_format_drop_zero_decimals($total, 2);
    $currentUrl = $_SERVER['REQUEST_URI'];


    $html .= nTabs($start)."<tr>\n";
    // Picture
    $html .= nTabs($start).    "<td>\n";
    $html .= nTabs($start).        "<a href='?c=shop&a=productDetails&prodId={$prodId}' type='no-hover'>\n";
    $html .= nTabs($start).            "<img src='{$imageUrl}' alt='{$altText}' width='25px' height='25px'>\n";        // !!! CSS !!!
    $html .= nTabs($start).        "</a>\n";
    $html .= nTabs($start).    "</td>\n";
    // Name & Amount
    $html .= nTabs($start).    "<td>\n";
    $html .= nTabs($start).        "<h3 class='produktname'>{$name}</h3>\n";
    $html .= nTabs($start).        "<p>{$amount} x {$price}€/kg</p>\n";
    $html .= nTabs($start).    "</td>\n";
    // Price
    $html .= nTabs($start).    "<td>\n";
    $html .= nTabs($start).        "<form method='get'>\n";
    $html .= nTabs($start).            "<input type='hidden' name='removeItem' value='{$prodId}'>\n";
    $html .= nTabs($start).            "<input type='hidden' name='currentUrl' value='{$currentUrl}'>\n";
    $html .= nTabs($start).            "<button type='submit' class='' style='color:red; padding:0; border:none; background:none; cursor:pointer'><b>[entfernen]</b></button>\n";
    $html .= nTabs($start).        "</form>\n";
    $html .= nTabs($start).        "<p>{$total}€</p>\n";
    $html .= nTabs($start).    "</td>\n";

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
