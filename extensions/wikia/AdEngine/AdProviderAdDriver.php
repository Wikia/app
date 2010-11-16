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
		$out = '<div id="' . htmlspecialchars($slotname) . '" class="wikia-ad noprint">';
		$dartUrl = AdProviderDART::getInstance()->getUrl($slotname, $slot);
		$out .= <<<EOT
<script type="text/javascript">
	wgAfterContentAndJS.push(function() {
		if (typeof(AdDriverDelayedLoader) != 'undefined') {
			AdDriverDelayedLoader.appendCall(new AdDriverCall("$slotname", "{$slot['size']}",  "$dartUrl"));
		}
	});
</script>
EOT;
		$out .= '</div>';
		//$out = $this->getSetupHtml();
		$out .= AdProviderLiftium::getInstance()->getSetupHtml();

		return $out;
	}

	public function getSetupHtml() {
		static $called = false;
		if ($called) {
			return false;
		}
		$called = true;

		$out = <<<EOT
<script type="text/javascript">
	var dartTile = 1;
	var dartOrd = Math.random()*10000000000000000;
</script>
EOT;

		return $out;
	}
	
	private $slotsToCall = array();
	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}
	public function batchCallAllowed(){ return false; }
	public function getBatchCallHtml(){ return false; }
	
}
