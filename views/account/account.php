<h1>Mein Account</h1>
<div class="accountfield">
    <? require_once FUNCTIONSPATH.'htmlGeneration.php' ?>

    <div class="profilefield">
        <!-- User-Image -->
        <img src=<?=IMAGESPATH . 'user-placeholder.png'?> alt="Profilbild" class="user-picture">
        <br>

        <div>
            <!-- Firstname & Lastname -->
            <?= ucfirst($firstName) . " " . ucfirst($lastName) ?>
        

            <!-- "Abmelden"-Button -->
            <form method="post">
                <input type="submit" name="submitLogout" value="Abmelden">
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

            <input type="submit" name="submitEmailChange" value="Ändern">

            <!-- Errors -->
            <? isset($errors) && isset($_POST['submitEmailChange']) ? printErrors($errors) : '' ?>
        </form>
        <br>


        <!-- Change Password -->
        <form method="post">
            Altes Passwort:
            <input type="password" name="oldPassword" id="oldpassword" placeholder="Altes Passwort" autocapitalize="off"><br>
            Neues Passwort:
            <input type="password" name="newPassword" id="newpassword" placeholder="Neues Passwort" autocapitalize="off"><br>
            Passwort bestätigen:
            <input type="password" name="newPasswordConfirm" id="newpasswordconfirm" placeholder="Passwort bestätigen" autocapitalize="off">

            <input type="submit" name="submitPasswordChange" value="Ändern">

            <!-- Errors -->
            <? isset($errors) && isset($_POST['submitPasswordChange']) ? printErrors($errors) : '' ?>
        </form>
        <br>


        <!-- Change/Add Address -->
        <form method="post">

            <? if (userHasAddress()) : ?>
                Aktuelle Adresse: <?= "{$street} {$number}, {$zip} {$city}"?>
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

            <input type="submit" name="submitAddress" value="<?= ucfirst($action) ?>">

            <!-- Errors -->
            <? isset($errors) && isset($_POST['submitAddress']) ? printErrors($errors) : '' ?>
        </form>
    </div>

    <div class="adminoptions">
        Neues Produkt in das Sortiment einfügen:
        <br>
        <form method="post">
            Produktname:
            <input type="string" name="product_name" id="product_name" placeholder="Produktname" autocapitalize="off">
            Preis:
            <input type="number" name="product_price" id="product_price" placeholder="Preis" autocapitalize="off">
            Anzahl im Vorratslager:
            <input type="number" name="product_stock" id="product_stock" placeholder="In Stock" autocapitalize="off">
            Produktbeschreibung:
            <input type="string" name="product_description" id="product_description" placeholder="Produktbeschreibung" autocapitalize="off">
            Kategorie:
            <select name="categorie" id="categorie">
                <option value="fruit">Obst</option>
                <option value="vegetable">Gemüse</option>
            </select>
            Produkttags:
            <input type="string" name="product_tags" id="product_tags" placeholder="Tags" autocapitalize="off">
            Produktbild:
            <form action="/action_page.php">
                <input type="file" id="productImage" name="filename">
            </form>
            <br>
            <input type="submit">
        </form>
    </div>
</div>