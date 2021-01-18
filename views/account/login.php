<div class="login-form">
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
            <!-- Weiß nicht wie die Error definiert sind, aber es wird pauschal erstmal Username UND Passwort rot umrandet 
                Problem war dass es nach dem Seite refreshen immernoch rot umrandet war, obwohl die Fehlermeldung nichtmalmehr da war.
            <style>
                .login-form input:not([type="checkbox" i]):not([type="submit" i]){
                    
                    border: 1px solid red;
                    border-radius: 4px;
                    padding: 0 0 0 10px;
                    width: 290px;
                    height: 35px;
                }
            </style>
            -->
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