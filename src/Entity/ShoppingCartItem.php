<?php

namespace App\Entity;

use App\Repository\ShoppingCartItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingCartItemRepository::class)]
class ShoppingCartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $quantity = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?ShoppingCart $ShoppingCart = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingCartItems')]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->ShoppingCart;
    }

    public function setShoppingCart(?ShoppingCart $ShoppingCart): self
    {
        $this->ShoppingCart = $ShoppingCart;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
