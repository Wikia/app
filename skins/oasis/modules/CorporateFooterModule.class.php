<?php

class CorporateFooterModule extends Module {
	var $footer_links;
	var $copyright;

	public function executeIndex() {
		global $wgLangToCentralMap, $wgContLang, $wgCityId, $wgUser, $wgLang, $wgMemc;
		$mKey = wfMemcKey('mOasisFooterLinks', $wgLang->getCode());
		$this->footer_links = $wgMemc->get($mKey);
		if (empty($this->footer_links)) {
			$this->footer_links = $this->getWikiaFooterLinks();
			$wgMemc->set($mKey, $this->footer_links, 86400);
		}
		$this->replaceLicense();
	}
	
	
	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	 private function getWikiaFooterLinks() {
		wfProfileIn( __METHOD__ );

		global $wgCityId;
		$catId = WikiFactoryHub::getInstance()->getCategoryId($wgCityId);

		$message_key = 'shared-Oasis-footer-wikia-links';
		$nodes = array();
				
		if(!isset($catId) || null == ($lines = getMessageAsArray($message_key.'-'.$catId))) {
			wfDebugLog('monaco', $message_key.'-'.$catId . ' - seems to be empty');
			if(null == ($lines = getMessageAsArray($message_key))) {
				wfDebugLog('monaco', $message_key . ' - seems to be empty');
				wfProfileOut( __METHOD__ );
				return $nodes;
			}
		}

		foreach($lines as $line) {
			$depth = strrpos($line, '*');
			if($depth === 0) {
				$nodes[] = parseItem($line);
			}
		}
		wfProfileOut( __METHOD__ );
		return $nodes;
	}
	
	private function replaceLicense() {
		for ($i=0; $i < count($this->footer_links); $i++) {
			if ($this->footer_links[$i]["text"] == 'GFDL' || $this->footer_links[$i]["text"] == '_LICENSE_') {
				$this->footer_links[$i]["text"] = $this->copyright;
			}
		}
	}
}
