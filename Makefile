
up:
	./vendor/bin/sail up -d
down:
	./vendor/bin/sail down
stop:
	- docker-compose stop
connect:
	docker exec -it wsg-app bash
docker-cache-clear:
	docker builder prune
clean:
    - ./vendor/bin/sail artisan config:clear
    - ./vendor/bin/sail artisan route:clear
    - ./vendor/bin/sail artisan view:clear
    - ./vendor/bin/sail artisan optimize:clear
