<?php
/**
 * This Extension provides Special:Protectsite, which makes it possible for
 * users with protectsite permissions to quickly lock down and restore various
 * privileges for anonymous and registered users on a wiki.
 *
 * Knobs:
 * 'protectsite' - Group permission to use the special page.
 * $wgProtectsiteLimit - Maximum time allowed for protection of the site.
 * $wgProtectsiteDefaultTimeout - Default protection time.
 * $wgProtectsiteExempt - Array of non-sysop usergroups to be not effected by rights changes
 */

if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__);

/* Register the new user rights level */
$wgAvailableRights[] = 'protectsite';

/* Set the group access permissions */
#$wgGroupPermissions['sysop']['protectsite'] = true; //is conditionally set outside of extension

/* Add this Special page to the Special page listing array */
$wgSpecialPages['Protectsite'] = array( 'SpecialPage', 'Protectsite', 'protectsite', true, false, "$dir/SpecialProtectSite_body.php" );

/* Register initialization function */
$wgExtensionFunctions[] = 'wfSetupProtectsite';

/* Extension Credits.  Splarka wants me to be so UN:VAIN!  Haet haet hat! */
$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Protect Site',
	'version'        => '0.2',
	'description'    => 'Allows a site administrator to temporarily block various site modifications',
	'author'         => array( '[http://uncyclopedia.wikia.com/wiki/User:Dawg Eric Johnston (Dawg)]', 'C. \'Uberfuzzy\' Stafford' ),
	'descriptionmsg' => 'specialprotectsite-desc',
);

$wgExtensionMessagesFiles['SpecialProtectSite'] = $dir . '/SpecialProtectSite.i18n.php';

/* Set the default timeout if not set in the configuration. */
if( empty( $wgProtectsiteDefaultTimeout ) ) {
	$wgProtectsiteDefaultTimeout = '1 hour';
}


/**
 * This function does all the initialization work for the extension.
 * Persistent data is unserialized from a record in the objectcache table
 * which is set in the Special page.  It will change the permissions for
 * various functions for anonymous and registered users based on the data
 * in the array.  The data expires after the set amount of time, just like
 * a block.
 */
function wfSetupProtectsite() {
	/* Globals */
	global $wgUser, $wgGroupPermissions, $wgVersion, $wgMemc, $wgProtectsiteExempt, $wgCommandLineMode;

	// macbre: don't run code below when running in command line mode (memcache starts to act strange)
	if (!empty($wgCommandLineMode)) {
		return;
	}

	/* Initialize Object */
	$persist_data = new MediaWikiBagOStuff();

	/* Get data into the prot hash */
	$prot = $wgMemc->get(wfMemcKey('protectsite'));
	if( !$prot ) {
		$prot = $persist_data->get('protectsite');
		if( !$prot ) {
			$wgMemc->set(wfMemcKey('protectsite'), 'disabled');
		}
	}

	/* Logic to disable the selected user rights */
	if (is_array($prot)) {
		/* MW doesn't timout correctly, this handles it */
		if (time() >= $prot['until']) {
			$persist_data->delete('protectsite');
		}

		/* Protection-related code */
		/* Code for MediaWiki 1.8+ */
		$wgGroupPermissions['*']['createaccount'] = !($prot['createaccount'] >= 1);
		$wgGroupPermissions['user']['createaccount'] = !($prot['createaccount'] == 2);

		$wgGroupPermissions['*']['createpage'] = !($prot['createpage'] >= 1);
		$wgGroupPermissions['*']['createtalk'] = !($prot['createpage'] >= 1);
		$wgGroupPermissions['user']['createpage'] = !($prot['createpage'] == 2);
		$wgGroupPermissions['user']['createtalk'] = !($prot['createpage'] == 2);
		$wgGroupPermissions['sysop']['createpage'] = true;
		$wgGroupPermissions['sysop']['createtalk'] = true;

		$wgGroupPermissions['*']['edit'] = !($prot['edit'] >= 1);
		$wgGroupPermissions['user']['edit'] = !($prot['edit'] == 2);
		$wgGroupPermissions['sysop']['edit'] = true;

		$wgGroupPermissions['user']['move'] = !($prot['move'] == 1);
		$wgGroupPermissions['user']['upload'] = !($prot['upload'] == 1);
		$wgGroupPermissions['user']['reupload'] = !($prot['upload'] == 1);
		$wgGroupPermissions['user']['reupload-shared'] = !($prot['upload'] == 1);

		// are there any groups that should not get affected by Protectsite's lockdown?
		if( !empty($wgProtectsiteExempt) && is_array($wgProtectsiteExempt) ) {
			//there are, so loop over them, and force these rights to be true
			//will resolve any problems from inheriting rights from 'user' or 'sysop'
			foreach($wgProtectsiteExempt as $ExemptGroup)
			{
				$wgGroupPermissions[$ExemptGroup]['edit'] = 1;
				$wgGroupPermissions[$ExemptGroup]['createpage'] = 1;
				$wgGroupPermissions[$ExemptGroup]['createtalk'] = 1;
				$wgGroupPermissions[$ExemptGroup]['move'] = 1;
				$wgGroupPermissions[$ExemptGroup]['upload'] = 1;
				$wgGroupPermissions[$ExemptGroup]['reupload'] = 1;
				$wgGroupPermissions[$ExemptGroup]['reupload-shared'] = 1;
			}
		}
	}
}

