# Api platform 3

Generated from template https://github.com/dunglas/symfony-docker

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. `make start`
4. `make sh` to enter php container
5. `php bin/console lexik:jwt:generate-keypair`
6. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
7. Run `docker compose down --remove-orphans` to stop the Docker containers.

### Create and fill database

`make sh` (if you're not in the php container allready) 

`php bin/console doctrine:database:create`

`php bin/console doctrine:schema:update --force`

### Create User

`POST https://localhost/api/register`

```json
{
    "email": "john@email.com",
    "password": "B2#Etw8BN3zi"
}
```

### Authentication

`POST https://localhost/api/login_check`

```json
{
    "email": "john@email.com",
    "password": "B2#Etw8BN3zi"
}
```

## Docs

[Doctrine](docs/Doctrine/index.md) Example of
- Association Override
- Attribute Override
- Mapped Superclasses

[EntityA EntityB](docs/EntityAB/index.md) Example of
- `InheritanceType` `SINGLE_TABLE`

## Fix 🔧

- `UniqueEntity('email')`
- `php bin/console hautelook:fixtures:load`
- `POST https://localhost/api/entity_bs`

## Roadmap 🛣️

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


## TODO 📝

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

