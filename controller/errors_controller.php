<?php

class ErrorsController extends Controller
{
    public function actionError404()
    {
        //$_GET['error']; => handle different errors
        $test = "ERROR 404 NOT FOUND";
        $this->setParam('test', $test);
    }
}

?>