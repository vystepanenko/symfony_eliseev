up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear  docker-pull docker-build docker-up composerInstall

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

composerInstall:
	docker-compose run --rm symfony-php-cli composer install

php-v:
	docker-compose run --rm symfony-php-cli php -v

makeController:
	docker-compose run --rm symfony-php-cli php bin/console make:controller

clearCache:
	docker-compose run --rm symfony-php-cli php bin/console cache:clear