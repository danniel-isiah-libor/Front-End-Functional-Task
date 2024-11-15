# Variables
DOCKER_COMPOSE = docker-compose
SERVICE_NAME = app

# Build the Docker image
build:
	$(DOCKER_COMPOSE) build

# Run the Docker container
up:
	$(DOCKER_COMPOSE) up -d

# Stop the Docker container
down:
	$(DOCKER_COMPOSE) down

# View logs from the Docker container
logs:
	$(DOCKER_COMPOSE) logs -f

# Remove Docker containers, networks, volumes, and images created by up
clean:
	$(DOCKER_COMPOSE) down --rmi all --volumes --remove-

# Go inside the running container
shell:
	$(DOCKER_COMPOSE) exec $(SERVICE_NAME) /bin/sh
