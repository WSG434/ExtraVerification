
<h1 align="center">Email, SMS, Telegram Verify 🖼️ </h1>
  <h3 align="center">Granular project for skills demo </h3>

[//]: # (![LaravelGallery]&#40;https://github.com/WSG434/LaravelGallery/blob/master/preview.jpg?raw=true&#41;)

## 🚀 Stack

- PHP, Laravel
- Docker
- git

## ⚡ Quick setup

1. Скачать проект `git clone https://github.com/WSG434/ExtraVerification`
2. Скопировать и запустить docker команды в терминале: 
	`docker compose up --build -d && docker compose exec php-cli composer install && docker compose exec php-cli php artisan migrate:fresh --seed`
3. API доступно по адресу `localhost:8080/api`, Postman коллекция в корне и доступна для импорта, не забудьте про .env
