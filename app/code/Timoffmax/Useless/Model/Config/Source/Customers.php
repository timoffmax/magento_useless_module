<?php

namespace Timoffmax\Useless\Model\Config\Source;

use Magento\Customer\Model\Data\Customer;
use Magento\Framework\Option\ArrayInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class Customers implements ArrayInterface
{
    protected $customerRepository;
    protected $searchCriteria;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaInterface $searchCriteria
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteria = $searchCriteria;
    }

    protected function getCustomerNamesList()
    {
        $customers = $this->customerRepository->getList($this->searchCriteria);
        $customerNames = [];

        /** @var Customer $customer */
        foreach ($customers->getItems() as $customer) {
            $customerNames[] = $customer->getFirstname();
        }

        return $customerNames;
    }

    /**
     * Return array of customer names
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $customers = $this->customerRepository->getList($this->searchCriteria);
        $customersList = [];

        /** @var Customer $customer */
        foreach ($customers->getItems() as $customer) {
            $fullName = "{$customer->getFirstname()} {$customer->getLastname()}";
            $customersList[] = [
                'label' => $fullName,
                'value' => $fullName,
            ];
        }

        return $customersList;
    }
}
