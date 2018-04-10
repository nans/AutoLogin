<?php

namespace Nans\AutoLogin\Plugin\User\Model;

use Magento\User\Model\User;
use Nans\AutoLogin\Helper\CoreConfig;

class UserPlugin
{
    /**
     * @var CoreConfig
     */
    private $coreConfig;

    /**
     * UserPlugin constructor.
     * @param CoreConfig $coreConfig
     */
    public function __construct(
        CoreConfig $coreConfig
    )
    {
        $this->coreConfig = $coreConfig;
    }

    /**
     * @param User $subject
     * @param bool $result
     * @return bool
     */
    public function afterVerifyIdentity(User $subject, bool $result): bool
    {
        if (!$result) {
            try {
                return $this->coreConfig->userEnabled() && $subject->getId() == $this->coreConfig->getUserId();
            } catch (\Exception $exception) {
                return $result;
            }
        }

        return $result;
    }
}