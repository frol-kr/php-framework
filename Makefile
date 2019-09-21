TAG_DEV=php-framework/app-dev

help:
	@echo "'init' - To initialize the project for local development"
	@echo "'build' - To build docker "
	@echo "'composer.install' - To install vendors using the composer.lock file"
	@echo "'composer.require package='core/something ^1.0' - To add a package to composer.json"
	@echo "'composer.remove package='core/something ^1.0' - To remove a package to composer.json"
	@echo "'composer.update' - To update vendors"

.PHONY: help init build

init: build

build:
	docker build -t ${TAG_DEV}:latest .

composer.install:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer install --prefer-dist

composer.require:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer require ${package}

composer.remove:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer remove ${package}

composer.update:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer update
