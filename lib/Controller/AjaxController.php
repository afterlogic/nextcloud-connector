<?php

/**
 * nextCloud - Afterlogic WebMail integration
 * @copyright 2002-2023 Afterlogic Corp.
 */

namespace OCA\Afterlogic\Controller;

use OCP\IRequest;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\App\IAppManager;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;

class AjaxController extends Controller
{
    private $config;
    private $userSession;
    private $appManager;

    public function __construct($appName, IRequest $request, IConfig $config, IUserSession $userSession, IAppManager $appManager)
    {
        parent::__construct($appName, $request);
        $this->config = $config;
        $this->userSession = $userSession;
        $this->appManager = $appManager;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function setPersonal()
    {
        if (isset($_POST['appname'], $_POST['afterlogic-password'], $_POST['afterlogic-email']) && 'afterlogic' === $_POST['appname']) {
            $oUser = $this->userSession->getUser();
            $sUser = $oUser ? $oUser->getUID() : '';

            $sEmail = $_POST['afterlogic-email'];
            $this->config->setUserValue($sUser, 'afterlogic', 'afterlogic-email', $sEmail);

            $sPass = $_POST['afterlogic-password'];
            if ('******' !== $sPass) {
		$path = $this->appManager->getAppPath('afterlogic');
                include_once $path.'/lib/functions.php';

                $this->config->setUserValue(
                    $sUser,
                    'afterlogic',
                    'afterlogic-password',
                    aftEncodePassword($sPass, md5($sEmail))
                );
            }

            return new JSONResponse([
                'status' => 'success',
                'Message' => 'Saved successfully'
            ]);
        }

        return new JSONResponse([
        'status' => 'error',
        'Message' => 'Invalid arguments'
        ]);
    }

    /**
     * @NoCSRFRequired
     */
    public function setAdmin()
    {
        if (isset($_POST['appname'], $_POST['afterlogic-url'], $_POST['afterlogic-path']) && 'afterlogic' === $_POST['appname']) {
            $this->config->setAppValue('afterlogic', 'afterlogic-url', $_POST['afterlogic-url']);
            $this->config->setAppValue('afterlogic', 'afterlogic-path', $_POST['afterlogic-path']);

            return new JSONResponse([
                'status' => 'success',
                'Message' => 'Saved successfully'
            ]);
        }

        return new JSONResponse([
        'status' => 'error',
        'Message' => 'Invalid arguments'
        ]);
    }
}
