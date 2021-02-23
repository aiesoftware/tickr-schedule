.PHONY: copy_env
copy_env:
	cp .env.example .env

.PHONY: install_dependencies
install_dependencies:
	docker-compose -f docker-compose-cmd.yml run composer install

.PHONY: start_container
start_container:
	docker-compose up -d

.PHONY: stop_container
stop_container:
	docker-compose down

.PHONY: tests_unit
tests_unit:
	docker-compose -f docker-compose-cmd.yml run tests_unit

.PHONY: tests_feature
tests_feature:
	docker-compose -f docker-compose-cmd.yml run tests_feature

project_setup: copy_env install
install: install_dependencies
start: start_container
stop: stop_container
tests_all: tests_unit tests_feature
