<!--________________WARENKORB________________-->
<div class="warenkorbcontainer">
    <aside class="warenkorb aktiv" id="w">
        <div class="warenkorb-header">
            <a href="#">></a>
            <p>Meine Einkaufsliste</p>
        </div>
        <div class="warenkorbliste"> <!-- hier wurde noch was mit data load gemacht um dann vermutlich die daten auszulesen -->
            <div class="warenkorbinhalt">
                <table class="warenreihe">
                    <tbody>
                        <tr> <!-- jede Reihe ist ein Produkt im Warenkorb mit: -->
                            <td> <!-- Bild -->
                                <a href="?c=shop&a=productDetails" type="no-hover">
                                    <img src=<?=IMAGESPATH . 'placeholder.png'?> alt="Frucht" width="25px" height="25px">
                                </a>
                            </td>
                            <td> <!-- Name & Anzahl -->
                                <h3 class="produktname">Eine Frucht!</h3>
                                <p>14125 Tonnen</p>
                            </td>
                            <td> <!-- Preis -->

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </aside>
</div>