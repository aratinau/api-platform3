<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
