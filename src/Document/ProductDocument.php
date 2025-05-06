<?php

namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: "products")]
#[MongoDB\Index(keys: ["status" => "asc"])]
class ProductDocument
{
    #[MongoDB\Id]
    private string $id;

    #[MongoDB\Field(type: "string")]
    private string $name;

    #[MongoDB\Field(type: "float")]
    private float $price;

    #[MongoDB\Field(type: "string")]
    private string $category;

    #[MongoDB\Field(type: "string")]
    private string $status = 'new';

    #[MongoDB\Field(type: "date")]
    private DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function markProcessed(): void
    {
        $this->status = 'processed';
    }

    // Getters and setters

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
