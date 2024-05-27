# Users and Notifications Microservices

This project consists of two microservices: `users-service` and `notifications-service`. The `users-service` handles user creation and dispatches events, while the `notifications-service` listens for these events and logs the user data.

## Prerequisites

- Docker
- Docker Compose

## Getting Started

1. Run `docker-composer build` to build container images.
2. Run `docker-composer up` to run containers.

## Running Tests

1. Go to `users-service` directory and run command `./vendor/bin/phpunit` to run all tests for users service.
2. Go to `notifications-service` directory and run command `./vendor/bin/phpunit` to run all tests within notifications service.

## Endpoint Info

1. Users service will be running at `http://localhost:8000`
2. Notifications service will be running at `http://localhost:8001`
3. Endpoint to create user is `http://localhost:8000/users`
4. Logs can be checked in `notifications.log` file.
5. To create user use curl `curl -X POST http://localhost:8000/users  -H "Content-Type: application/json" -d '{"email":"test@example.com","firstName":"Test","lastName":"User"}'` or postman.