<?php


class ShopController extends Controller
{

    public function actionProducts()
    {
        $test = "PRODUKTE";
        $this->setParam('test', $test);
    }


    public function actionProductDetails()
    {
        $this->setParam('test', "INFOOO");

        $db = $GLOBALS['db'];
        //$_GET['prodId'];

        $this->setParam('imageSrc', "assets/images/products/apple.jpg");
        $this->setParam('altText',  "Apfel");
    }

}

?>