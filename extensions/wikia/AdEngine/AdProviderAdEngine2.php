<?php

class AdProviderAdEngine2 extends AdProviderIframeFiller implements iAdProvider {

	public $enable_lazyload = true;
	public $name = 'AdEngine2';

	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance === false) {
			self::$instance = new AdProviderAdEngine2();
		}
		return self::$instance;
	}

	private $slotsToCall = array();
	public function addSlotToCall($slotname) {
		$this->slotsToCall[]=$slotname;
	}

	public function batchCallAllowed(){ return false; }
	public function getSetupHtml() { return false; }
	public function getBatchCallHtml(){ return false; }

	public function getAd($slotname, $slot, $params = null) {
		$out = '<div id="' . htmlspecialchars($slotname) . '" class="wikia-ad noprint default-height">';
		//$out .= '<script>window.AdQueue.push(' . json_encode(array('name' => $slotname)) . ');</script>';
		$out .= '<script>window.adslots2.push(' . json_encode(array($slotname, null, $this->name)) . ');</script>';
		$out .= '</div>';
		return $out;
	}

	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) { return ''; }
}