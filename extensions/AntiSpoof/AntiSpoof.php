<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'AntiSpoof',
	'svn-date' => '$LastChangedDate: 2009-02-02 16:06:12 +0100 (pon, 02 lut 2009) $',
	'svn-revision' => '$LastChangedRevision: 46709 $',
	'url' => 'http://www.mediawiki.org/wiki/Extension:AntiSpoof',
	'author' => 'Brion Vibber',
	'description' => 'Blocks the creation of accounts with mixed-script, confusing and similar usernames',
	'descriptionmsg' => 'antispoof-desc',
);

/**
 * Set this to false to disable the active checks;
 * items will be logged but invalid or conflicting
 * accounts will not be stopped.
 *
 * Logged items will be marked with 'LOGGING' for
 * easier review of old logs' effect.
 */
$wgAntiSpoofAccounts = true;

/**
 * Allow sysops and bureaucrats to override the spoofing checks
 * and create accounts for people which hit false positives.
 */
$wgGroupPermissions['sysop']['override-antispoof'] = true;
$wgGroupPermissions['bureaucrat']['override-antispoof'] = true;
$wgAvailableRights[] = 'override-antispoof';

$dir = dirname( __FILE__ );

$wgExtensionMessagesFiles['AntiSpoof'] = "$dir/AntiSpoof.i18n.php";

$wgAutoloadClasses['AntiSpoof'] = "$dir/AntiSpoof_body.php";
$wgAutoloadClasses['SpoofUser'] = "$dir/SpoofUser.php";

$wgHooks['LoadExtensionSchemaUpdates'][] = 'asUpdateSchema';
$wgHooks['AbortNewAccount'][] = 'asAbortNewAccountHook';
$wgHooks['UserCreateForm'][] = 'asUserCreateFormHook';
$wgHooks['AddNewAccount'][] = 'asAddNewAccountHook';

function asUpdateSchema() {
	global $wgExtNewTables, $wgDBtype;
	$wgExtNewTables[] = array(
		'spoofuser',
		dirname( __FILE__ ) . '/sql/patch-antispoof.' . $wgDBtype . '.sql' );
	return true;
}

/**
 * Hook for user creation form submissions.
 * @param User $u
 * @param string $message
 * @return bool true to continue, false to abort user creation
 */
function asAbortNewAccountHook( $user, &$message ) {
	global $wgAntiSpoofAccounts, $wgUser, $wgRequest;
	wfLoadExtensionMessages( 'AntiSpoof' );

	if( !$wgAntiSpoofAccounts ) {
		$mode = 'LOGGING ';
		$active = false;
	} elseif( $wgRequest->getCheck('wpIgnoreAntiSpoof') &&
			$wgUser->isAllowed( 'override-antispoof' ) ) {
		$mode = 'OVERRIDE ';
		$active = false;
	} else {
		$mode = '';
		$active = true;
	}

	$name = $user->getName();
	$spoof = new SpoofUser( $name );
	if( $spoof->isLegal() ) {
		$normalized = $spoof->getNormalized();
		$conflicts = $spoof->getConflicts();
		if( empty($conflicts) ) {
			wfDebugLog( 'antispoof', "{$mode}PASS new account '$name' [$normalized]" );
		} else {
			wfDebugLog( 'antispoof', "{$mode}CONFLICT new account '$name' [$normalized] spoofs " . implode( ',', $conflicts ) );
			if( $active ) {
				$numConflicts = count( $conflicts );
				$message = wfMsgExt( 'antispoof-conflict-top', array('parsemag'), $name, $numConflicts );
				$message .= '<ul>';
				foreach( $conflicts as $simUser ) {
					$message .= '<li>' . wfMsg( 'antispoof-conflict-item', $simUser ) . '</li>';
				}
				$message .= '</ul>' . wfMsg( 'antispoof-conflict-bottom' );
				return false;
			}
		}
	} else {
		$error = $spoof->getError();
		wfDebugLog( 'antispoof', "{$mode}ILLEGAL new account '$name' $error" );
		if( $active ) {
			$message = wfMsg( 'antispoof-name-illegal', $name, $error );
			return false;
		}
	}
	return true;
}

/**
 * Set the ignore spoof thingie
 */
function asUserCreateFormHook( &$template ) {
	global $wgRequest, $wgAntiSpoofAccounts, $wgUser;

	wfLoadExtensionMessages( 'AntiSpoof' );

	if( $wgAntiSpoofAccounts && $wgUser->isAllowed( 'override-antispoof' ) )
		$template->addInputItem( 'wpIgnoreAntiSpoof',
			$wgRequest->getCheck('wpIgnoreAntiSpoof'),
			'checkbox', 'antispoof-ignore' );
	return true;
}

/**
 * On new account creation, record the username's thing-bob.
 */
function asAddNewAccountHook( $user ) {
	$spoof = new SpoofUser( $user->getName() );
	$spoof->record();
	return true;
}
