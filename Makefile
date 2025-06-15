# Automate commands

up:
	composer update
	docker compose up -d --build

down:
	docker compose down

prune:
	docker volume prune -a
	docker network prune
	docker system prune -a

status:
	@docker ps -a --format 'table {{.ID}}\t{{.Image}}\t{{.RunningFor}}\t{{.Status}}\t{{.Names}}\t{{.State}}\t{{.Size}}\t{{.Mounts}}\t{{.Networks}}'
