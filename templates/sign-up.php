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
    <?php
        if (isset($errors)) {
                $class = 'form--invalid';
            } else {
                $class = '';
        }
    ?>
    <form class="form container <?=$class; ?>" action="sign-up.php" method="post" autocomplete="off" enctype="multipart/form-data">

        <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
            $value = isset($new_user['email']) ? esc($new_user['email']) : ""; ?>

        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item  <?=$classname; ?>">
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value; ?>">
            <span class="form__error"><?=$errors['email'] ?? "" ?></span>
        </div>

        <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";?>

        <div class="form__item <?=$classname; ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error"><?=$errors['password'] ?? "" ?></span>
        </div>

        <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
            $value = isset($new_user['name']) ? esc($new_user['name']) : ""; ?>

        <div class="form__item <?=$classname; ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$value; ?>">
            <span class="form__error"><?=$errors['name'] ?? "" ?></span>
        </div>

        <?php $classname = isset($errors['message']) ? "form__item--invalid" : "";
            $value = isset($new_user['message']) ? esc($new_user['message']) : ""; ?>

        <div class="form__item <?=$classname; ?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?=$value; ?></textarea>
            <span class="form__error"><?=$errors['message'] ?? "" ?></span>
        </div>

        <?php $classname = isset($errors['avatar']) ? "form__item--invalid" : "";
        ?>

        <div class="form__item form__item--file <?=$classname; ?>">
            <label>Аватар</label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="user-img" value="" name="avatar">
                <label for="user-img">
                    Добавить
                </label>
            <span class="form__error"><?=$errors['avatar'] ?? "" ?></span>
            </div>
        </div>

        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>
