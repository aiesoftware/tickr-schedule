install:
	docker-compose -f docker-compose-cmd.yml run composer install

run:
	docker-compose up

.PHONY: tests_unit
tests_unit:
	docker-compose -f docker-compose-cmd.yml run tests_unit

.PHONY: tests_feature
tests_feature:
	docker-compose -f docker-compose-cmd.yml run tests_feature

tests_all: tests_unit tests_feature
