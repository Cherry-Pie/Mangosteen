SHELL ?= /bin/bash

YELLOW=\033[0;33m
BLUE=\033[0;34m
BOLDGREEN=\033[1;32m
RED=\033[0;31m
NC=\033[0m

.SILENT: ;
.ONESHELL: ;
.NOTPARALLEL: ;
.EXPORT_ALL_VARIABLES: ;
Makefile: ;

.DEFAULT_GOAL := help


.PHONY: up
up:
	docker-compose up -d

.PHONY: build
build:
	docker-compose build app

.PHONY: stop
stop:
	docker-compose stop

.PHONY: bash
bash:
	docker-compose exec --user webuser app bash

.PHONY: root
root:
	docker-compose exec --user root app bash

.PHONY: publish
publish:
	docker build -t mangosteen-app-release .
	docker tag mangosteen-app-release:latest yarosofakingwoeful/mangosteen-app:release
	docker push yarosofakingwoeful/mangosteen-app:release

%:
	@:
