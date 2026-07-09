<?php

declare(strict_types=1);

namespace OCA\Afterlogic\AppInfo;

use OCP\Server;
use OCP\INavigationManager;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\IGroupManager;
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
        $server = $context->getServerContainer();
        $config = $server->get(IConfig::class);
        $userSession = $server->get(IUserSession::class);
        $groupManager = $server->get(IGroupManager::class);

        $sUrl = trim($config->getAppValue('afterlogic', 'afterlogic-url', ''));
        $oUser = $userSession->getUser();
        $bIsAdmin = $oUser ? $groupManager->isAdmin($oUser->getUID()) : false;

        if ('' !== $sUrl || $bIsAdmin) {
            \OCP\Util::addScript('afterlogic', 'afterlogic');

            Server::get(INavigationManager::class)->add(function () use ($server) {
                return [
                    'id' => self::APP_ID,
                    'name' => 'Afterlogic',
		    'href' => $server->query(\OCP\IURLGenerator::class)->linkToRouteAbsolute('afterlogic.page.index'),
                    'icon' => $server->query(\OCP\IURLGenerator::class)->imagePath('afterlogic', 'mail.svg'),
                    'order' => 10
                ];
            });
        }
    }
}
