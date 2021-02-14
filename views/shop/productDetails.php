
<!-- Errors -->
<? if (isset($errors)) : ?>
    <div style="text-align: center;">
        <? foreach ($errors as $error) : ?>
            <?= $error ?>
        <? endforeach; ?>
    </div>

<? else : ?>

    <h2><?= $name; ?></h2>


    <img src=<?= $imageUrl ?> alt=<?= $altText ?> width='250em' height='250em'>
    <br>

    Preis: <?= $price; ?>€
    <br>

    Auf Lager: <?= $numberInStock; ?>
    <br>

    Beschreibung: <?= $description; ?>

    <form method="post" action="hier muss was wichtiges rein">          <!-- WHUT REIN? -->
        <div class="menge_mit_submit">
            <div class="mengenauswahl">
                <?= generateAmountHTML($numberInStock) ?>
                <!-- <p>oder ander Menge wählen</p>
                und dann hier noch ein Formular wo man eine eigene Menge reinschreiben kann -->
            </div>
            <button type="submit" class="submit_amount" name="submitProduct">In den Warenkorb</button>
        </div>
    </form>

    </div>
<? endif; ?><br>