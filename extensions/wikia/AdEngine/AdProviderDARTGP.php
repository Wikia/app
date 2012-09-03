<?php

class AdProviderDARTGP extends AdProviderIframeFiller implements iAdProvider {

	public $enable_lazyload = true;
	protected static $instance = false;

	private $isMainPage;
	private $slotsToCall = array();

	protected function __construct() {
		$this->isMainPage = WikiaPageType::isMainPage();
	}

	public static function getInstance() {
		if (self::$instance === false) {
			self::$instance = new AdProviderDARTGP();
		}
		return self::$instance;
	}

	public function addSlotToCall($slotname) {
		$this->slotsToCall[] = $slotname;
	}

	public function batchCallAllowed() {
		return false;
	}

	public function getSetupHtml() {
		return false;
	}

	public function getBatchCallHtml() {
		return false;
	}

	public function getAd($slotname, $slot, $params = null) {
		$out = '';
		$out .= '<div id="' . htmlspecialchars($slotname) . '" class="wikia-ad noprint default-height">';
		$out .= '<script type="text/javascript">';

		$out .= 'if (!window.gpslots) { window.gpslots = []; }';
		$out .= 'window.gpslots.push(["' . $slotname . '", "' . $slot['size'] . '", "DARTGP", "' . $slot['load_priority'] . '"]);';

		$out .= '</script>';
		$out .= '</div>';

		return $out;
	}

	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
		return '';
	}
}

