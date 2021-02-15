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
        $errors = [];
        $prodId = $_GET['prodId'];

        // get all product-details from the product that has been clicked on
        $productDetails = getProductDetails($prodId, $errors);

        if ($productDetails == null)
        {
            $this->setParam('errors', $errors);
        }
        else
        {
            // push all necessary product-info from $productDetails to the view
            foreach ($productDetails[0] as $key => $value)
            {
                $this->setParam($key, $value);
            }
        }


        if (isset($_POST['submitProduct']))
        {
            if ($_SESSION['loggedIn'] === true)
            {
                $userId    = $_SESSION['userID'];
                $amount    = $_POST['amount'];
                $prodId    = $_GET['prodId'];
                $noInStock = getNumberInStock($prodId);
                $cartId    = getCartId($userId, $errors);

                // if the selected amount is higher than the numberInStock, the amount is set to the numberInStock
                if ($amount > $noInStock)
                {
                    $amount = $noInStock;
                }

                // create array with all necessary info of the product so it can be added to the cart
                $prodInfo = [ 'product_id'      => $prodId,
                              'quantity'        => $amount,
                              'shoppingCart_id' => $cartId ];

                // add item and amount to your shopping cart
                $prodInCart = new ProductInShoppingCart($prodInfo);
                $prodInCart->insert();
                header('Location: ?c=shop&a=products#success');             // !!! CHANGE DYNAMIC URL !!!
                unset($prodInCart);
            }
            else
            {
                header('Location: ?c=account&a=login');     // CHANGE !!!
            }
        }

    }

}


?>