<?php

// include database
require_once __DIR__.'/../../config/database.php';


// check if an email is set in POST
if (isset($_POST['e']) && $_POST['e'] != null && $_POST['e'] != "")
{
    $email = $_POST['e'];
}
else
{
    $email = "";
}

// get the related userId from the email
$userId = getUserId($email);

// if there is no user-id the email doesn't exist in the database
if ($userId == null)
{
    echo("false");
}
// if there is an user-id the email already exists in the database
else
{
    echo("true");
}



function getUserId($email)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUserId = "SELECT id FROM user WHERE email = '{$email}';";
        $userId    = $db->query($sqlUserId)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $error['invalidEmail'] = "Die angegebene Email existiert nicht.";
    }

    return $userId[0]['id'] ?? null;
}


?>