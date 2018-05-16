<?php

namespace Nans\AutoLogin\Plugin\Backend\Model;

use Closure;
use Magento\Backend\Model\Auth;
use Magento\User\Api\Data\UserInterface;
use Magento\User\Model\ResourceModel\User\Collection;
use Nans\AutoLogin\Helper\CoreConfig;

class AuthPlugin
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var CoreConfig
     */
    private $coreConfig;

    /**
     * @param CoreConfig $coreConfig
     * @param Collection $collection
     */
    public function __construct(
        CoreConfig $coreConfig,
        Collection $collection
    )
    {
        $this->collection = $collection;
        $this->coreConfig = $coreConfig;
    }

    /**
     * @param Auth $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsLoggedIn(Auth $subject, bool $result): bool
    {
        if (!$result && $this->coreConfig->userEnabled()) {
            try {
                /** @var UserInterface $user */
                $user = $this->collection->getItemById($this->coreConfig->getUserId());
                $subject->login($user->getUserName(), $user->getPassword());
                return true;
            } catch (\Exception $exception) {
                return $result;
            }
        }

        return $result;
    }

    /**
     * @param Auth $subject
     * @param Closure $proceed
     * @return bool|mixed
     */
    public function aroundLogout(Auth $subject, Closure $proceed)
    {
        if ($this->coreConfig->userEnabled()) {
            return false;
        }
        return $proceed();
    }
}