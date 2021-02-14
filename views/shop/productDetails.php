<? $_SESSION['currentURL'] = "?c=shop&a=productDetails&prodId={$id}" ?>


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

    <form action="hier muss was wichtiges rein">
        <div class="menge_mit_submit">
            <div class="mengenauswahl">
                <select name="amount" id="amount">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>
                <!-- <p>oder ander Menge wählen</p>
                und dann hier noch ein Formular wo man eine eigene Menge reinschreiben kann -->
            </div>
            <button type="submit" class="submit_amount">In den Warenkorb</button>
        </div>
    </form>

    </div>
<? endif; ?><br>