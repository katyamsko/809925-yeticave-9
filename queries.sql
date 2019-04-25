/*DEFAULT CHARACTER SET utf8*/
/*DEFAULT COLLATE utf8_general_ci;*/
USE YetiCave;

INSERT INTO category
SET name = 'Доски и лыжи', code = 'boards';
INSERT INTO category
SET name = 'Крепления', code = 'attachment';
INSERT INTO category
SET name = 'Ботинки', code = 'boots';
INSERT INTO category
SET name = 'Одежда', code = 'clothing';
INSERT INTO category
SET name = 'Инструменты', code = 'tools';
INSERT INTO category
SET name = 'Разное', code = 'other';

INSERT INTO user
(reg_time, email, name, password, avatar, contacts) VALUES (NOW(),'katyamsko@gmail.com','Екатерина', 'butize', 'images/avatar1.png', 'phone_number1');
INSERT INTO user
(reg_time, email, name, password, avatar, contacts) VALUES (NOW(),'almazkamusic@yandex.ru','Алмаз', 'roni', 'images/avatar2.png', 'phone_number2');

INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, author_id, winner_id, category_id) VALUES (NOW(), '2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-1.jpg', 10999, NOW(), 1, 2, 1);
INSERT INTO lot
(lot_time, name, description, image, start_price, author_id, winner_id, category_id) VALUES (NOW(), 'DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-2.jpg', 159999, 1, 2, 1);
INSERT INTO lot
(lot_time, name, description, image, start_price, author_id, winner_id, category_id) VALUES (NOW(), 'Крепления Union Contact Pro 2015 года размер L/XL', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-3.jpg', 8000, 2, 1, 2);
INSERT INTO lot
(lot_time, name, description, image, start_price, author_id, winner_id, category_id) VALUES (NOW(), 'Ботинки для сноуборда DC Mutiny Charocal', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-4.jpg', 10999, 2, 1, 3);
INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, author_id, winner_id, category_id) VALUES (NOW(), 'Куртка для сноуборда DC Mutiny Charocal', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-5.jpg', 7500, NOW(), 1, 2, 4);
INSERT INTO lot
(lot_time, name, description, image, start_price, author_id, winner_id, category_id) VALUES (NOW(), 'Маска Oakley Canopy', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-6.jpg', 5400, 2, 1, 6);


INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 14000, 2, 1);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 16000, 1, 1);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 10000, 2, 5);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 9999, 2, 5);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 10000, 2, 6);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 13000, 2, 6);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 38000, 2, 2);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 39000, 2, 2);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 10, 2, 4);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 99, 2, 4);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 59000, 2, 3);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 63000, 2, 3);

/*Получить все категории*/
SELECT name FROM category;

/*Получить самые новые, открытые лоты. Каждый лот включает название, стартовую цену, ссылку на изображение, цену, название категории */

SELECT l.name, l.start_price, l.image, c.name AS category, MAX(r.price) AS last_price
  FROM lot AS l
    JOIN category AS c
    ON l.category_id = c.id
    JOIN rate as r
    on r.lot_id = l.id
    WHERE (l.end_time IS NULL)
    GROUP BY l.id
    ORDER BY l.lot_time ASC
    LIMIT 3;

/*Показать лот по его id (id выбирается на последней строке запроса). Получите также название категории, к которой принадлежит лот */
SELECT l.lot_time, l.name, l.description, l.image, l.start_price, l.end_time, l.step_rate, l.author_id, l.winner_id, l.category_id,  c.name
  FROM lot as l
    JOIN category as c
    ON l.category_id = c.id
    WHERE l.id = 1;

/*Обновить название лота (на имя 'name') по его идентификатору (выбирается на последней стрчоке запроса) */
UPDATE lot
  SET name = 'name'
    WHERE id = 1;

/*Получить список самых свежих ставок для лота по его идентификатору (выбирается на предпоследней строке запроса) */
SELECT l.name, r.price
  FROM rate AS r
    JOIN lot as l
    ON r.lot_id = l.id
    WHERE l.id = 1
    ORDER BY r.rate_time ASC
    LIMIT 3;
