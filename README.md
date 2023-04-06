# Тестовое задание:

Написать код на PHP, реализующий REST API, предназначенный для учёта посещений сайта с разбиением по странам.

### Сервис должен предоставлять два метода:

Обновление статистики, принимает один аргумент – код страны (ru, us, it...).

Предполагаемая нагрузка: 1 000 запросов в секунду.

Получение собранной статистики по всем странам, возвращает JSON-объект вида:
{ код страны: количество, cy: 123, us: 456, ... }.
Предполагаемая нагрузка: 1 000 запросов в секунду.

Хранилище данных: Redis.

Допустимо использование готовых библиотек, фреймворков и т.п..

На оценку влияет готовность к высоким нагрузкам, читаемость кода, обработка ошибок.
Время выполнения: от 2 до 4 часов.

### Для запуска проекта:

Зависимость "make"

1. git clone git@github.com:Tyrqvir/test-app-visitor.git
2. Запустить make local-deploy

### Настройки приложения

- Управление кэшем для получения списка находится в .env
- Креды для подключения redis находятся в .env

### Notes:

1. Не успел внедрить версионость через заголовки
2. Не успел доделать Swagger
3. Не успел написать unit тесты + нагрузочные для проверки условия по rps
4. Не успел отрисовать use cases
5. Все ошибки планируются обрабатывать в ExceptionEventSubscriber
