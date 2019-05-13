  <main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $value) :?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?=esc($value['name']); ?></a>
            </li>
        <? endforeach; ?>
      </ul>
    </nav>
    <div class="container">
      <section class="lots">
        <h2>Результаты поиска по запросу «<span><?=$search; ?></span>»</h2>
        <ul class="lots__list">
          <?php foreach ($lots as $value) : ?>

          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?=$value['lot_image'] ?>" width="350" height="260" alt="<?=$value['lot_name']; ?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?=$value['category']; ?></span>
              <h3 class="lot__title"><a class="text-link" href="<?="lot.php" . "?id=" . $value['lot_id']; ?>"><?=$value['lot_name']; ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?=$value['start_price']; ?><b class="rub">р</b></span>
                </div>
                <div class="lot__timer timer">
                  <?=$value['lot_time']; ?>
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
                $href = 'href="search.php?q='.$search_string.'&find=Найти&page='.($cur_page-1).'"';
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
              if ($cur_page != $page) {
                $href = 'href="search.php?q='.$search_string.'&find=Найти&page='.$page.'"';
              } else {
                $href = '';
              }
            ?>
            <li class="pagination-item <?php if ($page == $cur_page): ?>pagination__item--active<?php endif; ?>">
              <a <?=$href; ?>><?=$page;?></a>
            </li>
          <?php endforeach; ?>
          <li class="pagination-item pagination-item-next">
            <?php
              if ($cur_page != $pages_count) {
                $href = 'href="search.php?q='.$search_string.'&find=Найти&page='.($cur_page+1).'"';
              } else {
                $href = '';
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

