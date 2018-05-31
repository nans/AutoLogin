<?php

namespace Nans\AutoLogin\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Magento\Config\Model\ResourceModel\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Nans\AutoLogin\Helper\CoreConfig;

class DisableCommand extends Command
{
    const COMMAND_NAME = 'autologin:disable';
    const INPUT_KEY_TYPE = 'type';
    const VALUE_FRONTEND = 'f';
    const VALUE_BACKEND = 'b';
    const VALUE_ALL = 'all';

    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    )
    {
        parent::__construct(self::COMMAND_NAME);
        $this->config = $config;
    }

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)->setDescription('Disable autologin for backend or frontend');
        $this->addArgument(self::INPUT_KEY_TYPE, InputArgument::REQUIRED, __('Type a string'));
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->disableAutoLoginByType($input->getArgument(self::INPUT_KEY_TYPE));
            $output->writeln('Autologin was disabled. Clean the cache to make changes.');
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }

    /**
     * @param string $type
     * @throws LocalizedException
     */
    protected function disableAutoLoginByType($type)
    {
        if ($type != self::VALUE_FRONTEND && $type != self::VALUE_BACKEND && $type != self::VALUE_ALL) {
            throw new LocalizedException(
                __('Use %1 for frontend or %2 for backend',
                    self::VALUE_FRONTEND,
                    self::VALUE_BACKEND)
            );
        }

        switch ($type) {
            case self::VALUE_FRONTEND:
                $this->disableFrontend();
                break;
            case self::VALUE_BACKEND:
                $this->disableBackend();
                break;
            case self::VALUE_ALL:
                $this->disableFrontend();
                $this->disableBackend();
                break;
        }
    }

    protected function disableFrontend()
    {
        $this->config->saveConfig(CoreConfig::CUSTOMER_ENABLED, 0, 'default', 0);
    }

    protected function disableBackend()
    {
        $this->config->saveConfig(CoreConfig::USER_ENABLED, 0, 'default', 0);
    }
}

