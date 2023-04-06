help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

clear-cache: ## Run clear cache
	docker-compose exec php bash -c "./bin/console cache:clear"
.PHONY: clear-cache

composer-init: ## Composer install
	docker-compose exec php bash -c "composer install"
.PHONY: composer-init

exec-app: ## docker exec
	docker-compose exec php bash
.PHONY: exec

build: ## docker-compose build up
	docker-compose up -d --build
.PHONY: build

local-deploy: build composer-init clear-cache## local deploy
.PHONY: local-deploy

.DEFAULT_GOAL := help