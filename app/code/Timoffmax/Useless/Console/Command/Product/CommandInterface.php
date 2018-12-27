<?php

namespace Timoffmax\Useless\Console\Command\Product;

interface CommandInterface
{
    public const INPUT_KEY_ID = 'id';
    public const INPUT_KEY_PRODUCT_ID = 'productId';
    public const INPUT_KEY_PRICE = 'price';
    public const INPUT_KEY_ORIGINAL_PRICE = 'originalPrice';

    public const COMMAND_PREFIX = 'timoffmax_useless:product:';
}
