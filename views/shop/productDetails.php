
<!-- Errors -->
<? if (isset($errors)) : ?>

    <div style="text-align: center;">
        <? foreach ($errors as $error) : ?>
            <?= $error ?>
        <? endforeach; ?>
    </div>

<? else : ?>

    <!-- "Zurück"-Button -->
    <form method="get">
        <input type="hidden" name="c" value="shop" />
        <input type="hidden" name="a" value="<?=$catName?>s" />
        <button type="submit" class="">
            < Zurück
        </button>
    </form>

    <h1><?= ucfirst($name); ?></h1>

    <div class="detailwrapper">

    <div class="pdetailspic">
        <img src=<?= $imageUrl ?> alt=<?= $altText ?> width='250em' height='250em'>
    </div>

    <div class="pdetailsdesc">
        Beschreibung: 
        <br><?= $description; ?>
    </div>

    <div class="pdetailskauf">
        Preis: <?= $price; ?>€
        <br>

        Auf Lager: <?= $numberInStock; ?>
        <br>

        <form method="post">
            <div class="menge_mit_submit">
                <div class="mengenauswahl">
                    <?= generateAmountHTML($numberInStock) ?>
                </div>
                <!-- "In den Warenkorb"-Button -->
                <button type="submit" class="submit_amount" name="submitProduct" <?= ($numberInStock <= 0) ? "disabled" : "" ?>>
                    <img src=<?=IMAGESPATH . 'addtoshoppingcart.png'?> alt="Stylised shopping cart" class="addtocartpicture">
                </button>
            </div>
        </form>

    </div>

</div>

<? endif; ?><br>