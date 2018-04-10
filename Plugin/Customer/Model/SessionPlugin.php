<?php

namespace Nans\AutoLogin\Plugin\Customer\Model\Session;

use Magento\Customer\Model\Session;
use Nans\AutoLogin\Helper\CoreConfig;

class SessionPlugin
{
    /**
     * @var CoreConfig
     */
    private $coreConfig;

    /**
     * SessionPlugin constructor.
     * @param CoreConfig $coreConfig
     */
    public function __construct(
        CoreConfig $coreConfig
    )
    {
        $this->coreConfig = $coreConfig;
    }

    /**
     * @param Session $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsLoggedIn(Session $subject, bool $result): bool
    {
        if (!$result && $this->coreConfig->customerEnabled()) {
            try {
                return $subject->loginById($this->coreConfig->getCustomerId());
            } catch (\Exception $exception) {
                return $result;
            }
        }
        return $result;
    }
}