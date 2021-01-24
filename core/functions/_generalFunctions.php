<?php


function rememberMe($userID, $password_DB)
{
    $duration = time() + 3600 * 24 * 30;
    setcookie('userID',       $userID,      $duration, '/');
    setcookie('passwordHash', $password_DB, $duration, '/');
}


function getUserID($email, $db)
{
    $sqlUserID = "SELECT id FROM user WHERE email = '{$email}';";
    $userData  = $db->query($sqlUserID)->fetchAll();

    return $userData[0]['id'] ?? '';
}


?>