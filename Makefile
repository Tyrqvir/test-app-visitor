help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

clear-cache: ## Run clear cache
	docker-compose exec php bash -c "./bin/console cache:clear"
.PHONY: clear-cache

init-country-codes: ## Init country codes
	docker-compose exec php bash -c "./bin/console visitor:load-country-codes"
.PHONY: init-country-codes

composer-init: ## Composer install
	docker-compose exec php bash -c "composer install"
.PHONY: composer-init

unit-tests: ## Unit Tests
	docker-compose exec php bash -c "./vendor/phpunit/phpunit/phpunit"
.PHONY: unit-tests

exec-app: ## docker exec
	docker-compose exec php bash
.PHONY: exec

build: ## docker-compose build up
	docker-compose up -d --build
.PHONY: build

local-deploy: build composer-init clear-cache unit-tests## local deploy
.PHONY: local-deploy

.DEFAULT_GOAL := help