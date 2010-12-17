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
		$out = '';
		$extraClasses = '';
		switch ($slotname) {
			case 'CORP_TOP_LEADERBOARD':
			case 'HOME_TOP_LEADERBOARD':
			case 'TOP_LEADERBOARD':
			case 'CORP_TOP_RIGHT_BOXAD':
			case 'HOME_TOP_RIGHT_BOXAD':
			case 'TOP_RIGHT_BOXAD':
			case 'PREFOOTER_LEFT_BOXAD':
			case 'PREFOOTER_RIGHT_BOXAD':
				$extraClasses .= ' default-height';
				break;
		}
		if (strpos($slotname, 'EXIT_STITIAL') === FALSE) {
			$out .= '<div id="' . htmlspecialchars($slotname) . '" class="wikia-ad noprint'.$extraClasses.'">';
		}

		$dartUrl = AdProviderDART::getInstance()->getUrl($slotname, $slot);
		$out .= <<<EOT
<script type="text/javascript">
EOT;
		if (strpos($slotname, 'EXIT_STITIAL') !== FALSE) {
			$out .= <<<EOT
	if (typeof(AdDriverDelayedLoader) != 'undefined') {
		if (AdDriverDelayedLoader.started && !AdDriverDelayedLoader.isRunning()) {
			AdDriverDelayedLoader.reset();
			var loadExitstitial = true;
		}
		AdDriverDelayedLoader.appendCall(new AdDriverCall("$slotname", "{$slot['size']}",  "$dartUrl"));
		if (typeof loadExitstitial != 'undefined' && loadExitstitial) {
			AdDriverDelayedLoader.load();
		}
	}
EOT;
		
		}
		else {
			$out .= <<<EOT
	wgAfterContentAndJS.push(function() {
		if (typeof(AdDriverDelayedLoader) != 'undefined') {
			AdDriverDelayedLoader.appendCall(new AdDriverCall("$slotname", "{$slot['size']}",  "$dartUrl"));
		}
	});
EOT;
		}

		$out .= <<<EOT
</script>
EOT;
		if (strpos($slotname, 'EXIT_STITIAL') === FALSE) {
			$out .= '</div>';
		}

		$out .= $this->getSetupHtml();
		$out .= AdProviderLiftium::getInstance()->getSetupHtml();

		return $out;
	}

	public function getSetupHtml() {
		global $wgCityId;

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
		$out .= AdEngine::getInstance()->providerValuesAsJavascript($wgCityId);

		return $out;
	}
	
	private $slotsToCall = array();
	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}
	public function batchCallAllowed(){ return false; }
	public function getBatchCallHtml(){ return false; }
	
}
