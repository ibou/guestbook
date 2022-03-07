
.PHONY: help

## Colors
COLOR_RESET			= \033[0m
COLOR_ERROR			= \033[31m
COLOR_INFO			= \033[32m
COLOR_COMMENT		= \033[33m
COLOR_TITLE_BLOCK	= \033[0;44m\033[37m

SF_ENV = dev


## Help
help:
	@printf "${COLOR_TITLE_BLOCK}UGO Customer Portal Makefile${COLOR_RESET}\n"
	@printf "\n"
	@printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	@printf " make [target]\n\n"
	@printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	@awk '/^[a-zA-Z\-\_0-9\@]+:/ { \
		helpLine = match(lastLine, /^## (.*)/); \
		helpCommand = substr($$1, 0, index($$1, ":")); \
		helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
		printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)


######### DOCKER COMPOSE COMMANDS #########

DOCKER_COMPOSE = docker-compose -p guestbook -f docker-compose.yml -f docker-compose.override.yml

## launch docker containers, no rebuild
start:
	@$(DOCKER_COMPOSE) up --no-recreate

## stop docker containers
stop:
	@$(DOCKER_COMPOSE) stop


######### DATABASE #########

fixtures-test:
	symfony php bin/console doctrine:fixtures:load -n --env=test

fixtures-dev:
	symfony php bin/console doctrine:fixtures:load -n --env=dev

database-test:
	symfony php bin/console doctrine:database:drop --if-exists --force --env=test
	symfony php bin/console doctrine:database:create --if-not-exists --env=test
	symfony php bin/console doctrine:schema:update --force --env=test

database-dev:
	symfony php bin/console doctrine:database:create --if-not-exists --env=dev
	symfony php bin/console doctrine:schema:update --force --env=dev

prepare-test:
	make database-test
	make fixtures-test

prepare-dev:
	make database-dev
	make fixtures-dev

tests: 
	symfony php bin/phpunit --testdox
.PHONY: tests

consume:
	symfony console messenger:consume async -vv