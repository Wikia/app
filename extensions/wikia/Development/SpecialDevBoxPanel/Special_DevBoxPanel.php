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
$wgHooks['PageRenderingHash'][] = 'wfDevBoxSeparateParserCache';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'DevBoxPanel',
	'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
	'description' => 'This extension makes it easier to administer a Wikia Dev Box.',
	'version' => '0.0.3',
);

// Definitions
define('DEVBOX_DEFAULT_WIKI_DOMAIN', 'devbox.wikia.com');

require_once($IP . '/includes/SpecialPage.php');
$wgSpecialPages['DevBoxPanel'] = 'DevBoxPanel';

class DevBoxPanel extends SpecialPage {
	public function __construct(){
		// macbre: don't run code below when running in command line mode (memcache starts to act strange) - NOTE: This macbre code was in a different spot... this may be fixed implicitly now.
		if (!empty($wgCommandLineMode)) {
			return true;
		}

		parent::__construct('DevBoxPanel');
	}

	/**
	 * The main function of the SpecialPage.  Adds the content for the page
	 * to the wgOut global.
	 */
	function execute($par) {
		global $wgOut,$wgHooks,$wgDevelEnvironment,$wgUser;

		if( !$wgUser->isAllowed( 'devboxpanel' ) ) {
			throw new PermissionsError( 'devboxpanel' );
		}

		$wgHooks['BeforePageDisplay'][] = 'devBoxPanelAdditionalScripts';

		$wgOut->setPageTitle(wfMsg("devbox-title"));
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		if($wgDevelEnvironment){
			if (isset($_REQUEST['switch'])) svnHandleSwitch();
			if (isset($_REQUEST['update'])) svnHandleUpdate();

			$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$tmpl->set_vars(array(
								"svnToolHtml"      => getHtmlForSvnTool(),
								"dbComparisonHtml" => getHtmlForDatabaseComparisonTool(),
								"infoHtml"         => getHtmlForInfo(),
								"footer"           => wfMsg("devbox-footer", __FILE__),
								));
			$wgOut->addHTML($tmpl->render('special-devboxpanel'));
		} else {
			$wgOut->addHTML(wfMsg('devbox-panel-not-enabled'));
		}

	} // end execute()

} // end class DevBoxPanel


function devBoxPanelAdditionalScripts( OutputPage &$out, &$sk ){
	global $wgExtensionsPath;
	$out->addStyle( "$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.css" );
	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.js'></script>");
	return true;
}

/**
 * Hooks into WikiFactory to force use of the wiki which the developer
 * has explicitly set using this panel (if applicable).
 *
 * @return true to allow the WikiFactoryLoader to do its other necessary initalization.
 */
function wfDevBoxForceWiki(&$wikiFactoryLoader){
	global $wgDevelEnvironment, $wgWikiFactoryDB, $wgCommandLineMode;
	if($wgDevelEnvironment){
		$forcedWikiDomain = getForcedWikiValue();
		$cityId = WikiFactory::DomainToID($forcedWikiDomain);
		if(!$cityId){
			// If the overridden name doesn't exist AT ALL, use a default just to let the panel run.
			$forcedWikiDomain = DEVBOX_DEFAULT_WIKI_DOMAIN;
			$cityId = WikiFactory::DomainToID($forcedWikiDomain);
		}

		if($wgCommandLineMode) {
			$cityId = getenv( "SERVER_ID" );

			$wikiFactoryLoader->mCityID = $cityId;
			$wikiFactoryLoader->mWikiID = $cityId;
		}


		if($cityId){
			$wikiFactoryLoader->mServerName = $forcedWikiDomain;

			// Need to set both in order to get our desired effects.
			$wikiFactoryLoader->mCityID = $cityId;
			$wikiFactoryLoader->mWikiID = $cityId;
		}

		// This section allows us to use c1 or c2 as a source for wiki databases
		// Be aware that this means the database has to be loaded in the right cluster according to wikicities!
		$db = wfGetDB( DB_SLAVE, "dump", $wgWikiFactoryDB );
		$sql = 'SELECT city_cluster from city_list where city_id = ' . $cityId;
		$result = $db->query( $sql, __METHOD__ );

		$row = $result->fetchRow();
		$wikiFactoryLoader->mVariables["wgDBcluster"] = $row['city_cluster'];

		// Final sanity check to make sure our database exists
		if ($forcedWikiDomain != DEVBOX_DEFAULT_WIKI_DOMAIN) {
			$dbname = WikiFactory::DomainToDB($forcedWikiDomain);
			$db1 = wfGetDB( DB_SLAVE, "dump", $wgWikiFactoryDB );
			$db2 = wfGetDB( DB_SLAVE, "dump", $wgWikiFactoryDB . '_c2'); // lame

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
 * Modify parser cache key to be different on each devbox (BugId:24647)
 *
 * @param string $hash part of parser cache key to be modified
 * @param User $user current user instance
 * @return boolean true
 */
function wfDevBoxSeparateParserCache(&$hash) {
	global $wgDevelEnvironmentName;

	$hash .= "!dev-{$wgDevelEnvironmentName}";
	return true;
}


/**
 * @return array Parts of host. used to set $wgDevelEnvironmentName;
 */
function getHostParts() {
	if (!isset($_SERVER['HTTP_HOST'])) return null;
	if (count (explode(".", $_SERVER['HTTP_HOST'])) == 3) return null;
	$aHostParts = explode(".", str_replace('.wikia-dev.com', '', $_SERVER['HTTP_HOST']));
	return $aHostParts;
}

/**
 * @return String full domain of wiki which this dev-box should behave as.
 *
 * Hostname scheme: override.developer.wikia-dev.com
 * Example: muppet.owen.wikia-dev.com -> muppet.wikia.com
 * Example: es.gta.owen.wikia-dev.com -> es.gta.wikia.com
 *
 * TODO: figure out if .poz domains are still used?
 * 	if (array_search('poz', $aHostParts) !== false){
 *		array_pop($aHostParts);  // remove .poz if it exists in the host name
 *	}
 */
function getForcedWikiValue(){
	global $wgDevelEnvironmentName;
	$aHostParts = getHostParts();

	if(!empty($hostParts)) {
		$wgDevelEnvironmentName = array_pop($hostParts);
	} else {
		$host = exec('hostname'); //TODO: replce it by gethostname php >= 5.3.0
		$host = explode("-", $host);
		$wgDevelEnvironmentName = trim($host[1]);
	}

	if(empty($aHostParts)) {
		return "";
	}
	array_pop($aHostParts);  // remove developer name
	$override = implode(".", $aHostParts);
	return "$override.wikia.com";
} // end getForcedWikiValue()


/**
 * @return array - databases which are available on this cluster
 *                 use the writable devbox server instead of the production slaves.
 */
function getDevBoxOverrideDatabases($db){

	$IGNORE_DBS = array('information_schema', 'mysql', '#mysql50#lost+found', 'devbox', 'wikicities_c2');
	$retval = array();

	$info = $db->getLBInfo();
	$connection = mysql_connect($info['host'], $info['user'], $info['password']);
	$res = mysql_query('SHOW DATABASES', $connection);
	while ($row = mysql_fetch_object($res)) {
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

function svnHandleUpdate() {
	$base_path = dirname(dirname(dirname(dirname(dirname( __FILE__ )))));
	shell_exec("svn update $base_path 2>&1");
}

function svnHandleSwitch() {
	$url = 'https://svn.wikia-code.com/wikia/';
	$branch = $_REQUEST['branch'];
	if ($branch == 'trunk') {
		$url .= $branch;
	} else {
		$url .= "branches/$branch";
	}

	$base_path = dirname(dirname(dirname(dirname(dirname( __FILE__ )))));
	shell_exec("cd $base_path; svn switch $url");
}

/**
 * A tool for showing the current status of SVN and for updating the working copy to a new branch
 */

function getHtmlForSvnTool() {
	global $wgTitle;
	$errors = array();

	$base_path = dirname(dirname(dirname(dirname(dirname( __FILE__ )))));
	$stat = stat($base_path);
	if ($stat['gid'] != posix_getegid()) {
		$group = posix_getgrgid(posix_getegid());
		$errors[] = "Incorrect file ownership.  To fix, run:<br><code>sudo chgrp -R ".$group['name']." $base_path</code>";
	}

	$perms = fileperms($base_path);
	if (!($perms & 0x0010)) {
		$errors[] = "Incorrect file permissions. To fix, run:<br><code>sudo chmod -R g+w $base_path</code>";
	}

	$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$data = shell_exec("svn info ".dirname(dirname(dirname(dirname(dirname( __FILE__ ))))));

	foreach (explode("\n", $data) as $line) {
		if (empty($line)) continue;
		list($k, $v) = explode(": ", $line);
		$info{$k} = $v;
	}

	$data = shell_exec("svn list https://svn.wikia-code.com/wikia/branches/");
	$branches = array_map(create_function('$v', 'return rtrim($v, "/");'), explode("\n", $data));

	$tmpl->set_vars(array(
						"svnUrl"     => $info{'URL'},
						"svnUpdated" => $info{'Last Changed Date'},
						"branches"   => array_merge(array('trunk'), $branches),
						"action"     => $wgTitle->getLocalUrl(),
						"errors"     => $errors,
						));
	return $tmpl->render('svn-tool');
}

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

	global $wgDBname,$wgExternalSharedDB, $wgWikiFactoryDB;

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
