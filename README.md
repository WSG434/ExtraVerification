
<h1 align="center">LaravelGallery 🖼️ </h1>
  <h3 align="center">Granular project for skills demo </h3>

![LaravelGallery](https://github.com/WSG434/LaravelGallery/blob/master/preview.jpg?raw=true)

## 🚀 Stack

- PHP, Laravel
- Docker
- git, xDebug

## ⚡ Quick setup

1. Скачать проект `git clone https://github.com/WSG434/LaravelGallery.git`
2. Скопировать и запустить docker команды в терминале: 
	`docker compose up --build -d && docker compose exec php-cli composer install && docker compose exec php-cli php artisan migrate && docker compose exec php-cli php artisan db:seed`
3. Перейти в браузер по адресу `localhost:8080`
