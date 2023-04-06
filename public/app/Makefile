help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-16s\033[0m %s\n", $$1, $$2}'
.PHONY: help

rector: ## Run rector
	vendor/bin/rector process src/

php-fixer: ## Run cs fixer
	vendor/bin/php-cs-fixer fix --allow-risky=yes

pretty: rector php-fixer ## Rector + fixer

test: ## Run test
	APP_ENV=test php bin/phpunit

.DEFAULT_GOAL := help
