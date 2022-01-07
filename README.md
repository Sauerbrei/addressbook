# Address Book

## Getting Started

TLDR; first start? `make start && make migrate` goto http://localhost or do `make test`

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `make build` to build fresh images
3. Run `make up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `make down` to stop the Docker containers.
6. `make test` will initialize the fixtures and run the whole testsuite in the docker environment
   1. otherwise youll need to set it up in your IDE by yourself.

## Ideas
 - execute migrations automatically on startup
 - Translate the form-labels via 'label' => 'translation.key'
 - Add more constraints to the forms via 'constraints' => [new ...()]
   - I assumed to validate only against the generic types (look ContactType)
 - add more integration tests for the controllers. currently it is a show case
