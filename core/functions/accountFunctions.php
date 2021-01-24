<?php


function register($firstName, $lastName, $email, $password)
{

    // $user = new User();
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
        //get the user-information for the entered email from the database
        $sqlUserData = "SELECT * FROM user WHERE id = {$userID};";
        $userData    = $db->query($sqlUserData)->fetchAll();    // [0] => Array (['id'] => 1, ..., ['email'] => max)

        $userID_DB   = $userData[0]['id']           ?? '';    //= isset($userData[0]['email']) ? $userData[0]['email'] : ''; 
        $password_DB = $userData[0]['passwordHash'] ?? '';

        //check if email and password match         //!!! CHANGE TO EMAIL??? !!!
        if ($userID   == $userID_DB
        &&  $password == $password_DB)
        {
            $_SESSION['loggedIn'] = true;
            header('Location: index.php');

            //check if "Angemeldet bleiben?" is selected
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

    $_SESSION['loggedIn'] = false;    //??? nötig ???

    session_destroy();
    header('Location: index.php');
}


?>