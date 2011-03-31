<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManager {

	private $mCacheBuster;
	private $mCombine;
	private $mMinify;
	private $mCommonHost;
	private $mAssetsConfig;

	public static function onMakeGlobalVariablesScript(&$vars) {
		global $wgOasisHD, $wgCdnRootUrl, $wgAssetsManagerQuery;

		$params = SassUtil::getOasisSettings();
		if($wgOasisHD) {
			$params['hd'] = 1;
		}

		$vars['sassParams'] = $params;

		$vars['wgAssetsManagerQuery'] = $wgAssetsManagerQuery;
		$vars['wgCdnRootUrl'] = $wgCdnRootUrl;

		return true;
	}

	public function __construct(/* string */ $commonHost, /* int */ $cacheBuster, /* boolean */ $combine = true, /* boolean */ $minify = true) {
		$this->mCacheBuster = $cacheBuster;
		$this->mCombine = $combine;
		$this->mMinify = $minify;
		$this->mCommonHost = $commonHost;
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	public function getSassCommonURL(/* string */ $scssFilePath, /* boolean */ $minify = null) {
		global $wgOasisHD;

		$params = SassUtil::getOasisSettings();
		if($wgOasisHD) {
			$params['hd'] = 1;
		}

		if($minify != null ? !$minify : !$this->mMinify) {
			$params['minify'] = false;
		} else {
			unset($params['minify']);
		}

		return $this->getAMLocalURL('sass', $scssFilePath, $params);
		//return $this->mCommonHost . $this->getAMLocalURL('sass', $scssFilePath, $params);
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return string Relative URL to one file
 	 */
	public function getOneLocalURL(/* string */ $filePath, /* boolean */ $minify = null) {
		if($minify != null ? $minify : $this->mMinify) {
			$url = $this->getAMLocalURL('one', $filePath);
		} else {
			$url = '/' . $filePath . '?cb=' . $this->mCacheBuster;
		}
		return $url;
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return string Full URL to one file, uses wiki specific host
 	 */
	public function getOneFullURL(/* string */ $filePath, /* boolean */ $minify = null) {
		global $wgServer;
		return $wgServer . $this->getOneLocalURL($filePath);
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return string Full common URL to one file, uses not wiki specific host
 	 */
	public function getOneCommonURL(/* string */ $filePath, /* boolean */ $minify = null) {
		return $this->mCommonHost . $this->getOneLocalURL($filePath, $minify);
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return array Array of one or many URLs
 	 */
	private function getGroupURL(/* string */ $groupName, /* array */ $params = array(), /* string */ $prefix, /* boolean */ $combine, /* boolean */ $minify) {
		if($combine != null ? $combine : $this->mCombine) {
			// "minify" is a special parameter that can be set only when initialising object and can not be overwritten per request
			if($minify != null ? !$minify : !$this->mMinify) {
				$params['minify'] = false;
			} else {
				unset($params['minify']);
			}

			// When AssetsManager works in "combine" mode then only one URL will be returned
			return array($prefix . $this->getAMLocalURL('group', $groupName, $params));

		} else {
			// Lazy loading of AssetsConfig
			if(empty($this->mAssetsConfig)) {
				$this->mAssetsConfig = F::build('AssetsConfig');
			}
			$assets = $this->mAssetsConfig->resolve($groupName, $this->mCombine, $this->mMinify);
			$URLs = array();
			foreach($assets as $asset) {
				if(substr($asset, 0, 7) == 'http://') {
					$URLs[] = $asset;
				} else {
					$URLs[] = $prefix . $this->getOneLocalURL($asset);
				}
			}
			return $URLs;
		}
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return array Array of one or many relative URLs
 	 */
	public function getGroupLocalURL(/* string */ $groupName, /* array */ $params = array(), /* boolean */ $combine = null, /* boolean */ $minify = null) {
		return $this->getGroupURL($groupName, $params, '', $combine, $minify);
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return array Array of one or many full URLs, uses wiki specific host
 	 */
	public function getGroupFullURL(/* string */ $groupName, /* array */ $params = array(), /* boolean */ $combine = null, /* boolean */ $minify = null)  {
		global $wgServer;
		return $this->getGroupURL($groupName, $params, $wgServer, $combine, $minify);
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return array Array of one or many full common URLs, uses not wiki specific host
 	 */
	public function getGroupCommonURL(/* string */ $groupName, /* array */ $params = array(), /* boolean */ $combine = null, /* boolean */ $minify = null)  {
		return $this->getGroupURL($groupName, $params, $this->mCommonHost, $combine, $minify);
	}

	private function getAMLocalURL($type, $oid, $params = array()) {
		global $wgAssetsManagerQuery;
		return sprintf($wgAssetsManagerQuery,
			/* 1 */ $type,
			/* 2 */ $oid,
			/* 3 */ urlencode(http_build_query($params)),
			/* 4 */ $this->mCacheBuster);
	}

}
