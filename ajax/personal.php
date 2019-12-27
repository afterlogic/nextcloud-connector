<?php

/**
 * nextCloud - AfterLogic WebMail
 * @copyright 2002-2018 AfterLogic Corp.
 */

\OC_JSON::checkLoggedIn();
\OC_JSON::callCheck();

if (isset($_POST['appname'], $_POST['afterlogic-password'], $_POST['afterlogic-email'], $_POST['afterlogic-login']) && 'afterlogic' === $_POST['appname'])
{
	$sUser = OCP\User::getUser();

	$sEmail = $_POST['afterlogic-email'];
	$sLogin = $_POST['afterlogic-login'];

	\OC::$server->getConfig()->setUserValue($sUser, 'afterlogic', 'afterlogic-email', $sEmail);
	\OC::$server->getConfig()->setUserValue($sUser, 'afterlogic', 'afterlogic-login', $sLogin);

	$sPass = $_POST['afterlogic-password'];
	if ('******' !== $sPass)
	{
		include_once OC_App::getAppPath('afterlogic').'/functions.php';
		
		\OC::$server->getConfig()->setUserValue($sUser, 'afterlogic', 'afterlogic-password',
			aftEncodePassword($sPass, md5($sEmail)));
	}

	\OC_JSON::success(array('Message' => 'Saved successfully'));
	return true;
}

\OC_JSON::error(array('Message' => 'Invalid argument(s)'));
return false;
