# Тестовое задание

## Требования к ресурсам
По ТЗ приложение выполнено на Yii 1.24 и бд MySQL
1. PHP >= 5.4 < 8
2. Сервер Apache

## Установка

1. Склонировать репозиторий
2. Создать базу данных
3. Прописать настройки коннекта в файле protected/config/db.php
4. Накатить миграции
5. Создать домен с HTTP доступом в директорию public

## Использование

### Разбор логов

1. Установить пути до файлов с логами в параметрах конфигурации (protected/config/params.php)

    1.1 Можно прописать несколько логов под своими именами. По этим именам будет определяться маска формата

    2.2 Пути должны быть абсолютными
  
2. Установить маски логов

   2.1 Маска формата ассоциируется с файлом лога по имени

   2.2 Формат должен соответствовать формату в настройках apache

   2.3 По умолчанию используется формат CLF

   2.4 Форматы CLF и COMBINED можно установить директивами 'common' и 'combined' соответственно

   2.5 Можно использовать любой кастомный формат (в примере показан разбор логов опенсервера)

3. Сам разбор. В директории protected нужно запустить консольную команду  `$ php yiic parserlog`

### Авторизация 

1. Авторизация происходит по токену, который генерируется в момент аутентификации
2. Для демонстрации используется логин/пароль  demo/demo
3. Со стороннего ресурса (API) нужно отправить POST-запрос, в теле которого должен быть JSON вида:
`
{"username":"demo", "password":"demo"}
`
В ответ вернется JSON с токеном, который нужно включать в каждый следующий запрос


### Просмотр логов

1. Просмотр логов доступен только авторизованным пользователям
2. При запросе со стороннего ресурса вернется JSON с данными логов


