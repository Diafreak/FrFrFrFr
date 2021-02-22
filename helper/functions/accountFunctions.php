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

function loginWithCookie()
{
    $pwHash = $_COOKIE['pwHash'];
    $userId = $_COOKIE['userId'];

    $db       = $GLOBALS['db'];
    $userData = [];

    try
    {
        // get the user-information for the entered email from the database
        $sqlUserData = "SELECT * FROM user WHERE id = {$userId};";
        $userData    = $db->query($sqlUserData)->fetchAll()[0];

        $userId_DB       = $userData['id']           ?? '';
        $passwordHash_DB = $userData['passwordHash'] ?? '';

        // check if email and password match
        if ($userId == $userId_DB
        &&  $pwHash == $passwordHash_DB)
        {
            setSessionVariables(true, $userId);
        }
    }
    catch (\PDOException $e)
    {
        $errors["automaticLogin"] = "Automatische Anmeldung fehlgeschlagen.";
    }
}



function login($email, $password, &$errors)
{
    $db       = $GLOBALS['db'];
    $userData = [];
    $userId   = getUserId($email, $errors);

    try
    {
        // get the user-information for the entered email from the database
        $sqlUserData = "SELECT * FROM user WHERE id = {$userId};";
        $userData    = $db->query($sqlUserData)->fetchAll()[0];

        $userId_DB       = $userData['id']           ?? '';
        $passwordHash_DB = $userData['passwordHash'] ?? '';

        // check if email and password match
        if ($userId == $userId_DB
        &&  password_verify($password, $passwordHash_DB)
        // this is just a "helper" so we can insert an admin-role with the "demo-data.sql"
        ||  $userData['email'] == 'admin' && $password == $passwordHash_DB)
        {
            setSessionVariables(true, $userId);

            // check if "Angemeldet bleiben?" is selected
            if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'remember')
            {
                rememberMe($userId, $passwordHash_DB);
            }

            // redirect to the front page and show the "Anmeldung Erfolgreich"-banner
            header('Location: index.php#success');
        }
        else
        {
            $errors['invalidLogin'] = "Nutzername oder Password falsch!";
        }
    }
    catch (\PDOException $e)
    {
        $errors['invalidLogin'] = "Nutzername oder Password falsch!";
    }
}



function rememberMe($userId, $pwHash)
{
    $duration = time() + 3600 * 24 * 30;
    setcookie('userId', $userId, $duration, '/');
    setcookie('pwHash', $pwHash, $duration, '/');
}




// ======================================
// =============== LOGOUT ===============
// ======================================

function logOut()
{
    setcookie('userId', '', -1, '/');
    setcookie('pwHash', '', -1, '/');
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



function userHasAddress()
{
    $db     = $GLOBALS['db'];
    $userId = $_SESSION['userId'];

    try
    {
        $sqlAddressId = "SELECT address_id FROM user WHERE id = '{$userId}';";
        $addressId    = $db->query($sqlAddressId)->fetchAll();

        return $addressId[0]['address_id'] == null ? false : true;
    }
    catch (\PDOException $e)
    {
        $errors['addressId'] = "Nutzer besitzt keinen Adresse.";
    }
    return false;
}



function getUserAddress($userId)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUserAddress = "SELECT    a.zip, a.city, a.street, a.number
                           FROM      address a
                           RIGHT JOIN user    u ON a.id = u.address_id
                           WHERE     u.id = '{$userId}';";

        $userAddress = $db->query($sqlUserAddress)->fetchAll();

        return $userAddress[0] ?? null;
    }
    catch (\PDOException $e)
    {
        $errors['addressUser'] = "Nutzer besitzt keinen Adresse.";
    }
}



function submitAddress($street, $number, $city, $zip, $userId, &$errors)
{
    $addressId = getAddressId($userId, $errors);

    if ($addressId == null)
    {
        addNewAddress($street, $number, $city, $zip, $userId, $errors);
    }
    else
    {
        if ($street != null) updateAddress($addressId, 'street', $street, $errors);
        if ($number != null) updateAddress($addressId, 'number', $number, $errors);
        if ($city   != null) updateAddress($addressId, 'city',   $city,   $errors);
        if ($zip    != null) updateAddress($addressId, 'zip',    $zip,    $errors);
    }
}




// =====================================================
// =============== NEW-PRODUCT FUNCTIONS ===============
// =====================================================

function addNewProduct($prodName, $price, $quantity, $description, $categorie, $tags, &$errors)
{
    if ($prodName == "" || $price == "" || $quantity == "" || $description == "" || $categorie == "" || $tags == "")
    {
        $errors["emptyFields"] = "Bitte alle Felder ausfüllen.";
    }
    else
    {
        $price = str_replace(',', '.', $price);

        // check if the product name already exists in the database
        if (doesProdNameAlreadyExist($prodName, $errors)) $errors['nameExistence'] = "Das angebene Produkt existiert bereits.";

        // check if entered value are numbers and a price in the range of 0.01€ - 99.99€
        if (!validPrice($price, $errors))                 $errors['invalidPrice'] = "Der Preis muss zwischen 0€ und 100€ liegen.";

        // check if quantity is greater than 0
        if (!validQuantity($quantity, $errors))           $errors['invalidQuantity'] = "Menge muss größer als 0 sein.";

        // check if the selected category exists in the database
        if (!validCategory($categorie, $errors))          $errors['invalidCategory'] = "Die angegebene Kategorie existiert nicht.";

        // check if the selected image in valid and pass it to $prodImageFile
        $prodImageFile = validProdImage($errors);


        if (count($errors) == 0)
        {
            insertNewProduct($prodName, $price, $quantity, $description, $categorie, $tags, $prodImageFile, $errors);
            uploadProdImage($prodImageFile, $errors);
        }
    }
}



// insert the new product into the database
function insertNewProduct($prodName, $price, $quantity, $description, $category, $tags, $imageUrl, &$errors)
{
    $db = $GLOBALS['db'];

    $catId = getCatId($category, $errors);

    // insert tags into database and get the id from them to write them into the $prodDetails
    $tags = new ProductTags($tags = ['tags' => $tags]);
    $tags->insert();
    $insertedTagsId = $db->lastInsertId();


    $prodDetails = [ 'name'           => $prodName,
                     'price'          => $price,
                     'numberInStock'  => $quantity,
                     'description'    => $description,
                     'category_id'    => $catId,
                     'productTags_id' => $insertedTagsId ];

    //insert the product into the database and get the inserted id for the related product-image
    $product = new Product($prodDetails);
    $product->insert();
    $insertedProdId = $db->lastInsertId();


    $imageDetails = [ 'imageUrl'   => $imageUrl,
                      'altText'    => $prodName,
                      'product_id' => $insertedProdId ];

    $image = new Image($imageDetails);
    $image->insert();


    // unset all created objects
    unset($tags);
    unset($product);
    unset($image);
}



function uploadProdImage($prodImageFile, &$errors)
{
    // if there are no errors, try uploading the image
    if (count($errors) == 0)
    {
        if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $prodImageFile))
        {
            $errors["imageUpload"] = "Beim Hochladen des Bildes ist ein Fehler aufgetreten.";
        }
    }
    else
    {
        $errors["imageUpload"] = "Das Bild konnte nicht hochgeladen werden.";
    }
}




// ======================================================
// =============== VALIDATION NEW PRODUCT ===============
// ======================================================

function doesProdNameAlreadyExist($prodName, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlProdId = "SELECT id FROM product WHERE name = '{$prodName}';";
        $prodId    = $db->query($sqlProdId)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['prodId'] = "Die angegebene Prod-ID existiert nicht.";
    }

    return empty($prodId) ? false : true;
}



function validPrice($price, &$errors)
{
    if ((float)$price > 0)
    {
        $regexPrice = "/^([1-9][0-9]|0)(\.[0-9]{0,2})?$/";
        return preg_match($regexPrice, $price);
    }
    return false;
}



function validQuantity($quantity)
{
    return $quantity > 0 ? true : false;
}



function validCategory($catName, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlCatId = "SELECT id FROM category WHERE name = '{$catName}s';";
        $catId    = $db->query($sqlCatId)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['prodId'] = "Die angegebene Kategorie existiert nicht.";
    }

    return empty($catId) ? true : false;
}



function validProdImage(&$errors)
{
    if (!empty($_FILES["productImage"]["name"]))
    {
        // save-path for image
        $prodImageDir  = IMAGESPATH."products/";
        $prodImageFile = $prodImageDir . basename($_FILES["productImage"]["name"]);

        // check if file already exists
        if (file_exists($prodImageFile))
        {
            $errors["imageExists"] = "Diese Datei existiert bereits.";
        }

        // check file size
        if ($_FILES["productImage"]["size"] > MAX_IMAGE_SIZE_IN_KB)
        {
            $errors["imageSize"] = "Bild darf höchstens ".MAX_IMAGE_SIZE_IN_KB."kb groß sein.";
        }

        // get the file-type by reading the string after the "." of a file
        $imageFileType = strtolower( pathinfo($prodImageFile, PATHINFO_EXTENSION) );

        // only allow jpg/jpeg-images
        if ($imageFileType != "jpg" && $imageFileType != "jpeg")
        {
            $errors["imageType"] = "Es sind nur JPG oder JPEG-Dateien erlaubt.";
        }

        return $prodImageFile;
    }
    else
    {
        $errors["noImage"] = "Bitte ein Bild auswählen.";
    }
}




// =================================================
// =============== GENERAL FUNCTIONS ===============
// =================================================

function generatePasswordHash($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
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




// ===========================================================
// =============== VALIDATION REGISTER / LOGIN ===============
// ===========================================================

function validateRegisterInputs($userInformation, &$errors)
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
    $maxPWLength = $user->getSchema()['passwordHash']['max'];

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
        $errors['pwMinLength'] = "Passwort muss mind. $minPWLength Zeichen lang sein.";
    }
    else if (mb_strlen($password) > $maxPWLength)
    {
        $errors['pwMaxLength'] = "Passwort darf max. $maxPWLength Zeichen lang sein.";
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




// =================================================
// =============== ADDRESS FUNCTIONS ===============
// =================================================

function getAddressId($userId, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUserAddressId = "SELECT address_id FROM user WHERE id = '{$userId}';";
        $userAddressId    = $db->query($sqlUserAddressId)->fetchAll();

        return $userAddressId[0]['address_id'] ?? null;
    }
    catch (\PDOException $e)
    {
        $errors['addressIdUser'] = "Nutzer besitzt keinen Adresse.";
    }
    return false;
}



function addNewAddress($street, $number, $city, $zip, $userId, &$errors)
{
    // if user has no address no fields can be empty
    if ($street != null
    ||  $number != null
    ||  $city   != null
    ||  $zip    != null)
    {
        $addressInfo = [ 'street' => $street,
                         'number' => $number,
                         'city'   => $city,
                         'zip'    => $zip ];

        $address = new Address();
        $schema  = $address->getSchema();

        validateAddressInfo($addressInfo, $schema, $errors);

        unset($address);

        if (count($errors) == 0)
        {
            $db = $GLOBALS['db'];

            $address = new Address($addressInfo);
            $address->insert();

            // get id of inserted address and set it in the adddress_id-row of the user
            $addressId = $db->lastInsertId();
            updateUserAddressId($addressId, $userId, $errors);

            unset($address);
        }
    }
    else
    {
        $errors['addressEmpty'] = "Alle Felder müssen ausgefüllt sein.";
    }
}



function validateAddressInfo($addressInfo, $schema, &$errors)
{
    foreach ($addressInfo as $key => $info)
    {
        // check if a 'max'-constrait is set
        if(isset($schema[$key]['min']))
        {
            $maxLength = $schema[$key]['min'];
            if(mb_strlen($info) < $maxLength)
            {
                $errors["addressMinLength{$key}"] = ucfirst($key) . " muss mind. {$maxLength} Zeichen lang sein.";
            }
        }

        // check if a 'min'-constrait is set
        if(isset($schema[$key]['max']))
        {
            $maxLength = $schema[$key]['max'];
            if(mb_strlen($info) > $maxLength)
            {
                $errors["addressMaxLength{$key}"] = ucfirst($key) . " darf nicht länger als {$maxLength} sein.";
            }
        }
    }
}



function updateUserAddressId($addressId, $userId, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUpdateAddressId = "UPDATE user SET address_id = '{$addressId}' WHERE id = '{$userId}';";
        $updateStatement    = $db->prepare($sqlUpdateAddressId);
        $updateStatement->execute();
    }
    catch (\PDOException $e)
    {
        $errors['addressIdUser'] = "Adresse konnte nicht geupdatet werden.";
    }
}



function updateAddress($addressId, $column, $value, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUpdateAddress = "UPDATE address SET {$column} = '{$value}' WHERE id = '{$addressId}';";
        $updateStatement  = $db->prepare($sqlUpdateAddress);
        $updateStatement->execute();
    }
    catch (\PDOException $e)
    {
        $errors['addressUpdate'] = ucfirst($column)." in Address konnte nicht geupdatet werden.";
    }
}




// ===============================================
// =============== EMAIL FUNCTIONS ===============
// ===============================================

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
    $userId = getUserId($email, $error);

    // if there is no user-id the email doesn't exist in the database
    if (empty($userId))
    {
        return false;
    }

    // if there is an user-id the email already exists in the database
    return true;
}




// ===================================================
// =============== EXTRACTED FUNCTIONS ===============
// ===================================================

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



// gets an email and returns the userId from the database if the email is in the database
function getUserId($email, &$errors)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUserID = "SELECT id FROM user WHERE email = '{$email}';";
        $userData  = $db->query($sqlUserID)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['invalidEmail'] = "Die angegebene Email existiert nicht.";
    }

    return $userData[0]['id'] ?? '';
}



function setSessionVariables($loggedIn, $userId)
{
    $_SESSION['loggedIn'] = $loggedIn;
    $_SESSION['userId']   = $userId;
    $_SESSION['cartId']   = getCartId($userId);
    $_SESSION['isAdmin']  = isAdmin($userId);
}



function isAdmin($userId)
{
    $db = $GLOBALS['db'];

    try
    {
        $sqlUserRole = " SELECT r.name
                         FROM   role r
                         JOIN   user u ON r.id = u.role_id
                         WHERE  u.id = '{$userId}';";
        $userRole = $db->query($sqlUserRole)->fetchAll();
    }
    catch (\PDOException $e)
    {
        $errors['invalidUserId'] = "Die angegebene User-ID existiert nicht.";
    }

    return $userRole[0]['name'] == "admin" ? true : false;
}

?>