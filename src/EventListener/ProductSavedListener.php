<?php

namespace App\EventListener;

use App\Event\ProductSavedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class ProductSavedListener
{
    public function __construct(private readonly LoggerInterface $logger) {}

    public function __invoke(ProductSavedEvent $event): void
    {
        $this->logger->info('Product saved with ID: '.$event->productId);
    }
}
