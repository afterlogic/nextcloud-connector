<?php

declare(strict_types=1);

namespace OCA\Afterlogic\AppInfo;

use OCP\Server;
use OCP\INavigationManager;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap
{
    public const APP_ID = 'afterlogic';

    public function __construct(array $urlParams = [])
    {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void
    {
        return;
    }

    public function boot(IBootContext $context): void
    {
        $sUrl = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));

        if ('' !== $sUrl || \OC_User::isAdminUser(\OC_User::getUser())) {
            \OCP\Util::addScript('afterlogic', 'afterlogic');

            $server = $context->getServerContainer();

            Server::get(INavigationManager::class)->add(function () use ($server) {
                return [
                    'id' => self::APP_ID,
                    'name' => 'Afterlogic',
                    'href' => $server->getURLGenerator()->linkToRouteAbsolute('afterlogic.page.index'),
                    'icon' => $server->getURLGenerator()->imagePath('afterlogic', 'mail.svg'),
                    'order' => 10
                ];
            });
        }
    }
}
