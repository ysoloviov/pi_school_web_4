-- select all users first/last name who made a purchase of products from "Office" category in "Rite Aid" shop for last 10 years
SELECT users.name, users.surname
FROM users
JOIN purchases ON users.id = purchases.user_id
JOIN shops on shops.id = purchases.shop_id
JOIN purchase_product ON purchases.id = purchase_product.purchase_id
JOIN product_category ON product_category.product_id = purchase_product.product_id
JOIN categories ON categories.id = product_category.category_id
WHERE categories.name = "Office"
AND shops.name = "Rite Aid"
AND purchases.date BETWEEN CURDATE() - INTERVAL 10 YEAR AND CURDATE()

-- *select names of all categories and count the number of purchases of products from that category
SELECT categories.name AS category_name, COUNT(purchase_product.product_id) AS purchases_amount
FROM purchase_product
JOIN product_category ON product_category.category_id = purchase_product.product_id
JOIN categories ON categories.id = product_category.category_id
GROUP BY product_category.category_id

-- select users first/last name who have more than one purchase in "Kroger" shop
SELECT users.name, users.surname, COUNT(users.id) as purchases_amount
FROM users
JOIN purchases ON purchases.user_id = users.id
JOIN shops on shops.id = purchases.shop_id
WHERE shops.name = "Kroger"
GROUP BY users.id
HAVING purchases_amount > 1

-- *show profit amount per month by particular shop (might be useful in reporting)
SELECT shops.name AS shop_name, DATE_FORMAT(purchases.date, "%M %Y") as month, SUM(sum) AS income
FROM purchases
JOIN shops ON shops.id = purchases.shop_id
GROUP BY shops.name, month

-- search a user by it's full name or part of it
SELECT name, surname
FROM users
WHERE CONCAT(name, surname) LIKE "%sa%"

-- show amount of all purchases made by a user
SELECT users.name, users.surname, SUM(sum) AS spent
FROM users
JOIN purchases ON purchases.user_id = users.id
GROUP BY users.id

-- select users first/last name who have purchases only at "Kroger" shop
SET @shop = (SELECT id FROM shops WHERE name = "Kroger");
SELECT users.name, users.surname
FROM users
JOIN(
	SELECT purchases.user_id, purchases.shop_id, COUNT(DISTINCT purchases.shop_id) AS shops_amount
	FROM purchases
	GROUP BY purchases.user_id
	HAVING shops_amount = 1
	AND purchases.shop_id = @shop
) AS temp ON users.id = temp.user_id

-- select users first/last name who have purchases in all shops
SET @amount = (SELECT COUNT(id) FROM shops);
SELECT users.name, users.surname
FROM users
JOIN(
	SELECT purchases.user_id, COUNT(DISTINCT purchases.shop_id) as shops_amount
	FROM purchases
	GROUP BY purchases.user_id
	HAVING shops_amount >= @amount
) AS temp ON users.id = temp.user_id
