-- Удаление пустых категорий
DELETE FROM `categories`
WHERE `id` NOT IN (SELECT DISTINCT `category_id` FROM `products`);

-- Удаление товаров без наличия
DELETE FROM `products`
WHERE `id` NOT IN (SELECT DISTINCT `product_id` FROM `availabilities`);

-- Удаление складов без товаров
DELETE FROM `stocks`
WHERE `id` NOT IN (SELECT DISTINCT `stock_id` FROM `availabilities`);

