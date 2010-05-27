<?php
/**
 * @package MediaWiki
 * @author: Sean Colombo
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
 * TODO: Since "local" isn't technically a requirement, make sure to update the comments here to make that clear.  It
 * is quite likely that all of the devbox dbs will be moved to some other server for space reasons relatively soon.
 *
 * TODO: GUI for setting which local databases will override the production slaves.
 *
 * TODO: Programmatically install a link in the User Links for the Dev Box Panel
 */

if(!defined('MEDIAWIKI')) die("Not a valid entry point.");

// Credentials for the editable (not public) devbox database.
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DevBoxDatabase.php' );

// From now on it is assumed that if you're using the DevBoxPanel, you only want to write when you
// are using a locally overridden database.
$wgReadOnly = true;

// TODO: DETERMINE THE CORRECT PERMISSIONS... IS THERE A "DEVELOPERS" GROUP THAT WE ALL ACTUALLY BELONG TO?  WILL WE BE ON ALL WIKIS?
// Permissions
$wgAvailableRights[] = 'devboxpanel';
$wgGroupPermissions['*']['devboxpanel'] = false;
$wgGroupPermissions['user']['devboxpanel'] = false;
$wgGroupPermissions['staff']['devboxpanel'] = true;
$wgGroupPermissions['devboxpanel']['devboxpanel'] = true;

$wgSpecialPageGroups['DevBoxPanel'] = 'wikia';

// Hooks
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['DevBoxPanel'] = $dir.'Special_DevBoxPanel.i18n.php';
$wgHooks['WikiFactory::execute'][] = "wfDevBoxForceWiki";

$wgExtensionFunctions[] = 'wfSetupDevBoxPanel';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'DevBoxPanel',
	'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
	'description' => 'This extension makes it easier to administer a Wikia Dev Box.',
	'version' => '0.0.2',
);

// Definitions
$serv = $_SERVER['SERVER_NAME'];
define('DEVBOX_FORCED_WIKI_KEY', "devbox_forceWiki_$serv");
//define('DEVBOX_FORCED_WIKI_FILE', dirname(__FILE__).'/devbox_forceWiki.txt');
define('DEVBOX_FORCED_WIKI_FILE', "/tmp/$serv"."_devbox_forceWiki.txt");
define('DEVBOX_OVERRIDDEN_DBS_KEY', "devbox_overridden_dbs_$serv");
define('DEVBOX_OVERRIDDEN_DBS_FILE', "/tmp/$serv"."_devbox_overridden_dbs.txt");
define('DEVBOX_OVERRIDDEN_DBS_DELIM', '`'); // delimiter used to separate values in both memory & file (grave is used because it is not allowed in table names)

define('DEVBOX_ACTION', 'panelAction');
define('DEVBOX_ACTION_CHANGE_WIKI', 'devbox-change-wiki');
define('DEVBOX_FIELD_FORCE_WIKI', 'devbox-field-force-wiki');
define('DEVBOX_ACTION_PULL_DB', 'devbox-pull-database');
define('DEVBOX_FIELD_DB_TO_PULL', 'dbToPull');
define('DEVBOX_ACTION_PULL_DOMAIN', 'devbox-pull-domain');
define('DEVBOX_FIELD_DOMAIN_TO_PULL', 'domainToPull');

define('DEVBOX_DEFAULT_WIKI_DOMAIN', 'devbox.wikia.com');
define('DEV_BOX_SERVER_NAME', "devbox-server");

// Doing it as its own cluster didn't work because of some details of how wikicities_[cluster] works.
// Instead, we will try to use the main cluster, but override what server that means.
// TODO: SWAP ME!  This probably is the solution, but there needs to be some testing (and I can't login at the moment).
define('DEV_BOX_CLUSTER', "devbox_section");
//define('DEV_BOX_CLUSTER', "DEFAULT");

function wfSetupDevBoxPanel() {
	global $IP, $wgMessageCache;

	require_once($IP . '/includes/SpecialPage.php');
	SpecialPage::addPage(new SpecialPage('DevBoxPanel', 'devboxpanel', true, 'wfDevBoxPanel', false));
	$wgMessageCache->addMessage('devboxpanel', 'Dev-Box Panel');
}

function devBoxPanelAdditionalScripts( &$out, &$sk ){
	global $wgExtensionsPath,$wgStyleVersion;
	$out->addStyle( "$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.css?$wgStyleVersion" );
	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.js?$wgStyleVersion'></script>");
	return true;
}

/**
 * Hooks into WikiFactory to force use of the wiki which the developer
 * has explicitly set using this panel (if applicable).
 *
 * @return true to allow the WikiFactoryLoader to do its other necessary initalization.
 */
function wfDevBoxForceWiki(&$wikiFactoryLoader){
	global $wgDevelEnvironment;
	if($wgDevelEnvironment){
		$forcedWikiDomain = getForcedWikiValue();
		$cityId = WikiFactory::DomainToID($forcedWikiDomain);
		if(!$cityId){
			// If nothing is configured yet on this devbox, use a default just to let the panel run.
			$forcedWikiDomain = DEVBOX_DEFAULT_WIKI_DOMAIN;
			$cityId = WikiFactory::DomainToID($forcedWikiDomain);
		}
		if($cityId){
			$wikiFactoryLoader->mServerName = $forcedWikiDomain;

			// Need to set both in order to get our desired effects.
			$wikiFactoryLoader->mCityId = $cityId;
			$wikiFactoryLoader->mWikiId = $cityId;
		}
		
		wfDevBoxApplyLocalDatabaseOverrides(&$wikiFactoryLoader);
	}
	return true;
} // end wfDevBoxForceWiki()

/**
 * Applies our mapping of which databases should use localhost as their
 * server instead of the production slaves.  If the current database is
 * using localhost, then this function removes the read-only mode to allow
 * normal usage since this is just a sandbox db on a dev-box.
 */
function wfDevBoxApplyLocalDatabaseOverrides(&$wikiFactoryLoader){
	global $wgLBFactoryConf;

	$databasesToOverride = getDevBoxOverrideDatabases();

	// If the current db is overridden, make sure to override the cluster setting from the database.
	$dbName = WikiFactory::DomainToDB($wikiFactoryLoader->mServerName);
	if(in_array($dbName, $databasesToOverride)){
		$wikiFactoryLoader->mVariables["wgDBcluster"] = DEV_BOX_CLUSTER;

		// Since the currently in-use database is on the devbox server, we can safely remove the read-only setting.
		global $wgReadOnly;
		$wgReadOnly = false;
	} else {
		// Since the currently configured wiki is not pulled yet, show a message that indicates that it must be pulled.
		// We are no longer doing the method where we can read from production slaves if there is no local copy.

		global $wgArticlePath,$wgRequest;
		$title = $wgRequest->getVal('title');
		$pageUrl = str_replace( "$1", urlencode( $title ), $wgArticlePath );		
		$link = "$pageUrl&".DEVBOX_ACTION."=".DEVBOX_ACTION_PULL_DB."&".DEVBOX_FIELD_DB_TO_PULL."=".urlencode($dbName);
		$getIt = "<a href='$link'>".wfMsg("devbox-get-db")."</a>";
		print wfMsg("devbox-no-local-copy", $dbName, $link);

		// Nothing else is going to work without a database, so exit.
		exit;
	}

	// TODO: THIS SECTION PROBABLY WON'T BE NEEDED ANYMORE SINCE DB.sjc-dev CONTAINS THE READABLE DATABASES.
	/*
	// Devbox database credentials (from private svn /wikia-conf/DevBoxDatabase.php).
	global $wgDBdevboxUser,$wgDBdevboxPassword,$wgDBdevboxServer;

	// Modify wgLBFactoryConf using loaded settings...
	$wgLBFactoryConf['sectionLoads'][DEV_BOX_CLUSTER] = array(DEV_BOX_SERVER_NAME => 1);
	$wgLBFactoryConf['hostsByName'][DEV_BOX_SERVER_NAME] = $wgDBdevboxServer;
	$wgLBFactoryConf['readOnlyBySection'][DEV_BOX_CLUSTER] = false;
	$wgLBFactoryConf['templateOverridesByServer'][DEV_BOX_SERVER_NAME] = array(
		'user' => $wgDBdevboxUser,
		'password' => $wgDBdevboxPassword,
	);
	// Makes all of the overridden databases connect to the devbox server instead of prod slaves.
	// This isn't needed to do the override, but it leaves the data in a "correct" state in case other
	// code tries to load from the conf. again.
	foreach($databasesToOverride as $dbName){
		$wgLBFactoryConf['sectionsByDB'][$dbName] = DEV_BOX_CLUSTER;
	}
	*/
} // end wfDevBoxApplyLocalDatabaseOverrides()

/**
 * @return String domain of wiki which this dev-box should behave as. Empty
 *                string if no wiki is forced in which case the domain of
 *                request will be used by WikiFactory to determine what wiki
 *                is being used.
 */
function getForcedWikiValue(){
	global $wgMemc;
	if(!$wgMemc){
		$memc = wfGetCache( CACHE_MEMCACHED );
	} else {
		$memc = $wgMemc;
	}

	$forcedWiki = $memc->get(DEVBOX_FORCED_WIKI_KEY);
	if(!$forcedWiki){
		// File won't exist at first... fail gracefully.
		$forcedWiki = @trim(file_get_contents(DEVBOX_FORCED_WIKI_FILE));
		if($forcedWiki === false){
			$forcedWiki = "";
		}
	}

	return $forcedWiki;
} // end getForcedWikiValue()

/**
 * NOTE: This function does not check whether the forcedWikiName is a real
 * domain name.  That must be done in the calling-code.
 *
 * @param String forcedWikiDomain - the domain of the wiki which this
 *                                  devbox should run as.
 * @return boolean - true on success, false on error
 */
function setForcedWikiValue($forcedWikiName){
	global $wgMemc;
	if(!$wgMemc){
		$memc = wfGetCache( CACHE_MEMCACHED );
	} else {
		$memc = $wgMemc;
	}

	$forcedWikiName = trim($forcedWikiName);

	$retVal = file_put_contents(DEVBOX_FORCED_WIKI_FILE, $forcedWikiName);
	if($retVal !== false){
		$retVal = true; // make success boolean
		$memc->set(DEVBOX_FORCED_WIKI_KEY, $forcedWikiName, strtotime("+5 minute"));
	}
	return $retVal;
} // end setForcedWikiValue()

/**
 * @return array - databases which the developer wants to be overridden to
 *                 use the writable devbox server instead of the production slaves.
 */
function getDevBoxOverrideDatabases(){
	global $wgMemc;
	if(!$wgMemc){
		$memc = wfGetCache( CACHE_MEMCACHED );
	} else {
		$memc = $wgMemc;
	}

	$overDbsRaw = $memc->get(DEVBOX_OVERRIDDEN_DBS_KEY);
	if(!$overDbsRaw){
		// File won't exist at first... fail gracefully.
		$overDbsRaw = @trim(file_get_contents(DEVBOX_OVERRIDDEN_DBS_FILE));
		if($overDbsRaw === false){
			$overDbs = array();
		} else {
			$overDbs = explode(DEVBOX_OVERRIDDEN_DBS_DELIM, $overDbsRaw);
		}
	} else {
		$overDbs = explode(DEVBOX_OVERRIDDEN_DBS_DELIM, $overDbsRaw);
	}

	return $overDbs;
} // end getDevBoxOverrideDatabases()

/**
 * Stores the array of which databases the developer wants to point to
 * the devbox database for (in read/write mode) instead of using the default
 * which is to be in read-only mode from the production slaves.
 *
 * @param overDbs array whose values are the names of the databases to override
 * @return boolean - true on success, false on error
 */
function setDevBoxOverrideDatabases($overDbs){
	global $wgMemc;
	if(!$wgMemc){
		$memc = wfGetCache( CACHE_MEMCACHED );
	} else {
		$memc = $wgMemc;
	}

	if(!is_array($overDbs) || (count($overDbs) == 0)){
		$overDbsRaw = "";
	} else {
		$overDbsRaw = implode(DEVBOX_OVERRIDDEN_DBS_DELIM, $overDbs);
	}
	$retVal = file_put_contents(DEVBOX_OVERRIDDEN_DBS_FILE, $overDbsRaw);
	if($retVal !== false){
		$retVal = true; // make success boolean
		$memc->set(DEVBOX_OVERRIDDEN_DBS_KEY, $overDbsRaw, strtotime("+5 minute"));
	}
	return $retVal;
} // end setDevBoxOverrideDatabases()

/**
 * Given the domain name of a wiki, finds its server then creates a dump
 * of the content & loads it into a database of the same name locally.
 *
 * If the database already exists locally, it will be dropped and completely
 * replaced by whatever is available from the production slaves.
 *
 * NOTE: This function makes the assumption that it is the primary purpose
 * of the current page-load and therefore it completely messes with the
 * configuration settings for this run.  Due to these side-effects, it is
 * recommended that this function be called on a page that's either inside
 * of an iframe or is just an AJAX request.
 *
 * Based largely on Nick's pullDB.bash.
 */
function pullProdDatabaseToLocal($domainOfWikiToPull){
	global $wgCityId,$wgDBserver,$wgDBname,$wgDBuser,$wgDBpassword;
	global $wgExtensionsPath,$wgStyleVersion;
	
	set_time_limit(0);
	
	// Print out a minimal header.
	print "<html>
	<head>
		<title>Pulling $domainOfWikiToPull</title>
		<link rel='stylesheet' type='text/css' href='$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.css?$wgStyleVersion'/>
	</head>
	<body><div style='font-family:courier,\"courier new\",monospaced'>";
	
	// Set the wiki, but with overrides turned off (we're trying to find the production slave
	// for the database).
	$originalOverrides = getDevBoxOverrideDatabases(); // restore these later
	$originalWikiValue = getForcedWikiValue();
	setDevBoxOverrideDatabases(array());
	setForcedWikiValue($domainOfWikiToPull);

	$wikiFactoryLoader = new WikiFactoryLoader();
	$wgCityId = $wikiFactoryLoader->execute();
	
	// Restore the dev-box overrides because they're persistent and we only wanted to temporarily ignore them.
	setDevBoxOverrideDatabases($originalOverrides);
	setForcedWikiValue($originalWikiValue);

	// Everything is configured, now move the data.
	$tmpFile = "/tmp/$wgDBname.mysql.gz";
	print "Dumping \"$wgDBname\" from host \"$wgDBserver\"...<br/>\n";
	$response = `mysqldump --compress --single-transaction --skip-comments --quick -h $wgDBserver -u$wgDBuser -p$wgDBpassword $wgDBname --result-file=$tmpFile 2>&1`;
	if(trim($response) != ""){
		print "<div class='devbox-error'>Database dump returned the following error:\n<em>$response</em></div>\n";
	} else {
		print "Backup created.<br/>\n";
	}
	print "<br/>\n";

	print "Creating database...<br/>\n";
	global $wgDBdevboxUser,$wgDBdevboxPassword,$wgDBdevboxServer;
	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer -e "CREATE DATABASE IF NOT EXISTS $wgDBname" 2>&1`;
	if(trim($response) != ""){
		print "<div class='devbox-error'>CREATE DATABASE attempt returned the error:\n<em>$response</em></div>\n";
	} else {
		print "\"$wgDBname\" created on \"$wgDBdevboxServer\".<br/>\n";
	}
	print "<br/>";
	
	print "Loading \"$wgDBname\" into \"$wgDBdevboxServer\"...<br/>\n";
	$response = `cat $tmpFile | mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer $wgDBname 2>&1`;
	if(trim($response) != ""){
		print "<div class='devbox-error'>Error loading the database dump into $wgDBdevboxServer:\n<em>$response</em></div>\n";
	} else {
		print "<div class='devbox-success'>Database loaded successfully!</div>\n";
	}
	print "<br/>\n";
	
	print "Removing dumpfile...<br/>\n";
	$response = `rm -f $tmpFile 2>&1`;
	if(trim($response) != ""){
		print "<div class='devbox-error'>WARNING: Problem deleting the dump-file:\n<em>$response</em></div>\n";
	}
	print "Done.<br/>\n";

	print "</div></body></html>\n";

	exit; // This is not a normal page!  See function-comment.
} // end pullProdDatabaseToLocal()

/**
 * The main function of the SpecialPage.  Adds the content for the page
 * to the wgOut global. 
 */
function wfDevBoxPanel() {
	global $wgOut,$wgHooks,$wgDevelEnvironment;
	$wgHooks['BeforePageDisplay'][] = 'devBoxPanelAdditionalScripts';

	wfLoadExtensionMessages('DevBoxPanel');
	$wgOut->setPageTitle(wfMsg("devbox-title"));
	$wgOut->setRobotpolicy( 'noindex,nofollow' );
	$wgOut->setArticleRelated( false );
	
	if($wgDevelEnvironment){
		$wgOut->addHTML("<div class='skinKiller'>");

		// Intro
		$wgOut->addHTML("<em>");
		$wgOut->addHTML(wfMsg('devbox-intro'));
		$wgOut->addHTML("</em><br/><br/>");

		// Do any processing of actions here (and display success/error messages).
		global $wgRequest;
		$action = $wgRequest->getVal(DEVBOX_ACTION);
		switch($action){
		case DEVBOX_ACTION_CHANGE_WIKI:
			$forceWiki = $wgRequest->getVal(DEVBOX_FIELD_FORCE_WIKI);

			// TODO: VERIFY THAT forceWiki IS A REAL WIKI AND DISPLAY A WARNING OTHERWISE (and don't save it in that case).
			// TODO: VERIFY THAT forceWiki IS A REAL WIKI AND DISPLAY A WARNING OTHERWISE (and don't save it in that case).

			if(setForcedWikiValue($forceWiki)){
				$nameForMessage = ($forceWiki==""?wfMsg('devbox-default-wiki'):$forceWiki);
				$wgOut->addHTML(successHtml(wfMsg('devbox-change-wiki-success', $nameForMessage)));
			} else {
				$wgOut->addHTML(errorHtml(wfMsg('devbox-change-wiki-fileerror', DEVBOX_FORCED_WIKI_FILE)));
			}
			break;
		case DEVBOX_ACTION_PULL_DB:
			$domainToPull = WikiFactory::DBtoDomain($wgRequest->getVal(DEVBOX_FIELD_DB_TO_PULL));
			pullProdDatabaseToLocal($domainToPull);
			break;
		case DEVBOX_ACTION_PULL_DOMAIN:
			pullProdDatabaseToLocal($wgRequest->getVal(DEVBOX_FIELD_DOMAIN_TO_PULL));
			break;
		default:
			break;
		}

		//// DISPLAY OF THE MAIN CONTENT OF THE PANEL IS BELOW ////

		// TODO: Divide these sections into tabs (possibly using jQuery UI).
		// TODO: Divide these sections into tabs (possibly using jQuery UI).

		// Display section which lets the developer force which wiki to act as.
		$wgOut->addHTML(getHtmlForChangingCurrentWiki());

		// Display section with vital stats on the server (where the LocalSettings are, the error logs, databases, etc.) with a link to phpinfo.
		$wgOut->addHTML(getHtmlForInfo());

		// Display section for creating local copies of dbs from production slaves.
		$wgOut->addHTML(getHtmlForDatabaseComparisonTool());

		// Footer to attract changes...
		$wgOut->addHTML(wfMsg("devbox-footer", __FILE__));
		
		$wgOut->addHTML("</div>"); // end of skinKiller div
	} else {
		$wgOut->addHTML(wfMsg('devbox-panel-not-enabled'));
	}

} // end wfDevBoxPanel()

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
	
	$html .= "<h2>".wfMsg('devbox-heading-pull-dbs')."</h2>";
	
	// TODO: REMOVE OR MAKE THIS BETTER INTEGRATED (I'm JUST RANDOMLY TYPING NOW) AFTER CONFIRMING THAT SLAVES ARE USED.
	$html .= "<strong>Please don't dump LARGE databases yet - I haven't evaluated the performance impact of that yet!</strong><br/>\n";
	
	// Form for pulling any wiki by its domain.
	$html .= "<form name='".DEVBOX_ACTION_PULL_DOMAIN."' method='post' action=''>
		<div>
			".wfMsg('devbox-pull-by-domain')."
			<input type='hidden' name='".DEVBOX_ACTION."' value='".DEVBOX_ACTION_PULL_DOMAIN."'/>
			<input type='text' name='".DEVBOX_FIELD_DOMAIN_TO_PULL."' value=''/>
			<input type='submit'/>
		</div>
	</form>";
	$html .= "<br/><br/>";

	// A set of recommended databases so that any new user can know a basic set of dbs to get them started.
	$RECOMMENDED_DBS = array(
		"wikicities",		// required for several write-operations (update it frequently!)
		//"dataware", 		// just use the prod database
		"answers",			// required for answers.wikia development
		"armyoftwo",        // a small wiki to use for testing db loading
		"farmville",        // a small wiki to use for testing db loading
		"ffxi",				// a random wiki for comparison
		"lyricwiki",		// a wiki from the B shard
		"wowwiki",			// very popular wiki
	);

	// Determine what databases are on this dev-box.
	global $wgDBdevboxUser, $wgDBdevboxPassword, $wgDBdevboxServer;
	$db = mysql_connect($wgDBdevboxServer, $wgDBdevboxUser, $wgDBdevboxPassword);
	$devbox_dbs_objs = mysql_list_dbs($db);
	$devbox_dbs = array();
	$IGNORE_DBS = array('information_schema', 'mysql');
	while ($row = mysql_fetch_object($devbox_dbs_objs)) {
		$devbox_dbs[] = $row->Database;
	}
	$devbox_dbs = array_diff($devbox_dbs, $IGNORE_DBS);
	asort($devbox_dbs);

	$html .= "<table class='devBoxPanel'>";
	$html .= "<tr><th>".wfMsg("devbox-dbs-on-devbox")."</th><th>".wfMsg("devbox-dbs-in-production")."</th></tr>";
	
	// List the databases on the devbox mysql instance.
	$html .= "<tr><td width='50%'>";
	$html .= "<em>".wfMsg("devbox-section-existing")."</em>";
	$html .= getHtmlForDbList($devbox_dbs, $RECOMMENDED_DBS, $devbox_dbs);
	$html .= "</td><td width='50%'>";

	// List the recommended databases.
	$html .= "<em>".wfMsg("devbox-section-recommended")."</em>";
	$html .= getHtmlForDbList($RECOMMENDED_DBS, $RECOMMENDED_DBS, $devbox_dbs);

	$html .= "</td></tr></table>";

	return $html;
} // end getHtmlForDatabaseComparisonTool()

/**
 * Given an array of dbs and the settings for which are recommended and/or
 * installed on the devbox mysql instance, returns the HTML for a list which lets
 * the user fetch those databases if desired.
 */
function getHtmlForDbList($dbsToList, $RECOMMENDED_DBS, $devbox_dbs){
	$html = "";
	if(count($dbsToList) > 0){
		$html .= "<ul>";
		global $wgArticlePath,$wgRequest;
		$title = $wgRequest->getVal('title');
		$pageUrl = str_replace( "$1", urlencode( $title ), $wgArticlePath );
		foreach($dbsToList as $dbName){
			$link = "$pageUrl&".DEVBOX_ACTION."=".DEVBOX_ACTION_PULL_DB."&".DEVBOX_FIELD_DB_TO_PULL."=".urlencode($dbName);
			$reloadIt = "<a href='$link'>".wfMsg("devbox-reload-db")."</a>";
			$getIt = "<a href='$link'>".wfMsg("devbox-get-db")."</a>";
			if(in_array($dbName, $devbox_dbs)){
				// Already have this database.
				$html .= "<li class='dbp-alreadyInstalled'>$dbName <span class='dbp-rightButtons'>$reloadIt</span></li>";
			} else if(in_array($dbName, $RECOMMENDED_DBS)){
				// This isn't installed yet but it's recommended that it should be.
				$html .= "<li class='dbp-recommended'>$dbName <span class='dbp-rightButtons'>$getIt</span></li>";
			} else {
				// Available, not currently installed, not one of the specifically recommended.
				// This will be most databases.
				$html .= "<li class='dbp-available'>$dbName <span class='dbp-rightButtons'>$getIt</span></li>";
			}
		}
		$html .= "</ul>";
	} else {
		$html .= "<small>".wfMsg('devbox-no-dbs-in-list')."</small>";
	}
	return $html;
} // end getHtmlForDbList()

/**
 * Displays information that will help the developer develop more
 * easily instead of having to track down this information elsewhere.
 * All hard to find files, settings, etc. should be here.
 */
function getHtmlForInfo(){
	$html = "";
	
	$html .= "<h2>".wfMsg("devbox-heading-vital")."</h2>";

	global $IP,$wgScriptPath,$wgExtensionsPath,$wgCityId;
	global $wgDBname,$wgExternalSharedDB;
	
	$settings = array(
		"error_log"            => ini_get('error_log'),
		"\$IP"                 => $IP,
		"\$wgScriptPath"       => $wgScriptPath,
		"\$wgExtensionsPath"   => $wgExtensionsPath,
		"\$wgCityId"           => $wgCityId,
		"\$wgDBname"           => $wgDBname,
		"\$wgExternalSharedDB" => $wgExternalSharedDB,
		"Databases that will use devbox-mysql<br/>
		server in read/write instead of prod<br/>
		slaves in readOnly" => implode(", ", getDevBoxOverrideDatabases()),
		"Hacky solution to change which databases<br/>
		will use the devbox mysql server instead<br/>
		of readOnly prod slaves is to <strong>edit this file:</strong>"
							=> DEVBOX_OVERRIDDEN_DBS_FILE,
	);
	$html .= "<table class='devbox-settings'>\n";
	$html .= "<tr><th>".wfMsg("devbox-setting-name")."</th><th>".wfMsg("devbox-setting-value")."</th></tr>\n";
	$index = 0;
	foreach($settings as $name => $val){
		$html .= "<tr".($index%2==1?" class='odd'":"").">";
		$html .= "<td>$name</td><td>$val</td>";
		$html .= "</tr>\n";
		$index++;
	}
	$html .= "</table>\n";

	return $html;
} // end getHtmlForInfo()

/**
 * Returns the HTML of a form which will let the developer override which wiki this box
 * should behave as.  This will give the option of letting the developer replace the prior
 * method of changing their hosts file to pretend to be a different wiki.
 *
 * The prior method was finicky because browsers don't always refresh the hostsfile right
 * away, the devs often have to check their hosts files to see which were left pointing to
 * dev-boxes, and it's not clear from looking at the pages which server is really being
 * used (since the URL would be the same) so devs had to continually check the source code
 * for "Served By" comments.
 */
function getHtmlForChangingCurrentWiki(){
	$html = "";

	$html .= "<h2>".wfMsg("devbox-heading-change-wiki")."</h2><br/>";

	// If no wiki is specified yet, highlight this section.
	$forceWiki = getForcedWikiValue();
	$class = ($forceWiki==""?" class='attention'":"");

	$html .= "<div$class>\n";
	$html .= "<em>".wfMsg("devbox-change-wiki-intro")."</em><br/>";

	$html .= "<form method='post' action=''>
		<input type='hidden' name='".DEVBOX_ACTION."' value='".DEVBOX_ACTION_CHANGE_WIKI."'/>
		<div>".wfMsg("devbox-change-wiki-label")." <input type='text' name='".DEVBOX_FIELD_FORCE_WIKI."' value='$forceWiki' />
		<input type='submit' value='".wfMsg('devbox-change-wiki-submit')."'/>
		</div>
	</form>";
	$html .= "</div>";

	return $html;
} // end getHtmlForChangingCurrentWiki()

function successHtml($msg){
	return "<div class='devbox-success'>$msg</div>";
} // end successHtml()

function errorHtml($msg){
	return "<div class='devbox-error'>$msg</div>";
} // end errorHtml()

?>
