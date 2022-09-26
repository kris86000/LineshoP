<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $nameArticle = null;

    #[ORM\Column(length: 200)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 200)]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?categories $categories = null;

    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: Orderslines::class)]
    private Collection $orderslines;

    public function __construct()
    {
        $this->orderslines = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameArticle(): ?string
    {
        return $this->nameArticle;
    }

    public function setNameArticle(string $nameArticle): self
    {
        $this->nameArticle = $nameArticle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategories(): ?categories
    {
        return $this->categories;
    }

    public function setCategories(?categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection<int, Orderslines>
     */
    public function getOrderslines(): Collection
    {
        return $this->orderslines;
    }

    public function addOrdersline(Orderslines $ordersline): self
    {
        if (!$this->orderslines->contains($ordersline)) {
            $this->orderslines->add($ordersline);
            $ordersline->setArticle($this);
        }

        return $this;
    }

    public function removeOrdersline(Orderslines $ordersline): self
    {
        if ($this->orderslines->removeElement($ordersline)) {
            // set the owning side to null (unless already changed)
            if ($ordersline->getArticle() === $this) {
                $ordersline->setArticle(null);
            }
        }

        return $this;
    }
}
