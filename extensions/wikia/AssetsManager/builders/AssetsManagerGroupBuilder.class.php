<?php 

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerGroupBuilder extends AssetsManagerBaseBuilder {
	
	public function __construct($request) {
		parent::__construct($request);
		
		global $IP;
		
		$ac = new AssetsConfig();
		$assets = $ac->resolve($this->mOid, true, (!isset($this->mParams['minify']) || $this->mParams['minify'] == true), $this->mParams);

		foreach($assets as $asset) {
			if(substr($asset, 0, 7) == 'http://') {
				$this->mContent .= HTTP::get($asset);
			} else {
				$this->mContent .= file_get_contents($IP . '/' . $asset);
			}
			
			if(empty($this->mContentType)) {
				$this->mContentType = $this->resolveContentType($asset);
			}
		}

		// For RTE only
		if($this->mOid == 'rte') {
			$this->mContent = preg_replace('#^.*@Packager\\.RemoveLine.*$#m', '', $this->mContent);
			$this->mContent = str_replace("\xEF\xBB\xBF", '', $this->mContent);
		}

	}

}
