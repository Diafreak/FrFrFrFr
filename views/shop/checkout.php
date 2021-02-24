<h1>KASSE</h1>


<div class="checkoutcontainer">

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
    <form method="POST">
        <button type="submit" name="submitCheckout">Kaufen</button>
    </form>

</div>