up:
	docker-compose up -d

clear-rebuild:
	./vendor/bin/sail build --no-cache

# Stop and remove containers, networks, volumes and images
clean:
	docker-compose down --rmi local -v

env:
	[ -f .env ] && echo .env exists || cp .env.example .env

# Build and up docker containers
build:
	docker-compose build

# Start docker containers
start:
	docker-compose start

init: env build up install

#-----------------------------------------------------------
# Linter
#-----------------------------------------------------------
pint:
	./vendor/bin/sail pint -v --test

## Fix code directly
pint-hard:
	./vendor/bin/sail pint -v

test:
	./vendor/bin/sail artisan co:cle
	#./vendor/bin/sail artisan test
	./vendor/bin/sail composer test

docs:
	./vendor/bin/sail artisan l5-swagger:generate

install:
	docker exec -it --user=sail gp-app composer i
	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan migrate:fresh --seed
 	./vendor/bin/sail artisan storage:link
