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


        // check if "In den Warenkorb" is clicked
        if (isset($_POST['submitProduct']))
        {
            if ($_SESSION['loggedIn'] === true)
            {
                $userId    = $_SESSION['userId'];
                $cartId    = $_SESSION['cartId'];
                $amount    = $_POST['amount'];
                $prodId    = $_GET['prodId'];
                $noInStock = getNumberInStock($prodId);

                isProductAlreadyInCart($cartId, $prodId, $amount);

                // if the selected amount is higher than the numberInStock, the amount is set to the numberInStock
                if ($amount > $noInStock)
                {
                    $amount = $noInStock;
                }

                // if the item is already in your cart, update the amount of it instead of creating a new entry
                if ($amount != $_POST['amount'])
                {
                    updateAmountInCart($cartId, $prodId, $amount);
                }
                // if the selected amount is higher than the numberInStock, nothing will happen to
                // prevent unnecessary database updating/inserting
                else if (!$amount == $noInStock)
                {
                    addItemToCart($amount, $noInStock, $prodId, $cartId);
                }

                header('Location: ?c=shop&a=products#success');             // !!! CHANGE DYNAMIC URL !!!
            }
            else
            {
                // redirect to login if the user wants to add an item to their cart
                header('Location: ?c=account&a=login');                         //!!! CHANGE !!!
            }
        }

    }

}


?>