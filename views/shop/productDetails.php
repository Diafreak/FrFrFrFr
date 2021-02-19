
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
                <!-- <p>oder ander Menge wählen</p>
                und dann hier noch ein Formular wo man eine eigene Menge reinschreiben kann -->
            </div>
            <button type="submit" class="submit_amount" name="submitProduct" <?= ($numberInStock <= 0) ? "disabled" : "" ?>>In den Warenkorb</button>
        </div>
    </form>
    </div>
</div>
<? endif; ?><br>