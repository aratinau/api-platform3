# Api platform 3

Generated from template https://github.com/dunglas/symfony-docker

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

# Roadmap

- fork from dunglas/symfony-docker
- install doctrine, api-platform, fixtures

```shell
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```    

- Creation Book entity + fixtures

    - filter on `category[]`

- Install Lexik JWT

    composer require "lexik/jwt-authentication-bundle"
    php bin/console lexik:jwt:generate-keypair

## TODO

### User
- [ ] mail confirmation
- [ ] resend mail confirmation (expiration date)


- [ ] password forgot
- [ ] change password forgot


- [ ] update mail (resend confirmation mail + expiration date)
- [ ] update password (need current password)

### File

- [ ] multipart

### Misc
- [ ] enum instead array in Book $category

### Doctrine

- [ ] all DiscriminatorMap {"NONE", "JOINED", "SINGLE_TABLE", "TABLE_PER_CLASS"} 

