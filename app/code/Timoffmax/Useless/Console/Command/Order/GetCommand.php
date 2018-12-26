<?php

namespace Timoffmax\Useless\Console\Command\Order;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Input\InputOption;
use Timoffmax\Useless\Model\Order;
use Timoffmax\Useless\Model\OrderRepository;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class GetCommand extends Command implements CommandInterface
{
    public const COMMAND_NAME = self::COMMAND_PREFIX . 'get';

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
            ->setDescription('Get timoffmax_useless order whether by ID or original order ID')
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getOption(self::INPUT_KEY_ID);
        $orderId = $input->getOption(self::INPUT_KEY_ORDER_ID);

        /** @var Order $order */
        if (!empty($id) || !empty($orderId)) {
            if (!empty($id)) {
                $order = $this->orderRepository->getById($id);
            } else {
                $order = $this->orderRepository->getByOrderId($orderId);
            }
        } else {
            $output->writeln("Please, specify 'id' or 'orderId' option.");

            return Cli::RETURN_FAILURE;
        }

        $output->writeln("--- Result ---");
        $output->writeln("ID: {$order->getId()}");
        $output->writeln("Order ID: {$order->getOrderId()}");
        $output->writeln("Total: {$order->getTotal()}");

        return Cli::RETURN_SUCCESS;
    }
}
