<?php

namespace Nans\AutoLogin\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NotFoundException;

class CoreConfig
{
    const CUSTOMER_ENABLED = 'autologin/customer/enabled';
    const CUSTOMER_ID = 'autologin/customer/id';
    const USER_ENABLED = 'autologin/user/enabled';
    const USER_ID = 'autologin/user/id';

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

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
        return ($this->_scopeConfig->getValue(self::CUSTOMER_ENABLED)) ? true : false;
    }

    /**
     * @return bool
     */
    public function userEnabled(): bool
    {
        return ($this->_scopeConfig->getValue(self::USER_ENABLED)) ? true : false;
    }

    /**
     * @return int
     * @throws NotFoundException
     */
    public function getCustomerId(): int
    {
        $customer = $this->_scopeConfig->getValue(self::CUSTOMER_ID);
        if (!$customer) {
            throw new NotFoundException(__('Customer not selected'));
        }
        return $customer;
    }

    /**
     * @return int
     * @throws NotFoundException
     */
    public function getUserId(): int
    {
        $admin = $this->_scopeConfig->getValue(self::USER_ID);
        if (!$admin) {
            throw new NotFoundException(__('User not selected'));
        }
        return $admin;
    }
}