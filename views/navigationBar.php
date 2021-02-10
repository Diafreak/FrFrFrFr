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
                        <a href="?c=pages&a=shoppingCard" type="no-hover">
                            <img src=<?=IMAGESPATH . 'Korb.png'?> alt="Warenkorb" width="25px" height="25px">
                        </a>
                        <!--Ich/ wir müssen mal schauen wie wir einfach eine Variable ändern mit nem 'a', anstatt ne neue Seite aufzurufen siehe jurassicfruit blabla?showCart=1 -->
                        <a href="?c=account&a=login" type="no-hover">
                            <img src=<?=IMAGESPATH . 'user.png'?> alt="Login" width="25px" height="25px">
                        </a>
                    </li>
                </ul>

            </nav>
        </header>
    </body>

</html>