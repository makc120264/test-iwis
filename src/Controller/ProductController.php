<?php

namespace App\Controller;

use App\Message\ProductImportMessage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function sendMessage(): Response
    {
        $name = 'Cabernet Sauvignon ' . uniqid();
        $price = mt_rand(5000, 50000) / 100;
        // Create a unique test message
        $message = new ProductImportMessage(
            $name,
            $price,
            "Red Wine"
        );

        // Send message to queue
        $this->bus->dispatch($message);

        return new Response('Message sent to RabbitMQ!');
    }
}
