<?php

class Controller
{
    private $action     = null;
    private $controller = null;

    protected $params = [];


    //constructor
    public function __construct($_action = null, $_controller = null)
    {
        $this->action     = $_action;
        $this->controller = $_controller;
    }


    public function render()
    {
        // generate the view path
        $viewPath = $this->viewPath($this->controller, $this->action); //VIEWSPATH.$this->controller.DIRECTORY_SEPARATOR.$this->action.'.php';

        // check the file exists
        if(!file_exists($viewPath))
        {
            // redirect to error page 404 because not found
            header('Location: index.php?c=errors&a=error404');
            //header('Location: index.php?c=errors&a=error404&error=viewpath');
            //exit(0); // ??? ???
        }

        // extract the params array to get all needed variables for the view
        extract($this->params);
        
        // just include the view here, it's like putting the code of the php file by copy paste on this position.
        include __DIR__.'/../views/navigationBar.php';
        include $viewPath;
    }



    /**
    * Setter for params, which will be used for the render method
    * @param  String $key   Key in the param array
    * @param  Mixed  $value Key value
    */
    protected function setParam($key, $value = null)
    {
        $this->params[$key] = $value;
    }


    //generates the include-path for the site you want to render
    private function viewPath($controllerName, $action)
    {
        return __DIR__.'/../views/'.$controllerName.'/'.$action.'.php';
    }


    //destructor
    public function __destruct()
    {
        $this->action     = null;
        $this->controller = null;
        $this->params     = null;
    }
}

?>