<h1>OBST</h1>

<!-- "Zum Warenkorb hinzugefügt"-Banner -->
<div id="success" class="banner product-added">
    <span>Zum Warenkorb hinzugefügt</span>
    <a href="#" class="close">[schließen]</a>
</div>


<div class="content">
    <div class="schaufenster">
        <ul class="produkt-tabelle"> <?= generateShopLayout($product, $errors); ?> </ul>
    </div>
</div>


<!-- Errors -->
<? if (isset($errors)) : ?>
    <div style="text-align: center;">
        <? foreach ($errors as $error) : ?>
            <?= $error ?>
        <? endforeach; ?>
    </div>
<? endif; ?><br>