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
	private $mGeneratedUrls = array();

	/**
	 * Loads packages' configuration if it wasn't already loaded
	 *
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 */
	private function loadConfig() {
		if(empty($this->mAssetsConfig)) {
			$this->mAssetsConfig = F::build( 'AssetsConfig' );
		}
	}

	public static function getInstance() {
		if( self::$mInstance == false ) {
			global $wgCdnRootUrl, $wgStyleVersion, $wgAllInOne, $wgRequest;
			self::$mInstance = new AssetsManager($wgCdnRootUrl, $wgStyleVersion, $wgRequest->getBool('allinone', $wgAllInOne), $wgRequest->getBool('allinone', $wgAllInOne));
		}
		return self::$mInstance;
	}

	public static function onMakeGlobalVariablesScript(&$vars) {
		global $wgOasisHD, $wgOasisFluid, $wgCdnRootUrl, $wgAssetsManagerQuery;

		$params = SassUtil::getOasisSettings();
		if($wgOasisHD) {
			$params['hd'] = 1;
		} else if($wgOasisFluid) {
			$params['hd'] = 2;
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
	 * Returns the local or common URL for one or more assets (either single files or configured packages).
	 * 
	 * 
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 * 
	 * @param mixed $assetName the name of a package or the path of an asset file as a string or an array of them,
	 * if it's an array then it must contain only single file assets or packages (not mixed) and all of the same type.
	 * Please note that when passing an array this method will try to return a combined URL if possible (works only for non-SASS packages ATM),
	 * if you want/need separate URL's for each asset in the array then call this method separately for each of them.
	 * @param bool $local [OPTIONAL] wether to fetch per-wiki local URL's or not,
	 * (false by default, i.e. the method returns a shared host URL's for our network).
	 * 
	 * @throws WikiaException
	 * 
	 * @return array an array containing one or more URL's
	 */
	public function getURL( $assetName, &$type = null, $local = false ) {
		wfProfileIn( __METHOD__ );

		$this->loadConfig();

		if ( !is_array( $assetName ) ) {
			$assetName = array( $assetName );
		}

		$combineable = count( $assetName ) > 1;
		$isGroup = $checkType = $checkGroup = null;
		$urls = array();

		foreach ( $assetName as $asset ) {
			$aType = $this->mAssetsConfig->getGroupType( $asset );

			if ( $aType === null ) {
				//single asset file
				$isGroup = false;

				//not a configured package, drop combination
				//TODO: if combination of single assets will be allowed at one point, then review this value
				$combineable = false;

				//get the resource type from the file extension
				$tokens = explode( '.', $asset );
				$tokensCount = count( $tokens );

				if ( $tokensCount > 1 ) {
					$extension = strtolower( $tokens[$tokensCount - 1] );

					if ( in_array( $extension, $this->getAllowedAssetExtensions() ) ){
						switch ( $extension ) {
							case 'js':
								$aType = self::TYPE_JS;
								break;
							case 'css':
								$aType = self::TYPE_CSS;
								break;
							case 'scss':
								$aType = self::TYPE_SCSS;
								break;
							default:
								wfProfileOut( __METHOD__ );
								throw new WikiaException( 'Asset type not recognized.' );
						}
					}
				}
			} else {
				//configured package
				$isGroup = true;
				//TODO: combined SASS assets are not supported at the moment, if we'll change this then this check needs to be reviewed
				$combineable = $combineable && !( $aType == self::TYPE_SCSS );
			}

			//TODO: URL's for packages combined with single assets are not supported at the moment, if we'll change this then this check needs to be reviewed
			if ( $checkGroup === null ) {
				//first run, just assign
				$checkGroup = $isGroup;
			} elseif ( $checkGroup != $isGroup ) {
				wfProfileOut( __METHOD__ );
				throw new WikiaException( 'Cannot process single file assets and groups together.' );
			}

			//TODO: URL's for packages/assets with different types are not supported at the moment, if we'll change this then this check needs to be reviewed
			if ( $checkType === null ) {
				//first run, just assign
				$checkType = $aType;
			} elseif ( $checkType != $aType ) {
				wfProfileOut( __METHOD__ );
				throw new WikiaException( 'Cannot process assets of different types together.' );
			}

			//if not combineable generate URL's avoiding re-iterating out of this loop
			//this works here as far as single assets + groups or assets of different types cannot be mixed
			//TODO: if the above won't be true anymore at some point, then this needs to be done in a separate loop
			if ( !$combineable ) {
				if ( $isGroup ) {
					if ( $aType == self::TYPE_SCSS ) {
						$urls = array_merge( $urls, ( !empty( $local ) ) ? $this->getSassGroupLocalURL( $asset ) : $this->getSassGroupCommonURL( $asset ) );
					} else {
						$urls = array_merge( $urls, ( !empty( $local ) ) ? $this->getGroupLocalURL( $asset ) : $this->getGroupCommonURL( $asset ) );
					}
				} else {
					if ( $aType == self::TYPE_SCSS ) {
						$urls[] = ( !empty( $local ) ) ? $this->getSassLocalURL( $asset ) : $this->getSassCommonURL( $asset );;
					} else {
						$urls[] =  ( !empty( $local ) ) ? $this->getOneLocalURL( $asset ) : $this->getOneCommonURL( $asset );
					}
				}
			}
		}

		if ( $combineable ) {
			$urls = ( !empty( $local ) ) ? $this->getGroupsLocalURL( $assetName ) : $this->getGroupsCommonURL( $assetName );
		}

		$type = $checkType;

		wfProfileOut( __METHOD__ );
		return $urls;
	}

	/**
	 * Generates a valid SASS URL with all the required commandline parameters for Oasis
	 * 
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 * 
	 * @param string $scssFilePath
	 * @param string $prefix
	 * @param bool $minify
	 * 
	 * @return string the generated URL
	 */
	private function getSassURL( $scssFilePath, $prefix, $minify = null ) {
		wfProfileIn( __METHOD__ );
		global $wgOasisHD, $wgOasisFluid;

		$params = SassUtil::getOasisSettings();

		if ( $wgOasisHD ) {
			$params['hd'] = 1;
		}

		if ( $wgOasisFluid ) {
			$params['hd'] = 2;
		}

		if ( $minify !== null ? !$minify : !$this->mMinify ) {
			$params['minify'] = false;
		} else {
			unset( $params['minify'] );
		}

		$url = $prefix . $this->getAMLocalURL( 'sass', $scssFilePath, $params );

		wfProfileOut( __METHOD__ );
		return $url;
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	public function getSassCommonURL(/* string */ $scssFilePath, /* boolean */ $minify = null) {
		return $this->getSassURL( $scssFilePath, $this->mCommonHost, $minify );
	}

	/**
	 * Returns the per-wiki local URL to a SASS-processed asset
	 * 
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 * 
	 * @param string $scssFilePath
	 * @param bool $minify
	 * 
	 * @return string the generated URL
	 */
	public function getSassLocalURL( $scssFilePath, $minify = null ) {
		return $this->getSassURL( $scssFilePath, '', $minify );
	}

	private function getSassGroupURL( $groupName, $prefix, $combine = null, $minify = null ) {
		wfProfileIn( __METHOD__ );

		$urls = array();
		$minify = $minify !== null ? $minify : $this->mMinify;
		$combine = $combine !== null ? $combine : $this->mCombine;

		foreach ( $this->mAssetsConfig->resolve( $groupName, $combine, $minify ) as $scssFilePath ) {
			$urls[] = $this->getSassURL( $scssFilePath, $prefix, $minify );
		}

		$this->mGeneratedUrls += array_fill_keys( $urls, $groupName );

		wfProfileOut( __METHOD__ );
		return $urls;
	}

	public function getSassGroupLocalURL( $groupName, $minify = null ){
		return $this->getSassGroupURL( $groupName, '', $minify );
	}

	public function getSassGroupCommonURL( $groupName, $minify = null ){
		return $this->getSassGroupURL( $groupName, $this->mCommonHost, $minify );
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
		wfProfileIn( __METHOD__ );

		//lazy loading of AssetsConfig
		$this->loadConfig();

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

		$this->mGeneratedUrls += array_fill_keys( $URLs, $groupName );

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		$URLs = array();

		if($combine !== null ? $combine : $this->mCombine) {
			// When AssetsManager works in "combine" mode return URL to the combined package
			$url = $prefix . $this->getAMLocalURL('groups', implode(',', $groupNames), $params);

			foreach ( $groupNames as $g ) {
				$this->mGeneratedUrls[$url] = $g;
			}

			$URLs[] = $url;
		}
		else {
			foreach($groupNames as $groupName) {
				$URLs = array_merge($URLs, $this->getGroupURL($groupName, $params, $prefix, $combine, $minify));
			}
		}

		wfProfileOut( __METHOD__ );
		return $URLs;
	}

	/**
	 * @author macbre
	 * @return array Array of one or many full common URLs, uses not wiki specific host
 	 */
	public function getGroupsCommonURL( Array $groupNames, /* array */ $params = array(), /* boolean */ $combine = null, /* boolean */ $minify = null ) {
		if ( ( $combine !== null ? $combine : $this->mCombine ) || ( $minify !== null ? $minify : $this->mMinify ) ) {
			return $this->getGroupsURL( $groupNames, $params, $this->mCommonHost, $combine, $minify );
		} else {
			return $this->getGroupsURL( $groupNames, $params, '', $combine, $minify );
		}
	}

	/**
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 * @return array Array of one or many full common URLs, uses not wiki specific host
	 */
	public function getGroupsLocalURL( Array $groupNames, /* array */ $params = array(), /* boolean */ $combine = null, /* boolean */ $minify = null ) {
		return $this->getGroupsURL($groupNames, $params, '', $combine, $minify);
	}

	private function getAMLocalURL($type, $oid, $params = array()) {
		wfProfileIn( __METHOD__ );

		global $wgAssetsManagerQuery, $IP, $wgSpeedBox, $wgDevelEnvironment;
		$cb = $wgSpeedBox && $wgDevelEnvironment ?
			hexdec(substr(wfAssetManagerGetSASShash( $IP.'/'.$oid ),0,6)) :
			$this->mCacheBuster;

		$url = sprintf($wgAssetsManagerQuery,
			/* 1 */ $type,
			/* 2 */ $oid,
			/* 3 */ !empty($params) ? urlencode(http_build_query($params)) : '-',
			/* 4 */ $cb);

		wfProfileOut( __METHOD__ );
		return $url;
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

	/**
	 * Checks if an URL produced by any of the AssetsManager::getGroup*Url() methods is associated to a package registered for a specific skin
	 * This method is used to filter our unwanted assets when outputting references in skin logic (e.g. in the WikiaMobile skin)
	 * 
	 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
	 * 
	 * @param string $url the url to get the package config for
	 * @param WikiaSkin $skin the skin instance
	 * 
	 * @throws WikiaException
	 * 
	 * @return bool wether the package has been registered for the specified skin or not
	 */
	public function checkAssetUrlForSkin( $url, WikiaSkin $skin ) {
		wfProfileIn( __METHOD__ );

		//lazy loading of AssetsConfig
		$this->loadConfig();
		$group = null;
		$skinName = $skin->getSkinName();
		$strict = $skin->isStrict();
		
		if ( !empty( $this->mGeneratedUrls[$url] ) ) {
			$group = $this->mGeneratedUrls[$url];
		} else {
			/**
			 * One of the following scenarios:
			 * - the package has not been processed by any of the getGroup*Url methods so far
			 * - this is a URL of a single asset generated by one of the getOne*Url methods
			 * - this is an hardcoded URL passed directly to e.g. OutputPage::addScript
			 * 
			 * If we're in strict mode then return false, the asset should be registered for $skin in config.php and
			 * it should have been generated by getGroup*Url if the developer knew what he was trying to do.
			 * 
			 * If we're in non-strict mode then return true as assets not bound to a skin are allowed anyways
			 */
			wfProfileOut( __METHOD__ );
			return !$strict;
		}

		$registeredSkin = $this->mAssetsConfig->getGroupSkin( $group );
		$check = ( is_array( $registeredSkin ) ) ? in_array( $skinName, $registeredSkin ) : $skinName === $registeredSkin;

		//if not strict packages with no skin registered are positive
		if ( $strict === false ) {
			$check = $check || empty( $registeredSkin );
		}

		wfProfileOut( __METHOD__ );
		return $check;
	}
}
