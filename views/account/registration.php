
<?php if($validRegistration === true) : ?>
    <!--<div class="success-message">
        Vielen Dank, für dein Konto! Sie werden automatisch auf die Login-Seite weitergeleitet.
        <meta http-equiv="refresh" content="5; URL=index.php?c=pages&a=login">
    </div>-->
    <?="";//header('Location: ?c=account&a=login'); ?>
<?php else : ?>

<div class="registration-form user-form">
    <h1>Registrierung</h1>

    <form method="post">

        <!-- First Name -->
        <input type="string" name="firstname" id="firstname" placeholder="Vorname" autocapitalize="on"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '' ?>">

        <!-- Last Name -->
        <input type="string" name="lastname" id="lastname" placeholder="Nachname" autocapitalize="on"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '' ?>">

        <!-- Email -->
        <input type="string" name="email" id="email" placeholder="E-Mail" autocapitalize="off"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

        <!-- Password -->
        <input type="password" name="password" id="password" placeholder="Passwort" autocapitalize="off">
        <input type="password" name="passwordconfirm" id="passwordconfirm" placeholder="Passwort wiederholen" autocapitalize="off">


        <!-- Errors -->
        <? if (isset($errors)) : ?>
            <div style="color:red">
                <?php foreach($errors as $error) : ?>
                    <li><?=$error?></li>
                <?php endforeach; ?>
            </div>
        <? endif; ?><br>

        <!-- "Register"-Button -->
        <input type="submit" name="submitRegistration" value="Registrieren"><br>

    </form>

    <!-- "Back to Login"-Button -->
    <form method="get">
        <input type="hidden" name="c" value="account" />
        <input type="hidden" name="a" value="login" />
        <button type="submit" class="button">
            Zurück zum Login
        </button>
    </form>
</div>

<?php endif; ?>