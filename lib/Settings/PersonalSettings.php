<?php

namespace OCA\Afterlogic\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class PersonalSettings implements ISettings
{
    public function __construct()
    {
    }


public function getForm(): TemplateResponse
{
    \OC_Util::checkLoggedIn();
    \OCP\Util::addScript('afterlogic', 'afterlogic');

    $sUrl = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));
    $sPath = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-path', ''));

    if ('' === $sUrl) {
        return new TemplateResponse('afterlogic', 'empty', []);
    } else {
        $sUser = \OC_User::getUser();
        $sEmail = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-email', '');
        include_once \OC_App::getAppPath('afterlogic').'/lib/functions.php';
        $sPassword = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-password', '');
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
