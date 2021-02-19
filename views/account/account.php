<h1>Mein Account</h1>

<? require_once FUNCTIONSPATH.'htmlGeneration.php' ?>


<!-- User-Image -->
<img src=<?=IMAGESPATH . 'user-placeholder.png'?> alt="Profilbild" class="user-picture">
<br>


<!-- Firstname & Lastname -->
<?= ucfirst($firstName) . " " . ucfirst($lastName) ?>
<br><br>


<!-- "Abmelden"-Button -->
<form method="post">
    <input type="submit" name="submitLogout" value="Abmelden">
</form>
<br>


<!-- Change Email -->
<form method="post">
    Aktuelle E-Mail: <?= strtolower($email) ?> <br>
    Neue E-Mail:
    <input type="string" name="changeEmail" id="chemail" placeholder="E-Mail Adresse ändern" autocapitalize="off"
     value="<?= (isset($errors) && $errors != null) && isset($_POST['changeEmail']) ? strtolower(htmlspecialchars($_POST['changeEmail'])) : '' ?>">

    <input type="submit" name="submitEmailChange" value="Ändern">

    <!-- Errors -->
    <? isset($errors) && isset($_POST['submitEmailChange']) ? printErrors($errors) : '' ?>
</form>
<br>


<!-- Change Password -->
<form method="post">
    Altes Passwort:
    <input type="password" name="oldPassword" id="oldpassword" placeholder="Altes Passwort" autocapitalize="off"><br>
    Neues Passwort:
    <input type="password" name="newPassword" id="newpassword" placeholder="Neues Passwort" autocapitalize="off"><br>
    Passwort bestätigen:
    <input type="password" name="newPasswordConfirm" id="newpasswordconfirm" placeholder="Passwort bestätigen" autocapitalize="off">

    <input type="submit" name="submitPasswordChange" value="Ändern">

    <!-- Errors -->
    <? isset($errors) && isset($_POST['submitPasswordChange']) ? printErrors($errors) : '' ?>
</form>
<br>


<!-- Change/Add Address -->
<form method="post">

    <? if (userHasAddress()) : ?>
        Aktuelle Adresse: <?= "{$street} {$number}, {$zip} {$city}"?>
        <? $action = "ändern" ?>
    <? else : ?>
        Noch keine Addresse vorhanden
        <? $action = "hinzufügen" ?>
    <? endif; ?>
    <br>

    Straße:
    <input type="string" name="address_street" id="address_street" placeholder="Straße <?=$action?>" autocapitalize="off"
     value="<?= (isset($errors) && $errors != null) && isset($_POST['address_street']) ? ucfirst(htmlspecialchars($_POST['address_street'])) : '' ?>"><br>
    Hausnummer:
    <input type="string" name="address_number" id="address_number" placeholder="Hausnummer <?=$action?>" autocapitalize="off"
     value="<?= (isset($errors) && $errors != null) && isset($_POST['address_number']) ? htmlspecialchars($_POST['address_number']) : '' ?>"><br>
    Stadt
    <input type="string" name="address_city" id="address_city" placeholder="Stadt <?=$action?>" autocapitalize="off"
     value="<?= (isset($errors) && $errors != null) && isset($_POST['address_city']) ? ucfirst(htmlspecialchars($_POST['address_city'])) : '' ?>"><br>
    PLZ:
    <input type="string" name="address_zip" id="address_zip" placeholder="Postleitzahl <?=$action?>" autocapitalize="off"
     value="<?= (isset($errors) && $errors != null) && isset($_POST['address_zip']) ? htmlspecialchars($_POST['address_zip']) : '' ?>">

    <input type="submit" name="submitAddress" value="<?= ucfirst($action) ?>">

    <!-- Errors -->
    <? isset($errors) && isset($_POST['submitAddress']) ? printErrors($errors) : '' ?>
</form>