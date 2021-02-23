<h1>KASSE</h1>


<div class="checkoutcontainer">
    <aside class="checkout">
        <div class="checkoutliste">
            <div class="checkoutinhalt">
                <table class="checkoutreihe">
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