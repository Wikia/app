<?php
/**
 * @author Sean Colombo
 *
 * Special pages to make the modifications necessary for the current wiki to
 * become a recipes site.
 */

if(!defined('MEDIAWIKI'))
   die();

$wgAvailableRights[] = 'becomerecipes';
$wgGroupPermissions['staff']['becomerecipes'] = true;

$wgExtensionFunctions[] = 'wfBecomeRecipesSetup';
$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Become Recipes',
   'author' => '[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]',
   'description' => 'Make necessary database and message changes to turn the wiki into a Recipes wiki (only needs to be done once per wiki).'
);

/* special page init */
function wfBecomeRecipesSetup() {
	global $IP, $wgMessageCache;
	require_once($IP. '/includes/SpecialPage.php');

	SpecialPage::addPage(new SpecialPage('Becomerecipes', 'becomerecipes', true, 'wfBecomeRecipesSpecial', false));
	$wgMessageCache->addMessages(array('becomerecipes' => 'Make this site into a recipes site'));
}

/* the core */
function wfBecomeRecipesSpecial( $par ) {
	global $wgOut, $wgUser, $wgRequest ;
   	$wgOut->setPageTitle ("Become a Recipes Wiki");

	// Detect if this is a recipes site...
	$isAlreadyRecipes = false;
	$dbr = wfGetDB(DB_MASTER);
	$queryString = "SHOW COLUMNS FROM watchlist";
	$result = $dbr->query($queryString, __METHOD__);
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
	} else if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			if($row['Field'] == "wl_wikia_addedtimestamp"){
				$isAlreadyRecipes = true;
			}
		}
	}
	
	if($isAlreadyRecipes){
		$wgOut->addHTML("<div style='border:#0f0 solid 1px;background-color:#cfc'>This database is already set up as a recipes site.  You're good to go!</div>");
	} else {
		$numErrors = 0;
		// Perform database alterations.
		if(!$dbr->query("ALTER TABLE `watchlist` ADD `wl_wikia_addedtimestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP", __METHOD__)){
			$wgOut->addHTML("ERROR: Error adding wl_wikia_addedtimestamp column to watchlist table.<br/>\n");
			$numErrors++;
		}
		if(!$dbr->query("ALTER TABLE `watchlist` ADD INDEX ( `wl_wikia_addedtimestamp` )", __METHOD__)){
			$wgOut->addHTML("ERROR: Error adding INDEX to wl_wikia_addedtimestamp column in watchlist table.<br/>\n");
			$numErrors++;
		}
		$wgOut->addHTML("Database alterations complete.<br/>\n");

		// Change certain messages.
		$numErrors += setMessage("MediaWiki:Watch", "Save this page");
		$numErrors += setMessage("MediaWiki:Unwatch", "Remove");
		$numErrors += setMessage("MediaWiki:watching", "Saving");
		$numErrors += setMessage("MediaWiki:unwatching", "Removing");
		$numErrors += setMessage("MediaWiki:addedwatchtext", "The page \"[[$1]]\" has been added to your Saved Pages");
		$numErrors += setMessage("MediaWiki:removedwatchtext", "The page \"[[$1]]\" has been removed from your Saved Pages");
		$numErrors += setMessage("MediaWiki:sf-link", "Share this page");
		$numErrors += setMessage("MediaWiki:Talkpage", "Messages");
		$numErrors += setMessage("MediaWiki:Article-comments-comments", "Add a Tip or Comment");
		$numErrors += setMessage("MediaWiki:Article-comments-post", "Post");
		$numErrors += setMessage("MediaWiki:Widget-title-community", "New recipes");
		$wgOut->addHTML("Messages updated.<br/>\n");

		// Success xor error message.
		if($numErrors == 0){
			$wgOut->addHTML("<div style='border:#0f0 solid 1px;background-color:#cfc'>Setup complete.  This wiki will now function as a recipes site.</div>");
		} else {
			$wgOut->addHTML("<div style='border:#f00 solid 1px;background-color:#fcc'>There were errors while trying to become a recipes wiki.  Please see above.</div>");
		}
	}

} // end wfBecomeRecipesSpecial()

/**
 * Given the name of the message (with preceding "MediaWiki:"), updates it's contents
 * to be the content passed in.  This happens as an edit from the currently logged in user.
 *
 * Returns an integer that is the number of errors (so 0 on success and one on failure).
 */
function setMessage($msgName, $content){
	global $wgOut;
	$numErrors = 0;
	$wgTitle = Title::newFromText( $msgName );
	if ( !$wgTitle ) {
		$wgOut->addHTML("ERROR: Invalid title: \"$msgName\"<br/>\n");
		$numErrors++;
	} else {
		$wgArticle = new Article( $wgTitle );

		# Do the edit
		$flags = 0;
		$summary = "Switching to Recipes messaging.";
		$success = $wgArticle->doEdit( $text, $summary, $flags);
		if ( $success ) {
			$wgOut->addHTML("Sucessfully updated \"$msgName\".<br/>\n");
		} else {
			$wgOut->addHTML("ERROR: Unable to update \"$msgName\".<br/>\n");
			$numErrors++;
		}
	}

	return $numErrors;
} // end setMessage()
