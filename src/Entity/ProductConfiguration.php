<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductConfigurationRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(columns={"paper_format_id", "pages_id", "paper_type_id"})})
 */
class ProductConfiguration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PaperFormat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paperFormat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PaperType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paperType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductConfigurationQuantityPrice", mappedBy="productConfiguration", orphanRemoval=true)
     */
    private $productConfigurationQuantityPrices;

    public function __construct()
    {
        $this->productConfigurationQuantityPrices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaperFormat(): ?PaperFormat
    {
        return $this->paperFormat;
    }

    public function setPaperFormat(?PaperFormat $paperFormat): self
    {
        $this->paperFormat = $paperFormat;

        return $this;
    }

    public function getPages(): ?Pages
    {
        return $this->pages;
    }

    public function setPages(?Pages $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function getPaperType(): ?PaperType
    {
        return $this->paperType;
    }

    public function setPaperType(?PaperType $paperType): self
    {
        $this->paperType = $paperType;

        return $this;
    }

    /**
     * @return Collection|ProductConfigurationQuantityPrice[]
     */
    public function getProductConfigurationQuantityPrices(): Collection
    {
        return $this->productConfigurationQuantityPrices;
    }

    public function addProductConfigurationQuantityPrice(ProductConfigurationQuantityPrice $productConfigurationQuantityPrice): self
    {
        if (!$this->productConfigurationQuantityPrices->contains($productConfigurationQuantityPrice)) {
            $this->productConfigurationQuantityPrices[] = $productConfigurationQuantityPrice;
            $productConfigurationQuantityPrice->setProductConfiguration($this);
        }

        return $this;
    }

    public function removeProductConfigurationQuantityPrice(ProductConfigurationQuantityPrice $productConfigurationQuantityPrice): self
    {
        if ($this->productConfigurationQuantityPrices->contains($productConfigurationQuantityPrice)) {
            $this->productConfigurationQuantityPrices->removeElement($productConfigurationQuantityPrice);
            // set the owning side to null (unless already changed)
            if ($productConfigurationQuantityPrice->getProductConfiguration() === $this) {
                $productConfigurationQuantityPrice->setProductConfiguration(null);
            }
        }

        return $this;
    }
}
