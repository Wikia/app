<?php
/**
 * Groups all Wikia-specific hook handlers called by Resource Loader
 *
 * @package Wikia
 * @author macbre
 * @author Wladyslaw Bodzek
 */

use Wikia\Logger\WikiaLogger;

class ResourceLoaderHooks {

	const TIMESTAMP_PRECISION = 900; // 15 minutes

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
	 * @param ResourceLoader $resourceLoader Object to configure
	 * @throws MWException
	 */
	static public function onResourceLoaderRegisterModules( ResourceLoader $resourceLoader ) {
		global $wgCdnRootUrl;

		$sources = $resourceLoader->getSources();

		// Do not use shared domain for shared assets for dev env
		if ( Wikia::isDevEnv() ) {
			$resourceLoader->addSource( 'common', $sources['local'] );
			return;
		}

		// Use shared domain name "common" source
		$sources['common'] = [
			'loadScript' => "$wgCdnRootUrl/__load/-/",
			'apiScript' => $sources['local']['apiScript'],
		];

		$resourceLoader->addSource( 'common', $sources['common'] );
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
		global $wgResourceLoaderAssetsSkinMapping, $wgOasisLoadCommonCSS, $wgLoadCommonCSS;

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
		// TODO: Remove $wgOasisLoadCommonCSS after renaming it to $wgLoadCommonCSS in WF after release
		if ( ( $skinName === 'oasis' ) && empty( $wgOasisLoadCommonCSS ) && empty( $wgLoadCommonCSS ) ) {
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
		return true;
	}

	public static function onAlternateResourceLoaderURL( &$loadScript, &$query, &$url, $modules ) {
		global $wgEnableLocalResourceLoaderLinks;
		$resourceLoaderInstance = self::getResourceLoaderInstance();

		$source = false;
		foreach ($modules as $moduleName) {
			$module = $resourceLoaderInstance->getModule($moduleName);

			if ( !$module ) {
				continue;
			}

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

		if ( substr($loadScript,-1) == '/' ) {
			// shared asset loaded from shared domain

			$loadQuery = $query;
			$modules = $loadQuery['modules'];
			unset($loadQuery['modules']);

			$params = urlencode(http_build_query($loadQuery));
			$url = $loadScript . "$params/$modules";
		} else {
			// just a copy&paste from ResourceLoader::makeLoaderURL :-(
			$url = wfAppendQuery( $loadScript, $query ) . '&*';
		}
		if ( !$wgEnableLocalResourceLoaderLinks ) {
			$url = wfExpandUrl( $url, PROTO_RELATIVE );
		}

		return false;
	}

	public static function onResourceLoaderMakeQuery( $modules, &$query ) {
		// PER-58: append CB value to RL query
		global $wgStyleVersion;
		if ( !empty( $query['version'] ) ) {
			$query['version'] = $wgStyleVersion . "-" . $query['version'];
		} else {
			$query['cb'] = $wgStyleVersion;
		}

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

	/**
	 * Customize caching policy for RL modules
	 *
	 * * cache "static" modules for 30 days when cb param in the URL matches $wgStyleVersion
	 * * cache "dynamic" modules for 30 days when version param is present in the URL and matches $mtime timestamp
	 * * otherwise fallback to caching for 5 minutes
	 *
	 * @see BAC-1241
	 *
	 * @param ResourceLoader $rl
	 * @param ResourceLoaderContext $context
	 * @param $mtime int UNIX timestamp from module(s) calculated from filesystem
	 * @param $maxage int UNIX timestamp for maxage
	 * @param $smaxage int UNIX timestamp for smaxage
	 * @return bool it's a hook
	 */
	public static function onResourceLoaderModifyMaxAge(ResourceLoader $rl, ResourceLoaderContext $context, $mtime, &$maxage, &$smaxage) {
		global $wgStyleVersion, $wgResourceLoaderMaxage;

		// parse cb and version provided as URL parameters
		// version%3D123456-20140220T090000Z
		// cb%3D123456%26
		$version = explode('-', (string) $context->getVersion(), 2);

		if (count($version) === 2) {
			list($cb, $ts) = $version;
			$ts = strtotime($ts); // convert MW to UNIX timestamp
		}
		else {
			$cb = $context->getRequest()->getVal('cb', false);
			$ts = 0;
		}

		// check if at least one of required modules serves dynamic content
		$hasDynamicModule = false;
		$modules = $context->getModules();

		foreach($modules as $moduleName) {
			if (!($rl->getModule($moduleName) instanceof ResourceLoaderFileModule) ) {
				$hasDynamicModule = true;
				break;
			}
		}

		if ($hasDynamicModule) {
			// use long TTL when version value matches $mtime passed to the hook
			$useLongTTL = !empty($ts) && ($ts <= $mtime);
		}
		else {
			// use long TTL when cache buster value from URL matches $wgStyleVersion
			$useLongTTL = !empty($cb) && ($cb <= $wgStyleVersion);
		}

		// modify caching times
		if (!$useLongTTL) {
			WikiaLogger::instance()->info( 'rl.shortTTL', [
				'modules' => join(',', $modules),
				'cb' => $cb,
				'ts' => $ts ?: 0,
			]);
		}

		$cachingTimes = $wgResourceLoaderMaxage[$useLongTTL ? 'versioned' : 'unversioned'];
		$maxage  = $cachingTimes['client'];
		$smaxage = $cachingTimes['server'];

		return true;
	}

	/**
	 * Round timestamps to 15 minutes to make Varnish entries consistent across nodes
	 *
	 * @param $timestamp int timestamp to normalize
	 * @return int normalized timestamp
	 *
	 * @author macbre
	 * @see BAC-1153
	 */
	public static function normalizeTimestamp($timestamp) {
		return intval( floor( $timestamp / self::TIMESTAMP_PRECISION ) * self::TIMESTAMP_PRECISION );
	}
}
