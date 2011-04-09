<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerGroupBuilder extends AssetsManagerBaseBuilder {

	public function __construct($request) {
		parent::__construct($request);

		global $IP, $wgUser;

		$ac = new AssetsConfig();
		$assets = $ac->resolve($this->mOid, true, (!isset($this->mParams['minify']) || $this->mParams['minify'] == true), $this->mParams);

		foreach($assets as $asset) {
			if(Http::isValidURI($asset)) {
				if(strpos($asset, 'index.php?title=-&action=raw&smaxage=0&gen=js') !== false) {
					$this->mContent .= $wgUser->getSkin()->generateUserJs();
				} else if(strpos($asset, 'Wikia.css') !== false) {
					$this->mContent .= wfMsg('Wikia.css');
				} else if(strpos($asset, 'index.php?title=-&action=raw&maxage=86400&gen=css') !== false) {
					$this->mContent .= $wgUser->getSkin()->generateUserStylesheet();
				} else {
					$this->mContent .= HTTP::get($asset);
				}
			} else {
				$this->mContent .= file_get_contents($IP . '/' . $asset);
			}

			$this->mContent .= "\n";
		}

		// For RTE only
		if($this->mOid == 'rte') {
			$this->mContent = preg_replace('#^.*@Packager\\.RemoveLine.*$#m', '', $this->mContent);
			$this->mContent = str_replace("\xEF\xBB\xBF", '', $this->mContent);
		}

		$this->mContentType = $ac->getGroupType($this->mOid);
	}

}
