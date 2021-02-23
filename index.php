<?php

require_once 'config/imports.php';


session_start();


// set default values for controller and cation
$controllerName = $_GET['c'] ?? 'pages';
$actionName     = $_GET['a'] ?? 'home';


$controllerPath = CONTROLLERSPATH.$controllerName.'_controller.php';


//if a cookie is set: log in user automatically
if (isset($_COOKIE['userId']) && $_COOKIE['userId'] != "" && $_COOKIE['userId'] != null
&&  isset($_COOKIE['pwHash']) && $_COOKIE['pwHash'] != "" && $_COOKIE['pwHash'] != null)
{
    loginWithCookie();
}


// check if the called controller-file exists
if (file_exists($controllerPath))
{
    // include the given controller-file
    require_once $controllerPath;
    // get controller-class name
    $controllerClassName = ucfirst($controllerName).'Controller';

    // check if the controller-class in the controller-file exists
    if (class_exists($controllerClassName))
    {
        // create a new controller instanze with given action and controller
        $controllerInstance = new $controllerClassName($actionName, $controllerName);
        // get the called action
        $actionMethodName   = 'action'.ucfirst($actionName);

        // check if called action in the controller exists
        if (method_exists($controllerInstance, $actionMethodName))
        {
            // execute the called action from the called controller
            $controllerInstance->{$actionMethodName}();
        }
        else { header('Location: ?c=errors&a=error404'); }

    }
    else { header('Location: ?c=errors&a=error404'); }

}
else { header('Location: ?c=errors&a=error404'); }

?>



<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href=<?=STYLESPATH."style.css"?>>
    <link rel="stylesheet" href=<?=STYLESPATH."banner.css"?>>
    <link rel="stylesheet" href=<?=STYLESPATH."forms.css"?>>

    <!-- Icon in tab-bar -->
    <link rel="shortcut icon" href="<?=IMAGESPATH."/navBar/ferret.svg"?>" type="image/x-icon" />

    <!-- page title -->
    <title>FrFrFrFr <?=ucfirst($actionName)?></title>
</head>

            <!-- if the shopping cart is shown scrolling is disabled -->
<body class="<?= (isset($_GET['cart']) && $_GET['cart'] == 'show') ? 'no-scrolling' : '' ?>">
    <div class="wrapall">
        <div class="stuff">
            <?php
                // show shopping cart if the icon is clicked
                if (isset($_GET['cart']) && $_GET['cart'] == 'show')
                {
                    include VIEWSPATH.'shoppingCart.php';
                }

                // remove item from shopping cart if the remove-button is pressed
                if (isset($_GET['removeItem']))
                {
                    removeItemFromCart($_GET['removeItem'], $_GET['currentUrl']);
                }

                // this method will render the view of the called action
                // for this the the file in the views directory will be included
                $controllerInstance->render();
            ?>
        </div>

        <footer>
            <p>Test test<br>
                Hier wird getestet</p>
        </footer>
    </div>
</body>
</html>