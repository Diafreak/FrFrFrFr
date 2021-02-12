
<!-- Errors -->
<? if (isset($errors)) : ?>
    <div style="text-align: center;">
        <? foreach ($errors as $error) : ?>
            <?= $error ?>
        <? endforeach; ?>
    </div>

<? else : ?>

    <h1><?= $name; ?></h1>


    <img src=<?= $imageUrl ?> alt=<?= $altText ?> width='250em' height='250em'>
    <br>

    Preis: <?= $price; ?>€
    <br>

    Auf Lager: <?= $numberInStock; ?>
    <br>

    Beschreibung: <?= $description; ?>

<? endif; ?><br>