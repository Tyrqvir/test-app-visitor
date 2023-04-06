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
6. Я бы еще перевел на http cache с varnish в кач адаптера