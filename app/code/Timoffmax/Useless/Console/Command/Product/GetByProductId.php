<?php

namespace Timoffmax\Useless\Console\Command\Product;

use Timoffmax\Useless\Model\Product;
use Timoffmax\Useless\Model\ProductRepository;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class GetByProductId extends Command
{
    const INPUT_KEY_PRODUCT_ID = 'productId';

    const COMMAND_PREFIX = 'timoffmax_useless:product:';
    const COMMAND_NAME = self::COMMAND_PREFIX . 'get-by-product-id';

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Get timoffmax_useless product by original product ID')
            ->addArgument(
                self::INPUT_KEY_PRODUCT_ID,
                InputArgument::REQUIRED,
                'Original product ID'
            )
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $productId = $input->getArgument(self::INPUT_KEY_PRODUCT_ID);
        
        /** @var Product $product */
        $product = $this->productRepository->getByProductId($productId);

        $output->writeln("ID: {$product->getId()}");
        $output->writeln("Product ID: {$product->getProductId()}");
        $output->writeln("Price: {$product->getPrice()}");
    }
}
