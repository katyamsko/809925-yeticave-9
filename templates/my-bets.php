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
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">

        <?php foreach ($my_rates as $key => $value) :?>

        <tr class="rates__item <?=$value['rates_item_class']; ?>">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?=$value['lot_image']; ?>" width="54" height="40" alt="<?=$value['lot_image']; ?>">
            </div>
            <h3 class="rates__title"><a href="<?="lot.php" . "?id=" . $value['lot_id']; ?>"><?=$value['lot_name']; ?></a></h3>

            <?php if ($value['is_winner']): ?>
              <p><?=$value['contacts']; ?></p>
            <?php endif; ?>

          </td>
          <td class="rates__category">
            <?=$value['category']; ?>
          </td>
          <td class="rates__timer">
            <div class="timer <?=$value['timing_class']; ?>"><?=$value['timing_format']; ?></div>
          </td>
          <td class="rates__price">
            <?=$value['offer']; ?>
          </td>
          <td class="rates__time">
            <?=$value['time_diff_text']; ?>
          </td>
        </tr>

        <?php endforeach; ?>
      </table>
    </section>
  </main>
