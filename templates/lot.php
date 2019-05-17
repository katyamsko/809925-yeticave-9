<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $value) :?>
            <li class="nav__item">
                <a href="all-lots.php?cat=<?=$value['code']; ?>"><?=esc($value['name']); ?></a>
            </li>
            <? endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?=esc($lot['lot_name']); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lot['image']; ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot['category']; ?></span></p>
                <p class="lot-item__description"><?=esc($lot['description']); ?> </p>
            </div>
            <div class="lot-item__right">
                <?php if ($is_auth && !$user_flag && !isset($diff_time($lot['end_time'])['span']) && ($lot['author_id'] != $user_id)): ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer <?=$lot['timer_class']; ?>">
                        <?=$lot['format_time']; ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=esc(price($lot['current_price'])); ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=$lot['minimal_price']; ?></span>
                        </div>
                    </div>
                    <?php
                        if (isset($errors)) {
                            $class = 'form--invalid';
                        } else {
                            $class = '';
                        }
                    ?>
                    <form class="lot-item__form <?=$class; ?>" action="<?="lot.php?id=" . $id_lot; ?>" method="post" autocomplete="off">

                        <?php $classname = isset($errors['cost']) ? "form__item--invalid" : "";
                            $value = isset($lot['cost']) ? $lot['cost'] : ""; ?>

                        <p class="lot-item__form-item form__item <?=$classname; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="12 000">
                            <span class="form__error"><?=$errors['cost']; ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
                <?php endif; ?>
                <div class="history">
                    <h3>История ставок (<span><?=$count; ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($table_rates as $key => $value) :?>
                        <tr class="history__item">
                            <td class="history__name"><?=$value['author_name']; ?></td>
                            <td class="history__price"><?=$value['offer']; ?></td>
                            <td class="history__time"><?=$value['time_diff_text']; ?></td>
                        </tr>
                        <? endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
