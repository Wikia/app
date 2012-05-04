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
				if(strpos($asset, 'index.php?title=-&action=raw&smaxage=0&gen=js') !== false) {
					$this->mContent .= $wgUser->getSkin()->generateUserJs();
				} else if(strpos($asset, 'Wikia.css') !== false) {
					$message = wfMsgForContent('Wikia.css');
					if(!wfEmptyMsg('Wikia.css', $message)) {
						$this->mContent .= $message;
					}
				} else if(strpos($asset, 'index.php?title=-&action=raw&maxage=86400&gen=css') !== false) {
					$this->mContent .= $wgUser->getSkin()->generateUserStylesheet();
				} else {
					//Debug added on May 4, 2012 to inquire external requests spikes
					$start = microtime(true);
					$this->mContent .= HTTP::get($asset);
					$totalTime = microtime(true) - $start;

					if ( $totalTime >= 1 ) {
						Wikia::log(__METHOD__, false, "oid: {$this->mOid}, totalTime: {$totalTime}, asset: {$asset}, referrer: {$_SERVER['HTTP_REFERER']}, entrypoint: {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", true);
					}
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

		if($this->mOid == 'site_user_css') {
			$this->mCacheMode = 'private';
		}
	}
}
