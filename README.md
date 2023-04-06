### Для запуска проекта:

Зависимость "make"

1. `git clone git@github.com:Tyrqvir/test-app-visitor.git`
2. Запустить `make local-deploy`
3. Для сброса данных хранилище по просмотрам или перезаписать данные в хранилище по новым странам
   запускать `make init-country-codes`
4. В контейнере load-test производится запуск нагрузочного тестирования через wrk по локальной сети docker

### Настройки приложения

- Управление кэшем для получения списка находится в .env
    - LIST_VISITOR_TTL=15
    - LIST_VISITOR_CACHE_KEY=visitor-list
    - COUNTRY_CODE_CACHE_KEY=country-codes
    - COUNTRY_CODE_CACHE_TTL=86400
- Креды для подключения redis находятся в .env

### Notes:

1. Не успел внедрить версионость через заголовки
2. Не успел доделать Swagger
3. Не успел отрисовать use cases
4. Все ошибки планируются обрабатывать в ExceptionEventSubscriber
5. Я бы еще перевел на http cache с varnish в кач адаптера