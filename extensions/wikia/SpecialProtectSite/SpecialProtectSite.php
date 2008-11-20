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
 */

if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__);

/* Register the new user rights level */
$wgAvailableRights[] = 'protectsite';

/* Set the group access permissions */
$wgGroupPermissions['bureaucrat']['protectsite'] = true;

/* Add this Special page to the Special page listing array */
$wgSpecialPages['Protectsite'] = array( 'SpecialPage', 'Protectsite', 'protectsite', true, false, "$dir/SpecialProtectSite_body.php" );

/* Register initialization function */
$wgExtensionFunctions[] = 'wfSetupProtectsite';

/* Extension Credits.  Splarka wants me to be so UN:VAIN!  Haet haet hat! */
$wgExtensionCredits['specialpage'][] = array(
  'name'        => 'Protect Site',
  'version'     => '0.1',
  'description' => 'allows a site administrator to temporarily block various site modifications',
  'author'      => '[mailto:e.wolfie@gmail.com Eric Johnston] ' .
                   '<nowiki>[</nowiki>' .
                   '[http://uncyclopedia.org/wiki/User:Dawg Uncyclopedia:Dawg]' .
                   '<nowiki>]</nowiki>',
);

$wgExtensionMessagesFiles['SpecialProtectSite'] = $dir . '/SpecialProtectSite.i18n.php';

/* Set the default timeout if not set in the configuration. */
if( !isset( $wgProtectsiteDefaultTimeout ) ) {
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
	global $wgUser, $wgGroupPermissions, $wgVersion, $wgMemc;

	/* Initialize Object */
	$persist_data = new MediaWikiBagOStuff();

	/* Get data into the prot hash */
	$prot = $wgMemc->get('protectsite');
	if( !$prot ) {
		$prot = $persist_data->get('protectsite');
		if( !$prot ) {
			$wgMemc->set('protectsite', 'disabled');
		}
	}

	/* Chop a single named value out of an array and return the new array.
	 * This is required for 1.7 compatibility.
	 * Remove from source once 1.8+ is required for use of this extension.
	 */
	function chop_array($arr,$value) {
		if (in_array($value, $arr)) {
			foreach ($arr as $val) {
				if ($val != $value) {
					$ret[] = $val;
				}
			}
			return $ret;
		}
		else {
			return $arr;
		}
	}

	/* Logic to disable the selected user rights */
	if (is_array($prot)) {
		/* MW doesn't timout correctly, this handles it */
		if (time() >= $prot['until']) {
			$persist_data->delete('protectsite');
		}

		/* Protection-related code */
		if (version_compare($wgVersion,'1.8','>=')) {
			/* Code for MediaWiki 1.8 */
			$wgGroupPermissions['*']['createaccount'] = !($prot['createaccount'] >= 1);
			$wgGroupPermissions['user']['createaccount'] = !($prot['createaccount'] == 2);

			$wgGroupPermissions['*']['createpage'] = !($prot['createpage'] >= 1);
			$wgGroupPermissions['*']['createtalk'] = !($prot['createpage'] >= 1);
			$wgGroupPermissions['user']['createpage'] = !($prot['createpage'] == 2);
			$wgGroupPermissions['user']['createtalk'] = !($prot['createpage'] == 2);

			$wgGroupPermissions['*']['edit'] = !($prot['edit'] >= 1);
			$wgGroupPermissions['user']['edit'] = !($prot['edit'] == 2);
			$wgGroupPermissions['sysop']['edit'] = true;

			$wgGroupPermissions['user']['move'] = !($prot['move'] == 1);
			$wgGroupPermissions['user']['upload'] = !($prot['upload'] == 1);
			$wgGroupPermissions['user']['reupload'] = !($prot['upload'] == 1);
			$wgGroupPermissions['user']['reupload-shared'] = !($prot['upload'] == 1);
		}
		else {
			/* Code for MediaWiki 1.7 (and possibly below) */
			if (!in_array('sysop',$wgUser->mGroups) && !in_array('bureaucrat',$wgUser->mGroups)) {
				if ($wgUser->mId == 0) {
					if ($prot['createaccount'] >= 1) {
						$wgUser->mRights = chop_array($wgUser->mRights,'createaccount');
					}

					if ($prot['createpage'] >= 1) {
						$wgUser->mRights = chop_array($wgUser->mRights,'createpage');
						$wgUser->mRights = chop_array($wgUser->mRights,'createtalk');
					}

					if ($prot['edit'] >= 1) {
						$wgUser->mRights = chop_array($wgUser->mRights,'edit');
					}
				}
				else {
					if ($prot['createaccount'] == 2) {
						$wgUser->mRights = chop_array($wgUser->mRights,'createaccount');
					}

					if ($prot['createpage'] == 2) {
						$wgUser->mRights = chop_array($wgUser->mRights,'createpage');
						$wgUser->mRights = chop_array($wgUser->mRights,'createtalk');
					}

					if ($prot['edit'] == 2) {
						$wgUser->mRights = chop_array($wgUser->mRights,'edit');
					}

					if ($prot['move'] == 1) {
						$wgUser->mRights = chop_array($wgUser->mRights,'move');
					}

					if ($prot['upload'] == 1) {
						$wgUser->mRights = chop_array($wgUser->mRights,'upload');
						$wgUser->mRights = chop_array($wgUser->mRights,'reupload');
						$wgUser->mRights = chop_array($wgUser->mRights,'reupload-shared');
					}
				}
			}
		}
	}
}

