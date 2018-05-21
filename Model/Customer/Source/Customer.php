<?php

namespace Nans\AutoLogin\Model\Customer\Source;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\ResourceModel\Customer\Collection;
use Magento\Framework\Data\OptionSourceInterface;

class Customer implements OptionSourceInterface
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection
    ) {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $customers = [];

        /** @var CustomerInterface $customer */
        foreach ($this->collection->getItems() as $customer) {
            $customers[] = [
                'label' => $customer->getEmail(),
                'value' => $customer->getId(),
            ];
        }

        return $customers;
    }
}
