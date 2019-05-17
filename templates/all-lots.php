<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $value) :?>
                <li class="nav__item <?php if ($value['code'] == $lots_category) {
                        print('nav__item--current');
                    } ?>">
                    <a href="all-lots.php?cat=<?=$value['code']; ?>"><?=esc($value['name']); ?></a>
                </li>
            <? endforeach; ?>
        </ul>
    </nav>
    <div class="container">
        <section class="lots">

            <?php
                if ($category) {
                    $title_string = 'Все лоты в категории <span>«' . $category . '»</span>';
                } else {
                    $title_string = 'Все открытые лоты';
                }
            ?>

            <h2><?=$title_string; ?></h2>
            <ul class="lots__list">
                <?php foreach ($lot as $value): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?=$value['lot_image']; ?>" width="350" height="260" alt="<?=esc($value['lot_name']); ?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?=$value['category']; ?></span>
                        <h3 class="lot__title">
                            <a class="text-link" href="<?="lot.php" . "?id=" . $value['lot_id']; ?>"><?=esc($value['lot_name']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">
                                    <?php
                                        if ($value['count'] > 0) {
                                            $span_string = $value['rate_status_text'];
                                        } else {
                                            $span_string = 'Стартовая цена';
                                        }
                                    ?>
                                    <?=$span_string; ?>
                                </span>
                                <span class="lot__cost">
                                    <?=$price($value['lot_price']); ?>
                                </span>
                            </div>
                            <div class="lot__timer timer <?=$value['timer_class']; ?>">
                                <?=$value['format_time']; ?>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php if ($pages_count > 1): ?>
            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev">
                <?php
                    if ($cur_page != 1) {
                        $href = 'href="all-lots.php?cat='.$lots_category.'&page='.($cur_page-1).'"';
                    } else {
                        $href = '';
                    }
                ?>
                    <a <?=$href; ?>>
                        Назад
                    </a>
                </li>
                <?php foreach ($pages as $page): ?>
                    <?php
                    if (isset($lots_category)) {
                        if ($cur_page != $page) {
                            $href = 'href="all-lots.php?cat='.$lots_category.'&page='.$page.'"';
                        } else {
                            $href = '';
                        }
                    } else {
                        if ($cur_page != $page) {
                            $href = 'href="all-lots.php?page='.$page.'"';
                        } else {
                            $href = '';
                        }
                    }

                    ?>
                <li class="pagination-item <?php if ($page == $cur_page): ?>pagination__item--active<?php endif; ?>">
                    <a <?=$href; ?>><?=$page;?></a>
                </li>
                <?php endforeach; ?>
                <li class="pagination-item pagination-item-next">
                    <?php
                        if (isset($lots_category)) {
                            if ($cur_page != $pages_count) {
                                $href = 'href="all-lots.php?cat='.$lots_category.'page='.($cur_page+1).'"';
                            } else {
                                $href = '';
                            }
                        } else {
                            if ($cur_page != $pages_count) {
                                $href = 'href="all-lots.php?page='.($cur_page+1).'"';
                            } else {
                                $href = '';
                            }
                        }

                    ?>
                    <a <?=$href; ?>>
                        Вперед
                    </a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</main>
