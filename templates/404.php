<main>
    <nav class="nav">
        <ul class="nav__list container">
        <?php foreach ($categories as $value) :?>
            <li class="nav__item">
                <a href="all-lots.php?cat=<?=$value['code']; ?>">
                    <?=esc($value['name']); ?>
                </a>
            </li>
        <? endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2>404 Страница не найдена</h2>
        <p>Данной страницы не существует на сайте.</p>
    </section>
</main>
