all: rebuild run

build:
	docker-compose build --no-cache --build-arg hostUID=`id -u` --build-arg hostGID=`id -g` web

rebuild:
	docker-compose build --build-arg hostUID=`id -u` --build-arg hostGID=`id -g` web

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
