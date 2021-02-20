<?php


class ShopController extends Controller
{

    public function actionFruits()
    {
        // put search-tag(s) as querry parameter in url
        // redirect to products that fit the search tag before generating the html for the shop
        if (isset($_GET['searchTags']) && $_GET['searchTags'] != "")
        {
            $controller = $_GET['c'];
            $action     = $_GET['a'];
            $tags       = str_replace(" ", "+", $_GET['searchTags']);

            header("Location: ?c={$controller}&a={$action}&t={$tags} ");
        }

        // set category so the correct products will be displayed
        $product = "fruit";
        $this->setParam('product', $product);

        // get search-tags if they are set and push them to the view so only products
        // that fit the tags are displayed
        $tags =  $_GET['t'] ?? "";
        $this->setParam('tags', $tags);
    }



    public function actionVegetables()
    {
        $product = "vegetable";
        $this->setParam('product', $product);

        // echo($_GET['search']);

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