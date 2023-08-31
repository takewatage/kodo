up-m1:
	docker-compose -f docker-compose.yml -f docker-compose.dev.yml -f docker-compose.m1.yml up -d
up:
	docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d
down:
	- docker-compose stop
	- docker-compose down
stop:
	- docker-compose stop
connect:
	docker exec -it wsg-app bash
docker-cache-clear:
	docker builder prune
up-st:
	docker-compose -f docker-compose.st.yml -f docker-compose.dev.yml up -d
