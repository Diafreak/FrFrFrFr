<?php

// init.php initialises the global PATH-constants
// loaded first so they can be used for further initialization
require_once 'config/init.php';

// load database-initialization
require_once CONFIGPATH.'database.php';

// load all the core-files
require_once COREPATH.'controller.class.php';
require_once COREPATH.'model.class.php';

// load functions in the core-folder
require_once FUNCTIONSPATH.'_generalFunctions.php';
require_once FUNCTIONSPATH.'accountFunctions.php';
require_once FUNCTIONSPATH.'generateShopLayout.php';

// load each model from the models-folder
foreach(glob(MODELSPATH.'*.php') as $modelClass)
{
    require_once $modelClass;
}

?>