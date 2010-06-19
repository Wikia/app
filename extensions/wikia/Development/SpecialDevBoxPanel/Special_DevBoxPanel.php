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
//require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DevBoxDatabase.php' );

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
	'version' => '0.0.3',
);

// Definitions
//$serv = (isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:"cli");
//define('DEVBOX_FORCED_WIKI_KEY', "devbox_forceWiki_$serv");
//define('DEVBOX_FORCED_WIKI_FILE', dirname(__FILE__).'/devbox_forceWiki.txt');
//define('DEVBOX_FORCED_WIKI_FILE', "/tmp/$serv"."_devbox_forceWiki.txt");
//define('DEVBOX_OVERRIDDEN_DBS_KEY', "devbox_overridden_dbs_$serv");
//define('DEVBOX_OVERRIDDEN_DBS_DELIM', '`'); // delimiter used to separate values in both memory & file (grave is used because it is not allowed in table names)

//define('DEVBOX_ACTION', 'panelAction');
//define('DEVBOX_ACTION_CHANGE_WIKI', 'devbox-change-wiki');
//define('DEVBOX_FIELD_FORCE_WIKI', 'devbox-field-force-wiki');
//define('DEVBOX_ACTION_PULL_DB', 'devbox-pull-database');
//define('DEVBOX_FIELD_DB_TO_PULL', 'dbToPull');
//define('DEVBOX_ACTION_PULL_DOMAIN', 'devbox-pull-domain');
//define('DEVBOX_FIELD_DOMAIN_TO_PULL', 'domainToPull');

define('DEVBOX_DEFAULT_WIKI_DOMAIN', 'devbox.wikia.com');
//define('DEV_BOX_SERVER_NAME', "devbox-server");

// Doing it as its own cluster didn't work because of some details of how wikicities_[cluster] works.
// Instead, we will try to use the main cluster, but override what server that means.
// TODO: SWAP ME!  This probably is the solution, but there needs to be some testing (and I can't login at the moment).
//define('DEV_BOX_CLUSTER', "devbox_section");
define('DEV_BOX_CLUSTER', "DEFAULT");

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
	global $wgDevelEnvironment, $wgWikiFactoryDB;
	if($wgDevelEnvironment){
		$forcedWikiDomain = getForcedWikiValue();
		$cityId = WikiFactory::DomainToID($forcedWikiDomain);
		if(!$cityId){
			// If the overridden name doesn't exist AT ALL, use a default just to let the panel run.
			$forcedWikiDomain = DEVBOX_DEFAULT_WIKI_DOMAIN;
			$cityId = WikiFactory::DomainToID($forcedWikiDomain);
		}
		if($cityId){
			$wikiFactoryLoader->mServerName = $forcedWikiDomain;

			// Need to set both in order to get our desired effects.
			$wikiFactoryLoader->mCityId = $cityId;
			$wikiFactoryLoader->mWikiId = $cityId;
		}

		// This section allows us to use c1 or c2 as a source for wiki databases
		// Be aware that this means the database has to be loaded in the right cluster according to wikicities!
		$db = wfGetDB( DB_MASTER, "dump", $wgWikiFactoryDB );
		$sql = 'SELECT city_cluster from city_list where city_id = ' . $cityId;
		$result = $db->query( $sql, __METHOD__ );

		$row = $result->fetchRow();
		$wikiFactoryLoader->mVariables["wgDBcluster"] = $row['city_cluster'];

		// Final sanity check to make sure our database exists
		if ($forcedWikiDomain != DEVBOX_DEFAULT_WIKI_DOMAIN) {
			$dbname = WikiFactory::DomainToDB($forcedWikiDomain);
			$db1 = wfGetDB( DB_MASTER, "dump", $wgWikiFactoryDB );
			$db2 = wfGetDB( DB_MASTER, "dump", $wgWikiFactoryDB . '_c2'); // lame

			$devbox_dbs = array_merge(getDevBoxOverrideDatabases($db1), getDevBoxOverrideDatabases($db2));
			if (array_search($dbname, $devbox_dbs) === false) {
				echo "<pre>Fatal Error: No local copy of database [$dbname] was found.</pre>";
				exit(); // fatal error
			}
		}

		// TODO: move this into the config file
		global $wgReadOnly;
		$wgReadOnly = false;

	}
	return true;
} // end wfDevBoxForceWiki()


/**
 * @return String full domain of wiki which this dev-box should behave as.
 *
 * Hostname scheme: override.developer.wikia-dev.com
 * Example: muppet.owen.wikia-dev.com -> muppet.wikia.com
 */
function getForcedWikiValue(){
	if (count (explode(".", $_SERVER['HTTP_HOST'])) == 4) {
		list($override, $developer, $wikia_dev, $com) = explode(".", $_SERVER['HTTP_HOST']);
		//$_SERVER['HTTP_HOST'] == "$developer.wikia-dev.com";
		return "$override.wikia.com";
	}
	return "";
} // end getForcedWikiValue()


/**
 * @return array - databases which are available on this cluster
 *                 use the writable devbox server instead of the production slaves.
 */
function getDevBoxOverrideDatabases($db){

	$IGNORE_DBS = array('information_schema', 'mysql', 'messaging', 'help', 'devbox', 'wikicities', 'wikicities_c2');
	$retval = array();

	$info = $db->getLBInfo();
	$connection = mysql_connect($info['host'], $info['user'], $info['password']);
	$db_list = mysql_list_dbs($connection);
	while ($row = mysql_fetch_object($db_list)) {
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

/*
function pullProdDatabaseToLocal($domainOfWikiToPull){
	global $wgCityId,$wgDBserver,$wgDBname,$wgDBuser,$wgDBpassword;
	global $wgExtensionsPath,$wgStyleVersion, $wgWikiaLocalSettingsPath;

	set_time_limit(0);

	// NOTE: The database settings for production slaves are in DB.php, so that data has to be loaded temporarily.
	require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DB.php' );
	$dbr = wfGetDB( DB_SLAVE, "dump", $wgDBname );
	$dbr_lbinfo = $dbr->getLBInfo();
	$wgDBserver_prodSlave = $dbr_lbinfo['host'];
	$wgDBuser_prodSlave = $wgDBuser;
	$wgDBpassword_prodSlave = $wgDBpassword;
	require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DB.sjc-dev.php' ); // Restore actual values for DevBox connections.

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
	//setForcedWikiValue($domainOfWikiToPull);

	$wikiFactoryLoader = new WikiFactoryLoader();
	$wgCityId = $wikiFactoryLoader->execute();
	
	// Restore the dev-box overrides because they're persistent and we only wanted to temporarily ignore them.
	setDevBoxOverrideDatabases($originalOverrides);
	//setForcedWikiValue($originalWikiValue);

	// Everything is configured, now move the data.
	$tmpFile = "/tmp/$wgDBname.mysql.gz";
	print "Dumping \"$wgDBname\" from host \"$wgDBserver_prodSlave\"...<br/>\n";
	print "mysqldump --compress --single-transaction --skip-comments --quick -h $wgDBserver_prodSlave -u$wgDBuser_prodSlave -p$wgDBpassword_prodSlave $wgDBname --result-file=$tmpFile 2>&1";
	$response = `mysqldump --compress --single-transaction --skip-comments --quick -h $wgDBserver_prodSlave -u$wgDBuser_prodSlave -p$wgDBpassword_prodSlave $wgDBname --result-file=$tmpFile 2>&1`;
	if(trim($response) != ""){
		print "<div class='devbox-error'>Database dump returned the following error:\n<em>$response</em></div>\n";
	} else {
		print "Backup created.<br/>\n";
	}
	print "<br/>\n";

	print "Creating database...<br/>\n";
	global $wgDBdevboxUser,$wgDBdevboxPassword,$wgDBdevboxServer;
	$response = `mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer -e "CREATE DATABASE IF NOT EXISTS $wgDBname" 2>&1`;
	print "mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer -e \"CREATE DATABASE IF NOT EXISTS $wgDBname\" 2>&1";
	if(trim($response) != ""){
		print "<div class='devbox-error'>CREATE DATABASE attempt returned the error:\n<em>$response</em></div>\n";
	} else {
		print "\"$wgDBname\" created on \"$wgDBdevboxServer\".<br/>\n";
	}
	print "<br/>";
	
	print "Loading \"$wgDBname\" into \"$wgDBdevboxServer\"...<br/>\n";
	$response = `cat $tmpFile | mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer $wgDBname 2>&1`;
	print "cat $tmpFile | mysql -u $wgDBdevboxUser -p$wgDBdevboxPassword -h $wgDBdevboxServer $wgDBname 2>&1";
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
*/

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
		if (getForcedWikiValue() == "") {
			$wgOut->addHTML(wfMsg("devbox-change-wiki-intro", $_SERVER['SERVER_NAME']));
		} else {
			$wgOut->addHTML(wfMsg("devbox-change-wiki-success", $_SERVER['SERVER_NAME']));
		}

		//// DISPLAY OF THE MAIN CONTENT OF THE PANEL IS BELOW ////

		// TODO: Divide these sections into tabs (possibly using jQuery UI).
		// TODO: Divide these sections into tabs (possibly using jQuery UI).

		// Display section which lets the developer force which wiki to act as.
		//$wgOut->addHTML(getHtmlForChangingCurrentWiki());

		// Display section listing available databases
		$wgOut->addHTML(getHtmlForDatabaseComparisonTool());

		// Display section with vital stats on the server (where the LocalSettings are, the error logs, databases, etc.) with a link to phpinfo.
		$wgOut->addHTML(getHtmlForInfo());

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
	
	$html .= "<h2>".wfMsg("devbox-heading-change-wiki")."</h2>";
	
	// Determine what databases are on this dev-box.

	global $wgDBname,$wgExternalSharedDB, $wgWikiFactoryDB;

	//$db_dev = wfGetDB( DB_MASTER, "dump", $wgDBname );
	$db1 = wfGetDB( DB_MASTER, "dump", $wgWikiFactoryDB );
	$db2 = wfGetDB( DB_MASTER, "dump", $wgWikiFactoryDB . '_c2'); // lame

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
	);
	$html .= "<table class='devbox-settings'>\n";
	$html .= "<tr><th>".wfMsg("devbox-setting-name")."</th><th>".wfMsg("devbox-setting-value")."</th></tr>\n";
	$index = 0;
	foreach($settings as $name => $val){
		$html .= "<tr".($index%2==1?" class='odd'":"").">";
		$html .= "<td width=150>$name</td><td width=150>$val</td>";
		$html .= "</tr>\n";
		$index++;
	}
	$html .= "</table>\n";

	return $html;
} // end getHtmlForInfo()

?>
