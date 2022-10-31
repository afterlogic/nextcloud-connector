<?php

$sUrl = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));
$sPath = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-path', ''));

if ('' !== $sUrl || \OC_User::isAdminUser(\OC_User::getUser()))
{
    \OCP\Util::addScript('afterlogic', 'afterlogic');

    \OC::$server->getNavigationManager()->add(function () {
	$urlGenerator = \OC::$server->getURLGenerator();
        return [
	    'id' => 'afterlogic_index',
	    'order' => 10,
    	    'href' => $urlGenerator->linkToRoute('afterlogic.page.index'),
    	    'icon' => $urlGenerator->imagePath('afterlogic', 'mail.svg'),
    	    'name' => 'Afterlogic',
	];
    });
}