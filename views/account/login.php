
<? if (!isset($error)) : ?>
<!-- KOMMENTIEREN -->
<div class="login-form">

<? else : ?>
<!-- KOMMENTIEREN -->
<div class="login-form login-form-error">

<? endif; ?>

    <h1><?=$test?></h1>

    <form method="post">
        <input type="string" name="username" id="username" placeholder="Username" autocapitalize="off"
        value="<?= (isset($error) && $error !== '') && isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">

        <input type="password" name="password" id="password" placeholder="Password" autocapitalize="off">

        <div class="rememberMe">
        <input type="checkbox" name="rememberMe" id="check"
        <?=isset($_POST['rememberMe']) ? 'checked' : '' ?>>
        <label for="check"> Angemeldet bleiben?</label>
        </div>

        <? if (isset($error)) : ?>
            <div style="color:red">
                <?=$error?>
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