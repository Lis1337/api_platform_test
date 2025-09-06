compose = docker compose

up:
	$(compose) up -d

down:
	$(compose) down

build:
	$(compose) down && $(compose) build && $(compose) up -d

apec:
	docker exec -it app bash
