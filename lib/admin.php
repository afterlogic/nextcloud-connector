<?php

/**
 * nextCloud - Afterlogic WebMail integration
 * @copyright 2002-2020 Afterlogic Corp.
 */

OCP\User::checkAdminUser();

OCP\Util::addScript('afterlogic', 'afterlogic');

$oTemplate = new OCP\Template('afterlogic', 'admin');
$oTemplate->assign('afterlogic-url', \OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));
$oTemplate->assign('afterlogic-path', \OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-path', ''));
return $oTemplate->fetchPage();
