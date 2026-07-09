<?php

namespace OCA\Afterlogic\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\App\IAppManager;
use OCP\Settings\ISettings;

class PersonalSettings implements ISettings
{
    private $config;
    private $userSession;
    private $appManager;

    public function __construct(IConfig $config, IUserSession $userSession, IAppManager $appManager)
    {
        $this->config = $config;
        $this->userSession = $userSession;
        $this->appManager = $appManager;
    }


public function getForm(): TemplateResponse
{
    $oUser = $this->userSession->getUser();
    if (!$oUser) {
        return new TemplateResponse('afterlogic', 'empty', []);
    }
    \OCP\Util::addScript('afterlogic', 'afterlogic');

    $sUrl = trim($this->config->getAppValue('afterlogic', 'afterlogic-url', ''));
    $sPath = trim($this->config->getAppValue('afterlogic', 'afterlogic-path', ''));

    if ('' === $sUrl) {
        return new TemplateResponse('afterlogic', 'empty', []);
    } else {
        $sUser = $oUser->getUID();
        $sEmail = $this->config->getUserValue($sUser, 'afterlogic', 'afterlogic-email', '');
	$path = $this->appManager->getAppPath('afterlogic');
        include_once $path.'/lib/functions.php';
        $sPassword = $this->config->getUserValue($sUser, 'afterlogic', 'afterlogic-password', '');
        $sPassword = aftDecodePassword($sPassword, md5($sEmail));

        $parameters['afterlogic-email'] = $sEmail;
        $parameters['afterlogic-password'] = (0 === strlen($sPassword) ? '' : '******');
        return new TemplateResponse('afterlogic', 'personal', $parameters);
    }
}

    public function getSection()
    {
        return 'additional';
    }

    public function getPriority()
    {
        return 10;
    }
}
