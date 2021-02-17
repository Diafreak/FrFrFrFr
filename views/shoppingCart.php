
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

    </aside>
</div>