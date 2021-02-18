<?php


class ShopController extends Controller
{

    public function actionFruits()
    {
        $product = "fruit";
        $this->setParam('product', $product);

        $tags =  $_GET['t'] ?? "";
        $this->setParam('tags', $tags);
    }



    public function actionVegetables()
    {
        $product = "vegetable";
        $this->setParam('product', $product);

        $tags =  $_GET['t'] ?? "";
        $this->setParam('tags', $tags);
    }



    public function actionProductDetails()
    {
        $errors = [];
        $prodId = $_GET['prodId'];

        // get all product-details from the product that has been clicked on
        $productDetails = getProductDetails($prodId, $errors)[0];

        if ($productDetails == null)
        {
            $this->setParam('errors', $errors);
        }
        else
        {
            // push all necessary product-info from $productDetails to the view
            foreach ($productDetails as $key => $value)
            {
                $this->setParam($key, $value);
            }
        }


        // check if "In den Warenkorb" is clicked
        if (isset($_POST['submitProduct']))
        {
            addItemToCart($prodId, $productDetails);
        }
    }

}


?>