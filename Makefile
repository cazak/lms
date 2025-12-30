SHELL = /bin/sh

UID := $(shell id --user)
GID := $(shell id --group)

export UID
export GID

init: docker-down-clear clear docker-pull docker-build docker-up back-init

check: validate-schema lint analyze test

cli:
	docker compose run --rm -it php-cli sh

docker-up:
	docker compose up --detach

docker-down:
	docker compose down --remove-orphans --timeout=1

docker-down-clear:
	docker compose down --volumes --remove-orphans --timeout=1

docker-pull:
	docker compose pull

docker-build:
	docker compose build --pull

clear:
	docker run --rm --volume "${PWD}":/app --workdir /app alpine:3.22 sh -c 'rm -rf var/cache/* var/log/* var/test/*'

back-init: permissions deps-install wait-db

permissions:
	docker run --rm --volume "${PWD}"/:/app --workdir /app alpine:3.22 chmod 777 var/cache var/log var/test

deps-install:
	docker compose run --rm php-cli composer install

deps-update:
	docker compose run --rm php-cli composer update

wait-db:
	docker compose run --rm php-cli wait-for-it postgres:5432 -t 30

validate-schema:
	docker compose run --rm php-cli composer app orm:validate-schema -- -v

lint:
	docker compose run --rm php-cli composer rector -- --dry-run
	docker compose run --rm php-cli composer php-cs-fixer fix -- --dry-run --diff

lint-fix:
	docker compose run --rm php-cli composer rector
	docker compose run --rm php-cli composer php-cs-fixer fix

analyze:
	docker compose run --rm php-cli composer phpstan

test:
	docker compose run --rm php-cli composer test
