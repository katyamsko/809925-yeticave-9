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
    <?php
        if (isset($errors)) {
                $class = 'form--invalid';
            } else {
                $class = '';
        }
    ?>
    <form class="form form--add-lot container <?=$class; ?>" action="add.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">

        <?php $classname = isset($errors['lot-name']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-name']) ? $lot['lot-name'] : ""; ?>

        <div class="form__item <?=$classname; ?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$value; ?>">
          <span class="form__error"><?=$errors['lot-name'] ? $errors['lot-name'] : "" ?></span>
        </div>

        <?php $classname = isset($errors['category']) ? "form__item--invalid" : "";
        ?>

        <div class="form__item <?=$classname; ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
            <?php foreach ($categories as $value) :?>
                <option <?php if ($lot['category'] == $value['name']) print('selected'); ?> value="<?=$value['id']; ?>"><?=esc($value['name']); ?></option>
            <? endforeach; ?>
          </select>
          <span class="form__error"><?=$errors['category'] ? $errors['category'] : "" ?></span>
        </div>
      </div>

        <?php $classname = isset($errors['message']) ? "form__item--invalid" : "";
            $value = isset($lot['message']) ? $lot['message'] : ""; ?>

      <div class="form__item form__item--wide <?=$classname; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$value; ?></textarea>
        <span class="form__error"><?=$errors['message'] ? $errors['message'] : "" ?></span>
      </div>

        <?php $classname = isset($errors['lot_image']) ? "form__item--invalid" : "";
        ?>

      <div class="form__item form__item--file <?=$classname; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" value="" name="lot_image">
          <label for="lot-img">
            Добавить
          </label>
          <span class="form__error"><?=$errors['lot_image'] ? $errors['lot_image'] : "" ?></span>
        </div>
      </div>
      <div class="form__container-three">

        <?php $classname = isset($errors['lot-rate']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-rate']) ? $lot['lot-rate'] : ""; ?>

        <div class="form__item form__item--small <?=$classname; ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?=$value; ?>">
          <span class="form__error"><?=$errors['lot-rate']; ?></span>
        </div>

        <?php $classname = isset($errors['lot-step']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-step']) ? $lot['lot-step'] : ""; ?>

        <div class="form__item form__item--small <?=$classname; ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?=$value; ?>">
          <span class="form__error"><?=$errors['lot-step']; ?></span>
        </div>

        <?php $classname = isset($errors['lot-date']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-date']) ? $lot['lot-date'] : ""; ?>

        <div class="form__item <?=$classname; ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=$value; ?>">
          <span class="form__error"><?=$errors['lot-date']; ?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>
