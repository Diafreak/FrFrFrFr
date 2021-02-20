<ul class="filterleiste">

    <? $currentUrl = $_SERVER['REQUEST_URI']; ?>

    <!-- if category = fruits -->
    <? if ($_GET['a'] == 'fruits') : ?>

        <a href="<?=$currentUrl?>&t=kernobst">
            <li>Kernobst</li>
        </a>
        <a href="<?=$currentUrl?>&t=steinobst">
            <li>Steinobst</li>
        </a>
        <a href="<?=$currentUrl?>&t=beeren">
            <li>Beeren</li>
        </a>
        <a href="<?=$currentUrl?>&t=zitrusfrüchte">
            <li>Zitrusfrüchte</li>
        </a>
        <a href="<?=$currentUrl?>&t=südfrüchte">
            <li>Südfrüchte</li>
        </a>

    <!-- if category = vegetables -->
    <? elseif ($_GET['a'] == 'vegetables') : ?>

        <a href="<?=$currentUrl?>&t=fruchtgemüse">
            <li>Fruchtgemüse</li>
        </a>
        <a href="<?=$currentUrl?>&t=salat">
            <li>(Blatt)Salat</li>
        </a>
        <a href="<?=$currentUrl?>&t=kohlgemüse">
            <li>Kohlgemüse</li>
        </a>
        <a href="<?=$currentUrl?>&t=knollengemüse">
            <li>Knollengemüse</li>
        </a>
        <a href="<?=$currentUrl?>&t=zwiebelgewächse">
            <li>Zwiebelgewächse</li>
        </a>

    <? endif; ?>

    <!-- Search-Bar -->
    <div class="search-container">
        <form>
            <input type="text" placeholder="Search..." name="search">
            <button type="submit">Suchen</button>
        </form>
    </div>

</ul>