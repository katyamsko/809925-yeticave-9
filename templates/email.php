
<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?=$user_name; ?></p>
<?php foreach ($lot as $value): ?>
    <p>Ваша ставка для лота <a href="<?='yeticave/lot.php?id='.$value['id']; ?>"><?=$value['name']; ?></a> победила.</p>

<?php endforeach; ?>

<p>Перейдите по ссылке <a href="<?='yeticave/my-bets.php' ;?>">мои ставки</a>,
чтобы связаться с автором объявления</p>
<small>Интернет Аукцион "YetiCave"</small>

