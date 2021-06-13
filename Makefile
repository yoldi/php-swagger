build:
	docker-compose -f docker-compose.test.yml build
phpmetrics:
	docker-compose -f docker-compose.test.yml run --rm php-cli vendor/bin/phpmetrics --report-html=reports/phpmetrics ./src
psalm:
	docker-compose -f docker-compose.test.yml run --rm php-cli vendor/bin/psalm
tests-coverage:
	docker-compose -f docker-compose.test.yml run --rm php-cli vendor/bin/codecept run unit --coverage --coverage-html