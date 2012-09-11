<?php
/**
 * Groups all Wikia-specific hook handlers called by Resource Loader
 *
 * @package Wikia
 * @author macbre
 * @author Wladyslaw Bodzek
 */
class ResourceLoaderHooks {

	static protected $resourceLoaderInstance;

	/**
	 * @static
	 * @return ResourceLoader
	 */
	static protected function getResourceLoaderInstance() {
		if ( empty( self::$resourceLoaderInstance ) ) {
			self::$resourceLoaderInstance = new ResourceLoader();
		}
		return self::$resourceLoaderInstance;
	}

	/**
	 * Configure Wikia-specific settings in ResourceLoader
	 *
	 * @static
	 * @param ResourceLoader $resourceLoader Object to configure
	 * @return bool true because it's a hook
	 */
	static public function onResourceLoaderRegisterModules( ResourceLoader $resourceLoader ) {
		global $wgScriptPath, $wgScriptExtension, $wgMedusaHostPrefix, $wgCdnRootUrl, $wgDevelEnvironment,
			   $wgStagingEnvironment, $wgCityId, $wgEnableResourceLoaderRewrites;

		$sources = $resourceLoader->getSources();

		// staff and internal special case
		if ( $wgCityId === null ) {
			$resourceLoader->addSource('common',$sources['local']);
			return true;
		}

		// Determine the shared domain name
		$isProduction = empty($wgDevelEnvironment) && empty($wgStagingEnvironment);
		if ( $isProduction ) {
			$host = 'http://' . (empty($wgMedusaHostPrefix) ? 'community.' : $wgMedusaHostPrefix) . 'wikia.com';
		} else {
			$host = $wgCdnRootUrl;
		}

		// Feed RL with the "common" source
		$scriptUri = "$host{$wgScriptPath}/load{$wgScriptExtension}";
		$apiUri = "$host{$wgScriptPath}/api{$wgScriptExtension}";
		$sources['common'] = array(
			'loadScript' => $scriptUri,
			'apiScript' => $sources['local']['apiScript'],
		);

		if ( !empty( $wgEnableResourceLoaderRewrites ) ) {
			// rewrite local source
			$url = $sources['local']['loadScript'];
			$url = str_replace("/load{$wgScriptExtension}","/__load/-/",$url);
			$sources['local']['loadScript'] = $url;
			// rewrite common source
			$url = $sources['common']['loadScript'];
			$url = str_replace("/load{$wgScriptExtension}","/__load/-/",$url);
			if ( $isProduction ) {
				$url = str_replace($host,$wgCdnRootUrl,$url);
			}
			$sources['common']['loadScript'] = $url;
		}

		$resourceLoader->setSource('local',$sources['local']);
		$resourceLoader->addSource('common',$sources['common']);

		return true;
	}

	/**
	 * Filter out user options which will be emitted as inline <script> tag
	 * by ResourceLoader (BugId:33294)
	 *
	 * @author macbre
	 *
	 * @static
	 * @param ResourceLoaderContext $context ResourceLoader context
	 * @param array $options user options to be filtered out
	 * @return bool true because it's a hook
	 */
	static public function onResourceLoaderUserOptionsModuleGetOptions( ResourceLoaderContext $context, array &$options ) {
		wfProfileIn(__METHOD__);
		#wfDebug(__METHOD__ . 'user options count (before): ' . count($options) . "\n");

		$whitelist = User::getDefaultOptions();

		// returns an array containing all the entries of $options which have keys that are present in $whitelist
		$options = array_intersect_key($options, $whitelist);

		#wfDebug(__METHOD__ . 'user options count (after): ' . count($options) . "\n");
		wfProfileOut(__METHOD__);
		return true;
	}

	static public function onResourceLoaderFileModuleConcatenateScripts( &$script ) {
		$script = preg_replace('#^.*@Packager\\.RemoveLine.*$#m', '', $script);

		return true;
	}

	/**
	 * @static
	 * @param $module
	 * @param ResourceLoaderContext $context
	 * @param $pages
	 * @return bool
	 */
	public static function onResourceLoaderSiteModuleGetPages( $module, $context, &$pages ) {
		global $wgResourceLoaderAssetsSkinMapping;

		// handle skin name changes
		$skinName = $context->getSkin();
		if ( isset( $wgResourceLoaderAssetsSkinMapping[$skinName] ) ) {
			$mappedName = $wgResourceLoaderAssetsSkinMapping[$skinName];
			$mapping = array(
				'MediaWiki:' . ucfirst( $skinName ) . '.js'
				=> 'MediaWiki:' . ucfirst( $mappedName ) . '.js',
				'MediaWiki:' . ucfirst( $skinName ) . '.css'
				=> 'MediaWiki:' . ucfirst( $mappedName ) . '.css'
			);
			$pages = Wikia::renameArrayKeys($pages,$mapping);
		}

		// Wikia doesn't include Mediawiki:Common.css in Oasis
		// lower-case skin name is returned by getSkin()
		if ( $skinName == 'oasis' ) {
			unset($pages['MediaWiki:Common.css']);
		}

		// todo: add user-defined site scripts here

		return true;
	}

	/**
	 * @static
	 * @param $module
	 * @param ResourceLoaderContext $context
	 * @param $userpage
	 * @param $pages
	 * @return bool
	 */
	public static function onResourceLoaderUserModuleGetPages( $module, $context, $userpage, &$pages ) {
		global $wgResourceLoaderAssetsSkinMapping;

		// handle skin name changes
		$skinName = $context->getSkin();
		if ( isset( $wgResourceLoaderAssetsSkinMapping[$skinName] ) ) {
			$mappedName = $wgResourceLoaderAssetsSkinMapping[$skinName];
			$mapping = array(
				"$userpage/" . $skinName . '.js'
				=> "$userpage/" . $mappedName . '.js',
				"$userpage/" . $skinName . '.css'
				=> "$userpage/" . $mappedName . '.css'
			);
			$pages = Wikia::renameArrayKeys($pages,$mapping);
		}

		// todo: add user-defined user scripts here

		return true;
	}

	public static function onResourceLoaderCacheControlHeaders( $context, $maxage, $smaxage, $exp ) {
		header( "X-Pass-Cache-Control: public, max-age=$maxage, s-maxage=$smaxage" );
		header( 'X-Pass-Expires: ' . wfTimestamp( TS_RFC2822, $exp + time() ) );

		return true;
	}

	public static function onAlternateResourceLoaderURL( &$loadScript, &$query, &$url, $modules ) {
		$resourceLoaderInstance = self::getResourceLoaderInstance();

		$source = false;
		foreach ($modules as $moduleName) {
			$module = $resourceLoaderInstance->getModule($moduleName);

			$moduleSource = $module->getSource();

			if ($source === false) {
				// first module is being inspected
				$source = $moduleSource;
			} elseif ($source !== $moduleSource) {
				// if there are at least two different sources used just fall back
				// to use local source
				$source = 'local';
				break;
			}
		}
		if ( empty($source) ) {
			$source = 'local';
		}

		$sources = $resourceLoaderInstance->getSources();
		$loadScript = $sources[$source]['loadScript'];

		// this is triggered only when $wgEnableResourceLoaderRewrites is set
		if ( substr($loadScript,-1) == '/' ) {
			$loadQuery = $query;
			$modules = $loadQuery['modules'];
			unset($loadQuery['modules']);

			$params = urlencode(http_build_query($loadQuery));
			$url = $loadScript . "$params/$modules";
			$url = wfExpandUrl( $url, PROTO_RELATIVE );

			return false;
		}

		return true;
	}

	public static function onResourceLoaderMakeQuery( $modules, &$query ) {
		$only = isset($query['only']) ? $query['only'] : null;

		if ( empty( $only ) || $only == 'styles' ) {
			$resourceLoaderInstance = self::getResourceLoaderInstance();
			$requireSass = false;
			foreach ($modules as $moduleName) {
				$module = $resourceLoaderInstance->getModule($moduleName);
				if ( $module->getFlag('sass') ) {
					$requireSass = true;
					break;
				}
			}

			if ( $requireSass ) {
				$sassParams = SassUtil::getSassSettings();
				foreach ($sassParams as $key => $value) {
					$query['sass_'.$key] = (string)$value;
				}
			}
		}

		return true;
	}

}
