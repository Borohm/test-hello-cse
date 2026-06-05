SAIL := ./vendor/bin/sail

.PHONY: install up down fresh test

install:
	cp .env.example .env
	docker run --rm \
			-u "$(shell id -u):$(shell id -g)" \
			-v $(shell pwd):/app \
			-w /app \
			composer:latest \
			composer install
	$(SAIL) up -d
	$(SAIL) artisan key:generate
	sleep 10
	$(SAIL) artisan migrate:fresh --seed
	$(SAIL) artisan storage:link

up:
	$(SAIL) up -d

down:
	$(SAIL) down

fresh:
	$(SAIL) artisan migrate:fresh --seed

test:
	$(SAIL) test
