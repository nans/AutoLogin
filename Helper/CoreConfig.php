<?php

declare(strict_types=1);

namespace Nans\AutoLogin\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NotFoundException;

class CoreConfig
{
    const string CUSTOMER_ENABLED = 'autologin/customer/enabled';
    const string CUSTOMER_ID = 'autologin/customer/id';
    const string USER_ENABLED = 'autologin/user/enabled';
    const string USER_ID = 'autologin/user/id';

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $_scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function customerEnabled(): bool
    {
        return $this->_scopeConfig->isSetFlag(self::CUSTOMER_ENABLED) == true;
    }

    /**
     * @return bool
     */
    public function userEnabled(): bool
    {
        return $this->_scopeConfig->isSetFlag(self::USER_ENABLED) == true;
    }

    /**
     * @return int
     * @throws NotFoundException
     */
    public function getCustomerId(): int
    {
        $customer = $this->_scopeConfig->getValue(self::CUSTOMER_ID);
        if (!$customer) {
            throw new NotFoundException(__('Customer account is not selected.'));
        }
        return (int)$customer;
    }

    /**
     * @return int
     * @throws NotFoundException
     */
    public function getUserId(): int
    {
        $admin = $this->_scopeConfig->getValue(self::USER_ID);
        if (!$admin) {
            throw new NotFoundException(__('Admin account is not selected.'));
        }
        return (int)$admin;
    }
}
