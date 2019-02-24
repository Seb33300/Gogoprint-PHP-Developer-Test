<?php

namespace App\Entity;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductConfigurationQuantityPriceRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(columns={"product_configuration_id", "quantity"})})
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ProductConfigurationQuantityPrice implements ObjectManagerAware
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductConfiguration", inversedBy="productConfigurationQuantityPrices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productConfiguration;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /** @var ObjectManager */
    private $objectManager;


    public function injectObjectManager(ObjectManager $objectManager, ClassMetadata $classMetadata) {
        $this->objectManager = $objectManager;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductConfiguration(): ?ProductConfiguration
    {
        return $this->productConfiguration;
    }

    public function setProductConfiguration(?ProductConfiguration $productConfiguration): self
    {
        $this->productConfiguration = $productConfiguration;

        return $this;
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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getPrices()
    {
        $prices = [];
        $sundays = 0;

        /** @var ProductionTimeMarkup[] $productionTimeMarkups */
        $productionTimeMarkups = $this->objectManager->getRepository(ProductionTimeMarkup::class)->findBy([], ['days' => 'ASC']);

        foreach ($productionTimeMarkups as $productionTimeMarkup) {
            if (date('w', strtotime(($productionTimeMarkup->getDays()+$sundays).' days')) == 0) {
                $sundays++;
            }
            $prices[] = [
                'date' => date('Y-m-d', strtotime(($productionTimeMarkup->getDays()+$sundays).' days')),
                'price' => $productionTimeMarkup->price = round($this->getPrice() * (1 + $productionTimeMarkup->getMarkup() / 100)),
            ];
        }

        return $prices;
    }
}
