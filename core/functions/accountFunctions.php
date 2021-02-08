<?php


function register($userInformation)
{
    $user = new User($userInformation);
    $user->insert();
}



function logIn($email = '', $password = '', $rememberMe = false, &$error = '')
{
    $db = $GLOBALS['db'];

    $userData = [];

    $userID_DB   = '';
    $password_DB = '';


    if ($rememberMe === true)
    {
        $userID   = $_COOKIE['userID'];
        $password = $_COOKIE['passwordHash'];
    }
    else
    {
        $userID = getUserID($email);
    }


    try
    {
        // get the user-information for the entered email from the database
        $sqlUserData = "SELECT * FROM user WHERE id = {$userID};";
        $userData    = $db->query($sqlUserData)->fetchAll();                // [0] => Array (['id'] => 1, ..., ['email'] => max)

        $userID_DB   = $userData[0]['id']           ?? '';                  //= isset($userData[0]['email']) ? $userData[0]['email'] : ''; 
        $password_DB = $userData[0]['passwordHash'] ?? '';

        // check if email and password match                //!!! CHANGE TO EMAIL? !!!
        if ($userID   == $userID_DB
        &&  $password == $password_DB)
        {
            $_SESSION['loggedIn'] = true;
            header('Location: index.php');

            // check if "Angemeldet bleiben?" is selected
            if (isset($_POST['rememberMe']))
            {
                rememberMe($userID, $password_DB);
            }
        }
        else
        {
            $error = "Nutzername oder Password falsch!";
        }
    }
    catch (\PDOException $e)
    {
        $error = "Nutzername oder Password falsch!";
    }
}



function logOut()
{
    setcookie('userID',       '', -1, '/');
    setcookie('passwordHash', '', -1, '/');

    $_SESSION['loggedIn'] = false;
    unset($_SESSION['loggedIn']);

    session_destroy();
    header('Location: index.php');
}



function validateInputs($userInformation, &$errors)
{
    extract($userInformation);

    if ($firstName === null || mb_strlen($firstName) < 2)    //!!! 2 durch schema - min ersetzten !!!
    {
        $errors['firstName'] = 'Vorname muss mind. 2 Zeichen lang sein.'; //!!! 2 durch schema - min ersetzten !!!
    }

    if ($lastName === null || mb_strlen($lastName) < 2)
    {
        $errors['lastName'] = 'Nachnname muss mind. 2 Zeichen lang sein';
    }

    if ($email === null || mb_strlen($email) < 2)                           //!!! Regex check for xxx@xxx.xx!!!
    {
        $errors['email'] = 'E-Mail ist zu kurz, bitte mehr als 2 Zeichen.';
    }

    if ($password === null || mb_strlen($password) < 8)
    {
        $errors['password'] = 'Passwort muss mind. 8 Zeichen lang sein.';
    }

    if ($password !== $passwordConfirm)
    {
        $errors['passwordMatch'] = 'Passwörter stimmen nicht überein.';
    }

    if (doesEmailExist($email))
    {
        $errors['emailTaken'] = "Email ist bereits vorhanden.";
    }
}

?>