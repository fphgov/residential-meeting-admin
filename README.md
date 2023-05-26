## Residential meeting admin

Start project
```
docker-compose up -d
```

Install dependecies on backend inline
```
docker exec -it residential_meeting_webapp composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader
```

Migrate database from Doctrine
```
docker exec -it residential_meeting_webapp composer db-update
```
