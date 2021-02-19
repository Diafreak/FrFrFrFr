<h1>GEMÜSE</h1>
<ul class="filterleiste">
            <a href="">
                <li>Fruchtgemüse</li>
            </a>
            <a href="">
                <li>(Blatt)Salat</li>
            </a>
            <a href="">
                <li>Kohlgemüse</li>
            </a>
            <a href="">
                <li>Knollengemüse</li>
            </a>
            <a href="">
                <li>Zwiebelgewächse</li>
            </a>
            <div class="search-container">
                <form>
                    <input type="text" placeholder="Search..." name="search">
                    <button type="submit">Suchen</i></button>
                </form>
            </div>
    </ul>
<!-- "Zum Warenkorb hinzugefügt"-Banner -->
<div id="success" class="banner product-added">
    <span>Zum Warenkorb hinzugefügt</span>
    <a href="#" class="close">[schließen]</a>
</div>


<div class="content">
    <div class="schaufenster">
        <ul class="produkt-tabelle"> <?= generateShopLayout($product, $tags, $errors); ?> </ul>
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