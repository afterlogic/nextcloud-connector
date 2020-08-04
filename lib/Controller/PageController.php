<?php

/**
 * nextCloud - Afterlogic WebMail integration
 * @copyright 2002-2020 Afterlogic Corp.
 */

namespace OCA\Afterlogic\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Controller;

class PageController extends Controller {
    public function __construct($appName, IRequest $request) {
	parent::__construct($appName, $request);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function index() {
	\OC::$server->getNavigationManager()->setActiveEntry('afterlogic_index');

	$sUrl = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));
	$sPath = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-path', ''));

	if ('' === $sUrl)
	{
		$oTemplate = new TemplateResponse('afterlogic', 'not-configured');
	}
	else
	{
		$sUser = \OCP\User::getUser();

		$sEmail = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-email', '');
		$sPassword = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-password', '');

		include_once \OC_App::getAppPath('afterlogic').'/lib/functions.php';

		$sPassword = aftDecodePassword($sPassword, md5($sEmail));
		$sSsoHash = aftSsoKey($sPath, $sEmail, $sPassword, $sEmail);

		$sUrl = rtrim($sUrl, '/\\');
		if ('.php' !== strtolower(substr($sUrl, -4)))
		{
			$sUrl .= '/';
		}

		if ('' === $sPath) {
		    $sResultUrl = $sUrl.'?postlogin&Email='.urlencode($sEmail).'&Password='.urlencode($sPassword);
		} else {
		    $sResultUrl = empty($sSsoHash) ? $sUrl.'?sso' : $sUrl.'?sso&hash='.$sSsoHash;
		}
		$params=['afterlogic-url' => $sResultUrl];
		$oTemplate = new TemplateResponse('afterlogic', 'iframe', $params);
		$csp = new ContentSecurityPolicy();
                $csp->addAllowedFrameDomain("'self'");
                $oTemplate->setContentSecurityPolicy($csp);
	}
	return $oTemplate;
    }
 }
