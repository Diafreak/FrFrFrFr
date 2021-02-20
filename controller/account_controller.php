<?php


class AccountController extends Controller
{

    // ========================================
    // =============== REGISTER ===============
    // ========================================

    public function actionRegistration()
    {
        $userInformation   = [];
        $errors            = [];
        $validRegistration = false;


        // check if "Registrieren"-button is pressed
        if(isset($_POST['submitRegistration']))
        {
            $userInformation['firstName']       = htmlspecialchars($_POST['firstname']          ) ?? null;
            $userInformation['lastName']        = htmlspecialchars($_POST['lastname']           ) ?? null;
            $userInformation['email']           = strtolower( htmlspecialchars($_POST['email']) ) ?? null;
            $userInformation['password']        = htmlspecialchars($_POST['password']           ) ?? null;
            $userInformation['passwordConfirm'] = htmlspecialchars($_POST['passwordconfirm']    ) ?? null;
            // every new registered user gets the role "customer"
            $userInformation['role_id']         = getRoleId('customer', $errors);

            validateInputs($userInformation, $errors);

            if (count($errors) === 0)
            {
                $userInformation['passwordHash'] = generatePasswordHash($userInformation['password']);
                register($userInformation);
                $validRegistration = true;
            }
        }

        // push variables to the view
        $this->setParam('errors', $errors);
        $this->setParam('validRegistration', $validRegistration);
    }




    // =====================================
    // =============== LOGIN ===============
    // =====================================

    public function actionLogin()
    {
        // continue to login if user isn't logged in already
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
        {
            // check if "Login"-button is pressed
            if (isset($_POST['submitLogin']))
            {
                // check if both input-fields are not empty
                if (!empty($_POST['email'])
                &&  !empty($_POST['password']))
                {
                    //get input from login-form
                    $email    = htmlspecialchars($_POST['email']);
                    $password = htmlspecialchars($_POST['password']);

                    login($email, $password, $this->params['errors']);
                }
                else
                {
                    $this->setParam('errors', 'Alle Felder müssen ausgefüllt sein!');
                }
            }
        }
        else
        {
            // if user is logged in already he is redirected to his account
            header('Location: ?c=account&a=account');
        }
    }




    // =======================================
    // =============== ACCOUNT ===============
    // =======================================

    public function actionAccount()
    {
        $errors = [];
        $userId = $_SESSION['userId'];

        // page can only be accessed if the user is logged in, otherwise he is redirected to login
        if ($_SESSION['loggedIn'] === true)
        {
            // check if "Email Ändern"-button is clicked
            if (isset($_POST['submitEmailChange']))
            {
                changeEmail(strtolower(htmlspecialchars($_POST['changeEmail'])), $errors);
            }


            // check if "Password Ändern"-button is clicked
            if (isset($_POST['submitPasswordChange']))
            {
                changePassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['newPasswordConfirm'], $errors);
            }


            // check if "Adresse Ändern/Hinzufügen"-button is clicked
            if (isset($_POST['submitAddress']))
            {
                submitAddress( htmlspecialchars($_POST['address_street']),
                               htmlspecialchars($_POST['address_number']),
                               htmlspecialchars($_POST['address_city']),
                               htmlspecialchars($_POST['address_zip']),
                               $userId, $errors );
            }


            // check if "Abmelden"-button is pressed
            if (isset($_POST['submitLogout']))
            {
                logOut();
            }


            // if an user has an address get street, number, zip and city and push it to the view to display them
            if (userHasAddress())
            {
                $address = getUserAddress($userId);

                foreach ($address as $key => $addressData)
                {
                    $this->setParam($key, $addressData);
                }
            }


            $user = getCurrentUser();

            // push all user-data to the view so it can be displayed
            foreach ($user as $key => $userData)
            {
                $this->setParam($key, $userData);
            }
        }
        else
        {
            header('Location: ?c=account&a=login');
        }
        // push errors to view
        $this->setParam('errors', $errors);
    }

}


?>