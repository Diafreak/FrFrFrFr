
<? if (isset($_SESSION['validCheckout']) && $_SESSION['validCheckout'] === true) : ?>

    <head>
        <meta http-equiv = "refresh" content = "5; url = index.php" />
    </head>
    <body>
        <br>
        <p>Bestellung (ID: <?=$orderId?>) erfolgreich abgeschlossen. Sie werden in 5 Sekunden weitergeleitet.</p>
        <? $_SESSION['validCheckout'] = false ?>
    </body>

<? else : ?>

    <? header("Location: index.php"); ?>

<? endif; ?>