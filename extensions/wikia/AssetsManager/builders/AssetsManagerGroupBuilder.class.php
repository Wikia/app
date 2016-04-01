<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerGroupBuilder extends AssetsManagerBaseBuilder {

	public function __construct(WebRequest $request) {
		parent::__construct($request);

		global $IP, $wgUser;

		$ac = new AssetsConfig();
		$assets = $ac->resolve($this->mOid, true, (!isset($this->mParams['minify']) || $this->mParams['minify'] == true), $this->mParams);
		$this->mContentType = $ac->getGroupType($this->mOid);

		foreach($assets as $asset) {
			// reference to a file to be fetched by the browser from external server (BugId:9522)
			if (substr($asset, 0, 10) == '#external_') {
				// do nothing
			} else if(Http::isValidURI($asset)) {
				$params = array();
				$url = parse_url($asset);
				if (isset($url['query'])) {
					parse_str($url['query'], $params);
				}
				// Start checking the url to see if it is something we care about (BugId:30188)
				if(isset($params['action']) && $params['action'] == 'raw' && isset($params['gen']) && $params['gen'] == 'js') {
					//$this->mContent .= RequestContext::getMain()->getSkin()->generateUserJs(); // FIXME
				} else if(isset($params['action']) && $params['action'] == 'raw' && isset($params['gen']) && $params['gen'] == 'css') {
					//$this->mContent .= RequestContext::getMain()->getSkin()->generateUserStylesheet(); // FIXME
				}
			} else {
				$this->mContent .= file_get_contents($IP . '/' . $asset);
			}


			if($this->mContentType == AssetsManager::TYPE_JS) {
				// add semicolon to separate concatenated files (BugId:20272)
				// but only for JS (BugId:20824)
				$this->mContent .= ";\n";
			}
		}

		// For RTE only
		// TODO: add "filters" definitions to config.php
		if($this->mOid == 'rte' || $this->mOid == 'eplrte' || $this->mOid == 'mini_editor_rte_js') {
			$this->mContent = preg_replace('#^.*@Packager\\.RemoveLine.*$#m', '', $this->mContent);
			$this->mContent = str_replace("\xEF\xBB\xBF" /* BOM */, '', $this->mContent);
		}
	}
}
