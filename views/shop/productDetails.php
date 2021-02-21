
<!-- Errors -->
<? if (isset($errors)) : ?>

    <div style="text-align: center;">
        <? foreach ($errors as $error) : ?>
            <?= $error ?>
        <? endforeach; ?>
    </div>

<? else : ?>

    <h1><?= $name; ?></h1>

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