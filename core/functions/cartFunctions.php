<?php


function getUrlWithoutCart()
{
    // get current URL
    $currentURL = $_SERVER['REQUEST_URI'];

    // remove the "&cart=show" after the c&a so the page you were on is loaded without the cart
    return str_replace("&cart=show", "", $currentURL);
}


?>