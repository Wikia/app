<?php
class HuluVideoPanelModule extends Module {
	
	var $partnerId = 'CSWidget';
	var $wgHuluVideoPanelShow;
	var $wgHuluVideoPanelAttributes;
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);

		wfProfileOut( __METHOD__ );
	}
}
