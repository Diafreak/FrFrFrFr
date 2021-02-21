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


        // ===== [ REGISTRIEREN-Button ] =====
        if(isset($_POST['submitRegistration']))
        {
            $userInformation['firstName']       = strtolower( htmlspecialchars($_POST['firstname'])     ) ?? null;
            $userInformation['lastName']        = strtolower( htmlspecialchars($_POST['lastname'] )     ) ?? null;
            $userInformation['email']           = strtolower( htmlspecialchars($_POST['email'])         ) ?? null;
            $userInformation['password']        =             htmlspecialchars($_POST['password']       ) ?? null;
            $userInformation['passwordConfirm'] =             htmlspecialchars($_POST['passwordconfirm']) ?? null;
            // every new registered user gets the role "customer"
            $userInformation['role_id']         = getRoleId('customer', $errors);

            validateInputs($userInformation, $errors);

            // register new user if there are no errors
            if (count($errors) == 0)
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
        $errors = [];

        // continue to login if user isn't logged in already
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
        {
            // ===== [ LOGIN-Button ] =====
            if (isset($_POST['submitLogin']))
            {
                // check if both input-fields are not empty
                if (!empty($_POST['email'])
                &&  !empty($_POST['password']))
                {
                    //get input from login-form
                    $email    = strtolower(htmlspecialchars($_POST['email'])  );
                    $password =            htmlspecialchars($_POST['password']);

                    login($email, $password, $errors);
                }
                else
                {
                    $errors['invalidInput'] = 'Alle Felder müssen ausgefüllt sein!';
                }
            }
        }
        else
        {
            // if user is logged in already he is redirected to his account
            header('Location: ?c=account&a=account');
        }

        $this->setParam('errors', $errors);
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
            // ===== [ EMAIL Ändern ] =====
            if (isset($_POST['submitEmailChange']))
            {
                changeEmail(strtolower(htmlspecialchars($_POST['changeEmail'])), $errors);
            }


            // ===== [ PASSWORT Ändern ] =====
            if (isset($_POST['submitPasswordChange']))
            {
                changePassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['newPasswordConfirm'], $errors);
            }


            // ===== [ ADRESSE Hinzufügen / Ändern ] =====
            if (isset($_POST['submitAddress']))
            {
                submitAddress( htmlspecialchars($_POST['address_street']),
                               htmlspecialchars($_POST['address_number']),
                               htmlspecialchars($_POST['address_city']),
                               htmlspecialchars($_POST['address_zip']),
                               $userId, $errors );
            }


            // ===== [ ABMELDEN ] =====
            if (isset($_POST['submitLogout']))
            {
                logOut();
            }


            // push street, number, zip and city to view if the user has an address
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