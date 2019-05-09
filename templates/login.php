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
    <form class="form container <?=$class; ?>" action="login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>

      <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
            $value = isset($form['email']) ? $form['email'] : ""; ?>

      <div class="form__item <?=$classname; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value; ?>">
        <span class="form__error"><?=$errors['email'] ?? "" ?></span>
      </div>

      <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";?>

      <div class="form__item form__item--last <?=$classname; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password'] ?? "" ?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>
