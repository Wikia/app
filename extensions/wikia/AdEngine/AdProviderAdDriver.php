<?php

class AdProviderAdDriver implements iAdProvider {

	const HIGH_LOADPRIORITY_FLOOR = 11;

	public $enable_lazyload = true;

	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderAdDriver();
		}
		return self::$instance;
	}

	public function getAd($slotname, $slot, $params = null) {
		wfProfileIn(__METHOD__);

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
			if (strpos($slotname, 'EXIT_STITIAL') !== FALSE || $slotname == 'MODAL_RECTANGLE' || $slotname == 'MODAL_INTERSTITIAL') {
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
	if(!window.adslots) {
		window.adslots = [];
	}
	window.adslots.push(["$slotname", "{$slot['size']}", "DART", {$slot['load_priority']}]);
EOT;
			if ($slot['load_priority'] >= self::HIGH_LOADPRIORITY_FLOOR) {
				$out .= <<<EOT
	if ( window.wgLoadAdDriverOnLiftiumInit || window.Wikia.AbTest && Wikia.AbTest.inTreatmentGroup( "AD_LOAD_TIMING", "AS_WRAPPERS_ARE_RENDERED" ) ) {
		if (window.adDriverCanInit) {
			AdDriverDelayedLoader.prepareSlots(AdDriverDelayedLoader.highLoadPriorityFloor);
		}
	}

EOT;

			}
		}

		$out .= <<<EOT
</script>
EOT;
		if (strpos($slotname, 'EXIT_STITIAL') === FALSE && strpos($slotname, 'MODAL') === FALSE) {
			$out .= '</div>';
		}

		// 2012/05/16 wlee: for purposes of ads A/B/C test, Liftium
		// setup code is emitted in Oasis_Index.php
		//$out .= AdProviderLiftium::getInstance()->getSetupHtml(array('isCalledAfterOnload'=>1, 'hasMoreCalls'=>1, 'maxLoadDelay'=>6000));

		wfProfileOut(__METHOD__);

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