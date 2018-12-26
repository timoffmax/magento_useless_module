<?php

namespace Timoffmax\Useless\Console\Command\Product;

use Symfony\Component\Console\Input\InputOption;
use Timoffmax\Useless\Model\ProductRepository;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DeleteCommand extends Command implements CommandInterface
{
    public const COMMAND_NAME = self::COMMAND_PREFIX . 'delete';

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
        $options = [
            new InputOption(
                self::INPUT_KEY_ID,
                null,
                InputOption::VALUE_OPTIONAL,
                'ID'
            ),
            new InputOption(
                self::INPUT_KEY_PRODUCT_ID,
                null,
                InputOption::VALUE_OPTIONAL,
                'Original product ID'
            ),
        ];

        $this->setName(self::COMMAND_NAME)
            ->setDefinition($options)
            ->setDescription('Delete timoffmax_useless product by ID or product ID')
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getOption(self::INPUT_KEY_ID);
        $productId = $input->getOption(self::INPUT_KEY_PRODUCT_ID);

        if (!empty($id) || !empty($productId)) {
            if (!empty($id)) {
                $this->productRepository->deleteById($id);
            } else {
                $this->productRepository->deleteByProductId($productId);
            }
        } else {
            $output->writeln("Please, specify 'id' or 'productId' option.");

            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }
}
