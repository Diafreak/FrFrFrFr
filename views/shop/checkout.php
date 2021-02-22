<h1>KASSE</h1>


<div class="warenkorbcontainer">
    <aside class="warenkorb aktiv" id="w">

        <div class="warenkorb-header">
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
        <form method="get">
            <!-- <input type="hidden" name="c" value="shop">
            <input type="hidden" name="a" value="checkout"> -->
            <button type="submit">Kaufen</button>
        </form>

    </aside>
</div>