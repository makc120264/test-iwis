<?php

namespace App\Command;

use App\Document\ProductDocument as MongoProduct;
use App\Entity\Category;
use App\Entity\Product;
use App\Event\ProductSavedEvent;
use Doctrine\ODM\MongoDB\DocumentManager as MongoManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(name: 'app:process-products')]
class ProcessProductsCommand extends Command
{
    public function __construct(
        private readonly MongoManager $mongo,
        private readonly EntityManagerInterface $mysql,
        private readonly EventDispatcherInterface $dispatcher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repo = $this->mongo->getRepository(MongoProduct::class);
        $products = $repo->findBy(['status' => 'new']);

        foreach ($products as $mongoProduct) {
            // Find or create a category
            $category = $this->mysql->getRepository(Category::class)
                ->findOneBy(['name' => $mongoProduct->getCategory()]);
            if (!$category) {
                $category = new Category();
                $category->setName($mongoProduct->getCategory());
                $this->mysql->persist($category);
            }

            // Find or create a product
            $product = $this->mysql->getRepository(Product::class)
                ->findOneBy(['name' => $mongoProduct->getName()]);

            if (!$product) {
                $product = new Product();
            }

            $product->setName($mongoProduct->getName());
            $product->setPrice($mongoProduct->getPrice());
            $product->setCategory($category);

            $this->mysql->persist($product);
            $this->mysql->flush();

            // event
            $this->dispatcher->dispatch(
                new ProductSavedEvent(
                    $product->getId()
                )
            );

            // update status and save to MongoDB
            $mongoProduct->markProcessed();
            $this->mongo->flush();
        }

        $output->writeln('Done.');

        return Command::SUCCESS;
    }
}
