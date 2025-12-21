compose = docker compose

up:
	$(compose) up -d

down:
	$(compose) down

build:
	$(compose) down && $(compose) build && $(compose) up -d

apec:
	docker exec -it app bash

# make run-test TEST=path
run-test:
	@apec
	php bin/codecept run ${TEST}
