<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductConfiguration")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $productConfiguration;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     */
    private $quantity;

    /**
     * @ORM\Column(type="date")
     *
     * @Serializer\Type("DateTime<'Y-m-d'>")
     *
     * @Assert\NotBlank()
     */
    private $date;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date = null): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getProductConfiguration()) {

            // Check if quantity is a valid value
            if ($this->getQuantity()) {
                foreach ($this->getProductConfiguration()->getProductConfigurationQuantityPrices() as $configurationQuantityPrice) {
                    if ($configurationQuantityPrice->getQuantity() == $this->getQuantity()) {
                        // Check if date is a valid value
                        if ($this->getDate()) {
                            foreach ($configurationQuantityPrice->getPrices() as $price) {
                                if ($price['date'] == $this->getDate()->format('Y-m-d')) {
                                    return true;
                                }
                            }
                            $context
                                ->buildViolation('Invalid date for this product configuration.')
                                ->atPath('quantity')
                                ->addViolation()
                            ;
                        }

                        return true;
                    }
                }
                $context
                    ->buildViolation('Invalid quantity for this product configuration.')
                    ->atPath('quantity')
                    ->addViolation()
                ;
            }

        }
    }
}
