<?php

namespace Timoffmax\Useless\Ui\Component\Listing\Column\Timoffmaxuselessorders;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class OrderLink extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $urlBuilder;

    public function __construct(UrlInterface $urlBuilder, ContextInterface $context, UiComponentFactory $uiComponentFactory, array $components = [], array $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as &$item) {
                $name = $this->getData("name");

                $orderId = $item["order_id"] ?? "X";

                $url = $this->urlBuilder->getUrl('sales/order/view', ['order_id' => $orderId]);
                $html = html_entity_decode("<a href=\"$url\">{$orderId}</a>");

                $item[$name] = $html;
            }
        }

        return $dataSource;
    }    
}
