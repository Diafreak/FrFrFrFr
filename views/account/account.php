
<!-- load js -->
<script src="<?=JSPATH?>account.js"></script>


<h1>Mein Account</h1>

<div class="accountfield">

    <div class="profilefield">
        <!-- User-Image -->
        <img src=<?=IMAGESPATH . 'user-placeholder.png'?> alt="Profilbild" class="user-picture">
        <br>

        <div>
            <!-- Firstname & Lastname -->
            <?= ucfirst($firstName) . " " . ucfirst($lastName) ?>
        

            <!-- "Abmelden"-Button -->
            <form method="post">
                <input type="submit" name="submitLogout" value="Abmelden" class="adminbutton">
            </form>
        </div>
    </div>
    <div class="profilesettingfield">

        <!-- Change Email -->
        <form method="post">
            Aktuelle E-Mail: <?= $email ?> <br>
            Neue E-Mail:
            <input type="string" name="changeEmail" id="chemail" placeholder="E-Mail Adresse ändern" autocapitalize="off"
                   value="<?= (isset($errors) && $errors != null) && isset($_POST['changeEmail']) ? strtolower(htmlspecialchars($_POST['changeEmail'])) : '' ?>">

            <!-- Button -->
            <input type="submit" name="submitEmailChange" id="submitEmailChange" value="Ändern">

            <!-- ERRORS JS -->
            <span id="errorEmail" class="error-message"></span>

            <!-- Errors PHP -->
            <span id="errorPHPemail"><? isset($errors) && isset($_POST['submitEmailChange']) ? printErrors($errors) : '' ?></span>
        </form>
        <br>


        <!-- Change Password -->
        <form method="post">
            Altes Passwort:
            <input type="password" name="oldPassword" id="oldPassword" placeholder="Altes Passwort" autocapitalize="off"><br>
            Neues Passwort:
            <input type="password" name="newPassword" id="newPassword" placeholder="Neues Passwort" autocapitalize="off"><br>
            Passwort bestätigen:
            <input type="password" name="newPasswordConfirm" id="newPasswordConfirm" placeholder="Passwort bestätigen" autocapitalize="off">

            <!-- Button -->
            <input type="submit" name="submitPasswordChange" id="submitPasswordChange" value="Ändern">

            <!-- ERRORS JS -->
            <span id="errorPW"        class="error-message"></span>
            <span id="errorPWConfirm" class="error-message"></span>

            <!-- Errors PHP -->
            <span id="errorPHPpassword"><? isset($errors) && isset($_POST['submitPasswordChange']) ? printErrors($errors) : '' ?></span>
        </form>
        <br>


        <!-- Change/Add Address -->
        <form method="post">

            <? if (userHasAddress()) : ?>
                Aktuelle Adresse: <? echo(ucfirst($street). " {$number}, {$zip} ".ucfirst($city))?>
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
            <input type="number" name="address_number" id="address_number" placeholder="Hausnummer <?=$action?>" autocapitalize="off"
                   value="<?= (isset($errors) && $errors != null) && isset($_POST['address_number']) ? htmlspecialchars($_POST['address_number']) : '' ?>"><br>
            Stadt
            <input type="string" name="address_city" id="address_city" placeholder="Stadt <?=$action?>" autocapitalize="off"
                   value="<?= (isset($errors) && $errors != null) && isset($_POST['address_city']) ? ucfirst(htmlspecialchars($_POST['address_city'])) : '' ?>"><br>
            PLZ:
            <input type="number" name="address_zip" id="address_zip" placeholder="Postleitzahl <?=$action?>" autocapitalize="off"
                   value="<?= (isset($errors) && $errors != null) && isset($_POST['address_zip']) ? htmlspecialchars($_POST['address_zip']) : '' ?>">

            <!-- Buttton -->
            <input type="submit" name="submitAddress" id="submitAddress" value="<?= ucfirst($action) ?>">

            <!-- ERRORS JS -->
            <span id="errorPW" class="error-message"></span>

            <!-- Errors PHP -->
            <span id="errorPHPaddress"><? isset($errors) && isset($_POST['submitAddress']) ? printErrors($errors) : '' ?></span>
        </form>
    </div>


    <!-- Add new product -->
    <? if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true) : ?>

        <div class="adminoptions">
            Neues Produkt in das Sortiment einfügen<br>

            <form method="post" enctype="multipart/form-data">
                Produktname
                <input type="string" name="product_name" id="product_name" placeholder="Produktname" autocapitalize="off"
                       value="<?= (isset($errors) && $errors != null) && isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '' ?>">

                Preis (€/kg)
                <input type="string" name="product_price" id="product_price" placeholder="Preis" autocapitalize="off"
                       value="<?= (isset($errors) && $errors != null) && isset($_POST['product_price']) ? htmlspecialchars($_POST['product_price']) : '' ?>">

                Anzahl im Vorratslager
                <input type="number" name="product_stock" id="product_stock" placeholder="In Stock" autocapitalize="off"
                       value="<?= (isset($errors) && $errors != null) && isset($_POST['product_stock']) ? htmlspecialchars($_POST['product_stock']) : '' ?>">

                Produktbeschreibung
                <input type="string" name="product_description" id="product_description" placeholder="Produktbeschreibung" autocapitalize="off"
                       value="<?= (isset($errors) && $errors != null) && isset($_POST['product_description']) ? htmlspecialchars($_POST['product_description']) : '' ?>">

                Kategorie
                <select name="categorie" id="categorie">
                    <option value="fruit">Obst</option>
                    <option value="vegetable">Gemüse</option>
                </select>

                Produkttags (mit Komma getrennt)
                <input type="string" name="product_tags" id="product_tags" placeholder="Tags" autocapitalize="off"
                       value="<?= (isset($errors) && $errors != null) && isset($_POST['product_tags']) ? htmlspecialchars($_POST['product_tags']) : '' ?>">

                Produktbild (MUSS quadratisch sein)
                <input type="hidden" name="MAX_FILE_SIZE" value="<?MAX_IMAGE_SIZE_IN_KB?>" />
                <input type="file" id="productImage" name="productImage">

                <!-- ERRORS JS -->
                <span id="errorPW" class="error-message"></span>

                <!-- Errors PHP -->
                <span id="errorPHPnewProduct"><? isset($errors) && isset($_POST['submitNewProduct']) ? printErrors($errors) : '' ?></span>

                <!-- Button -->
                <button type="submit" name="submitNewProduct" id="submitNewProduct">
                    Produkt hinzufügen
                </button>
            </form>

        </div>

    <? endif; ?>

</div>