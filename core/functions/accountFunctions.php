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
        $userData    = $db->query($sqlUserData)->fetchAll();

        $userID_DB   = $userData[0]['id']           ?? '';                  //= isset($userData[0]['email']) ? $userData[0]['email'] : ''; 
        $password_DB = $userData[0]['passwordHash'] ?? '';

        // check if email and password match                //!!! CHANGE TO EMAIL? !!!
        if ($userID   == $userID_DB
        &&  $password == $password_DB)
        {
            $_SESSION['loggedIn'] = true;
            // redirect to the front page and show the "Anmeldung Erfolgreich"-banner
            header('Location: index.php#success');

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



// ===============================
// ===== EXTRACTED FUNCTIONS =====
// ===============================

function validateFirstName($firstName, &$errors)
{
    $user = new User();                                                             //??? Better solution ???
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
    $user = new User();                                                             //??? Better solution ???
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
    if (doesEmailExist($email))
    {
        $errors['emailTaken'] = "Email ist bereits vorhanden.";
    }
}


function validateEmail($email, &$errors)
{
    $regexEmail = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";      //??? 4 doesn't work ???

    // check if email has pattern of x@x.xx
    if ($email === null || !preg_match($regexEmail, $email))
    {
        $errors['email'] = 'Bitte eine valide Email-Adresse eingeben.';
    }
}


function validatePassword($password, &$errors)
{
    //$regexPassword = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";               // !!! NEED REGEX !!!

    if ($password === null || mb_strlen($password) < 6)  //!preg_match($regexPassword, $password))
    {
        $errors['password'] = 'Passwort muss mind. 6 Zeichen lang sein.';
    }
}


function validatePasswordConfirm($password, $passwordConfirm, &$errors)
{
    if ($password !== $passwordConfirm)
    {
        $errors['passwordMatch'] = 'Passwörter stimmen nicht überein.';
    }
}

?>