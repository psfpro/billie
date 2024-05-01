run: up composer-install migrate fixtures

up:
	docker-compose up --detach

down:
	docker-compose down

rebuild:
	docker-compose up --build --remove-orphans --force-recreate --detach

composer-install:
	docker-compose exec -T app composer install --optimize-autoloader --no-interaction --no-progress

migrate:
	docker-compose exec -T app bin/console doctrine:migrations:migrate --allow-no-migration --no-interaction

fixtures:
	docker-compose exec -T app bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction

test-unit:
	docker-compose exec -T app vendor/bin/codecept run Unit
