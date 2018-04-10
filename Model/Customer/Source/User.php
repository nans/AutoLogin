<?php

namespace Nans\AutoLogin\Model\Customer\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\User\Api\Data\UserInterface;
use Magento\User\Model\ResourceModel\User\Collection;

class User implements OptionSourceInterface
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
    public function toOptionArray(): array
    {
        $users = [];

        /** @var UserInterface $user */
        foreach ($this->collection->getItems() as $user) {
            $users[] = [
                'label' => $user->getEmail(),
                'value' => $user->getId(),
            ];
        }

        return $users;
    }
}
