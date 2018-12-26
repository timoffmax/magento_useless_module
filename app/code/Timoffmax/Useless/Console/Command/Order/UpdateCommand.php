<?php

namespace Timoffmax\Useless\Console\Command\Order;

use Symfony\Component\Console\Input\InputOption;
use Timoffmax\Useless\Model\Order;
use Timoffmax\Useless\Model\OrderRepository;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class UpdateCommand extends Command implements CommandInterface
{
    const COMMAND_NAME = self::COMMAND_PREFIX . 'update';

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
                InputOption::VALUE_REQUIRED,
                'ID'
            ),
            new InputOption(
                self::INPUT_KEY_ORDER_ID,
                null,
                InputOption::VALUE_OPTIONAL,
                'Original order ID'
            ),
            new InputOption(
                self::INPUT_KEY_TOTAL,
                null,
                InputOption::VALUE_OPTIONAL,
                'New order total'
            ),
        ];

        $this->setName(self::COMMAND_NAME)
            ->setDefinition($options)
            ->setDescription('Update timoffmax_useless order by ID')
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getOption(self::INPUT_KEY_ID);
        $orderId = $input->getOption(self::INPUT_KEY_ORDER_ID);
        $total = $input->getOption(self::INPUT_KEY_TOTAL);

        if (!empty($id) || !empty($orderId)) {
            /** @var Order $order */
            if (!empty($id)) {
                $order = $this->orderRepository->getById($id);
            } else {
                $order = $this->orderRepository->getByOrderId($orderId);
            }
        } else {
            $output->writeln("Please, specify 'id' or 'orderId' option.");

            return Cli::RETURN_FAILURE;
        }

        if (!empty($orderId)) {
            $order->setOrderId($orderId);
        }

        if (isset($total)) {
            $order->setTotal($total);
        }

        $this->orderRepository->save($order);

        $output->writeln("--- Result ---");
        $output->writeln("ID: {$order->getId()}");
        $output->writeln("Order ID: {$order->getOrderId()}");
        $output->writeln("Price: {$order->getTotal()}");

        return Cli::RETURN_SUCCESS;
    }
}
