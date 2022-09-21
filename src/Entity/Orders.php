<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOrder = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: Orderslines::class)]
    private Collection $orderslines;

    public function __construct()
    {
        $this->orderslines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOrder(): ?\DateTimeInterface
    {
        return $this->dateOrder;
    }

    public function setDateOrder(\DateTimeInterface $dateOrder): self
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
            $ordersline->setOrders($this);
        }

        return $this;
    }

    public function removeOrdersline(Orderslines $ordersline): self
    {
        if ($this->orderslines->removeElement($ordersline)) {
            // set the owning side to null (unless already changed)
            if ($ordersline->getOrders() === $this) {
                $ordersline->setOrders(null);
            }
        }

        return $this;
    }
}
