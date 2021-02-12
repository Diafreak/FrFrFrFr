<?php


function rememberMe($sessionId)
{
    $duration = time() + 3600 * 24 * 30;
    setcookie('sessionId', $sessionId, $duration, '/');
    echo($_COOKIE['sessionId']);
}


// gets an email and returns the userID from the database if the email is in the database
function getUserID($email, &$error)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUserID = "SELECT id FROM user WHERE email = '{$email}';";
        $userData  = $db->query($sqlUserID)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $error = "Die angegebene Email existiert nicht.";
    }

    return $userData[0]['id'] ?? '';
}


// check for the registration if the given email is already in the database
function doesEmailExist($email, &$error)
{
    $userID = getUserID($email, $error);

    // if there is no user-id the email doesn't exist in the database
    if (empty($userID))
    {
        return false;
    }

    // if there is an user-id the email already exists in the database
    return true;
}


?>