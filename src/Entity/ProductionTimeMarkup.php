<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionTimeMarkupRepository")
 */
class ProductionTimeMarkup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $days;

    /**
     * @ORM\Column(type="integer")
     */
    private $markup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getMarkup(): ?int
    {
        return $this->markup;
    }

    public function setMarkup(int $markup): self
    {
        $this->markup = $markup;

        return $this;
    }
}
