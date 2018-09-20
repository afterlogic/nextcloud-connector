<?php

/**
 * nextCloud - AfterLogic WebMail
 * @copyright 2002-2018 AfterLogic Corp.
 */

OCP\User::checkAdminUser();

OCP\Util::addScript('afterlogic', 'afterlogic');

$oTemplate = new OCP\Template('afterlogic', 'admin');
$oTemplate->assign('afterlogic-url', \OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));
$oTemplate->assign('afterlogic-path', \OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-path', ''));
return $oTemplate->fetchPage();
