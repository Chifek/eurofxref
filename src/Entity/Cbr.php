<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CbrRepository")
 */
class Cbr
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $numcode;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $charcode;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nominal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumcode(): ?string
    {
        return $this->numcode;
    }

    public function setNumcode(string $numcode): self
    {
        $this->numcode = $numcode;

        return $this;
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

    public function getNominal(): ?int
    {
        return $this->nominal;
    }

    public function setNominal(int $nominal): self
    {
        $this->nominal = $nominal;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
