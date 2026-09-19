<p align="center"><a href="https://printerimfu.ru" target="_blank"><img src="https://github.com/user-attachments/assets/e65de4cc-54cc-4bcd-982c-6ad64e87a3e5" width="400" alt="Сайт по продаже принтеров"></a></p>

## О приложении <a href="https://printerimfu.ru" target="_blank"> printerimfu.ru </a>

Сайт по продаже принтеров, вроде доски объявлений, с ценами, уведомлениями для менеджеров и фильтрами.


### Установка

- Склонировать репозиторий из гитхаба


- Перейти в репозирорий с проектом



- Поднять контейнеры докера (в репозитории уже есть docker-compose.yml с nginx, MySQL и composer)
```bash

docker compose up -d
```

- Установить PHP-зависимости (Composer)
```bash

docker compose exec app composer install
```

- Скопировать (создать) файл окружения

```bash

cp .env.example .env
```

- Сгенерировать ключ laravel
```bash

docker compose exec app php artisan key:generate
```

- Выполнить миграцию и заполнить базу данных тестовыми данными
```bash

docker compose exec app php artisan migrate --seed
```

- Если всё прошло успешно, то проект будет доступен по адресу (порт 8080) http://localhost:8080.


### Какие могут возникнуть проблемы при устаовке:

- Если комп достаточно старый, то может не "подняться" контейнер с базой данных, проверить можно командой:
```bash

docker ps
```

В таком случае можно понизить версию дазы данных на более старую. В корневой директории находим
docker-compose.yml и меняем строку **image: mysql:8.0** на **image: mysql:5.7**

### Как обращаться к сервисам в докере

Обращаться к сервисам из корневой директории проекта через:

docker compose exec app

Например установить зависимости:

docker compose exec app composer install

Или сгенерировать ключ ларавель:

docker compose exec app php artisan key:generate

Или хотим создать контроллер:

docker compose exec app php artisan make:controller CustomerController

Или поработать с композером:

docker compose exec app composer require laravel/sanctum
