<?php


// ========================================
// =============== REGISTER ===============
// ========================================

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




// =====================================
// =============== LOGIN ===============
// =====================================

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
    $userID   = getUserId($email, $error);

    try
    {
        // get the user-information for the entered email from the database
        $sqlUserData = "SELECT * FROM user WHERE id = {$userID};";
        $userData    = $db->query($sqlUserData)->fetchAll()[0];

        $userID_DB       = $userData['id']           ?? '';
        $passwordHash_DB = $userData['passwordHash'] ?? '';

        // check if email and password match
        if ($userID == $userID_DB
        &&  password_verify($password, $passwordHash_DB)
        // this is just a "helper" so we can insert an admin-role with the "demo-data.sql"
        ||  $userData['email'] == 'admin' && $password == $passwordHash_DB)
        {
            $_SESSION['loggedIn'] = true;
            $_SESSION['userId']   = $userID;
            $_SESSION['cartId']   = getCartId($userID);

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




// ======================================
// =============== LOGOUT ===============
// ======================================

function logOut()
{
    setcookie('sessionId', '', -1, '/');
    session_destroy();
    header('Location: index.php#logout');
}




// ============================================
// =============== USER-ACCOUNT ===============
// ============================================

function getCurrentUser()
{
    $db     = $GLOBALS['db'];
    $userId = $_SESSION['userId'];

    try
    {
        $sqlCurrentUser = "SELECT * FROM user WHERE id = '{$userId}';";
        return $db->query($sqlCurrentUser)->fetchAll()[0] ?? null;
    }
    catch (\PDOException $e)
    {
        $errors['currentUser'] = "Der angegebene Nutzer existiert nicht.";
    }
}



function changeEmail($email, &$errors)
{
    // check if email has pattern of x@x.xx
    validateEmail($email, $errors);

    if (count($errors) == 0)
    {
        updateEmail($email, $errors);
    }
}



function changePassword($oldPassword, $newPassword, $newPasswordConfirm, &$errors)
{
    // check if the old passwort matches with the database
    validateOldPassword($oldPassword, $errors);
    // check if new passwort is equal the old password
    checkIfOldAndNewPasswordAreEqual($oldPassword, $newPassword, $errors);
    // check if passwort fits regex
    validatePassword($newPassword, $errors);
    // check if new password and new password-confirm are equal
    validatePasswordConfirm($newPassword, $newPasswordConfirm, $errors);

    if (count($errors) == 0)
    {
        updatePassword($newPassword, $errors);
    }
}




// =================================================
// =============== GENERAL FUNCTIONS ===============
// =================================================

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

    validateEmail($email, $errors);

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



function getCartId($userId, &$errors = [])
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCartId = "SELECT id FROM shoppingcart WHERE user_id = '{$userId}';";
        $cartId    = $db->query($sqlCartId)->fetchAll()[0];

        return $cartId['id'] ?? null;
    }
    catch (\PDOException $e)
    {
        $errors['cartId'] = "Dieser Nutzer besitzt keinen Einkaufswagen.";
    }
}




// ====================================================
// =============== VALIDATION FUNCTIONS ===============
// ====================================================

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



function validateEmail($email, &$errors)
{
    checkEmailExistence($email, $errors);

    $user = new User();
    $maxEmailLength = $user->getSchema()['email']['max'];

    if ($email == null)
    {
        $errors['emailEmpty'] = 'Email darf nicht leer sein.';
    }
    else if (mb_strlen($email) > $maxEmailLength)
    {
        $errors['emailLength'] = "Email darf max. $maxEmailLength Zeichen lang sein.";
    }
    else if (invalidEmail($email))
    {
        $errors['email'] = 'Bitte eine valide Email-Adresse eingeben.';
    }

    unset($user);
}



function validatePassword($password, &$errors)
{
    $user        = new User();
    $minPWLength = $user->getSchema()['passwordHash']['min'];

    $uppercase    = preg_match('@[A-Z]@', $password);
    $lowercase    = preg_match('@[a-z]@', $password);
    $number       = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if ($password == null)
    {
        $errors['pwEmpty'] = "Passwort darf nicht leer sein.";
    }
    else if (mb_strlen($password) < $minPWLength)
    {
        $errors['pwLength'] = "Passwort muss mind. $minPWLength Zeichen lang sein.";
    }
    else if (!$uppercase || !$lowercase || !$number || !$specialChars)
    {
        $errors["pwChars"] = "Passwort muss noch mind. ";

        if (!$uppercase)    $errors["pwChars"] .= "1 Großbuchstaben, ";
        if (!$lowercase)    $errors["pwChars"] .= "1 Kleinbuchstaben, ";
        if (!$number)       $errors["pwChars"] .= "1 Zahl, ";
        if (!$specialChars) $errors["pwChars"] .= "1 Sonderzeichen, ";

        $errors["pwChars"]  = rtrim($errors["pwChars"], ', ');
        $errors["pwChars"] .= " enthalten";
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



function validateOldPassword($oldPassword, &$errors)
{
    $db     = $GLOBALS['db'];
    $userId = $_SESSION['userId'];

    try
    {
        $sqlUserID = "SELECT passwordHash FROM user WHERE id = '{$userId}';";
        $pwHashDB  = $db->query($sqlUserID)->fetchAll();

        if (!password_verify($oldPassword, $pwHashDB[0]['passwordHash']))
        {
            // this is just a "helper" because "demo-data.sql" doesn't insert a passwordHash
            if (!($userId == "1" && $oldPassword == $pwHashDB[0]['passwordHash']))
            {
                $errors['passwordOld'] = "Altes Passwort ist nicht korrekt.";
            }
        }
    }
    catch (\PDOException $e)
    {
        $errors['passwordOldUser'] = "Der Nutzer existiert nicht.";
    }
}




// ===================================================
// =============== EXTRACTED FUNCTIONS ===============
// ===================================================

function checkEmailExistence($email, &$errors)
{
    if (doesEmailExist($email, $errors))
    {
        $errors['emailTaken'] = "Email ist bereits vorhanden.";
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



function updateEmail($email, &$errors)
{
    $db     = $GLOBALS['db'];
    $userId = $_SESSION['userId'];

    try
    {
        $sqlUpdateEmail  = "UPDATE user SET email = '{$email}' WHERE id = '{$userId}';";
        $updateStatement = $db->prepare($sqlUpdateEmail);
        $updateStatement->execute();
    }
    catch (\PDOException $e)
    {
        $errors['updateEmail'] = "Email konnte nicht geupdated werden.";
    }
}



// check for the registration if the given email is already in the database
function doesEmailExist($email, &$error)
{
    $userID = getUserId($email, $error);

    // if there is no user-id the email doesn't exist in the database
    if (empty($userID))
    {
        return false;
    }

    // if there is an user-id the email already exists in the database
    return true;
}



function checkIfOldAndNewPasswordAreEqual($oldPassword, $newPassword, &$errors)
{
    if ($oldPassword == $newPassword) $errors['passwordNewEqualOld'] = "Neues Passwort darf nicht gleich dem alten Passwort sein.";
}



function updatePassword($newPassword, &$errors)
{
    $db     = $GLOBALS['db'];
    $userId = $_SESSION['userId'];

    $newPasswordHash = generatePasswordHash($newPassword);

    try
    {
        $sqlUpdateEmail  = "UPDATE user SET passwordHash = '{$newPasswordHash}' WHERE id = '{$userId}';";
        $updateStatement = $db->prepare($sqlUpdateEmail);
        $updateStatement->execute();
    }
    catch (\PDOException $e)
    {
        $errors['updateEmail'] = "Passwort konnte nicht geändert werden.";
    }
}


// gets an email and returns the userID from the database if the email is in the database
function getUserId($email, &$error)
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


?>