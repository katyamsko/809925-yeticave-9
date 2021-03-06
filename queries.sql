/*DEFAULT CHARACTER SET utf8*/
/*DEFAULT COLLATE utf8_general_ci;*/
USE yeticave;

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
(reg_time, email, name, password, avatar, contacts)
VALUES (NOW(),'katyamsko@gmail.com','Екатерина', 'butize', 'images/avatar1.png', 'phone_number1');

INSERT INTO user
(reg_time, email, name, password, avatar, contacts)
VALUES (NOW(),'almazkamusic@yandex.ru','Алмаз', 'roni', 'images/avatar2.png', 'phone_number2');

INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, step_rate, author_id, winner_id, category_id)
VALUES (TIMESTAMP('2019-05-10', '16:00:00'), '2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-1.jpg', 10999, TIMESTAMP('2019-05-14', '16:00:00'), 500, 1, 2, 1);

INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, step_rate, author_id, category_id)
VALUES (TIMESTAMP('2019-05-11', '17:00:00'), 'DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-2.jpg', 159999, TIMESTAMP('2019-05-20', '16:00:00'), 200, 2, 1);

INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, step_rate, author_id, category_id)
VALUES (TIMESTAMP('2019-05-12', '18:00:00'), 'Крепления Union Contact Pro 2015 года размер L/XL', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-3.jpg', 8000, TIMESTAMP('2019-05-19', '23:00:00'), 300, 2, 2);

INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, step_rate, author_id, winner_id, category_id)
VALUES (TIMESTAMP('2019-05-13', '19:00:00'), 'Ботинки для сноуборда DC Mutiny Charocal', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-4.jpg', 10999, TIMESTAMP('2019-05-14', '23:00:00'), 200, 2, 1, 3);

INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, step_rate, author_id, category_id)
VALUES (TIMESTAMP('2019-05-14', '19:30:00'), 'Куртка для сноуборда DC Mutiny Charocal', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-5.jpg', 7500, TIMESTAMP('2019-05-20', '23:00:00'), 100, 5, 4);

INSERT INTO lot
(lot_time, name, description, image, start_price, end_time, step_rate, author_id, winner_id, category_id)
VALUES (TIMESTAMP('2019-05-14', '20:00:00'), 'Маска Oakley Canopy', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-6.jpg', 5400, TIMESTAMP('2019-05-13', '23:00:00'), 150, 5, 1, 6);


INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 14000, 2, 1);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 16000, 1, 1);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 10000, 2, 5);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 9999, 1, 5);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 10000, 2, 6);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 13000, 1, 6);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 38000, 2, 2);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 39000, 1, 2);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 10, 1, 4);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 99, 2, 4);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 59000, 1, 3);
INSERT INTO rate
(rate_time, price, user_id, lot_id) VALUES (NOW(), 63000, 2, 3);
