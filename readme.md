# YLab - Тест

Нужно создать в корне проекта файл [.env]:

```
YII_DEBUG       = true
YII_ENV         = dev

DB_DSN           = mysql:host=ylab-test-db;dbname=ylab_test
DB_USERNAME      = user
DB_PASSWORD      = pass

HOME_URL = http://localhost:8081/
```

Запуск проекта в докере:

```
docker-compose build
docker-compose up -d
```

Сайт будет доступен по адресу http://localhost:8081/ Порт сменил намерено, т.к. на машине уже есть нормальный веб-сервер на 80-м порту, без всяких докеров.

Поставить вендоры, накатить миграции и заполнить данными:

```
docker-compose exec app bash
composer install
php yii migrate
php yii seed
```
