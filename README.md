# Roadsurfer
> Where you can rent various amazing campervans and enjoy your trip!
---
Roadsurfer is a lightweight renting system that allows you to rent campervans and equipments. This system is designed by **DDD** conecpts and best practices.

## Installation
Roadsurfer makes use of Docker.

0. make sure you have `git`, `docker` and `docker-compose` installed.
   ```shell
   git clone git@github.com:samirreza/roadsurfer.git
   ```
1. now its time to isntall project you can also configure environments variables in .env files :
    ```shell
   make up
   make install
   make db
   ```
2. once the containers are running, your app is ready to go.
3. you can also seed database by running this commands :
    ```shell
    make shell
    php bin/console doctrine:fixtures:load
   ```
4. for acquaintance with system API's you can visit `http://localhost:8001` and see the swagger documentation for this project

### Tests
To make sure everything is working, you may run Roadsurfer's tests.
don't forget to create and config a test database before running tests!
   ```shell
    make shell
    php bin/console --env=test doctrine:database:create
    php bin/console --env=test doctrine:migration:migrate
   ```
To run the tests :
   ```shell
   make shell
   php ./vendor/bin/phpunit
   ```

## Notables
For this project we have some assumptions :
- each station take equipments in morning from 9 to 11 and must call take API
- each station deliver equipments in evening from 14 to 17 and must call deliver API
- you can check wiki image for better understanding the Algorithm

## TODOs
There are many enhancements still applicable on Roadsurfer, most important ones include:
- **Write more and more tests.**
- Add createdAt updatedAt columns to rent table by help of StofDoctrineExtensionsBundle
- Cache for doctrine queries (we have good events for invalidating them !)
- Use OpenAPI annotation
- Each station can manage its own working hours
- Improve swagger documentation and add all kind of exceptions and invalid messages
