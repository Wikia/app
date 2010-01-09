<?php
////
// Author: Sean Colombo
// Date: 20100107
//
// This panel will help developers administer their dev-boxes
// more easily.  This includes the ability to see what databases
// are currently available locally and to easily pull new databases
// in from production slaves.
//
// This panel will only work on systems where $wgDevelEnvironment is set to true.
//
// Prerequisite: need to have the 'devbox' user on your local database.
// TO GET THERE: Do "sudo su -" then "mysql" then "GRANT ALL ON *.* TO 'devbox'@'localhost' IDENTIFIED BY 'devbox'".
// TODO: Make sure all dev-boxes get to that point automatically w/a devbox/devbox user.
////

if(!defined('MEDIAWIKI')) die();

// this is so that only sysops can do batch moves
$wgAvailableRights[] = 'devboxpanel';
//$wgGroupPermissions['sysop']['devboxpanel'] = true;
$wgGroupPermissions['*']['devboxpanel'] = true; // for now, allow all users as long as $wgDevelEnvironment is true

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['DevBoxPanel'] = $dir.'Special_DevBoxPanel.i18n.php';

$wgExtensionFunctions[] = 'wfSetupDevBoxPanel';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Dev-Box Panel',
	'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
	'description' => 'This extension makes it easier to administer a Wikia Dev Box.',
	'version' => '0.0.1',
);

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

		// TODO: Do any processing of actions here (and display success/error messages).

		
		//// DISPLAY OF THE MAIN CONTENT OF THE PANEL IS BELOW ////
		
		// TODO: Display a section with vital stats on the server (where the LocalSettings are, the error logs, databases, etc.) with a link to phpinfo.
		$wgOut->addHTML(getHtmlForInfo());

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
		asort($available_dbs);

		// TODO: DISPLAY THE GUI FOR GETTING MORE DATABASES.

		$wgOut->addHTML("<table class='devBoxPanel'>");
		$wgOut->addHTML("<tr><th>".wfMsg("devbox-dbs-on-devbox")."</th><th>".wfMsg("devbox-dbs-in-production")."</th></tr>");
		$wgOut->addHTML("<tr><td width='50%'>");
		if(count($local_dbs) > 0){
			$wgOut->addHTML("<em>".wfMsg("devbox-section-existing")."</em>");
			$wgOut->addHTML("<ul>");
			foreach($local_dbs as $dbName){
				$wgOut->addHTML("<li class='dbp-alreadyInstalled'>$dbName</li>");
			}
			$wgOut->addHTML("</ul>");
		}
		$wgOut->addHTML("</td><td width='50%'>");
		if(count($available_dbs) > 0){
			$wgOut->addHTML("<em>".wfMsg("devbox-section-summary")."</em>");
			$wgOut->addHTML("<ul>");
			// List the databases we already have and the recommended ones first.
			foreach($available_dbs as $dbName){
				$reloadIt = "<a href='#'>".wfMsg("devbox-reload-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
				$getIt = "<a href='#'>".wfMsg("devbox-get-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
				if(in_array($dbName, $local_dbs)){
					// Already have this database.
					$wgOut->addHTML("<li class='dbp-alreadyInstalled'>$dbName <span class='dbp-rightButtons'>$reloadIt</span></li>");
				} else if(in_array($dbName, $RECOMMENDED_DBS)){
					// This isn't installed yet but it's recommended that it should be.
					$wgOut->addHTML("<li class='dbp-recommended'>$dbName <span class='dbp-rightButtons'><em>".wfMsg("devbox-recommended")."</em> $getIt</span></li>");
				}
			}
			$wgOut->addHTML("</ul>");

			// Go through and list ALL databases now.
			$wgOut->addHTML("<br/><em>".wfMsg("devbox-section-all")."</em>");
			$wgOut->addHTML("<ul>");
			foreach($available_dbs as $dbName){
				$reloadIt = "<a href='#'>".wfMsg("devbox-reload-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
				$getIt = "<a href='#'>".wfMsg("devbox-get-db")."</a>"; // TODO: MAKE THIS A WORKING LINK
				if(in_array($dbName, $local_dbs)){
					// Already have this database.
					$wgOut->addHTML("<li class='dbp-alreadyInstalled'>$dbName <span class='dbp-rightButtons'>$reloadIt</span></li>");
				} else if(in_array($dbName, $RECOMMENDED_DBS)){
					// This isn't installed yet but it's recommended that it should be.
					$wgOut->addHTML("<li class='dbp-recommended'>$dbName <span class='dbp-rightButtons'><em>".wfMsg("devbox-recommended")."</em> $getIt</span></li>");
				} else {
					// Available, not currently installed, not one of the specifically recommended.
					// This will be most databases.
					$wgOut->addHTML("<li class='dbp-available'>$dbName <span class='dbp-rightButtons'>$getIt</span></li>");
				}
			}
			$wgOut->addHTML("</ul>");
		}
		$wgOut->addHTML("</td></tr></table>");
	} else {
		$wgOut->addHTML(wfMsg('devbox-panel-not-enabled'));
	}

} // end wfDevBoxPanel()

/**
 * Displays information that will help the developer develop more
 * easily instead of having to track down this information elsewhere.
 * All hard to find files, settings, etc. should be here.
 */
function getHtmlForInfo(){
	$html = "";
	
	$html .= "<em>".wfMsg("devbox-vital-settings")."</em>";

	GLOBAL $IP,$wgScriptPath,$wgExtensionsPath;
	
	$settings = array(
		"error_log"            => ini_get('error_log'),
		"\$IP"                 => $IP,
		"\$wgScriptPath"       => $wgScriptPath,
		"\$wgExtensionsPath"   => $wgExtensionsPath,
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

?>
