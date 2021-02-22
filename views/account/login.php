
<!-- load js -->
<script src="<?=JSPATH?>login.js"></script>


<!-- "Registrierung Erfolgreich"-Banner -->
<div id="success" class="banner registration-success">
    <span>Registrierung Erfolgreich!</span>
    <a href="#" class="close">[schließen]</a>
</div>


<div class="login-form user-form">

    <h1>Login</h1>

    <form method="post">

        <!-- E-Mail -->
        <input type="string" name="email" id="email" placeholder="E-Mail" autocapitalize="off"
               value="<?= (isset($errors) && $errors !== '') && isset($_POST['email']) ? strtolower(htmlspecialchars($_POST['email'])) : '' ?>">

        <!-- Password -->
        <input type="password" name="password" id="password" placeholder="Passwort" autocapitalize="off">

        <!-- Remember Me -->
        <div class="rememberMe">
            <input type="checkbox" name="rememberMe" id="check" value="remember" <?=isset($_POST['rememberMe']) ? 'checked' : '' ?>>
            <label for="check"> Angemeldet bleiben?</label>
        </div>


        <!-- ERRORS JS -->
        <span id="errorEmptyFields" class="error-message"></span>


        <!-- Errors PHP -->
        <span id="errorPHP"><? isset($errors) && isset($_POST['submitLogin']) ? printErrors($errors) : '' ?></span><br>


        <!-- "Login"-Button -->
        <button type="submit" name="submitLogin" id="submitLogin" class="button">
            Login
        </button>
        <br>
    
    </form>


    <!-- "Registrierung"-Button -->
    <form method="get">
        <input type="hidden" name="c" value="account" />
        <input type="hidden" name="a" value="registration" />
        <button type="submit" class="button">
            Registrierung
        </button>
    </form>

</div>