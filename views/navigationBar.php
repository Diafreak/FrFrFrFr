<!DOCTYPE html>
<html>

    <body>
        <header>
            <nav>

                <ul>
                    <li class="no-hover">
                        <a href="?c=pages&a=home" type="no-hover">
                            <img src=<?=IMAGESPATH . 'ferret.svg'?> alt="Logo" class="logo"></a>
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
                            <img src=<?=IMAGESPATH . 'basket.svg'?> alt="Warenkorb" class="nav-icon">
                        </a>
                        <!--Ich/ wir müssen mal schauen wie wir einfach eine Variable ändern mit nem 'a', anstatt ne neue Seite aufzurufen siehe jurassicfruit blabla?showCart=1 -->
                        <a href="?c=account&a=login" type="no-hover">
                            <img src=<?=IMAGESPATH . 'user.svg'?> alt="Login" class="nav-icon">
                        </a>
                    </li>
                </ul>

            </nav>
        </header>

    </body>

</html>