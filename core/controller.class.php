<?php

class Controller
{
    // =====================
    // ===== VARIABLES =====
    // =====================

    private $action     = null;
    private $controller = null;

    protected $params = [];



    // =======================
    // ===== CONSTRUCTOR =====
    // =======================

    public function __construct($_action = null, $_controller = null)
    {
        $this->action     = $_action;
        $this->controller = $_controller;
    }



    // =============================
    // ===== GENERAL FUNCTIONS =====
    // =============================

    public function render()
    {
        // generate the view path
        $viewPath = $this->viewPath($this->controller, $this->action); //VIEWSPATH.$this->controller.DIRECTORY_SEPARATOR.$this->action.'.php';

        // check if the file exists
        if(!file_exists($viewPath))
        {
            // redirect to error page 404 because not found
            header('Location: index.php?c=errors&a=error404');
            //header('Location: index.php?c=errors&a=error404&error=viewpath');
        }

        // extract the params array to get all needed variables for the view
        extract($this->params);


        // include the navigation bar which is visible on all pages
        require VIEWSPATH.'navigationBar.php';
        // include the shopping cart which can be called on all pages
        require VIEWSPATH.'shoppingCart.php';

        // include the view
        include $viewPath;
    }



    // ===========================
    // ===== SETTER & GETTER =====
    // ===========================

    //sets params which will be used for the render-method
    protected function setParam($key, $value = null)
    {
        $this->params[$key] = $value;
    }



    // ===============================
    // ===== EXTRACTED FUNCTIONS =====
    // ===============================

    // generates the include-path for the site you want to render
    private function viewPath($controllerName, $action)
    {
        return __DIR__.'/../views/'.$controllerName.'/'.$action.'.php';
    }



    // ======================
    // ===== DESTRUCTOR =====
    // ======================

    public function __destruct()
    {
        $this->action     = null;
        $this->controller = null;
        $this->params     = null;
    }
}

?>