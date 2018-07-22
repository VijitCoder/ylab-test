all: build run

build:
	docker-compose build --no-cache web

run:
	docker-compose -p ylab up -d web

stop:
	docker-compose -p ylab kill

destroy:
	docker-compose -p ylab down
	
shell:
	docker-compose -p ylab exec app bash

logs:
	docker-compose -p ylab logs app

ip:
	docker inspect ylab-test-app | grep \"IPAddress\"
