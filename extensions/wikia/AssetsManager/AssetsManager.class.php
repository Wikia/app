<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManager {

	const TYPE_CSS = 'text/css';
	const TYPE_JS = 'application/x-javascript';
	const TYPE_SCSS = -1;

	const URL_TYPE_LOCAL = 0;
	const URL_TYPE_COMMON = 1;
	const URL_TYPE_FULL = 2;

	const SINGLE = 0;
	const PACKAGE = 1;

	private $mCacheBuster;
	private $mCombine;
	private $mMinify;
	private $mCommonHost;
	private $mAssetsConfig;
	private $mAllowedAssetExtensions = array( 'js', 'css', 'scss' );
	private static $mInstance = false;

	public static function getInstance() {
		if( self::$mInstance == false ) {
			global $wgCdnRootUrl, $wgStyleVersion, $wgAllInOne, $wgRequest;
			self::$mInstance = new AssetsManager($wgCdnRootUrl, $wgStyleVersion, $wgRequest->getBool('allinone', $wgAllInOne), $wgRequest->getBool('allinone', $wgAllInOne));
		}
		return self::$mInstance;
	}

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

	private function __construct(/* string */ $commonHost, /* int */ $cacheBuster, /* boolean */ $combine = true, /* boolean */ $minify = true) {
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

		if($minify !== null ? !$minify : !$this->mMinify) {
			$params['minify'] = false;
		} else {
			unset($params['minify']);
		}

		return $this->mCommonHost . $this->getAMLocalURL('sass', $scssFilePath, $params);
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return string Relative URL to one file
 	 */
	public function getOneLocalURL(/* string */ $filePath, /* boolean */ $minify = null) {
		global $wgScriptPath;
		if ($minify !== null ? $minify : $this->mMinify) {
			$url = $this->getAMLocalURL('one', $filePath);
		} else {
			$url = $wgScriptPath . '/' . $filePath . '?cb=' . $this->mCacheBuster;
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
		if ($minify !== null ? $minify : $this->mMinify) {
			return $this->mCommonHost . $this->getOneLocalURL($filePath, $minify);
		} else {
			return $this->getOneLocalURL($filePath, $minify);
		}
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return array Array of one or many URLs
 	 */
	private function getGroupURL(/* string */ $groupName, /* array */ $params, /* string */ $prefix, /* boolean */ $combine, /* boolean */ $minify) {

		// Lazy loading of AssetsConfig
		if(empty($this->mAssetsConfig)) {
			$this->mAssetsConfig = F::build('AssetsConfig');
		}
		$assets = $this->mAssetsConfig->resolve($groupName, $this->mCombine, $this->mMinify);
		$URLs = array();

		if($combine !== null ? $combine : $this->mCombine) {
			// "minify" is a special parameter that can be set only when initialising object and can not be overwritten per request
			if($minify !== null ? !$minify : !$this->mMinify) {
				$params['minify'] = false;
			} else {
				unset($params['minify']);
			}

			// check for an #external_ URL being the first item in the package (BugId:9522)
			if (isset($assets[0]) && substr($assets[0], 0, 10) == '#external_') {
				$URLs[] = substr($assets[0], 10);
			}

			// When AssetsManager works in "combine" mode return URL to the combined package
			$URLs[] = $prefix . $this->getAMLocalURL('group', $groupName, $params);
		} else {
			foreach($assets as $asset) {
				if(substr($asset, 0, 10) == '#external_') {
					$URLs[] = substr($asset, 10);
				} else if(Http::isValidURI($asset)) {
					$URLs[] = $asset;
				} else {
					$URLs[] = $prefix . $this->getOneLocalURL($asset, $minify);
				}
			}
		}

		return $URLs;
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
		if (($combine !== null ? $combine : $this->mCombine) || ($minify !== null ? $minify : $this->mMinify)) {
			return $this->getGroupURL($groupName, $params, $this->mCommonHost, $combine, $minify);
		} else {
			return $this->getGroupURL($groupName, $params, '', $combine, $minify);
		}
	}

	/**
	 * @author macbre
	 * @return array Array of one or many URLs
 	 */
	private function getGroupsURL(Array $groupNames, /* array */ $params, /* string */ $prefix, /* boolean */ $combine, /* boolean */ $minify) {
		$URLs = array();

		if($combine !== null ? $combine : $this->mCombine) {
			// When AssetsManager works in "combine" mode return URL to the combined package
			$URLs[] = $prefix . $this->getAMLocalURL('groups', implode(',', $groupNames), $params);
		}
		else {
			foreach($groupNames as $groupName) {
				$URLs = array_merge($URLs, $this->getGroupURL($groupName, $params, $prefix, $combine, $minify));
			}
		}

		return $URLs;
	}

	/**
	 * @author macbre
	 * @return array Array of one or many full common URLs, uses not wiki specific host
 	 */
	public function getGroupsCommonURL(Array $groupNames, /* array */ $params = array(), /* boolean */ $combine = null, /* boolean */ $minify = null)  {
		if (($combine !== null ? $combine : $this->mCombine) || ($minify !== null ? $minify : $this->mMinify)) {
			return $this->getGroupsURL($groupNames, $params, $this->mCommonHost, $combine, $minify);
		} else {
			return $this->getGroupsURL($groupNames, $params, '', $combine, $minify);
		}
	}

	private function getAMLocalURL($type, $oid, $params = array()) {
		global $wgAssetsManagerQuery, $IP, $wgSpeedBox, $wgDevelEnvironment;
		$cb = $wgSpeedBox && $wgDevelEnvironment ?
			hexdec(substr(wfAssetManagerGetSASShash( $IP.'/'.$oid ),0,6)) :
			$this->mCacheBuster;
		return sprintf($wgAssetsManagerQuery,
			/* 1 */ $type,
			/* 2 */ $oid,
			/* 3 */ !empty($params) ? urlencode(http_build_query($params)) : '-',
			/* 4 */ $cb);
	}


	public function getAllowedAssetExtensions(){
		return $this->mAllowedAssetExtensions;
	}

	/**
	 * Return request details containing HTTP referer and user agent
	 * @return string request details for debug logging
	 */
	public static function getRequestDetails() {
		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '-';
		$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '-';
		return "UA:{$userAgent}, referer:{$referer}";
	}
}
