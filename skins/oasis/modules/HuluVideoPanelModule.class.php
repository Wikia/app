<?php
class HuluVideoPanelModule extends Module {
	
	var $partnerId = 'CSWidget';
	var $wgHuluVideoPanelShow;
	var $wgHuluVideoPanelAttributes;
	
	public function executeIndex() {
		global $wgOut;
		
		wfProfileIn(__METHOD__);
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/HuluVideoPanel.scss'));
		wfProfileOut( __METHOD__ );
	}
}
