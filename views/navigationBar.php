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
                <div class="dropdown-menu">
                    <a href="?c=shop&a=fruits" >
                        <li>OBST</li>
                    </a>
                    <div class="dropdown-content">
                        <a href="irgendwas:)">Kernobst</a>
                        <a href="irgendwas:)">Steinobst</a>
                        <a href="irgendwas:)">Beeren</a>
                        <a href="irgendwas:)">Zitrusfrüchte</a>
                        <a href="irgendwas:)">Südfrüchte</a>
                    </div>
                </div>
                <a href="?c=shop&a=vegetables">
                    <li>GEMÜSE</li>
                </a>
                <a href="?c=pages&a=current">
                    <li>AKTUELLES</li>
                </a>
                <a href="?c=pages&a=contact">
                    <li>KONTAKT</li>
                </a>

                <li class="no-hover">
                    <a href=<?= "{$currentURL}&cart=show" ?> type="no-hover">
                        <img src=<?=IMAGESPATH . 'basket.svg'?> alt="Warenkorb" class="nav-icon">
                    </a>

                    <a href="?c=account&a=login" type="no-hover">
                        <img src=<?=IMAGESPATH . 'user.svg'?> alt="Login" class="nav-icon">
                    </a>
                </li>

            </ul>

        </nav>
    </header>
</body>