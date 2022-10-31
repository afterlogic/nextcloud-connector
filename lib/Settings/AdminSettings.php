<?php
namespace OCA\Afterlogic\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;

class AdminSettings implements ISettings {

	private $config;

	public function __construct(IConfig $config) {
		$this->config = $config;
	}

	public function getForm() {
		$keys = [
			'afterlogic-url',
			'afterlogic-path'
		];

		$parameters = [];
		foreach ($keys as $k) {
			$v = $this->config->getAppValue('afterlogic', $k);
			$parameters[$k] = $v;
		}
		return new TemplateResponse('afterlogic', 'admin', $parameters);
	}

	public function getSection() {
		return 'additional';
	}

	public function getPriority() {
		return 50;
	}

}
