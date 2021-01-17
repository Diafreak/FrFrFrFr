<?php


function rememberMe($userID, $password_DB)
{
    $duration = time() + 3600 * 24 * 30;
    setcookie('userID',       $userID,      $duration, '/');
    setcookie('passwordHash', $password_DB, $duration, '/');
}


function logIn($username = '', $password = '', $rememberMe = false, &$error = '')
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
        $userID = getUserID($username, $db);
    }


    try
    {
        //get the user-information for the entered username from the database
        $sqlUserData = "SELECT * FROM user WHERE id = {$userID};";
        $userData    = $db->query($sqlUserData)->fetchAll();    // [0] => Array (['id'] => 1, ..., ['username'] => max)

        $userID_DB   = $userData[0]['id']           ?? '';    //= isset($userData[0]['username']) ? $userData[0]['username'] : ''; 
        $password_DB = $userData[0]['passwordHash'] ?? '';

        //check if username and password match
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



function getUserID($username, $db)
{
    $sqlUserID = "SELECT * FROM user WHERE email = '{$username}';";
    $userData  = $db->query($sqlUserID)->fetchAll();

    return $userData[0]['id'] ?? '';
}
?>