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
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
    </div>
  </main>
