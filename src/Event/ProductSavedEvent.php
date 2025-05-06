<?php

namespace App\Event;

class ProductSavedEvent
{
    public function __construct(public readonly int $productId) {}
}
