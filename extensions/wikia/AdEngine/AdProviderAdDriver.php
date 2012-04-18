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
			//case 'HUB_TOP_LEADERBOARD':	// do not reserve space
			case 'TOP_LEADERBOARD':
			case 'CORP_TOP_RIGHT_BOXAD':
			case 'HOME_TOP_RIGHT_BOXAD':
			case 'TEST_HOME_TOP_RIGHT_BOXAD':
			case 'TEST_TOP_RIGHT_BOXAD':
			case 'TOP_RIGHT_BOXAD':
			case 'PREFOOTER_LEFT_BOXAD':
			case 'PREFOOTER_RIGHT_BOXAD':
				$extraClasses .= ' default-height';
				break;
		}
		if (is_array($params)) {
			if (!empty($params['extraClasses']) && is_array($params['extraClasses'])) {
				$extraClasses .= ' ' . implode(' ', $params['extraClasses']);
			}
		}
		
		if (strpos($slotname, 'EXIT_STITIAL') === FALSE && strpos($slotname, 'MODAL') === FALSE) {
			$out .= '<div id="' . htmlspecialchars($slotname) . '" class="wikia-ad noprint'.$extraClasses.'">';
		}

		$out .= <<<EOT
<script type="text/javascript">
EOT;
		if (strpos($slotname, 'MODAL') !== FALSE || strpos($slotname, 'EXIT_STITIAL') !== FALSE) {
			$out .= <<<EOT
	if (window.AdDriverDelayedLoader) {
		if (AdDriverDelayedLoader.started && !AdDriverDelayedLoader.isRunning()) {
			AdDriverDelayedLoader.reset();
			var loadAd = true;
		}
		AdDriverDelayedLoader.appendItem(new AdDriverDelayedLoaderItem("$slotname", "{$slot['size']}", "DART"));
EOT;
			if (strpos($slotname, 'EXIT_STITIAL') !== FALSE) {
				$out .= <<<EOT
		if (window.loadAd) {
			AdDriverDelayedLoader.load();
		}
EOT;
			}
			$out .= <<<EOT
	}
EOT;
		}
		else {
			$out .= <<<EOT
	wgAfterContentAndJS.push(function() {
		if (typeof(AdDriverDelayedLoader) != 'undefined') {
			AdDriverDelayedLoader.appendItem(new AdDriverDelayedLoaderItem("$slotname", "{$slot['size']}", "DART"));
		}
	});
EOT;
		}

		$out .= <<<EOT
</script>
EOT;
		if (strpos($slotname, 'EXIT_STITIAL') === FALSE && strpos($slotname, 'MODAL') === FALSE) {
			$out .= '</div>';
		}

		// LiftiumOptions init has been moved to AdEngine::wfAdEngineSetupJSVars
		// https://wikia.fogbugz.com/default.asp?28647
//		$out .= AdProviderLiftium::getInstance()->getSetupHtml(array('isCalledAfterOnload'=>1, 'hasMoreCalls'=>1, 'maxLoadDelay'=>6000));

		return $out;
	}

	public function getSetupHtml() {
		static $called = false;
		if ($called) {
			return false;
		}
		$called = true;

		$out = '';

		return $out;
	}
	
	private $slotsToCall = array();
	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}
	public function batchCallAllowed(){ return false; }
	public function getBatchCallHtml(){ return false; }
	
}
