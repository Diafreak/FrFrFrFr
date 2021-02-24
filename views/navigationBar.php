<body>
    <header>    
        <nav class="desktop">
            <ul>
                <li class="no-hover">
                    <a href="?c=pages&a=home" type="no-hover" class="navbar-icon">
                        <img src=<?=IMAGESPATH.'navBar/ferret.svg'?> alt="Logo" class="logo"></a>
                </li>

                <a href="?c=pages&a=home">
                    <li>HOME</li>
                </a>
                <a href="?c=shop&a=fruits">
                    <li>OBST</li>
                </a>
                <a href="?c=shop&a=vegetables">
                    <li>GEMÜSE</li>
                </a>
                <a href="?c=pages&a=current">
                    <li>AKTUELLES</li>
                </a>
                <a href="?c=pages&a=contact">
                    <li>ÜBER UNS</li>
                </a>

                <li class="no-hover">
                    <a href=<?= "{$currentURL}&cart=show" ?> type="no-hover">
                        <img src=<?=IMAGESPATH.'navBar/basket.svg'?> alt="Warenkorb" class="nav-icon">
                    </a>

                    <a href="?c=account&a=login" type="no-hover">
                        <img src=<?=IMAGESPATH.'navBar/user.svg'?> alt="Login" class="nav-icon">
                    </a>
                </li>

            </ul>
        </nav>

        <nav class="tablet">
            <div class="navbartrigger">
                <a href="#nav" class="menubutton icon">
                    <img src=<?=IMAGESPATH.'hamburgerbutton.png'?> alt="menu-icon">
                </a>

                <a href="?c=pages&a=home" type="no-hover" class="ferret icon">
                    <img src=<?=IMAGESPATH.'navBar/ferret.svg'?> alt="Logo" class="logo">
                </a>

                <a href=<?= "{$currentURL}&cart=show" ?> type="no-hover" class="cart icon">
                    <img src=<?=IMAGESPATH.'navBar/basket.svg'?> alt="Warenkorb" class="nav-icon">
                </a>

                <a href="?c=account&a=login" type="no-hover" class="account icon">
                    <img src=<?=IMAGESPATH.'navBar/user.svg'?> alt="Login" class="nav-icon">
                </a>
            </div>
            <div id="nav">
                <ul>
                    <a href="#" aria-label="Close Navigation" class="closenav">x</a>
                    <a href="?c=pages&a=home">
                        <li>HOME</li>
                    </a>
                    <a href="?c=shop&a=fruits">
                        <li>OBST</li>
                    </a>
                    <a href="?c=shop&a=vegetables">
                        <li>GEMÜSE</li>
                    </a>
                    <a href="?c=pages&a=current">
                        <li>AKTUELLES</li>
                    </a>
                    <a href="?c=pages&a=contact">
                        <li>ÜBER UNS</li>
                    </a>
                </ul>
            </div>
        </nav>
    </header>
</body>