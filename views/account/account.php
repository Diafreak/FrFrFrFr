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
        <input type="string" name="address" id="address" placeholder="Addresse hinzufügen / ändern" autocapitalize="off">
        <input type="submit" name="submitAddress" value="Submit">
</form>