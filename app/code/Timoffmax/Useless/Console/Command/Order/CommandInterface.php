<?php

namespace Timoffmax\Useless\Console\Command\Order;

interface CommandInterface
{
    public const INPUT_KEY_ID = 'id';
    public const INPUT_KEY_ORDER_ID = 'orderId';
    public const INPUT_KEY_ORIGINAL_TOTAL = 'originalTotal';
    public const INPUT_KEY_TOTAL = 'total';

    public const COMMAND_PREFIX = 'timoffmax_useless:order:';
}
