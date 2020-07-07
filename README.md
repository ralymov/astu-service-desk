# astu-service-desk
Application processing system for ASTU technical support department.

# Предварительные требования
1. Установить git `sudo apt install git`.
2. Установить PHP и его расширения
    ```
    sudo add-apt-repository ppa:ondrej/php
    sudo apt-get update
    sudo apt-get install php7.2
    sudo apt-get install php-pear php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-mysql php7.2-xml php7.2-pgsql
    ```
3. Проверить установку php через терминал `php -v`. Должно выдать версию.
4. Установить PostgreSQL `sudo apt install postgresql postgresql-contrib`.
5. Сконфигурировать базу данных (https://eax.me/postgresql-install/). 
В руководстве пропустить часть про установку. Нужно выполнить следующее
```
sudo -u postgres psql
CREATE DATABASE astu_service_desk;
CREATE USER astu_service_desk WITH password 'astu_service_desk';
GRANT ALL ON DATABASE astu_service_desk TO astu_service_desk;
```
6. Проверить подключение к БД через консоль 
`psql -h localhost astu_service_desk astu_service_desk`.
7. Установить composer по [руководству](https://getcomposer.org/download/) + `sudo mv composer.phar /usr/local/bin/composer`.
8. Установить npm и yarn (https://medium.com/@shivraj.jadhav82/nodejs-and-npm-setup-on-linux-mint-19-696023d50247)
```
curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
sudo apt-get install -y nodejs

curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt update && sudo apt install yarn
```

# Клонирование и запуск проекта

1. Клонировать репозиторий `git clone https://github.com/ralymov/astu-service-desk.git`.
2. Перейти в созданную директорию `cd astu-service-desk`.
3. Установить зависимости PHP `composer install`.
4. Установить зависимости JS `yarn install`.
5. Собрать фронтенд `yarn run dev` (в продакшн - `yarn run prod`).
6. Скопировать файл-пример настроек окружения с правильным именем (`cp .env.example .env`).
7. Сгенерировать ключ приложения `php artisan key:generate`.
8. Заполнить данными настройек окружения `.env` файл (созданные доступы к БД).
9. Запустить миграции (создает таблицы в БД) `php artisan migrate`.
10. Запустить заполнение БД начальными данными `php artisan db:seed`.
11. Сгенерировать ключ jwt `php artisan jwt:secret`.
12. Запустить сервер разработки по пути http://localhost:8000 `php artisan serve`. 
[Альтернатива](https://cpriego.github.io/valet-linux/).
13. Тестовые пользователи - `admin@admin` и `contractor@contractor`.
  
### .env переменные
* `DB_CONNECTION` - Название соединения (`pgsql`).
* `DB_HOST` - Адрес соединения (`127.0.0.1`).
* `DB_PORT` - Порт соединения (`5543` по умолчанию для postgre).
* `DB_DATABASE` - Название БД (`astu_service_desk`).
* `DB_USERNAME` - Имя пользователя БД (`astu_service_desk`).
* `DB_PASSWORD` - Пароль пользователя БД (`astu_service_desk`).
