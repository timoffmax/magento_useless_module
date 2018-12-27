<?php

namespace Timoffmax\Useless\Console\Command\Order;

use Timoffmax\Useless\Model\Order;
use Timoffmax\Useless\Model\OrderFactory;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class AddCommand extends Command implements CommandInterface
{
    public const COMMAND_NAME = self::COMMAND_PREFIX . 'add';

    /** @var OrderFactory */
    private $orderFactory;

    public function __construct(OrderFactory $orderFactory)
    {
        $this->orderFactory = $orderFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Create new timoffmax_useless order item')
            ->addArgument(
                self::INPUT_KEY_ORDER_ID,
                InputArgument::REQUIRED,
                'Original order ID'
            )
            ->addArgument(
                self::INPUT_KEY_ORIGINAL_TOTAL,
                InputArgument::REQUIRED,
                'Original order total'
            )
            ->addArgument(
                self::INPUT_KEY_TOTAL,
                InputArgument::REQUIRED,
                'Comverted order total'
            )
        ;

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Order $order */
        $order = $this->orderFactory->create();
        $order->setOrderId($input->getArgument(self::INPUT_KEY_ORDER_ID));
        $order->setOriginalTotal($input->getArgument(self::INPUT_KEY_ORIGINAL_TOTAL));
        $order->setTotal($input->getArgument(self::INPUT_KEY_TOTAL));
        $order->setIsObjectNew(true);
        $order->save();

        return Cli::RETURN_SUCCESS;
    }
}
