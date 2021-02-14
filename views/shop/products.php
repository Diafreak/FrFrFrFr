<h1><?=$test?></h1>


<div class="content">
    <div class="schaufenster">
        <ul class="produkt-tabelle"> <?= generateShopLayout('fruit', $errors); ?> </ul>
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