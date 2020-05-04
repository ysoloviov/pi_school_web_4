#Задание

В файле purchase_log.json.gz храниться информация о покупках клиентов. Каждая строка это
это отдельный json обект хранящий данные об одной покупке. Нужно сделать следующее:

1. Проанализировать структуру данных покупки и спроектировать схему базы данных так чтоб 
хранить данные из файла наилучшим образом
2. написать скрипт который будет считывать данные из файла и заносить в базу
3. написать ряд sql запросов которые будут предоставлять следующие данные:
- select all users first/last name who made a purchase of products from "Office" category in "Rite Aid" shop for last 10 years
- select names of all categories and count the number of purchases of products from that category
- select users first/last name who have more then one purchase in "Kroger" shop
- show profit amount per month by particular shop (Might be useful in reporting)
- search a user by it's full name oк part of it
- show amount of all purchases made by a user
- select users first/last name who have purchases only at "Kroger" shop
- select users first/last name who have purchases purchases in all shops
(обратите внимание, всех магазинов, то есть запрос должен продолжать правильно работать даже если 
я вручную добавлю в базу еще магазинов и покупок)


####Папка с задание должна содержать следующее

- файл schema.sql содержащий запросы на создание всех нужных таблиц
- файл queries.sql содержащий требуемые по заданию запросы
- папку lib в которой будут классы для работя с файлом и базой данных
- файл fillDB.php который при запуске будет наполнять базу
- файл config.php в котором будут конфиги базы данных(логин,пароль и т.д.)