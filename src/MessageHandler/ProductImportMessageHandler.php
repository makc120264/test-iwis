<?php

namespace App\MessageHandler;

use App\Document\ProductDocument;
use App\Message\ProductImportMessage;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductImportMessageHandler
{
    public function __construct(private readonly DocumentManager $documentManager)
    {
    }

    /**
     * @throws MongoDBException
     * @throws \Throwable
     */
    public function __invoke(ProductImportMessage $message): void
    {
        $product = new ProductDocument();
        $product->setName($message->getName());
        $product->setPrice($message->getPrice());
        $product->setCategory($message->getCategory());
        $product->setStatus('new');

        $this->documentManager->persist($product);
        $this->documentManager->flush();
    }
}
