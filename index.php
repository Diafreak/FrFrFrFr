<?php

require_once 'config/imports.php';


session_start();    //??? wohin ???


$controllerName = $_GET['c'] ?? 'pages';
$actionName     = $_GET['a'] ?? 'home';

$controllerPath = CONTROLLERSPATH.$controllerName.'_controller.php';


//if a cookie is set: log in user automatically
if (isset($_COOKIE['userID']))
{
    logIn(true);
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
    <link rel="stylesheet" href="assets/styles/style.css">
    <title>FrFrFrFr Frontpage</title>
</head>

<body>
    <?php
        // this method will render the view of the called action
        // for this the the file in the views directory will be included
        $controllerInstance->render();
    ?>
</body>
</html>