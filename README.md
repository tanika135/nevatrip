В файле index.php выводтся форма для выбора мероприятия и вида билета.

В файле script.js формируем динамический вывод типов билета. Если у выбронного мероприятия 
только один тип билета, то отобразится только он. Также через ajax сериализуем форму.

Файлы save_order.php - обработчик для ajax-запрасов.

api.php - пример стороннего api.
connection.php и dataprovider.php - подключение к базе данных.

В events.php реализованы методы получения событий из БД и рассчет общей стоимости заказа.

В orders.php реализованы методы создания таблицы с заказами, если она не существует и сохранение заказа в таблицу.
В методе saveOrder вызывается метод для создания билетов.

В tickets.php реализованы: 
метод создания таблицы с билетами, если она не существует
метод для сохранения билетов
метод поиска баркода
метод генерации баркода