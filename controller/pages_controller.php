<?php


class PagesController extends Controller
{

    public function actionHome()
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) /*Brauchen wir das überhaupt noch?*/
        {
            $test = "Home - Eingeloggt!";
        }
        else
        {
            $test = "HOME - Nicht eingeloggt :(";
        }

        $this->setParam('test', $test);
    }


    public function actionAbout()
    {
        $test = "ÜBER UNS";
        $this->setParam('test', $test);
    }


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


    public function actionProducts()
    {
        $test = "PRODUKTE";
        $this->setParam('test', $test);
    }

}

?>