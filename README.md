# Api platform 3

`make build`

`make up`

### Create and fill database

`make sh` (if you're not in the php container allready) 

`php bin/console doctrine:database:create`

`php bin/console doctrine:schema:update --force`

`php bin/console doctrine:fixtures:load -n`

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

### [Summary of](docs/Doctrine/index.md) Association Override, Attribute Override, Mapped Superclasses

### [EntityA EntityB](docs/EntityAB/index.md) Example using `InheritanceType` in mode `SINGLE_TABLE`

PR related: https://github.com/aratinau/api-platform3/pull/1

### [EntityX EntityY EntityZ](docs/EntityXYZ/index.md) Example using `MappedSuperclass` on abstract class

```mermaid
classDiagram
    EntityX --> EntityY
    EntityX --> EntityZ

    class EntityX ~abstract~
    EntityX : +User author
    EntityX : +string name

    class EntityY
    EntityY : +string recipient

    class EntityZ
    EntityZ : +Collection recipients
```

Example of
- `MappedSuperclass` and Get Collection of EntityY and EntityZ on same GetCollection
- Automatically applies the author with the Interface `AuthorInterface.php` and the Subscriber `AttachAuthorSubscriber`

PR related: https://github.com/aratinau/api-platform3/pull/2

### [Mail MailIncoming MailOutcoming](docs/Mail/index.md) of 🚀 `InheritanceType` in mode `JOINED`

```mermaid
classDiagram
    Mail --> MailIncoming
    Mail --> MailOutcoming

    class Mail
    Mail : +User author
    Mail : +string subject

    class MailIncoming
    MailIncoming : +string sender
    MailIncoming : +Collection recipients

    class MailOutcoming
    MailOutcoming : +User sender
    MailOutcoming : +string recipient
```

PR related: https://github.com/aratinau/api-platform3/pull/3

### Format `text/csv`, `text/dino 🦕`

![format.png](./docs/Format/format.png)

```bash
curl -X 'GET' \
  'https://localhost/api/users?page=1' \
  -H 'accept: text/dino'
```

![format.png](./docs/Format/format-dino.png)

```bash
curl -X 'GET' \
  'https://localhost/api/users?page=1' \
  -H 'accept: text/csv'
```

![format.png](./docs/Format/format-csv.png)

PR related: https://github.com/aratinau/api-platform3/pull/4

## Notes

    "hydra:description": "Unable to generate an IRI for the item of type \"App\\Entity\\EntityB\""
    This was happening because the entity was never being saved, so the id was never generated.
    https://stackoverflow.com/questions/57887026/unable-to-generate-an-iri-for-the-item-of-type-exception-after-api-platform-mi

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

  - `composer require "lexik/jwt-authentication-bundle"`
  - `php bin/console lexik:jwt:generate-keypair`

## Discussion and Message

### Create a new Discussion with a Message

![output.png](docs/Discussion/output.png)

`POST /api/discussions`

```json
{
    "content": "Fuga ducimus debitis fuga quis sint similique dolores."
}
```

### Create a new Message to an existing Discussion

`POST /api/discussions/{id}/message`

```json
{
    "content": "Hic ut et excepturi molestias amet sit."
}
```


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

### MappedSuperclass

- [ ] hydrate the results by iri
- [ ] paginate results
- [ ] order results
- [ ] filter results
