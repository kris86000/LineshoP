<?php

namespace App\Entity;

use App\Repository\OrderslinesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderslinesRepository::class)]
class Orderslines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'orderslines')]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?orders $orders = null;

    #[ORM\ManyToOne(inversedBy: 'orderslines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?articles $article = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrders(): ?orders
    {
        return $this->orders;
    }

    public function setOrders(?orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getArticle(): ?articles
    {
        return $this->article;
    }

    public function setArticle(?articles $article): self
    {
        $this->article = $article;

        return $this;
    }
}
