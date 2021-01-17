<?php

require_once 'config/database.php';
require_once 'config/init.php';

require_once 'core/controller.class.php';
require_once 'core/model.class.php';

require_once FUNCTIONSPATH.'_generalFunctions.php';
require_once FUNCTIONSPATH.'generateShopLayout.php';

foreach(glob('models/*.php') as $modelClass)
{
    require_once $modelClass;
}

?>