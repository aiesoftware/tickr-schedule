#### Laravel implementation

Project setup:
```
$ make project_setup
```

Start server and one time app key generation:
```
$ make start
$ docker-compose exec app php artisan key:generate
```

Run the entire test suite:
```
$ make tests_all
```

Run individual suites:
```
$ make tests_feature
$ make tests_unit
```

Endpoint is accessible on `localhost:8060` via curl:
```
curl  -H "Accept: application/json" -H "Content-Type: application/json" "localhost:8060/carbon-offset-schedule?scheduleInMonths=5&subscriptionStartDate=2021-01-07"
```

View CI build: https://github.com/aiesoftware/tickr-schedule/runs/1964940761?check_suite_focus=true

##### Approach

The goal is to isolate the domain code from the infrastructure code, to allow the domain code to be fully unit testable, and independent of the chosen framework. In theory the `Domain` namespace and its tests can be lifted out and used with a different framework. 

Infrastructure code, in this case anything framework/HTTP related, is covered by the integration tests, which test that the framework "adapters" are correctly wired up to the domain. 

