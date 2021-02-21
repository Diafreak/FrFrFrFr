<?php


class PagesController extends Controller
{
    public function actionHome(){}


    public function actionContact()
    {
        $test = "KONTAKT";
        $this->setParam('test', $test);
    }


    public function actionCurrent()
    {
        $test = "AKTUELLES";
        $this->setParam('test', $test);
    }
}

?>