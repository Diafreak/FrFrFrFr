<?php

class AccountController extends Controller
{
    public function actionRegistration()
    {
        $errors            = [];
        $validRegistration = false;

        // oh my good, we get data
        if(isset($_POST['submitRegistration']))
        {
            $firstName       = $_POST['firstname'] ?? null;
            $lastName        = $_POST['lastname'] ?? null;
            $email           = $_POST['email'] ?? null;
            $password        = $_POST['password'] ?? null;
            $passwordConfirm = $_POST['passwordconfirm'] ?? null;


            if($firstName === null || mb_strlen($firstName) < 2)
            {
                $errors['firstName'] = 'Name ist zu kurz, bitte mehr als 2 Zeichen.';
            }

            if($email === null || mb_strlen($email) < 2)
            {
                $errors['email'] = 'E-Mail ist zu kurz, bitte mehr als 2 Zeichen.';
            }

            if($password === null || mb_strlen($password) < 8)
            {
                $errors['password'] = 'Passwort ist zu kurz, bitte mehr als 8 Zeichen.';
            }


            if(count($errors) === 0)
            {
                // TODO: save to database
                if( true ) // fake true because no db connected yet
                {
                    $success = true;
                }
            }
        }

        // push to the variables to the view
        $this->setParam('error', $errors);
        $this->setParam('validRegistration', $validRegistration);
    }



    public function actionLogin()
    {
        $this->setParam('test', 'Login');
        //$this->setParam('error', '');


        //continue to login if user isn't logged in already
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
        {
            //check if "Login"-button is pressed
            if (isset($_POST['submitLogin']))
            {
                //check if both input-fields are not empty
                if (!empty($_POST['username'])
                &&  !empty($_POST['password']))
                {
                    //get input from login-form
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    logIn($username, $password, false, $this->params['error']);
                }
                else
                {
                    $this->setParam('error', 'Alle Felder müssen ausgefüllt sein!');
                }
            }
        }
        else
        {
            //if user is logged in already he is redirected to his account
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