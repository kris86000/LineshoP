<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $iD = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $iD): self
    {
        $this->iD = $iD;

        return $this;
    }
}
