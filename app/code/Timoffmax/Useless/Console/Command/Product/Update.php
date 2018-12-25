<?php

namespace Timoffmax\Useless\Console\Command\Product;

use Timoffmax\Useless\Model\Product;
use Timoffmax\Useless\Model\ProductRepository;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class Update extends Command
{
    const INPUT_KEY_ID = 'id';
    const INPUT_KEY_PRODUCT_ID = 'productId';
    const INPUT_KEY_PRICE = 'price';

    const COMMAND_PREFIX = 'timoffmax_useless:product:';
    const COMMAND_NAME = self::COMMAND_PREFIX . 'update';

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
            ->setDescription('Update timoffmax_useless product by ID')
            ->addArgument(
                self::INPUT_KEY_ID,
                InputArgument::REQUIRED,
                'ID'
            )
        ;

        $this->setName(self::COMMAND_NAME)
            ->setDescription('Update timoffmax_useless product by ID')
            ->addArgument(
                self::INPUT_KEY_ID,
                InputArgument::REQUIRED,
                'ID'
            )
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument(self::INPUT_KEY_ID);

        /** @var Product $product */
        $product = $this->productRepository->getById($id);

        $output->writeln("ID: {$product->getId()}");
        $output->writeln("Product ID: {$product->getProductId()}");
        $output->writeln("Price: {$product->getPrice()}");
    }
}
