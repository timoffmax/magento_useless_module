<?php

namespace Timoffmax\Useless\Console\Command\Order;

use Symfony\Component\Console\Input\InputOption;
use Timoffmax\Useless\Model\OrderRepository;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DeleteCommand extends Command implements CommandInterface
{
    public const COMMAND_NAME = CommandInterface::COMMAND_PREFIX . 'delete';

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;

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
                self::INPUT_KEY_ORDER_ID,
                null,
                InputOption::VALUE_OPTIONAL,
                'Original order ID'
            ),
        ];

        $this->setName(self::COMMAND_NAME)
            ->setDefinition($options)
            ->setDescription('Delete timoffmax_useless order by ID or original order ID')
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getOption(self::INPUT_KEY_ID);
        $orderId = $input->getOption(self::INPUT_KEY_ORDER_ID);

        if (!empty($id) || !empty($orderId)) {
            if (!empty($id)) {
                $this->orderRepository->deleteById($id);
            } else {
                $this->orderRepository->deleteByOrderId($orderId);
            }
        } else {
            $output->writeln("Please, specify 'id' or 'orderId' option.");

            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }
}
