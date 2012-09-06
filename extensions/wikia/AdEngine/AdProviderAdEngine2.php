<?php

class AdProviderAdEngine2 extends AdProviderIframeFiller implements iAdProvider {

	public $enable_lazyload = true;
	private $isMainPage, $useIframe = false;
	public $name = 'AdEngine2';

	protected static $instance = false;

	protected function __construct() {
		$this->isMainPage = WikiaPageType::isMainPage();
	}

	public static function getInstance() {
		if(self::$instance == false) {
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
		wfProfileIn(__METHOD__);

		$out = <<<EOT
<div id="{$slotname}" class="wikia-ad noprint default-height">
<script type="text/javascript">
	window.adslots2.push(['{$slotname}', '{$slot['size']}', '{$this->name}', '{$slot['load_priority']}']);
</script>
</div>
EOT;

		wfProfileOut(__METHOD__);
		
		return $out;
	}
	
	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) { return ''; }
}