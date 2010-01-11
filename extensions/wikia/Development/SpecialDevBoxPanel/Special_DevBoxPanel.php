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
 * TODO: Make sure all dev-boxes get to that point automatically w/a devbox user.
 *
 * TODO: Since "local" isn't technically a requirement, make sure to update the comments here to make that clear.  It
 * is quite likely that all of the devbox dbs will be moved to some other server for space reasons relatively soon.
 */

if(!defined('MEDIAWIKI')) die();

// Credentials for the editable (not public) devbox database.
require_once( dirname( $wgWikiaLocalSettingsPath ) . '/../DevBoxDatabase.php' );

// TODO: DETERMINE THE CORRECT PERMISSIONS... IS THERE A "DEVELOPERS" GROUP THAT WE ALL ACTUALLY BELONG TO?  WILL WE BE ON ALL WIKIS?
// Permissions
$wgAvailableRights[] = 'devboxpanel';
$wgGroupPermissions['staff']['devboxpanel'] = true;
$wgGroupPermissions['user']['devboxpanel'] = true; // for now, allow all users as long as $wgDevelEnvironment is true
$wgGroupPermissions['*']['devboxpanel'] = true; // for now, allow all users as long as $wgDevelEnvironment is true

// Hooks
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['DevBoxPanel'] = $dir.'Special_DevBoxPanel.i18n.php';
$wgHooks['WikiFactory::execute'][] = "wfDevBoxForceWiki";
$wgHooks['WikiFactory::execute::done'][] = "wfDevBoxForceDbServer";

$wgExtensionFunctions[] = 'wfSetupDevBoxPanel';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Dev-Box Panel',
	'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
	'description' => 'This extension makes it easier to administer a Wikia Dev Box.',
	'version' => '0.0.1',
);

// Definitions
define('DEVBOX_FORCED_WIKI_KEY', 'devbox_forceWiki');
//define('DEVBOX_FORCED_WIKI_FILE', dirname(__FILE__).'/devbox_forceWiki.txt');
define('DEVBOX_FORCED_WIKI_FILE', '/tmp/devbox_forceWiki.txt');
define('DEVBOX_OVERRIDDEN_DBS_KEY', 'devbox_overridden_dbs');
define('DEVBOX_OVERRIDDEN_DBS_FILE', '/tmp/devbox_overriden_dbs.txt');
define('DEVBOX_OVERRIDDEN_DBS_DELIM', '`'); // delimiter used to separate values in both memory & file (grave is used because it is not allowed in table names)
define('DEVBOX_CHANGE_WIKI_FORMNAME', 'devbox-change-wiki');
define('DEVBOX_FIELD_FORCE_WIKI', 'devbox-field-force-wiki');
define('DEVBOX_DEFAULT_WIKI_DOMAIN', 'devbox.wikia.com');
define('DEV_BOX_CLUSTER', "devbox_section");
define('DEV_BOX_SERVER_NAME', "devbox-server");

function wfSetupDevBoxPanel() {
	global $IP, $wgMessageCache;

	require_once($IP . '/includes/SpecialPage.php');
	SpecialPage::addPage(new SpecialPage('DevBoxPanel', 'devboxpanel', true, 'wfDevBoxPanel', false));
	$wgMessageCache->addMessage('devboxpanel', 'Dev-Box Panel');
}

function devBoxPanelAdditionalScripts( &$out, &$sk ){
	global $wgExtensionsPath,$wgStyleVersion;
	$out->addStyle( "$wgExtensionsPath/wikia/Development/SpecialDevBoxPanel/DevBoxPanel.css?$wgStyleVersion" );
	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/Development/DevBoxPanel.js?$wgStyleVersion'></script>");
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
	}

	// Devbox database credentials (from private svn /wikia-conf/DevBoxDatabase.php).
	global $wgDBdevboxUser,$wgDBdevboxPassword,$wgDBdevboxServer;

	// Modify wgLBFactoryConf using loaded settings...
	$wgLBFactoryConf['sectionLoads'][DEV_BOX_CLUSTER] = array(DEV_BOX_SERVER_NAME => 1);
	$wgLBFactoryConf['hostsByName'][DEV_BOX_SERVER_NAME] = $wgDBdevboxServer;
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
		$memc->set(DEVBOX_FORCED_WIKI_KEY, $forcedWikiName, strtotime("+2 hour"));
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
		$memc->set(DEVBOX_OVERRIDDEN_DBS_KEY, $overDbsRaw, strtotime("+2 hour"));
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
 */
function pullProdDatabaseToLocal($domainOfWikiToPull){
	global $wgCityId,$wgDBserver,$wgDBname;
	
	// Set the wiki, but with overrides turned off (we're trying to find the production slave
	// for the database).
	$originalOverrides = getDevBoxOverrideDatabases(); // restore these later
	setDevBoxOverrideDatabases(array());
	setForcedWikiValue($domainOfWikiToPull);

	$wikiFactoryLoader = new WikiFactoryLoader();
	$wgCityId = $wikiFactoryLoader->execute();

	print "server: $wgDBserver<br/>\n";
	print "db: $wgDBname<br/>\n";
	global $wgLBFactoryConf;
	print "<!--";
	//print_r($wgLBFactoryConf);
	//print_r($wikiFactoryLoader);
	print "-->";

	// Restore the dev-box overrides because they're persistent and we only wanted to temporarily ignore them.
	setDevBoxOverrideDatabases($originalOverrides);
	
	
	// TODO: BASICALLY CLONE THE FUNCTIONALITY OF pullDB.bash TO GRAB AND LOAD THE DATA (but w/svn-safe handling of database credentials).
	// TODO: BASICALLY CLONE THE FUNCTIONALITY OF pullDB.bash TO GRAB AND LOAD THE DATA (but w/svn-safe handling of database credentials).
	
	
	

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
	
	if($wgDevelEnvironment){
		// Intro
		$wgOut->addHTML("<em>");
		$wgOut->addHTML(wfMsg('devbox-intro'));
		$wgOut->addHTML("</em><br/><br/>");
		
		
		
// TODO: MOVE THIS TO BE PROCESSED IN THE SWITCH STATEMENT BELOW FROM ACTUAL GUI REQUESTS. - THIS FUNCTION WILL CURRENTLY DESTROY ALL OTHER PROCESSING BASICALLY.. JUST TESTING IT HERE.
pullProdDatabaseToLocal("armyoftwo.wikia.com");
		
		
		
		

		// TODO: Do any processing of actions here (and display success/error messages).
		global $wgRequest;
		$formName = $wgRequest->getVal('formName');
		switch($formName){
		case DEVBOX_CHANGE_WIKI_FORMNAME:
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
		default:
			break;
		}

		$wgOut->addHTML("<br/><hr/><br/>");
		// TODO: Do any processing of actions here (and display success/error messages).


		//// DISPLAY OF THE MAIN CONTENT OF THE PANEL IS BELOW ////

		// TODO: Divide these sections into tabs (possibly using jQuery UI).
		// TODO: Divide these sections into tabs (possibly using jQuery UI).

		// Display section which lets the developer force which wiki to act as.
		$wgOut->addHTML(getHtmlForChangingCurrentWiki());
		$wgOut->addHTML("<br/><hr/><br/>");

		// Display section with vital stats on the server (where the LocalSettings are, the error logs, databases, etc.) with a link to phpinfo.
		$wgOut->addHTML(getHtmlForInfo());
		$wgOut->addHTML("<br/><hr/><br/>");

		// Display section for creating local copies of dbs from production slaves.
		$wgOut->addHTML(getHtmlForDatabaseComparisonTool());

		// Footer to attract changes...
		$wgOut->addHTML(wfMsg("devbox-footer", __FILE__));
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
 * TODO: Add the option on each existing db to reload it or set it as the ACTIVE wiki.
 *
 * @return String - HTML for displaying the tool.
 */
function getHtmlForDatabaseComparisonTool(){
	$html = "";

	// A set of recommended databases so that any new user can know a basic set of dbs to get them started.
	$RECOMMENDED_DBS = array(
		"wikicities", 		// required for wikifactory settings
		"dataware", 		// contains the text of articles
		"answers",			// required for answers.wikia development
		"wowwiki",			// very popular wiki
		"ffxi",				// a random wiki for comparison
		"lyricwiki"			// a wiki from the B shard
	);

	// Determine what databases are on this dev-box.
	$db = wfGetDB(DB_SLAVE)->getProperty('mConn');
	$local_dbs_objs = mysql_list_dbs($db);
	$local_dbs = array();
	while ($row = mysql_fetch_object($local_dbs_objs)) {
		$local_dbs[] = $row->Database;
	}
	asort($local_dbs);

	// TODO: DETERMINE WHAT DATABASES ARE AVAILABLE FROM PRODUCTION SLAVES.
	$available_dbs = array();
// TODO: REMOVE AND REPLACE W/CODE TO ACTUALLY LOAD THE LIST OF DBs
$available_dbs[] = "lyricwiki";
$available_dbs[] = "answers";
$available_dbs[] = "dataware";
$available_dbs[] = "wikicities";
$available_dbs[] = "wowwiki";
$available_dbs[] = "ffxi";
$available_dbs[] = "muppet";
$available_dbs[] = "twighlightsaga";
// TODO: REMOVE AND REPLACE W/CODE TO ACTUALLY LOAD THE LIST OF DBs
	asort($available_dbs);

	// TODO: DISPLAY THE GUI FOR GETTING MORE DATABASES.

	$html .= "<table class='devBoxPanel'>";
	$html .= "<tr><th>".wfMsg("devbox-dbs-on-devbox")."</th><th>".wfMsg("devbox-dbs-in-production")."</th></tr>";
	$html .= "<tr><td width='50%'>";
	if(count($local_dbs) > 0){
		$html .= "<em>".wfMsg("devbox-section-existing")."</em>";
		$html .= "<ul>";
		foreach($local_dbs as $dbName){
			$html .= "<li class='dbp-alreadyInstalled'>$dbName</li>";
		}
		$html .= "</ul>";
	}
	$html .= "</td><td width='50%'>";
	if(count($available_dbs) > 0){
		$html .= "<em>".wfMsg("devbox-section-summary")."</em>";
		$html .= "<ul>";
		// List the databases we already have and the recommended ones first.
		foreach($available_dbs as $dbName){
			$reloadIt = "<a href='#'>".wfMsg("devbox-reload-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
			$getIt = "<a href='#'>".wfMsg("devbox-get-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
			if(in_array($dbName, $local_dbs)){
				// Already have this database.
				$html .= "<li class='dbp-alreadyInstalled'>$dbName <span class='dbp-rightButtons'>$reloadIt</span></li>";
			} else if(in_array($dbName, $RECOMMENDED_DBS)){
				// This isn't installed yet but it's recommended that it should be.
				$html .= "<li class='dbp-recommended'>$dbName <span class='dbp-rightButtons'><em>".wfMsg("devbox-recommended")."</em> $getIt</span></li>";
			}
		}
		$html .= "</ul>";

		// Go through and list ALL databases now.
		$html .= "<br/><em>".wfMsg("devbox-section-all")."</em>";
		$html .= "<ul>";
		foreach($available_dbs as $dbName){
			$reloadIt = "<a href='#'>".wfMsg("devbox-reload-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
			$getIt = "<a href='#'>".wfMsg("devbox-get-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
			if(in_array($dbName, $local_dbs)){
				// Already have this database.
				$html .= "<li class='dbp-alreadyInstalled'>$dbName <span class='dbp-rightButtons'>$reloadIt</span></li>";
			} else if(in_array($dbName, $RECOMMENDED_DBS)){
				// This isn't installed yet but it's recommended that it should be.
				$html .= "<li class='dbp-recommended'>$dbName <span class='dbp-rightButtons'><em>".wfMsg("devbox-recommended")."</em> $getIt</span></li>";
			} else {
				// Available, not currently installed, not one of the specifically recommended.
				// This will be most databases.
				$html .= "<li class='dbp-available'>$dbName <span class='dbp-rightButtons'>$getIt</span></li>";
			}
		}
		$html .= "</ul>";
	}
	$html .= "</td></tr></table>";

	return $html;
} // end getHtmlForDatabaseComparisonTool()

/**
 * Displays information that will help the developer develop more
 * easily instead of having to track down this information elsewhere.
 * All hard to find files, settings, etc. should be here.
 */
function getHtmlForInfo(){
	$html = "";
	
	$html .= "<em>".wfMsg("devbox-vital-settings")."</em>";

	GLOBAL $IP,$wgScriptPath,$wgExtensionsPath,$wgCityId,$wgNotAValidWikia;
	
	$settings = array(
		"error_log"            => ini_get('error_log'),
		"\$IP"                 => $IP,
		"\$wgScriptPath"       => $wgScriptPath,
		"\$wgExtensionsPath"   => $wgExtensionsPath,
		"\$wgCityId"           => $wgCityId,
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

	$forceWiki = getForcedWikiValue();

	// If no wiki is specified yet, highlight this section.
	$style = ($forceWiki==""?" style='background-color:#ffa'":"");
	
	$html .= "<div$style>\n";
	$html .= "<strong>".wfMsg("devbox-change-wiki-heading")."</strong><br/>";
	$html .= "<em>".wfMsg("devbox-change-wiki-intro")."</em><br/>";

	$html .= "<form method='post' action=''>
		<input type='hidden' name='formName' value='".DEVBOX_CHANGE_WIKI_FORMNAME."'/>
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
