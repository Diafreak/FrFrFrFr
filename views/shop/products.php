<h1><?=$test?></h1>


<div class="content">
    <div class="schaufenster">

        <ul class="produkt-tabelle">

            <?= generateShopLayout('fruit'); ?>

        </ul>

    </div>
</div>

<!-- Da ich noch nicht wusste wo das hin kommt, kommts einfach erst mal hier rein:
                    ________________WARENKORB________________
 -->
<div class="warenkorbcontainer">
    <aside class="warenkorb aktiv">
        <div class="warenkorb-header">
            <a href="irgendwasumdenwarenkorbzuschließenjaja">></a>
            <p>Meine Einkaufsliste</p>
        </div>
        <div class="warenkorbliste"> <!-- hier wurde noch was mit data load gemacht um dann vermutlich die daten auszulesen -->
            <div class="warenkorbinhalt">
                <table class="warenreihe">
                    <tbody>
                        <tr> <!-- jede Reihe ist ein Produkt im Warenkorb mit: -->
                            <td> <!-- Bild -->
                                <a href="?c=shop&a=prductDetails" type="no-hover">
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