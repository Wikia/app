<?php
/**
 * @package MediaWiki
 * @author: Sean Colombo, Owen Davis
 * @date: 20100107
 */

if(!defined('MEDIAWIKI')) die("Not a valid entry point.");

// Hooks
$dir = __DIR__ . '/';

if (!empty($wgRunningUnitTests) && $wgNoDBUnits) {
	Language::$dataCache = new FakeCache();
	$wgHooks['WikiFactory::execute'] = ["wfUnitForceWiki"];
} else {
	$wgHooks['WikiFactory::execute'][] = "wfDevBoxForceWiki";
}

$wgHooks['WikiFactory::executeBeforeTransferToGlobals'][] = "wfDevBoxDisableWikiFactory";
$wgHooks['ResourceLoaderGetConfigVars'][] = 'wfDevBoxResourceLoaderGetConfigVars';
$wgExceptionHooks['MWExceptionRaw'][] = "wfDevBoxLogExceptions";

// Asset manaager and ajax requests come in "too early" for the rest of config
// So we need a fallback global domain.  This is kind of a hack, fixme.
$wgDevboxDefaultWikiDomain = 'www.wikia.com';

if (getenv('wgDevelEnvironmentName')) {
	$wgDevelEnvironmentName = getenv('wgDevelEnvironmentName');
} else {
	# PLATFORM-1737 (Allow multiple dashes on dev hostnames)
	# Get first hyphen, if there's any, delete it and everything from the left side of that "-", else pass whole $host
	$host = gethostname();
	$index = stripos($host, "-");
	if($index > 0) {
		$wgDevelEnvironmentName = trim(substr($host, $index + 1));
	} else {
		$wgDevelEnvironmentName = trim($host);
	}
}

/**
 * Hooks into WikiFactory to force use of the wiki which the developer
 * has explicitly set using this panel (if applicable).
 *
 * @param WikiFactoryLoader $wikiFactoryLoader
 *
 * @return boolean true to allow the WikiFactoryLoader to do its other necessary initalization.
 *
 * @throws DBQueryError
 * @throws MWException
 */
function wfDevBoxForceWiki(WikiFactoryLoader $wikiFactoryLoader){
	global $wgDevelEnvironment, $wgExternalSharedDB, $wgCommandLineMode, $wgDevboxDefaultWikiDomain;
	if($wgDevelEnvironment){
		$forcedWikiDomain = getForcedWikiValue();
		$cityId = WikiFactory::DomainToID($forcedWikiDomain);
		if(!$cityId){
			// If the overridden name doesn't exist AT ALL, use a default just to let the panel run.
			$forcedWikiDomain = $wgDevboxDefaultWikiDomain;
			$cityId = WikiFactory::DomainToID($forcedWikiDomain);

			wfDebug(__METHOD__ . ": domain forced to {$forcedWikiDomain}\n");
		}

		if($wgCommandLineMode) {

			$cityId = getenv( "SERVER_ID" );
			if( is_numeric( $cityId ) ) {
				$wikiFactoryLoader->mCityID = $cityId;
				$wikiFactoryLoader->mWikiID = $cityId;
			}
			else {
				$dbName = getenv( "SERVER_DBNAME" );
				/**
				 * find city_id by database name
				 */
				$dbr = WikiFactory::db( DB_SLAVE );
				$cityId = $dbr->selectField(
					"city_list",
					array( "city_id" ),
					array( "city_dbname" => $dbName ),
					__METHOD__
				);
				if( is_numeric( $cityId ) ) {
					$wikiFactoryLoader->mCityID = $cityId;
					$wikiFactoryLoader->mWikiID = $cityId;
				}
			}
		}

		if($cityId){
			$wikiFactoryLoader->mServerName = $forcedWikiDomain;

			// Need to set both in order to get our desired effects.
			$wikiFactoryLoader->mCityID = $cityId;
			$wikiFactoryLoader->mWikiID = $cityId;
		}

		// This section allows us to use c1 or c2 as a source for wiki databases
		// Be aware that this means the database has to be loaded in the right cluster according to wikicities!
		$db = WikiFactory::db( DB_SLAVE );
		$cluster = $db->selectField( 'city_list', 'city_cluster', [ 'city_id' => $cityId ], __METHOD__ );
		$wikiFactoryLoader->mVariables["wgDBcluster"] = $cluster;

		// Final sanity check to make sure our database exists
		if ($forcedWikiDomain != $wgDevboxDefaultWikiDomain) {
			// check if the wiki exist on a cluster
			wfDebug( __METHOD__ . ": checking if wiki #{$cityId} exists on {$cluster} cluster...\n" );

			$dbname = WikiFactory::DomainToDB($forcedWikiDomain);
			$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB . '_' . $cluster );

			$res = $db->query( 'SHOW DATABASES ' . $db->buildLike($dbname), __METHOD__ ); // SHOW DATABASES LIKE 'muppet'

			if ( $res->numRows() === 0 ) {
				header( 'HTTP/1.1 503' );
				header( 'X-Error: missing database' );
				header( 'Content-Type: text/plain' );

				die( "No local copy of database [$dbname] was found on {$cluster} cluster [using {$db->getServer()} DB]." );
			}
		}
	}
	return true;
}

function wfUnitForceWiki(){
	global $wgDevelEnvironmentName, $wgDBcluster;
	$wgDevelEnvironmentName = 'test';
	$wgDBcluster = '';
	return false;
}


function wfDevBoxResourceLoaderGetConfigVars( &$vars ) {
	global $wgDevelEnvironment, $wgWikiaDatacenter;

	$vars['wgDevelEnvironment'] = $wgDevelEnvironment;
	$vars['wgWikiaDatacenter'] = $wgWikiaDatacenter;

	return true;
}

function wfDevBoxLogExceptions( $errorText ) {
	Wikia::logBacktrace("wfDevBoxLogExceptions");
	Wikia::log($errorText);
	return $errorText;
}

/**
 * @return String full domain of wiki which this dev-box should behave as.
 *
 * Hostname scheme: override.developer.wikia-dev.com
 * Example: muppet.owen.wikia-dev.com -> muppet.wikia.com
 * Example: es.gta.owen.wikia-dev.com -> es.gta.wikia.com
 * Example: muppet.wikia.com -> muppet.wikia.com
 */
function getForcedWikiValue(){
	global $wgDevDomain;

	if ( !isset( $_SERVER['HTTP_HOST'] ) ) {
		return '';
	}

	// This is an attempt to match "devbox" host names
	if ( strpos( $_SERVER['HTTP_HOST'], $wgDevDomain) !== false ) {
		$site = str_replace( '.' . $wgDevDomain, '', $_SERVER['HTTP_HOST'] );
		return "$site.wikia.com";
	}

	// Otherwise assume it's a wiki and try it anyway
	return $_SERVER['HTTP_HOST'];
}

/**
 * "Disable" WikiFactory wiki-specific settings when $wgDevboxSkipWikiFactoryVariables = true
 *
 * @author macbre
 *
 * @param WikiFactoryLoader $wikiFactoryLoader
 * @return bool true
 */
function wfDevBoxDisableWikiFactory(WikiFactoryLoader $wikiFactoryLoader) {
	global $wgDevboxSkipWikiFactoryVariables;

	if (!empty($wgDevboxSkipWikiFactoryVariables)) {
		wfDebug(__METHOD__ . ": WikiFactory settings are disabled!\n");

		$whitelist = array(
			'wgDBcluster',
			'wgDBname',
			'wgSitename',
			'wgArticlePath',
			'wgUploadPath',
			'wgUploadDirectory',
			'wgLogo',
			'wgFavicon',
			'wgLanguageCode'
		);

		foreach($wikiFactoryLoader->mVariables as $key => $value) {
			if (!in_array($key, $whitelist)) {
				unset($wikiFactoryLoader->mVariables[$key]);
			}
		}
	}

	return true;
}

/**
 * Vary memcache by devbox
 *
 * We append wfWikiID() here as wfMemcKey() uses
 * $wgCachePrefix or wfWikiID() if the first one is not set
 *
 * Sessions are shared between devboxes
 *
 * E.g. memcached: get(dev-macbre-plpoznan:revisiontext:textid:96888)
 *
 * @author macbre
 * @see PLATFORM-1401
 * @see https://github.com/Wikia/app/pull/5842
 */
$wgHooks['WikiFactory::onExecuteComplete'][] = function () {
	global $wgCachePrefix, $wgSharedKeyPrefix, $wgDevelEnvironmentName;

	$wgCachePrefix = 'dev-' . $wgDevelEnvironmentName . '-' . wfWikiID(); // e.g. dev-macbre-muppet / dev-macbre-glee / ...
	$wgSharedKeyPrefix = 'dev-' . $wgDevelEnvironmentName . '-' . $wgSharedKeyPrefix; // e.g. dev-macbre-wikicities

	return true;
};
