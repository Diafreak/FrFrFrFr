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
        $db     = $GLOBALS['db'];
        $prodId = $_GET['prodId'];

        // get all product-details from the product that has been clicked on
        $sqlCurrentProduct = "SELECT p.name, p.price, p.numberInStock, p.description,
                                     i.imageUrl, i.altText
                              FROM product p
                              JOIN image i ON p.id = i.product_id
                              WHERE p.id = {$prodId};";
        $productDetails = $db->query($sqlCurrentProduct)->fetchAll();

        // push all necessary product-info from $productDetails to the view
        foreach ($productDetails[0] as $key => $value)
        {
            $this->setParam($key, $value);
        }
    }

}


?>