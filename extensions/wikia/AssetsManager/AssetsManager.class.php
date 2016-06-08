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
	/**
	 * @var $mAssetsConfig AssetsConfig
	 */
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
			$this->mAssetsConfig = (new AssetsConfig);
		}
	}

	/**
	 * @static
	 * @return AssetsManager instance
	 */
	public static function getInstance() {
		if( self::$mInstance == false ) {
			global $wgCdnStylePath, $wgStyleVersion, $wgAllInOne, $wgRequest;
			self::$mInstance = new AssetsManager($wgCdnStylePath, $wgStyleVersion, $wgRequest->getBool('allinone', $wgAllInOne), $wgRequest->getBool('allinone', $wgAllInOne));
		}
		return self::$mInstance;
	}

	public static function onMakeGlobalVariablesScript(Array &$vars) {
		global $wgAssetsManagerQuery;

		$params = SassUtil::getSassSettings();

		$vars['sassParams'] = $params;
		$vars['wgAssetsManagerQuery'] = $wgAssetsManagerQuery;
		return true;
	}

	private function __construct(/* string */ $commonHost, /* int */ $cacheBuster, /* boolean */ $combine = true, /* boolean */ $minify = false) {
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
	 * @param mixed $type either string "js" or "css" or "scss"
	 * @param bool $local [OPTIONAL] wether to fetch per-wiki local URL's or not,
	 * (false by default, i.e. the method returns a shared host URL's for our network).
	 *
	 * @throws WikiaException
	 *
	 * @return String[] array containing one or more URL's
	 */
	public function getURL( $assetName, &$type = null, $local = false ) {
		wfProfileIn( __METHOD__ );

		$this->loadConfig();

		if ( !is_array( $assetName ) ) {
			$assetName = array( $assetName );
		}

		$combineable = count( $assetName ) > 1;
		$checkType = $checkGroup = null;
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
						// We always need to use common host for static assets since it has
						// the information about the slot which is otherwise not available
						// in varnish (BugId: 33905)
//						$urls[] =  ( !empty( $local ) ) ? $this->mCommonHost . $this->getOneLocalURL( $asset ) : $this->getOneCommonURL( $asset );
						$urls[] =  $this->getOneCommonURL( $asset );
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
	private function getSassURL( $scssFilePath, $prefix, $minify = null, $params = null ) {
		wfProfileIn( __METHOD__ );

		if ( !is_array( $params ) ) {
			$params = SassUtil::getSassSettings();

			if ( $minify !== null ? !$minify : !$this->mMinify ) {
				$params['minify'] = false;
			} else {
				unset( $params['minify'] );
			}
		}

		$url = $prefix . $this->getAMLocalURL( 'sass', $scssFilePath, $params );

		// apply domain sharding
		$url = wfReplaceAssetServer( $url );

		wfProfileOut( __METHOD__ );
		return $url;
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	public function getSassCommonURL(/* string */ $scssFilePath, /* boolean */ $minify = null, /* array */ $params = null) {
		global $wgCdnRootUrl;
		return $this->getSassURL( $scssFilePath, $wgCdnRootUrl, $minify, $params );
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
	public function getSassLocalURL( $scssFilePath, $minify = null, $params = null ) {
		return $this->getSassURL( $scssFilePath, '', $minify, $params );
	}

	/**
	 * attempts to turn a url (http://something.wikia.com/__am/sass/options/path/to/file.scss) to a local filepath
	 * (path/to/file.scss)
	 *
	 * @param string|array $urls the url to try and convert
	 * @return string|array the resulting filepaths or the original url if filepath can't be determined
	 */
	public function getSassFilePath($urls) {
		global $wgDevelEnvironment;

		/**
		 * for production urls, where urls are similar to:
		 * http://slot(1-9).images(1-9).wikia.nocookie.net/__am/sass/options/path/to/file.scss
		 */
		$regex = '/^(https?):\/\/(slot[0-9]+\.images([0-9]+))\.wikia.nocookie.net\/(.*)$/';
		if (!empty($wgDevelEnvironment)) {
			/**
			 * for urls in dev, where a url looks like:
			 * http://i(1-9).nelson.wikia-dev.com/__am/sass/options/path/to/file.scss
			 */
			$regex = '/^(https?):\/\/(i[0-9]+\.([a-z0-9]+))\.wikia-dev.com\/(.*)$/';
		}

		$urls = (array) $urls;
		$result = [];

		/**
		 * production - http://slotX.imagesY.wikia.nocookie.net/__am/sass/options/
		 * preview - http://preview.slot1.wikia.com/__am/sass/options/
		 * dev - http://iX.nelson.wikia-dev.com/__am/sass/options/
		 */
		$dummy = $this->getSassCommonURL('');

		if (preg_match($regex, $dummy, $dummyMatches)) {
			$dummyPath = $dummyMatches[4]; // will be __am/sass/options/ (no path/to/file.scss - we requested url for empty file)
			$dummyLength = strlen($dummyPath); // length of sass options all urls have
			foreach ($urls as $url) {
				/**
				 * $matches[4] will be __am/sass/options/path/to/file.scss so we can take diff
				 * with $dummyPath to find path/to/file.scss
				 */
				if (preg_match($regex, $url, $matches) && strpos($matches[4], $dummyPath) === 0) {
					$result[] = substr($matches[4], $dummyLength);
				} else {
					$result[] = $url;
				}
			}
		} else {
			/**
			 * fallback since some environments (preview) map everything to the same domain.
			 * in such cases we can use simple string manipulation
			 */
			$dummyLength = strlen($dummy);
			foreach ($urls as $url) {
				if (strpos($url, $dummy) === 0) {
					$result[] = substr($url, $dummyLength);
				} else {
					$result[] = $url;
				}
			}
		}

		return count($result) > 1 ? $result : $result[0];
	}

	/**
	 * determines whether a given url is for a sass resource. They tend to end in .scss
	 * @param string $url the url to check
	 * @return bool true if the url is a sass resource, false otherwise
	 */
	public function isSassUrl($url) {
		return substr($url, -5) == '.scss';
	}

	/**
	 * determines whether a given url is for JS group
	 *
	 * Example: http://slot1.images1.wikia.nocookie.net/__am/1413971462/group/noexternals%3D1/monetization_module_js
	 *
	 * @param string $url the url to check
	 * @return bool true if the url is a JS group, false otherwise
	 */
	public function isGroupUrl($url) {
		return is_string( $url ) && ( strpos( $url, '/group/' ) !== false );
	}

	/**
	 * Return AM group name from given URL
	 *
	 * If the given URL is not a valid group URL, false is returned
	 *
	 * @param string $url the URL to extract group name from
	 * @return bool|false group name or false if URL is invalid
	 */
	public function getGroupNameFromUrl($url) {
		if ( $this->isGroupUrl( $url ) ) {
			$parts = explode( '/', $url );
			return end( $parts );
		} else {
			return false;
		}
	}

	public function getSassesUrl( $sassList, $params = null ) {
		if ( !is_array( $sassList ) ) {
			$sassList = [$sassList];
		}

		$url = $this->getSassCommonURL( implode( ',', $sassList ), null, $params );
		$url = str_replace( ['/sass/', 'type=sass'], ['/sasses/', 'type=sasses'], $url );

		return $url;
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
		global $wgCdnRootUrl;
		return $this->getSassGroupURL( $groupName, $wgCdnRootUrl, $minify );
	}

	/**
	 * Returns domainless URL to an asset
	 *
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return string Relative URL to one file
	 */
	public function getOneLocalURL(/* string */ $filePath, /* boolean */ $minify = null) {
		global $wgScriptPath;
		// we should never ever use Asset Manager for ONE file
		// as it build our whole PHP stack and reads file from filesystem
		// which cannot be cached by web server as the content is assumed
		// to be dynamic
		// BAC-696: added ltrim() - prevent double slash in the URL
		$url = $wgScriptPath . '/' . ltrim( $filePath, '/' );
		// TODO: remove it completely
		//if ($minify !== null ? $minify : $this->mMinify) {
		//	$url = $this->getAMLocalURL('one', $filePath);
		//}
		return $url;
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return string Full common URL to one file, uses not wiki specific host
	 */
	public function getOneCommonURL(/* string */ $filePath, /* boolean */ $minify = null) {
		global $wgCdnRootUrl;
		if ($minify !== null ? $minify : $this->mMinify) {
			// Using $wgCdnRootUrl here because it doesn't contain a cb value (getAMLocalURL will add one)
			$url = $wgCdnRootUrl . $this->getAMLocalURL('one', $filePath, array('minify' => 1));
		} else {
			// We always need to use common host for static assets since it has
			// the information about the slot which is otherwise not available
			// in varnish (BugId: 33905)
			$url = $this->mCommonHost . $this->getOneLocalURL($filePath, $minify);
		}
		// apply domain sharding
		$url = wfReplaceAssetServer( $url );

		return $url;
	}

	/**
	 * @author Inez Korczyński <korczynski@gmail.com>
	 * @return array Array of one or many URLs
 	 */
	private function getGroupURL(/* string */ $groupName, /* array */ $params, /* string */ $prefix, /* boolean */ $combine, /* boolean */ $minify) {
		wfProfileIn( __METHOD__ );

		//lazy loading of AssetsConfig
		$this->loadConfig();

		// pass noexternals mode (BugId:28143)
		global $wgNoExternals;
		if (!empty($wgNoExternals)) {
			$params['noexternals'] = 1;
		}

		$assets = $this->mAssetsConfig->resolve($groupName, $this->mCombine, $this->mMinify, $params);
		$URLs = array();

		if($combine !== null ? $combine : $this->mCombine) {
			// "minify" is a special parameter that can be set only when initialising object and can not be overwritten per request
			if($minify !== null ? !$minify : !$this->mMinify) {
				$params['minify'] = false;
			} else {
				unset($params['minify']);
			}

			// check for an #external_ URL being in the package (BugId:9522)
			$isEmpty = true;
			foreach($assets as $asset) {
				if (substr($asset, 0, 10) == '#external_') {
					$URLs[] = substr($asset, 10);
				} else {
					$isEmpty = false;
				}
			}

			// add info about noexternals mode to AssetsManager URL (BugId:28143)
			global $wgNoExternals;
			if (!empty($wgNoExternals)) {
				$params['noexternals'] = 1;
			}

			// When AssetsManager works in "combine" mode return URL to the combined package
			if ( !$isEmpty ) {
				$url = $prefix . $this->getAMLocalURL('group', $groupName, $params);

				// apply domain sharding
				$url = wfReplaceAssetServer( $url );

				$URLs[] = $url;
			}
		} else {
			foreach($assets as $asset) {
				if(substr($asset, 0, 10) == '#external_') {
					$url = substr($asset, 10);
				} else if(Http::isValidURI($asset)) {
					$url = $asset;
				} else {
					// We always need to use common host for static assets since it has
					// the information about the slot which is otherwise not available
					// in varnish (BugId: 33905)
					$url = $this->getOneCommonURL($asset,$minify);
				}
				// apply domain sharding
				$url = wfReplaceAssetServer( $url );

				$URLs[] = $url;
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
		global $wgCdnRootUrl;
		if (($combine !== null ? $combine : $this->mCombine) || ($minify !== null ? $minify : $this->mMinify)) {
			return $this->getGroupURL($groupName, $params, $wgCdnRootUrl, $combine, $minify);
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
		global $wgCdnRootUrl;
		if ( ( $combine !== null ? $combine : $this->mCombine ) || ( $minify !== null ? $minify : $this->mMinify ) ) {
			return $this->getGroupsURL( $groupNames, $params, $wgCdnRootUrl, $combine, $minify );
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
		global $wgAssetsManagerQuery;
		$url = sprintf($wgAssetsManagerQuery,
			/* 1 */ $type,
			/* 2 */ $oid,
			/* 3 */ !empty($params) ? urlencode(http_build_query($params)) : '-',
			/* 4 */ $this->mCacheBuster);
		return $url;
	}

	public function getAllowedAssetExtensions(){
		return $this->mAllowedAssetExtensions;
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

		// ResourceLoader has its own skin filtering mechanism, skip the check for /__load/ URLs - CON-2113
		if ( strpos( $url, '/__load/' ) !== false ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		//lazy loading of AssetsConfig
		$this->loadConfig();
		$group = null;
		$strict = $skin->isStrict();

		if ( is_string( $url ) && array_key_exists($url, $this->mGeneratedUrls) ) {
			$group = $this->mGeneratedUrls[$url];
		} else {
			/**
			 * One of the following scenarios:
			 * - the url passed in is not a string
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

		$check = $this->checkIfGroupForSkin($group, $skin);

		wfProfileOut( __METHOD__ );
		return $check;
	}

	/**
	 * Checks if given asset's group should be loaded for provided skin
	 * @param string $group - Asset Manager group name
	 * @param Skin $skin - skin instance
	 * @return bool whether group should be loaded for given skin
	 */
	public function checkIfGroupForSkin($group, Skin $skin) {
		$this->loadConfig();
		$skinName = $skin->getSkinName();
		$registeredSkin = $this->mAssetsConfig->getGroupSkin( $group );
		$check = ( is_array( $registeredSkin ) ) ?
			in_array( $skinName, $registeredSkin ) : $skinName === $registeredSkin;
		//if not strict packages with no skin registered are positive
		if ( ( $skin instanceof WikiaSkin ) && ( $skin->isStrict() === false ) ) {
			$check = $check || empty( $registeredSkin );
		}
		return $check;
	}

	/**
	 * Returns a multi-type requested resources, @see AssetsManager.js
	 *
	 * @param Array $options an hash with the following keys:
	 * templates - an array of hashes with the following fields: controllerName, methodName and an optional params
	 * styles - comma-separated list of SASS files
	 * scripts - comma-separated list of AssetsManager groups
	 * messages - comma-separated list of JSMessages packages (messages are registered automagically)
	 * mustache - comma-separated paths to Mustache templates
	 * ttl - cache period for both varnish and browser (in seconds)
	 *
	 * @param bool $local wheter to fetch the URL with or without domain
	 *
	 * @return string the multi-type URL
	 *
	 * @throws WikiaException in case of empty request
	 *
	 * @example
	 * 	AssetsManager::getInstance()->getMultiTypePackageURL( array (
	 *		'messages' => 'EditPageLayout',
	 *		'scripts' => 'oasis_jquery,yui',
	 *		'styles' => 'path/to/style/file',
	 * 		'mustache' => 'path/to/MyController_index.mustache',
	 *		'templates' => array(
	 *			array(
	 *				'controller' => 'UserLoginSpecialController',
	 *				'method' => 'index',
	 *				'param' => array(
	 *					'useskin' => 'wikiamobile'
	 *				)
	 *			)
	 *		)
	 *	) );
	 */
	public function getMultiTypePackageURL( Array $options, $local = false ) {
		wfProfileIn( __METHOD__ );

		global $wgServer, $wgStyleVersion;
		$request = [];

		//WARNING: the following code  MUST mirror the order of properties as in AssetsManager.js!!!
		if ( !empty( $options['styles'] ) ) {
			$request['styles'] = is_array($options['styles']) ? join(',', $options['styles']) : $options['styles'];
		}

		if ( !empty( $options['scripts'] ) ) {
			$request['scripts'] = is_array($options['scripts']) ? join(',', $options['scripts']) : $options['scripts'];
		}

		if ( !empty( $options['messages'] ) ) {
			$request['messages'] = is_array($options['messages']) ? join(',', $options['messages']) : $options['messages'];
		}

		if ( !empty( $options['mustache'] ) ) {
			$request['mustache'] = is_array($options['mustache']) ? join(',', $options['mustache']) : $options['mustache'];
		}

		if ( !empty( $options['templates'] ) ) {
			$request['templates'] = ( is_array( $options['templates'] ) || is_object( $options['templates'] ) ) ?
				json_encode( $options['templates'] ) :
				$options['templates'];
		}

		if ( !empty( $options['params'] ) && is_array( $options['params'] ) ) {
			foreach ( $options['params'] as $name => $val ) {
				$request[$name] = $val;
			}
		}

		if ( !empty( $options['ttl'] ) ) {
			$request['ttl'] = $options['ttl'];
		}

		$request['cb'] = $wgStyleVersion;

		if ( !empty( $request ) ) {
			$url = ( empty( $local ) ) ? $wgServer : '';
			$url .= "/wikia.php?controller=AssetsManager&method=getMultiTypePackage&format=json";

			foreach ( $request as $key => $item ) {
				$url .= "&{$key}=" . urlencode( $item );
			}

			wfProfileOut( __METHOD__ );
			return $url;
		} else {
			wfProfileOut( __METHOD__ );
			throw new WikiaException( 'No resources to load specified' );
		}
	}

	/**
	 * Gets the URL and converts it to minified one if it points to single static file (JS or CSS)
	 * If it's not recognized as static asset the original URL is returned
	 *
	 * @param $url string URL to be inspected
	 * @return string
	 */
	public function minifySingleAsset( $url ) {
		global $wgAllInOne, $wgExtensionsPath, $wgStylePath, $wgResourceBasePath;

		if ( !empty( $wgAllInOne ) ) {
			static $map;
			if (empty($map)) {
				$map = [
					[ $wgExtensionsPath, 'extensions/' ],
					[ $wgStylePath, 'skins/' ],
					// $wgResourceBasePath = $wgCdnStylePath (there's no /resources in it)
					[ $wgResourceBasePath . '/resources', 'resources/' ],
				];
			}

			// BugId:38195 - don't minify already minified assets
			if (strpos($url, '/__am/') !== false) {
				return $url;
			}

			// don't minify already minified JS files
			if (strpos($url, '.min.js') !== false) {
				return $url;
			}

			foreach ($map as $item) {
				list( $prefix, $replacement ) = $item;

				// BugId: 38195 - wgExtensionPath / stylePath / ResourceBasePath do not end with a slash
				// add one to remove double slashes in resulting URL
				$prefix .= '/';

				if (startsWith($url, $prefix)) {
					$nurl = substr($url,strlen($prefix));
					$matches = array();
					if (preg_match("/^([^?]+)/",$nurl,$matches)) {
						if (preg_match("/\\.(css|js)\$/i",$matches[1])) {
							return $this->getOneCommonURL($replacement . $matches[1], true);
						}
					}
				}
			}
		}
		return $url;
	}
}
