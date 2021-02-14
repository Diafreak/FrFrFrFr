<?php


// ================================================
// ===== FUNCTIONS USED BY ACCOUNT_CONTROLLER =====
// ================================================

function register($userInformation)
{
    $user = new User($userInformation);
    $user->insert();

    // get the ID from the registered user to create his own shopping cart
    $db = $GLOBALS['db'];
    $insertedId = $db->lastInsertId();
    $userId = [ 'user_id' => $insertedId ];

    // assign a shopping cart for the registered user
    $cart = new ShoppingCart($userId);
    $cart->insert();

    unset($cart);
    unset($user);
}


function loginWithSessionId()
{
    session_destroy();
    session_id($_COOKIE['sessionId']);
    session_start();

    $_SESSION['loggedIn'] = true;
}


function login($email, $password, &$error)
{
    $db       = $GLOBALS['db'];
    $userData = [];
    $userID   = getUserID($email, $error);

    try
    {
        // get the user-information for the entered email from the database
        $sqlUserData = "SELECT * FROM user WHERE id = {$userID};";
        $userData    = $db->query($sqlUserData)->fetchAll();

        $userID_DB       = $userData[0]['id']           ?? '';
        $passwordHash_DB = $userData[0]['passwordHash'] ?? '';

        // check if email and password match
        if ($userID == $userID_DB
        &&  password_verify($password, $passwordHash_DB)
        // this is just a "helper" so we can insert an admin-role with the "demo-data.sql"
        ||  $userData[0]['email'] == 'admin' && $password == $passwordHash_DB)
        {
            $_SESSION['loggedIn'] = true;
            $_SESSION['userID']   = $userID;
            // redirect to the front page and show the "Anmeldung Erfolgreich"-banner
            header('Location: index.php#success');

            // check if "Angemeldet bleiben?" is selected
            if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'remember')
            {
                $sessionID = session_id();
                rememberMe($sessionID);
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
    setcookie('sessionId', '', -1, '/');
    session_destroy();
    header('Location: index.php#logout');
}


function generatePasswordHash($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}



function validateInputs($userInformation, &$errors)
{
    // extract the keys from $userInformation into individual variables
    extract($userInformation);

    // validate all inputs from the registration form
    validateFirstName($firstName, $errors);
    validateLastName( $lastName,  $errors);

    checkEmailExistence($email, $errors);
    validateEmail(      $email, $errors);

    validatePassword($password, $errors);

    validatePasswordConfirm($password, $passwordConfirm, $errors);
}



function rememberMe($sessionId)
{
    $duration = time() + 3600 * 24 * 30;
    setcookie('sessionId', $sessionId, $duration, '/');
}



function getRoleId($role, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlRoleID = "SELECT id FROM role WHERE name = '{$role}';";
        $roleID    = $db->query($sqlRoleID)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['roleId'] = "Die angegebene Rolle existiert nicht.";
    }

    return $roleID[0]['id'] ?? null;
}



// ===============================
// ===== EXTRACTED FUNCTIONS =====
// ===============================

function validateFirstName($firstName, &$errors)
{
    $user = new User();
    $minLength = $user->getSchema()['firstName']['min'];
    $maxLength = $user->getSchema()['firstName']['max'];

    if ($firstName === null || mb_strlen($firstName) < $minLength)
    {
        $errors['firstName'] = "Vorname muss mind. $minLength Zeichen lang sein.";
    }
    else if (mb_strlen($firstName) > $maxLength)
    {
        $errors['firstName'] = "Vorname darf max. $maxLength Zeichen lang sein.";
    }

    unset($user);
}


function validateLastName($lastName, &$errors)
{
    $user = new User();
    $minLength = $user->getSchema()['lastName']['min'];
    $maxLength = $user->getSchema()['lastName']['max'];

    if ($lastName === null || mb_strlen($lastName) < $minLength)
    {
        $errors['lastName'] = "Nachname muss mind. $minLength Zeichen lang sein.";
    }
    else if (mb_strlen($lastName) > $maxLength)
    {
        $errors['lastName'] = "Nachname darf max. $maxLength Zeichen lang sein.";
    }

    unset($user);
}


function checkEmailExistence($email, &$errors)
{
    if (doesEmailExist($email, $errors))
    {
        $errors['emailTaken'] = "Email ist bereits vorhanden.";
    }
}


function validateEmail($email, &$errors)
{
    $user = new User();
    $maxEmailLength = $user->getSchema()['lastName']['max'];

    if ($email === null || invalidEmail($email) || mb_strlen($email) > $maxEmailLength)
    {
        $errors['email']       = 'Bitte eine valide Email-Adresse eingeben.';
        $errors['emailLength'] = "Email darf max. $maxEmailLength Zeichen lang sein.";
    }

    unset($user);
}


function validatePassword($password, &$errors)
{
    $user = new User();
    $minPWLength = $user->getSchema()['passwordHash']['min'];

    $uppercase    = preg_match('@[A-Z]@', $password);
    $lowercase    = preg_match('@[a-z]@', $password);
    $number       = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if ($password === null
    || !$uppercase
    || !$lowercase
    || !$number
    || !$specialChars
    ||  mb_strlen($password) < $minPWLength)
    {
        $errors['passwordLength'] = "Passwort muss mind. $minPWLength Zeichen lang sein.";
        $errors['passwordChars']  = "Passwort muss mind. 1 Groß- und Kleinbuchstaben, 1 Zahl und 1 Sonderzeichen enthalten.";
    }

    unset($user);
}


function validatePasswordConfirm($password, $passwordConfirm, &$errors)
{
    if ($password !== $passwordConfirm)
    {
        $errors['passwordMatch'] = 'Passwörter stimmen nicht überein.';
    }
}



// check if email has pattern of x@x.xx
function invalidEmail($email)
{
    $regexEmail = "/^.+@.+\..{2,6}$/";

    // return false if email matches the regex
    if (preg_match($regexEmail, $email))
    {
        return false;
    }

    // return true if the email doesn't match the regex
    return true;
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