<?php


class AccountController extends Controller
{
    public function actionRegistration()
    {
        $userInformation   = [];
        $errors            = [];
        $validRegistration = false;


        // check if "Registrieren"-button is pressed
        if(isset($_POST['submitRegistration']))
        {
            $userInformation['firstName']       = htmlspecialchars($_POST['firstname']      ) ?? null;
            $userInformation['lastName']        = htmlspecialchars($_POST['lastname']       ) ?? null;
            $userInformation['email']           = htmlspecialchars($_POST['email']          ) ?? null;
            $userInformation['password']        = htmlspecialchars($_POST['password']       ) ?? null;
            $userInformation['passwordConfirm'] = htmlspecialchars($_POST['passwordconfirm']) ?? null;


            validateInputs($userInformation, $errors);

            $userInformation['passwordHash'] = $userInformation['password'];        //!!! CHANGE !!!

            if (count($errors) === 0)
            {
                register($userInformation);
                $validRegistration = true;
            }
        }


        // push variables to the view
        $this->setParam('errors', $errors);
        $this->setParam('validRegistration', $validRegistration);
    }



    public function actionLogin()
    {
        $this->setParam('test', 'Login');

        // continue to login if user isn't logged in already
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)       //??? change to only false ???
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

                    logIn($email, $password, false, $this->params['errors']);
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



    public function actionAccount()
    {
        $this->params['test'] = ($_SESSION['loggedIn'] === true) ? "Eingeloggt" : "Ausgeloggt" ;//"ACCOUNT";

        if ($_SESSION['loggedIn'] === true)
        {
            if (isset($_POST['submitLogout']))
            {
                logOut();
            }
        }
        else
        {
            header('Location: ?c=account&a=login');
        }
    }
}


?>