DATE=`date +%Y-%m-%d`
DATETIME = `date +%Y-%m-%d_%H-%M-%S`

define highlight
	@echo "\033[1;32m$1\033[0m"
endef

.PHONY: test_all
test_all:
	@./vendor/bin/phpunit

.PHONY: composer_reload
composer_reload:
	@composer clear-cache --no-interaction
	@composer update -vv --no-interaction
	@composer dump-autoload --no-interaction

.PHONY: composer_develop
composer_develop:
	@composer clear-cache --no-interaction
	@composer install -vv --no-interaction --dev --prefer-dist --optimize-autoloader

.PHONY: composer_public
composer_public:
	@composer clear-cache --no-interaction
	@composer install -vv --no-interaction --no-dev --prefer-dist --optimize-autoloader

.PHONY: composer_check
composer_check:
	$(call highlight,#### ---- composer diag ---- ####)
	@composer diag

.PHONY: insights
insights:
	@./vendor/bin/phpinsights analyse ./src

