<?php

declare(strict_types=1);

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
    const string COMMAND_NAME = 'autologin:disable';
    const string INPUT_KEY_TYPE = 'type';
    const string VALUE_FRONTEND = 'f';
    const string VALUE_BACKEND = 'b';
    const string VALUE_ALL = 'all';

    /**
     * @var Config
     */
    private Config $config;

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
        $this->setName(self::COMMAND_NAME)->setDescription('Command to disable automatic login.');
        $this->addArgument(self::INPUT_KEY_TYPE, InputArgument::REQUIRED, __('Type a string')->render());
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
            $output->writeln('The automatic login feature has been disabled. Clear the cache for the changes to take effect.');
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }

    /**
     * @param string $type
     * @throws LocalizedException
     */
    protected function disableAutoLoginByType(string $type): void
    {
        if ($type != self::VALUE_FRONTEND && $type != self::VALUE_BACKEND && $type != self::VALUE_ALL) {
            throw new LocalizedException(
                __('To disable a specific functionality, use value %1 for customers and value %2 for admins.',
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

    protected function disableFrontend(): void
    {
        $this->config->saveConfig(CoreConfig::CUSTOMER_ENABLED, '0', 'default', 0);
    }

    protected function disableBackend(): void
    {
        $this->config->saveConfig(CoreConfig::USER_ENABLED, '0', 'default', 0);
    }
}

