<?php

/**
 * nextCloud - Afterlogic WebMail integration
 * @copyright 2002-2020 Afterlogic Corp.
 */

OCP\User::checkLoggedIn();
OCP\Util::addScript('afterlogic', 'afterlogic');

$sUrl = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));
$sPath = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-path', ''));

if ('' === $sUrl)
{
	$oTemplate = new OCP\Template('afterlogic', 'empty');
}
else
{
	$sUser = OCP\User::getUser();

	$oTemplate = new OCP\Template('afterlogic', 'personal');

	$sEmail = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-email', '');

	include_once OC_App::getAppPath('afterlogic').'/lib/functions.php';
	
	$sPassword = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-password', '');
	$sPassword = aftDecodePassword($sPassword, md5($sEmail));

	$oTemplate->assign('afterlogic-email', $sEmail);
	$oTemplate->assign('afterlogic-password', 0 === strlen($sPassword) ? '' : '******');
}

return $oTemplate->fetchPage();
