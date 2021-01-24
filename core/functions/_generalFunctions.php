<?php


function rememberMe($userID, $password_DB)
{
    $duration = time() + 3600 * 24 * 30;
    setcookie('userID',       $userID,      $duration, '/');
    setcookie('passwordHash', $password_DB, $duration, '/');
}


// gets an email and returns the userID from the database if the email is in the database
function getUserID($email)
{
    $db = $GLOBALS['db'];
    $sqlUserID = "SELECT id FROM user WHERE email = '{$email}';";
    $userData  = $db->query($sqlUserID)->fetchAll();

    return $userData[0]['id'] ?? '';
}


// check for the registration if the given email is already in the database
function doesEmailExist($email)
{
    $userID = getUserID($email);

    // if there is no user-id the email doesn't exist in the database
    if (empty($userID))
    {
        return false;
    }

    // if there is an user-id the email already exists in the database
    return true;
}


?>