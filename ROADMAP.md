# Roadmap

- fork from dunglas/symfony-docker
- install doctrine , api-platform, fixtures

```shell
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```    

- Creation Book entity + fixtures 

  - filter on `category[]`

- Install Lexik JWT


    composer require "lexik/jwt-authentication-bundle"
    php bin/console lexik:jwt:generate-keypair