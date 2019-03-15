<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EurofxRepository")
 */
class Eurofx
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $charcode;

    /**
     * @ORM\Column(type="float")
     */
    private $rate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharcode(): ?string
    {
        return $this->charcode;
    }

    public function setCharcode(string $charcode): self
    {
        $this->charcode = $charcode;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
