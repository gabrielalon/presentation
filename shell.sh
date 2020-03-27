#!/bin/sh

docker-compose stop
docker-compose up --build -d

docker exec -it presentation-php bash
