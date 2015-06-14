<?php

class SpecialPageUserCommand extends UserCommand {

	const EXTERNAL_DATA_SOURCE_WIKI_ID = 4036;
	const EXTERNAL_DATA_URL = 'http://messaging.wikia.com/wikia.php?controller=UserTools&method=executeToolbarGetList&format=json';
	const EXTERNAL_DATA_CACHE_TTL = 7200;

	protected $disabledExtension = false;

	public function buildData() {
		global $wgUser, $wgTitle;

		$page = SpecialPageFactory::getPage($this->name);
		if (!is_object($page)) {
			$this->buildExternalData();
			return;
		}

		$this->available = true;
		$this->enabled = $page->userCanExecute($wgUser);
		$this->caption = $page->getDescription();
		$this->description = $page->getDescription();

		$this->href = $page->getTitle()->getLocalUrl();

		switch ( $this->name ) {
			case 'RecentChangesLinked':
				$this->href .= '/' . $wgTitle->getPartialUrl();
				break;
			case 'Contributions':
				$this->href .= '/' . $wgUser->getTitleKey();
				break;
		}

		$specialPageName = $page->getName();
		$options = array();
		wfRunHooks("UserCommand::SpecialPage::{$specialPageName}",array($this,&$options));
		foreach ($options as $k => $v)
			$this->$k = $v;
	}

	public function getInfo() {
		$this->needData();
		if (!$this->available) {
			return false;
		}
		return parent::getInfo();
	}

	protected function getDisabledMessage() {
		if ($this->disabledExtension) {
			return wfMsg('oasis-toolbar-not-enabled-here');
		}
		return parent::getDisabledMessage();
	}

	protected function getExternalDataUrl( $langCode = false ) {
		global $wgDevelEnvironment;

		$url = self::EXTERNAL_DATA_URL;
		// devbox override
		if (!empty($wgDevelEnvironment)) {
			$url = str_replace('wikia.com','wladek.wikia-dev.com',$url);
		}

		if (!empty($langCode)) {
			$url .= "&uselang={$langCode}";
		}

		return $url;
	}

	static protected $externalData = false;

	protected function getExternalData() {
		global $wgCityId;

		// Prevent recursive loop
		if ($wgCityId == self::EXTERNAL_DATA_SOURCE_WIKI_ID) {
			return array();
		}

		if (self::$externalData === false) {
			global $wgLang, $wgMemc;
			$code = $wgLang->getCode();
			$key = wfSharedMemcKey('user-command-special-page','lang',$code);
			$data = $wgMemc->get($key);
			if (empty($data)) {
				$data = array();
				$external = Http::get($this->getExternalDataUrl($code));
				$external = json_decode($external,true);
				if (is_array($external) && !empty($external['allOptions']) && is_array($external['allOptions'])) {
					foreach ($external['allOptions'] as $option) {
						$data[$option['id']] = $option;
					}
				}
				$wgMemc->set($key,$data,self::EXTERNAL_DATA_CACHE_TTL);
			}
			self::$externalData = $data;
		}
		return self::$externalData;
	}

	protected function buildExternalData() {
		$data = $this->getExternalData();
		if (isset($data[$this->id])) {
			$this->disabledExtension = true;
			$this->available = true;
			$this->enabled = false;
			$this->caption = $data[$this->id]['defaultCaption'];
			$this->description = $data[$this->id]['defaultCaption'];
		}
	}

}
