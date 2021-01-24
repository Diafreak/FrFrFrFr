
<? if (!isset($errors)) : ?>
<!-- KOMMENTIEREN -->
<div class="login-form">

<? else : ?>
<!-- KOMMENTIEREN -->
<div class="login-form login-form-error">

<? endif; ?>

    <h1><?=$test?></h1>

    <form method="post">
        <input type="string" name="email" id="email" placeholder="Email" autocapitalize="off"
        value="<?= (isset($errors) && $errors !== '') && isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

        <input type="password" name="password" id="password" placeholder="Password" autocapitalize="off">

        <div class="rememberMe">
        <input type="checkbox" name="rememberMe" id="check"
         <?=isset($_POST['rememberMe']) ? 'checked' : '' ?>>
        <label for="check"> Angemeldet bleiben?</label>
        </div>

        <? if (isset($errors)) : ?>
            <div style="color:red">
                <?=$errors?>
            </div>
        <? endif; ?><br>

        <input type="submit" name="submitLogin" value="Login"><br>
    </form>

    <form method="get">
        <input type="hidden" name="c" value="account" />
        <input type="hidden" name="a" value="registration" />
        <button type="submit" class="button">
            Register
        </button>
    </form>

</div>