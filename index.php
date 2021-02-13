<?php

require_once 'config/imports.php';

session_start();


$controllerName = $_GET['c'] ?? 'pages';
$actionName     = $_GET['a'] ?? 'home';

$controllerPath = CONTROLLERSPATH.$controllerName.'_controller.php';


//if a cookie is set: log in user automatically
if (isset($_COOKIE['sessionId']))
{
    loginWithSessionId();
}


if (file_exists($controllerPath))
{
    require_once $controllerPath;
    $controllerClassName = ucfirst($controllerName).'Controller';

    if (class_exists($controllerClassName))
    {
        $controllerInstance = new $controllerClassName($actionName, $controllerName);
        $actionMethodName   = 'action'.ucfirst($actionName);

        if (method_exists($controllerInstance, $actionMethodName))
        {
            $controllerInstance->{$actionMethodName}();
        }
        else { header('Location: index.php?c=errors&a=error404'); }

    }
    else { header('Location: index.php?c=errors&a=error404'); }

}
else { header('Location: index.php?c=errors&a=error404'); }

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=STYLESPATH."style.css"?>>
    <link rel="stylesheet" href=<?=STYLESPATH."banner.css"?>>

    <!-- load page-font from GoogleFonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Averia+Serif+Libre&display=swap"> 

    <title>FrFrFrFr Frontpage</title>
</head>

<body>
    <?php
        // this method will render the view of the called action
        // for this the the file in the views directory will be included
        $controllerInstance->render();
    ?>

    <footer>
        <p>Test test<br>
            Hier wird getestet</p>
    </footer>
</body>
</html>


<!--
    echo("<pre>");
    var_dump($productDetails);
    echo("</pre>");
-->