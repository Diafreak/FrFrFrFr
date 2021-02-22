
<div class="warenkorbcontainer">
    <aside class="warenkorb aktiv" id="w">

        <div class="warenkorb-header">
            <a href=<?= getUrlWithoutCart() ?>>X</a>
            <p>Mein Warenkorb</p>
        </div>

        <div class="warenkorbliste">
            <div class="warenkorbinhalt">
                <table class="warenreihe">
                    <tbody>
                        <?= generateCartItems(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        Total: <?= getTotalAmount(); ?>€
        <br>
        <!-- only show "Zur Kass"-Button if cart is not empty -->
        <? if (getTotalAmount() != '0') : ?>
        <form method="get">
            <input type="hidden" name="c" value="shop">
            <input type="hidden" name="a" value="checkout">
            <button type="submit">Zur Kasse</button>
        </form>
        <? endif; ?>

    </aside>
</div>