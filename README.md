Тестове завдання: 

# Обробка асинхронних повідомлень через RabbitMQ
Опис завдань:
1. Отримання повідомлення з RabbitMQ
   Реалізувати споживача (Symfony Messenger), який слухає чергу product_import у
   RabbitMQ.
   Повідомлення має такий JSON-формат:
   `{
   "name": "Cabernet Sauvignon",
   "price": 150.50,
   "category": "Red Wine"
   }`
   Після отримання, записати товар у MongoDB з початковим статусом new.

2. Збереження у MongoDB
   Зберігати товари в колекції products.
   Структура в MongoDB:
`   {
   "_id": "uuid",
   "name": "Cabernet Sauvignon",
   "price": 150.50,
   "category": "Red Wine",
   "status": "new",
   "created_at": "2025-02-09T12:00:00Z"
   }
`   Додати індекс на поле status для швидкого пошуку new товарів.

3. Обробка нових товарів та збереження в MySQL
   Реалізувати Symfony Console команду app:process-products, яка:
   Вибирає всі товари зі статусом new із MongoDB.
   Створює або оновлює записи в MySQL у таблицях:
   Product (id, name, price, category_id)
   Category (id, name)
   Після успішного збереження змінює статус товару в MongoDB на processed.

4. Викидання івенту та логування
   Після успішного збереження кожного товару в MySQL викидати Symfony Event
   ProductSavedEvent.
   Реалізувати перехоплювач (EventListener), який отримує цей івент та логує info
   про успішне збереження товару