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
