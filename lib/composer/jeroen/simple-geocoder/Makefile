# If the first argument is "composer"...
ifeq (composer,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "composer"
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(RUN_ARGS):;@:)
endif

.PHONY: ci test phpunit cs stan covers composer

ci: test cs

test: covers phpunit

cs: phpcs stan

phpunit:
	docker-compose run --rm app ./vendor/bin/phpunit

phpcs:
	docker-compose run --rm app ./vendor/bin/phpcs

stan:
	docker-compose run --rm app ./vendor/bin/phpstan analyse --level=1 --no-progress src/ tests/

covers:
	docker-compose run --rm app ./vendor/bin/covers-validator

composer:
	docker run --rm --interactive --tty --volume $(shell pwd):/app -w /app\
	 --volume ~/.composer:/composer --user $(shell id -u):$(shell id -g) composer composer $(filter-out $@,$(MAKECMDGOALS))
