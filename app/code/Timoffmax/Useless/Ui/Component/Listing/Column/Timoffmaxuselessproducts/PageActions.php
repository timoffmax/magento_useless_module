<?php

namespace Timoffmax\Useless\Ui\Component\Listing\Column\Timoffmaxuselessproducts;

class PageActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $id = "X";

                if (isset($item["product_id"])) {
                    $id = $item["product_id"];
                }

                $item[$name]["view"] = [
                    "href" => $this->getContext()->getUrl(
                        "timoffmax_useless_products/product/edit", ["product_id" => $id]),
                    "label"=>__("Edit")
                ];
            }
        }

        return $dataSource;
    }
}
