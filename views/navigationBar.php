<!DOCTYPE html>
<html>

    <body>
        <header>
            <nav>

                <ul>
                    <li class="no-hover">
                        <a href="?c=pages&a=home" type="no-hover">
                            <img src=<?=IMAGESPATH . 'ferret.svg'?> alt="Logo" width="100px" height="45px"></a>
                    </li>

                    <a href="?c=pages&a=home">
                        <li>HOME</li>
                    </a>
                    <a href="?c=pages&a=about">
                        <li>ÜBER UNS</li>
                    </a>
                    <a href="?c=shop&a=products">
                        <li>PRODUKTE</li>
                    </a>
                    <a href="?c=pages&a=current">
                        <li>AKTUELLES</li>
                    </a>
                    <a href="?c=pages&a=contact">
                        <li>KONTAKT</li>
                    </a>

                    <li class="no-hover">
                        <a href="#w" type="no-hover">
                            <img src=<?=IMAGESPATH . 'basket.svg'?> alt="Warenkorb" width="35px" height="35px">
                        </a>
                        <!--Ich/ wir müssen mal schauen wie wir einfach eine Variable ändern mit nem 'a', anstatt ne neue Seite aufzurufen siehe jurassicfruit blabla?showCart=1 -->
                        <a href="?c=account&a=login" type="no-hover">
                            <img src=<?=IMAGESPATH . 'user.svg'?> alt="Login" width="35px" height="35px">
                        </a>
                    </li>
                </ul>

            </nav>
        </header>

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
    </body>

</html>