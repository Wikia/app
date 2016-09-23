<?php
/**
 * @package MediaWiki
 * @author: Sean Colombo, Owen Davis
 * @date: 20100107
 *
 * This panel will help developers administer their dev-boxes
 * more easily.  This includes the ability to see what databases
 * are currently available locally and to easily pull new databases
 * in from production slaves.
 *
 * This panel will only work on systems where $wgDevelEnvironment is set to true.
 *
 * Prerequisite: need to have the 'devbox' user on your editable (usually localhost) database.
 * Look in the private svn's wikia-conf/DevBoxDatabase.php for the query to use.
 *
 *
 * TODO: GUI for setting which local databases will override the production slaves.
 *
 * TODO: Programmatically install a link in the User Links for the Dev Box Panel
 */

if(!defined('MEDIAWIKI')) die("Not a valid entry point.");

// Credentials for the editable (not public) devbox database.
//require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DevBoxDatabase.php' );

$wgSpecialPageGroups['DevBoxPanel'] = 'wikia';

// Hooks
$dir = __DIR__ . '/';
$wgExtensionMessagesFiles['DevBoxPanel'] = $dir.'Special_DevBoxPanel.i18n.php';

if (!empty($wgRunningUnitTests) && $wgNoDBUnits) {
	Language::$dataCache = new FakeCache();
	$wgHooks['WikiFactory::execute'] = ["wfUnitForceWiki"];
} else {
	$wgHooks['WikiFactory::execute'][] = "wfDevBoxForceWiki";
}

$wgHooks['WikiFactory::executeBeforeTransferToGlobals'][] = "wfDevBoxDisableWikiFactory";
$wgHooks['ResourceLoaderGetConfigVars'][] = 'wfDevBoxResourceLoaderGetConfigVars';
$wgExceptionHooks['MWExceptionRaw'][] = "wfDevBoxLogExceptions";

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'DevBoxPanel',
	'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
	'description' => 'This extension makes it easier to administer a Wikia Dev Box.',
	'version' => '0.0.3',
);

$wgSpecialPages['DevBoxPanel'] = 'DevBoxPanel';

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

// Asset manaager and ajax requests come in "too early" for the rest of config
// So we need a fallback global domain.  This is kind of a hack, fixme.
$wgDevboxDefaultWikiDomain = 'www.wikia.com';

class DevBoxPanel extends SpecialPage {
	public function __construct(){
		// macbre: don't run code below when running in command line mode (memcache starts to act strange) - NOTE: This macbre code was in a different spot... this may be fixed implicitly now.
		if (!empty($wgCommandLineMode)) {
			return;
		}

		parent::__construct('DevBoxPanel');
	}

	/**
	 * The main function of the SpecialPage.  Adds the content for the page
	 * to the wgOut global.
	 */
	function execute($par) {
		global $wgOut,$wgExtensionsPath,$wgDevelEnvironment,$wgUser;

		if( !$wgUser->isAllowed( 'devboxpanel' ) ) {
			throw new PermissionsError( 'devboxpanel' );
		}

		$wgOut->addStyle( "$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.css" );
		$wgOut->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.js'></script>");

		$wgOut->setPageTitle(wfMsg("devbox-title"));
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		if($wgDevelEnvironment){
			$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$tmpl->set_vars(array(
								"dbComparisonHtml" => getHtmlForDatabaseComparisonTool(),
								"infoHtml"			=> getHtmlForInfo(),
								"footer"			  => wfMsg("devbox-footer", __FILE__),
								));
			$wgOut->addHTML($tmpl->render('special-devboxpanel'));
		} else {
			$wgOut->addHTML(wfMsg('devbox-panel-not-enabled'));
		}

	} // end execute()

} // end class DevBoxPanel

/**
 * Hooks into WikiFactory to force use of the wiki which the developer
 * has explicitly set using this panel (if applicable).
 *
 * @return boolean true to allow the WikiFactoryLoader to do its other necessary initalization.
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
			$db = wfGetDB( DB_MASTER, [], $wgExternalSharedDB . '_' . $cluster ); // force master - @see PLATFORM-528

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
} // end wfDevBoxForceWiki()

function wfUnitForceWiki(){
	global $wgDevelEnvironmentName, $wgDBcluster;
	$wgDevelEnvironmentName = 'test';
	$wgDBcluster = '';
	return false;
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

function wfDevBoxResourceLoaderGetConfigVars( &$vars ) {
	global $wgDevelEnvironment;

	$vars['wgDevelEnvironment'] = $wgDevelEnvironment;

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
	global $wgDevelEnvironmentName;

	if (!isset($_SERVER['HTTP_HOST'])) {
		return '';
	}

	// This is an attempt to match "devbox" host names
	if (strpos($_SERVER['HTTP_HOST'], "wikia-dev.com") !== false){
		$site = str_replace('.' . $wgDevelEnvironmentName . '.wikia-dev.com', '', $_SERVER['HTTP_HOST']);
		return "$site.wikia.com";
	}

	// Otherwise assume it's a wiki and try it anyway
	return $_SERVER['HTTP_HOST'];

} // end getForcedWikiValue()


/**
 * @param DatabaseBase $db
 * @return array - databases which are available on this cluster
 *					  use the writable devbox server instead of the production slaves.
 */
function getDevBoxOverrideDatabases(DatabaseBase $db){

	$IGNORE_DBS = array('information_schema', 'mysql', '#mysql50#lost+found', 'wikicities_c2');
	$retval = array();

	$res = $db->query( 'SHOW DATABASES', __METHOD__ );

	while( $row = $res->fetchObject() ) {
		$retval[] = $row->Database;
	}

	$retval = array_diff($retval, $IGNORE_DBS);
	sort($retval);
	return $retval;

} // end getDevBoxOverrideDatabases()


/**
 * Given the domain name of a wiki, finds its server then creates a dump
 * of the content & loads it into a database of the same name locally.
 *
 * REMOVED BY OWEN: this functionality has been replaced by maintenance/wikia/getDatabase.php
 *
 *	function pullProdDatabaseToLocal($domainOfWikiToPull){
 *  }
 */

/**
 * A tool which shows what databases are installed
 * locally as well as which are available from
 * production slaves.  Allows a copy of any of the
 * databases to be dumped on a slave and loaded
 * locally (overwrites existing db if there is
 * already a local version).
 *
 * @return String - HTML for displaying the tool.
 */
function getHtmlForDatabaseComparisonTool(){
	$html = "";

	// Determine what databases are on this dev-box.
	global $wgWikiFactoryDB;

	//$db_dev = wfGetDB( DB_MASTER, "dump", $wgDBname );
	$db1 = wfGetDB( DB_SLAVE, "dump", $wgWikiFactoryDB );
	$db2 = wfGetDB( DB_SLAVE, "dump", $wgWikiFactoryDB . '_c2'); // lame

	$devbox_c1_dbs = getDevBoxOverrideDatabases($db1);
	$devbox_c2_dbs = getDevBoxOverrideDatabases($db2);

	$html .= "<table class='devbox-settings'>";
	$html .= "<tr><th>".wfMsg("devbox-section-existing", "c1")."</th><th>".wfMsg("devbox-section-existing", "c2")."</th></tr>";

	// List the databases on each cluster.
	// If we are not currently overriding the db, make these links
	// If we ARE overriding the db, turn the links off
	for ($i=0; $i < max(count($devbox_c1_dbs) , count($devbox_c2_dbs)); $i++) {
		$html .= "<tr><td width='150'>";
		$cell_value = "";
		if (isset($devbox_c1_dbs[$i])) {
			if (getForcedWikiValue() == "")
				$cell_value = "<a href=\"http://".$devbox_c1_dbs[$i].".".$_SERVER['SERVER_NAME']."\">".$devbox_c1_dbs[$i]."</a>";
			else
				$cell_value = $devbox_c1_dbs[$i];
		}
		$html .= $cell_value;
		$html .= "</td><td width='150'>";
		$cell_value = "";
		if (isset($devbox_c2_dbs[$i])) {
			if (getForcedWikiValue() == "")
				$cell_value = "<a href=\"http://".$devbox_c2_dbs[$i].".".$_SERVER['SERVER_NAME']."\">".$devbox_c2_dbs[$i]."</a>";
			else
				$cell_value = $devbox_c2_dbs[$i];
		}
		$html .= $cell_value;
		$html .= "</td></tr>";
	}
	$html .= "</table>";

	return $html;
} // end getHtmlForDatabaseComparisonTool()

/**
 * Displays settings info
 * All hard to find files, settings, etc. should be here.
 */
function getHtmlForInfo(){
	$html = "";

	global $IP,$wgScriptPath,$wgExtensionsPath,$wgCityId;
	global $wgDBname,$wgExternalSharedDB;

	$settings = array(
		"error_log"				=> ini_get('error_log'),
		"\$IP"					  => $IP,
		"\$wgScriptPath"		 => $wgScriptPath,
		"\$wgExtensionsPath"	=> $wgExtensionsPath,
		"\$wgCityId"			  => $wgCityId,
		"\$wgDBname"			  => $wgDBname,
		"\$wgExternalSharedDB" => $wgExternalSharedDB,
	);
	$html .= "<table class='devbox-settings'>\n";
	$html .= "<tr><th>".wfMsg("devbox-setting-name")."</th><th>".wfMsg("devbox-setting-value")."</th></tr>\n";
	$index = 0;
	foreach($settings as $name => $val){
		$html .= "<tr".($index%2==1?" class='odd'":"").">";
		$html .= "<td width=150>$name</td><td><tt>$val</tt></td>";
		$html .= "</tr>\n";
		$index++;
	}
	$html .= "</table>\n";

	return $html;
} // end getHtmlForInfo()

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
$wgHooks['WikiFactory::onExecuteComplete'][] = function() {
	global $wgCachePrefix, $wgSharedKeyPrefix, $wgDevelEnvironmentName;

	$wgCachePrefix = 'dev-' . $wgDevelEnvironmentName . '-' . wfWikiID(); // e.g. dev-macbre-muppet / dev-macbre-glee / ...
	$wgSharedKeyPrefix = 'dev-' . $wgDevelEnvironmentName . '-' . $wgSharedKeyPrefix; // e.g. dev-macbre-wikicities

	return true;
};
