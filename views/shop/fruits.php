<h1>OBST</h1>
    <ul class="filterleiste">
            <a href="">
                <li>Kernobst</li>
            </a>
            <a href="">
                <li>Steinobst</li>
            </a>
            <a href="">
                <li>Beeren</li>
            </a>
            <a href="">
                <li>Zitrusfrüchte</li>
            </a>
            <a href="">
                <li>Südfrüchte</li>
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