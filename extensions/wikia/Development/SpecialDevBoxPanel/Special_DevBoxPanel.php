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
define('DEVBOX_DEFAULT_WIKI_DOMAIN', 'devbox.wikia.com');

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
	if (!isset($_SERVER['HTTP_HOST'])) return "";
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

	$IGNORE_DBS = array('information_schema', 'mysql', '#mysql50#lost+found', 'messaging', 'help', 'devbox', 'wikicities', 'wikicities_c2');
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
 * REMOVED BY OWEN: this functionality has been replaced by maintenance/wikia/getDatabase.php
 *
 *	function pullProdDatabaseToLocal($domainOfWikiToPull){
 *  }
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
