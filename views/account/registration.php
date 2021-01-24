
<?php if($validRegistration === true) : ?>
    <!--<div class="success-message">
        Vielen Dank, für dein Konto! Sie werden automatisch auf die Login-Seite weitergeleitet.
        <meta http-equiv="refresh" content="5; URL=index.php?c=pages&a=login">
    </div>-->
    <?= header('Location: ?c=pages&a=products'); ?>
<?php else : ?>

<div class="registration-form">
    <h1>Registration</h1>

    <form method="post">
        
        <input type="string" name="firstname" id="firstname" placeholder="Firstname" autocapitalize="off"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '' ?>">
        <input type="string" name="lastname" id="lastname" placeholder="Lastname" autocapitalize="off"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '' ?>">
        <input type="string" name="email" id="email" placeholder="E-Mail" autocapitalize="off"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        <input type="string" name="username" id="username" placeholder="Username" autocapitalize="off"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">

        <input type="password" name="password" id="password" placeholder="Choose Password" autocapitalize="off">
        <input type="password" name="passwordconfirm" id="passwordconfirm" placeholder="Confirm Password" autocapitalize="off">

        <? if (isset($errors)) : ?>
            <div style="color:red">
                <?php foreach($errors as $error) : ?>
                    <li><?=$error?></li>
                <?php endforeach; ?>
            </div>
        <? endif; ?><br>
        <input type="submit" name="submitRegistration" value="Register"><br>
    </form>

    <form method="get">
        <input type="hidden" name="c" value="account" />
        <input type="hidden" name="a" value="login" />
        <button type="submit" class="button">
            Back to Login
        </button>
    </form>
</div>

<?php endif; ?>