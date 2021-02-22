
<!-- load js -->
<script src="<?=JSPATH?>registration.js"></script>


<!-- redirect to login after successful registration -->
<?php if($validRegistration === true) : ?>

    <!-- redirect to Login-page and show "Registrierung Erfolgreich"-banner -->
    <?= header('Location: ?c=account&a=login#success'); ?>

<?php else : ?>

    <div class="registration-form user-form">

        <h1>Registrierung</h1>


        <form method="post">

            <!-- First Name -->
            <input type="string" name="firstname" id="firstname" placeholder="Vorname" autocapitalize="on"
                   value="<?= (isset($errors) && $errors !== '') && isset($_POST['firstname']) ? ucfirst( strtolower( htmlspecialchars($_POST['firstname']) ) ) : '' ?>">

            <!-- Last Name -->
            <input type="string" name="lastname" id="lastname" placeholder="Nachname" autocapitalize="on"
                   value="<?= (isset($errors) && $errors !== '') && isset($_POST['lastname']) ? ucfirst( strtolower( htmlspecialchars($_POST['lastname']) ) ) : '' ?>">

            <!-- Email -->
            <input type="string" name="email" id="email" placeholder="E-Mail" autocapitalize="off"
                   value="<?= (isset($errors) && $errors !== '') && isset($_POST['email']) ? strtolower( htmlspecialchars($_POST['email']) ) : '' ?>">


            <!-- ERRORS JS -->
            <span id="errorFirstName" class="error-message"></span>
            <span id="errorLastName"  class="error-message"></span>
            <span id="errorEmail"     class="error-message"></span>
            <br>

            <!-- Password -->
            <input type="password" name="password"        id="password"        placeholder="Passwort"             autocapitalize="off">
            <input type="password" name="passwordconfirm" id="passwordconfirm" placeholder="Passwort wiederholen" autocapitalize="off">


            <!-- ERRORS JS -->
            <span id="errorPW"        class="error-message"></span>
            <span id="errorPWConfirm" class="error-message"></span>

            <!-- Errors PHP -->
            <span id="errorsPHP"><? isset($errors) && isset($_POST['submitRegistration']) ? printErrors($errors) : '' ?></span><br>


            <!-- "Register"-Button -->
            <button type="submit" name="submitRegistration" id="submitRegistration" class="button">
                Registrieren
            </button><br>

        </form>


        <!-- "Back to Login"-Button -->
        <form method="get">
            <input  type="hidden" name="c" value="account" />
            <input  type="hidden" name="a" value="login" />
            <button type="submit" class="button">
                Zurück zum Login
            </button>
        </form>

    </div>

<?php endif; ?>