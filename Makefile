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

test:
	@docker exec -i app php scripts/Test.php 2>&1 | sed 's/.*/\x1b[32m&\x1b[0m/'
	@printf "\n"
