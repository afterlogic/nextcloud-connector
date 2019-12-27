<?php

/**
 * nextCloud - AfterLogic WebMail
 * @copyright 2002-2018 AfterLogic Corp.
 */

/**
 * @param string $sPath
 * @param string $sEmail
 * @param string $sPassword
 * @param string $sLogin = ''
 * @return string
 */
function aftSsoKey($sPath, $sEmail, $sPassword, $sLogin = '')
{
	$sFile = rtrim(trim($sPath), '\\/').'/libraries/afterlogic/api.php';
	if (!class_exists('CApi') && file_exists($sFile))
	{
		include_once $sFile;

		if (class_exists('CApi'))
		{
			return CApi::GenerateSsoToken($sEmail, $sPassword, $sLogin);
		}
	}
	else
	{
	    $sFile = rtrim(trim($sPath), '\\/').'/system/autoload.php';
	    $sFileApi = rtrim(trim($sPath), '\\/').'/system/Api.php';
	    if (file_exists($sFileApi) && file_exists($sFile))
	    {
		include_once $sFile;
		\Aurora\System\Api::Init(true);
		return \Aurora\System\Api::GenerateSsoToken($sEmail, $sPassword, $sLogin);
	    }
	}
	
	return '';
}

/**
 * @param string $sPassword
 * @param string $sSalt
 * @return string
 */
function aftEncodePassword($sPassword, $sSalt)
{
	if (function_exists('mcrypt_encrypt') && function_exists('mcrypt_create_iv') && function_exists('mcrypt_get_iv_size') &&
		defined('MCRYPT_RIJNDAEL_256') && defined('MCRYPT_MODE_ECB') && defined('MCRYPT_RAND'))
	{
		return @trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($sSalt), $sPassword,
			MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
	}

	return @trim(base64_encode($sPassword));
}

/**
 * @param string $sPassword
 * @param string $sSalt
 * @return string
 */
function aftDecodePassword($sPassword, $sSalt)
{
	if (function_exists('mcrypt_encrypt') && function_exists('mcrypt_create_iv') && function_exists('mcrypt_get_iv_size') &&
		defined('MCRYPT_RIJNDAEL_256') && defined('MCRYPT_MODE_ECB') && defined('MCRYPT_RAND'))
	{
		return @mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($sSalt), base64_decode(trim($sPassword)),
			MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
	}

	return @base64_decode(trim($sPassword));
}
