<?php

class AdProviderAdDriver implements iAdProvider {
	
	public $enable_lazyload = true;

	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderAdDriver();
		}
		return self::$instance;
	}

	public function getAd($slotname, $slot, $params = null) {
		$out = '<div id="' . htmlspecialchars($slotname) . '" class="wikia-ad noprint">' .
		$out = $this->getSetupHtml();
		$out .= AdProviderLiftium::getInstance()->getSetupHtml();

		$dartUrl = AdProviderDART::getInstance()->getUrl($slotname, $slot);

		$out .= <<<EOT
<script type="text/javascript">
	AdDriver.callAd("$slotname", "{$slot['size']}",  "$dartUrl");
</script>
EOT;

		$out .= '</div>';

		return $out;
	}

	public function getSetupHtml() {
		static $called = false;
		if ($called) {
			return false;
		}
		$called = true;

		global $wgDevelEnvironment;
		if ($wgDevelEnvironment) {
			$base = '';
		}
		else {
			$base = '';
		}

		global $wgCacheBuster;
		$out =  '<script type="text/javascript" src="'. $base .'/extensions/wikia/AdEngine/AdDriver.js?' . $wgCacheBuster . '"></script>' . "\n";

		return $out;
	}
	
	private $slotsToCall = array();
	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}
	public function batchCallAllowed(){ return false; }
	public function getBatchCallHtml(){ return false; }
	
}
