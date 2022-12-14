<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use App\Repository\BookRepository;
use App\State\BookCollectionProvider;
use App\State\BookPostProcessor;
use App\State\TopBookCollectionProvider;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource]
#[GetCollection(provider: BookCollectionProvider::class)]
#[Get]
#[Put]
#[Post(processor: BookPostProcessor::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(groups: ['book:read', 'book:write'])]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Groups(groups: ['book:read', 'book:write'])]
    private array $category = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): array
    {
        return $this->category;
    }

    public function setCategory(?array $category): self
    {
        $this->category = $category;

        return $this;
    }
}
