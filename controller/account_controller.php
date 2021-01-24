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
            $firstName       = htmlspecialchars($_POST['firstname']       ?? null);
            $lastName        = htmlspecialchars($_POST['lastname']        ?? null);
            $email           = htmlspecialchars($_POST['email']           ?? null);
            $password        = htmlspecialchars($_POST['password']        ?? null);
            $passwordConfirm = htmlspecialchars($_POST['passwordconfirm'] ?? null);


            if ($firstName === null || mb_strlen($firstName) < 2)    //2 durch schema - min ersetzten
            {
                $errors['firstName'] = 'Vorname ist zu kurz, bitte mehr als 2 Zeichen.'; //2 durch schema - min ersetzten
            }

            if ($lastName === null || mb_strlen($lastName) < 2)
            {
                $errors['lastName'] = 'Nachnname ist zu kurz, bitte mehr als 2 Zeichen.';
            }

            if ($email === null || mb_strlen($email) < 2)
            {
                $errors['email'] = 'E-Mail ist zu kurz, bitte mehr als 2 Zeichen.';
            }

            if ($password === null || mb_strlen($password) < 8)
            {
                $errors['password'] = 'Passwort ist zu kurz, bitte mehr als 8 Zeichen.';
            }

            if ($password !== $passwordConfirm)
            {
                $errors['passwordMatch'] = 'Passwörter stimmen nicht überein.';
            }

            if (doesEmailExist($email))
            {
                $errors['emailTaken'] = "Email ist bereits vorhanden.";
            }

            if (count($errors) === 0)
            {
                echo("Success");
                register($firstName, $lastName, $email, $password);
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

        //continue to login if user isn't logged in already
        if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
        {
            //check if "Login"-button is pressed
            if (isset($_POST['submitLogin']))
            {
                //check if both input-fields are not empty
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