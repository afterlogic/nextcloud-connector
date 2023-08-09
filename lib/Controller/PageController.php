<?php

/**
 * nextCloud - Afterlogic WebMail integration
 * @copyright 2002-2023 Afterlogic Corp.
 */

namespace OCA\Afterlogic\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Controller;

class PageController extends Controller
{
    public function __construct($appName, IRequest $request)
    {
        parent::__construct($appName, $request);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function index()
    {
        \OC::$server->getNavigationManager()->setActiveEntry('afterlogic_index');

        $sUrl = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-url', ''));
        $sPath = trim(\OC::$server->getConfig()->getAppValue('afterlogic', 'afterlogic-path', ''));

        if ('' === $sUrl) {
            $oTemplate = new TemplateResponse('afterlogic', 'not-configured');
        } else {
            $sUser = \OC_User::getUser();

            $sEmail = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-email', '');
            $sPassword = \OC::$server->getConfig()->getUserValue($sUser, 'afterlogic', 'afterlogic-password', '');

            include_once \OC_App::getAppPath('afterlogic').'/lib/functions.php';

            $sPassword = aftDecodePassword($sPassword, md5($sEmail));

            $sUrl = rtrim($sUrl, '/\\');
            if ('.php' !== strtolower(substr($sUrl, -4))) {
                $sUrl .= '/';
            }
            if ('' === $sPath) {
                $sResultUrl = $sUrl.'?postlogin&Email='.urlencode($sEmail).'&Password='.urlencode($sPassword);
            } else {
                $sResultUrl = $sUrl.'?error=102';
                $query = $sUrl."?/Api";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, [
                    'Module' => 'Core',
                    'Method' => 'GetAppData'
                ]);
                curl_setopt($curl, CURLOPT_URL, $query);
                $result = curl_exec($curl);
                curl_close($curl);
                if ($result !== false) {
                    $json_res = json_decode($result, true);
                    $sCookiePath=(isset($json_res["Result"]["Core"]["CookiePath"]) ? $json_res["Result"]["Core"]["CookiePath"] : "/");
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($curl, CURLOPT_HEADER, 0);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, [
                    'Module' => 'Core',
                    'Method' => 'Login',
                    'Parameters' => '{"Login":"'.$sEmail.'","Password":"'.$sPassword.'"}'
                    ]);
                    curl_setopt($curl, CURLOPT_URL, $query);
                    $result = curl_exec($curl);
                    curl_close($curl);
                    if ($result !== false) {
                        $json_res = json_decode($result, true);
                        if (isset($json_res["Result"]["AuthToken"])) {
                            setcookie('AuthToken', $json_res["Result"]["AuthToken"], time()+3600, $sCookiePath);
                            $sResultUrl = $sUrl;
                        }
                    }
                }
            }
            $params=['afterlogic-url' => $sResultUrl];
            $oTemplate = new TemplateResponse('afterlogic', 'iframe', $params);
            $csp = new ContentSecurityPolicy();
            $sUrlParts = parse_url($sUrl);
            $csp->addAllowedFrameDomain($sUrlParts["host"]);
            $oTemplate->setContentSecurityPolicy($csp);
        }
        return $oTemplate;
    }
}
