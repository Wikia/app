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

	
	// TODO: Detect if this is a recipes site...
	
	
	// TODO: If this is not yet a recipes site, perform the database upgrades
	// TODO: If this is not yet a recipes site, change the messages (as the current user).
	
	// TODO: Display a message that either says that the conversion is now done, or that it was ALREADY done and doesn't need to be done again.
	
	
}
