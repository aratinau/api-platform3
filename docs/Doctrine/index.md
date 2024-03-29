# Doctrine

## Association Override

override a relationship mapping defined by the mapped superclass

    Things to note:
      - The "association override" specifies the overrides base on the property name.
      - This feature is available for all kind of associations. (OneToOne, OneToMany, ManyToOne, ManyToMany)
      - The association type CANNOT be changed.
      - The override could redefine the joinTables or joinColumns depending on the association type.
      - The override could redefine inversedBy to reference more than one extended entity.
      - The override could redefine fetch to modify the fetch strategy of the extended entity.

```php
<?php

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /** @var Collection<int, Group> */
    #[ORM\JoinTable(name: 'users_groups')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'group_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'users')]
    protected Collection $groups;

    #[ORM\ManyToOne(targetEntity: 'Address')]
    #[ORM\JoinColumn(name: 'address_id', referencedColumnName: 'id', nullable: true)]
    protected Address|null $address = null;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }
}

///////////////////////////////////////////////////////////////////////////////

#[ORM\Entity]
#[ORM\AssociationOverrides([
    new ORM\AssociationOverride(
        name: 'groups',
        joinColumns: [
            new ORM\JoinColumn(name: 'adminuser_id')
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: 'admingroup_id')
        ],
        joinTable: new ORM\JoinTable(
            name: 'users_admingroups',
        )
    ),
    new ORM\AssociationOverride(
        name: 'address',
        joinColumns: [
            new ORM\JoinColumn(name: 'adminaddress_id',
                referencedColumnName: 'id')
        ]
    )
])]
class Admin extends User
{
}
```

commit related: https://github.com/aratinau/api-platform3/commit/68209b6a345d4def8ab08d6761b13212cd41e20b

doctrine documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.14/reference/inheritance-mapping.html#association-override

## Attribute Override

override a field mapping defined by the mapped superclass

    Things to note:
      - The "attribute override" specifies the overrides base on the property name.
      - The column type CANNOT be changed. If the column type is not equal you get a MappingException
      - The override can redefine all the attributes except the type.

```php
#[MappedSuperclass]
class User
{
    #[ORM\Column(name: 'user_name', length: 250, unique: false, nullable: true)]
    private ?string $name = null;
}

///////////////////////////////////////////////////////////////////////////////

#[ORM\Entity]
#[ORM\AttributeOverrides([
    new ORM\AttributeOverride(
        name: 'id',
        column: new ORM\Column(
            name: 'guest_id',
            type: 'integer',
            length: 140
        )
    ),
    new ORM\AttributeOverride(
        name: 'name',
        column: new ORM\Column(
            name: 'guest_name',
            length: 240,
            unique: true,
            nullable: false
        )
    )
])]
class Guest extends User
{
    private ?int $id = null;
    private ?string $name = null;
}
```

commit related: https://github.com/aratinau/api-platform3/commit/0446d1d379b9e95b2d27bfab55fc755683ed1d2c

doctrine documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.14/reference/inheritance-mapping.html#attribute-override

## Mapped Superclasses

A mapped superclass is an abstract or concrete class that provides persistent entity state and mapping information for its subclasses, but which is not itself an entity. Typically, the purpose of such a mapped superclass is to define state and mapping information that is common to multiple entity classes.

```php
#[ORM\MappedSuperclass]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}

#[ORM\Entity]
class Employee extends Person
{
    private ?int $id = null;
}

#[ORM\Entity]
class Toothbrush 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
///////////////////////////////////////////////////////////////////////////////

```

commit related: https://github.com/aratinau/api-platform3/commit/f15447fb7bf19820de5a862de625dffee4896214

doctrine documentation: https://www.doctrine-project.org/projects/doctrine-orm/en/2.14/reference/inheritance-mapping.html#mapped-superclasses
