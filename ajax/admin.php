<?php

/**
 * nextCloud - AfterLogic WebMail
 * @copyright 2002-2018 AfterLogic Corp.
 */

\OC_JSON::checkAdminUser();
\OC_JSON::checkAppEnabled('afterlogic');
\OC_JSON::callCheck();

if (isset($_POST['appname'], $_POST['afterlogic-url'], $_POST['afterlogic-path']) && 'afterlogic' === $_POST['appname'])
{
	\OC::$server->getConfig()->setAppValue('afterlogic', 'afterlogic-url', $_POST['afterlogic-url']);
	\OC::$server->getConfig()->setAppValue('afterlogic', 'afterlogic-path', $_POST['afterlogic-path']);

	\OC_JSON::success(array('Message' => 'Saved successfully'));
	return true;
}

\OC_JSON::error(array('Message' => 'Invalid Argument(s)'));
return false;
