<h1><?=$test?></h1>

<img src=<?=IMAGESPATH . 'user-placeholder.png'?> alt="User-Picture" class="user-picture">

<form method="post">
    <br>
    <input type="submit" name="submitLogout" value="Logout">
</form>
<br>
<form method="post">
        <input type="string" name="changeEmail" id="chemail" placeholder="E-Mail Adresse ändern" autocapitalize="off">
        <input type="submit" name="submitEmailChange" value="Change">
</form>
<br>
<form method="post">
        <input type="password" name="changePassword" id="chpassword" placeholder="Passwort ändern" autocapitalize="off">
        <input type="submit" name="submitPasswordChange" value="Change">
</form>
<br>
<form method="post">
        <input type="string" name="address_street" id="address_street" placeholder="Straße hinzufügen / ändern" autocapitalize="off">
        <br>
        <input type="string" name="address_number" id="address_number" placeholder="Hausnummer hinzufügen / ändern" autocapitalize="off">
        <br>
        <input type="string" name="address_zip" id="address_zip" placeholder="Postleitzahl hinzufügen / ändern" autocapitalize="off">
        <input type="submit" name="submitAddress" value="Submit">
</form>