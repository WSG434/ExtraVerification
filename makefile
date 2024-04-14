up:
	docker compose up -d

down:
	docker compose down

fpm:
	docker compose exec php-fpm bash

cli:
	docker compose exec php-cli bash

npm-install:
	docker compose exec node npm install

npm-dev:
	docker compose exec node npm run dev

npm-build:
	docker compose exec node npm run build

tinker:
	docker compose exec -u 0 php-cli php artisan tinker

test:
	docker compose exec php-fpm vendor/bin/phpunit
