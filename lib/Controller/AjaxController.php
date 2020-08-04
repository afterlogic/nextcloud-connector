<?php

/**
 * nextCloud - Afterlogic WebMail integration
 * @copyright 2002-2020 Afterlogic Corp.
 */

namespace OCA\Afterlogic\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;

class AjaxController extends Controller {
    public function __construct($appName, IRequest $request) {
	parent::__construct($appName, $request);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function setPersonal() {
	if (isset($_POST['appname'], $_POST['afterlogic-password'], $_POST['afterlogic-email']) && 'afterlogic' === $_POST['appname'])
	{

		$sUser = \OCP\User::getUser();

		$sEmail = $_POST['afterlogic-email'];
		\OC::$server->getConfig()->setUserValue($sUser, 'afterlogic', 'afterlogic-email', $sEmail);

		$sPass = $_POST['afterlogic-password'];
		if ('******' !== $sPass)
		{
			include_once \OC_App::getAppPath('afterlogic').'/lib/functions.php';

			\OC::$server->getConfig()->setUserValue($sUser, 'afterlogic', 'afterlogic-password',
				aftEncodePassword($sPass, md5($sEmail)));
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
    public function setAdmin() {
	if (isset($_POST['appname'], $_POST['afterlogic-url'], $_POST['afterlogic-path']) && 'afterlogic' === $_POST['appname'])
	{
		\OC::$server->getConfig()->setAppValue('afterlogic', 'afterlogic-url', $_POST['afterlogic-url']);
		\OC::$server->getConfig()->setAppValue('afterlogic', 'afterlogic-path', $_POST['afterlogic-path']);

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
