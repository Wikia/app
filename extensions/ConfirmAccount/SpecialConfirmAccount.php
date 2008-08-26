<?php
#(c) Aaron Schulz 2007, GPL

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "ConfirmAccount extension\n";
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Confirm user accounts',
	'description' => 'Gives bureaucrats the ability to confirm account requests',
	'descriptionmsg' => 'confirmedit-desc',
	'author' => 'Aaron Schulz',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ConfirmAccount',
	'version' => '1.46',
);

# This extension needs email enabled!
# Otherwise users can't get their passwords...
if( !$wgEnableEmail ) {
	echo "ConfirmAccount extension requires \$wgEnableEmail set to true \n";
	exit( 1 ) ;
}

# Set the person's bio as their userpage?
$wgMakeUserPageFromBio = true;
# Text to add to bio pages if the above option is on
$wgAutoUserBioText = '';

$wgAutoWelcomeNewUsers = true;
# Make the username of the real name?
$wgUseRealNamesOnly = true;

# How long to store rejected requests
$wgRejectedAccountMaxAge = 7 * 24 * 3600; // One week
# How long after accounts have been requested/held before they count as 'rejected'
$wgConfirmAccountRejectAge = 30 * 24 * 3600; // 1 month

# How many requests can an IP make at once?
$wgAccountRequestThrottle = 1;
# Can blocked users request accounts?
$wgAccountRequestWhileBlocked = false;

# Minimum biography specs
$wgAccountRequestMinWords = 50;

# Show ToS checkbox
$wgAccountRequestToS = true;
# Show confirmation info fields
$wgAccountRequestExtraInfo = true;

# Prospective account access levels.
# Should be integer -> (special page param,user group,autotext) pairs.
# The account queues are at Special:ConfirmAccount/param.
$wgAccountRequestTypes = array(
	0 => array( 'authors', 'user' )
);

# If set, will add {{DEFAULTSORT:sortkey}} to userpages for auto-categories.
# The sortkey will be made be replacing the first element of this array
# (regexp) with the second. Set this variable to false to avoid sortkey use.
$wgConfirmAccountSortkey = false;
// For example, the below will do {{DEFAULTSORT:firstname, lastname}}
#$wgConfirmAccountSortkey = array( '/^(.+) ([^ ]+)$/', '$2, $1' );

# IMPORTANT: do we store the user's notes and credentials
# for sucessful account request? This will be stored indefinetely
# and will be accessible to users with crediential lookup permissions
$wgConfirmAccountSaveInfo = true;

# Send an email to address when account requests confirm their email.
# Set to false to skip this.
$wgConfirmAccountContact = false;

# If ConfirmEdit is installed and set to trigger for createaccount,
# inject catpchas for requests too?
$wgConfirmAccountCaptchas = true;

# Location of attached files for pending requests
$wgAllowAccountRequestFiles = true;
$wgAccountRequestExts = array('txt','pdf','doc','latex','rtf','text','wp','wpd','sxw');
$wgFileStore['accountreqs']['directory'] = "{$wgUploadDirectory}/accountreqs";
$wgFileStore['accountreqs']['url'] = null; // Private
$wgFileStore['accountreqs']['hash'] = 3;

# Location of credential files
$wgFileStore['accountcreds']['directory'] = "{$wgUploadDirectory}/accountcreds";
$wgFileStore['accountcreds']['url'] = null; // Private
$wgFileStore['accountcreds']['hash'] = 3;

$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['bureaucrat']['confirmaccount'] = true;
# This right has the request IP show when confirming accounts
$wgGroupPermissions['bureaucrat']['requestips'] = true;

# If credentials are stored, this right lets users look them up
$wgGroupPermissions['bureaucrat']['lookupcredentials'] = true;

$wgAvailableRights[] = 'confirmaccount';
$wgAvailableRights[] = 'requestips';
$wgAvailableRights[] = 'lookupcredentials';

# Show notice for open requests to admins?
# This is cached, but still can be expensive on sites with thousands of requests.
$wgConfirmAccountNotice = true;

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ConfirmAccount'] = $dir . 'ConfirmAccount.i18n.php';
$wgExtensionAliasesFiles['ConfirmAccount'] = $dir . 'ConfirmAccount.alias.php';

function efAddRequestLoginText( &$template ) {
	global $wgUser;

	wfLoadExtensionMessages( 'ConfirmAccount' );
	
	if( !$wgUser->isAllowed('createaccount') ) {
		$template->set( 'header', wfMsgExt('requestaccount-loginnotice', array('parse') ) );
	}
	return true;
}

function efCheckIfAccountNameIsPending( &$user, &$abortError ) {
	# If an account is made with name X, and one is pending with name X
	# we will have problems if the pending one is later confirmed
	$dbw = wfGetDB( DB_MASTER );
	$dup = $dbw->selectField( 'account_requests', '1',
		array( 'acr_name' => $user->getName() ),
		__METHOD__ );
	if ( $dup ) {
		wfLoadExtensionMessages( 'ConfirmAccount' );
		$abortError = wfMsgHtml('requestaccount-inuse');
		return false;
	}
	return true;
}

function efConfirmAccountInjectStyle() {
	global $wgOut, $wgUser;
	# Don't load unless needed
	if( !$wgUser->isAllowed('confirmaccount') )
		return true;
	# FIXME: find better load place
	# UI CSS
	$wgOut->addLink( array(
		'rel'	=> 'stylesheet',
		'type'	=> 'text/css',
		'media'	=> 'screen, projection',
		'href'	=> CONFIRMACCOUNT_CSS,
	) );
	return true;
}

function wfConfirmAccountsNotice( $notice ) {
	global $wgConfirmAccountNotice, $wgUser;

	if( !$wgConfirmAccountNotice || !$wgUser->isAllowed('confirmaccount') )
		return true;
		
	global $wgMemc, $wgOut;
	# Check cached results
	$key = wfMemcKey( 'confirmaccount', 'noticecount' );
	$count = $wgMemc->get( $key );
	# Only show message if there are any such requests
	if( !$count )  {
		$dbw = wfGetDB( DB_MASTER );
		$count = $dbw->selectField( 'account_requests', 'COUNT(*)',
			array( 'acr_deleted' => 0, 'acr_held IS NULL', 'acr_email_authenticated IS NOT NULL' ),
			__METHOD__ );
		# Use '-' for zero, to avoid any confusion over key existence
		if( !$count ) {
			$count = '-';
		}
		# Cache results
		$wgMemc->set( $key, $count, 3600*24*7 );
	}
	if( $count !== '-' ) {
		wfLoadExtensionMessages( 'ConfirmAccount' );
		$message = wfMsgExt( 'confirmaccount-newrequests', array('parsemag'), $count );
	
		$notice .= '<div id="mw-confirmaccount-msg" class="mw-confirmaccount-bar">' . $wgOut->parse($message) . '</div>';
	}
	return true;
}

$dir = dirname(__FILE__) . '/';
# Request an account
$wgSpecialPages['RequestAccount'] = 'RequestAccountPage';
$wgAutoloadClasses['RequestAccountPage'] = $dir . 'RequestAccount_body.php';
$wgSpecialPageGroups['RequestAccount'] = 'login';
# Confirm accounts
$wgSpecialPages['ConfirmAccounts'] = 'ConfirmAccountsPage';
$wgAutoloadClasses['ConfirmAccountsPage'] = $dir . 'ConfirmAccount_body.php';
$wgSpecialPageGroups['ConfirmAccounts'] = 'users';
# Account credentials
$wgSpecialPages['UserCredentials'] = 'UserCredentialsPage';
$wgAutoloadClasses['UserCredentialsPage'] = $dir . 'UserCredentials_body.php';
$wgSpecialPageGroups['UserCredentials'] = 'users';

$wgExtensionFunctions[] = 'efLoadConfirmAccount';
# Add notice of where to request an account
$wgHooks['UserCreateForm'][] = 'efAddRequestLoginText';
$wgHooks['UserLoginForm'][] = 'efAddRequestLoginText';
# Check for collisions
$wgHooks['AbortNewAccount'][] = 'efCheckIfAccountNameIsPending';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efConfirmAccountSchemaUpdates';
# Status header like "new messages" bar
$wgHooks['SiteNoticeAfter'][] = 'wfConfirmAccountsNotice';

function efLoadConfirmAccount() {
	global $wgScriptPath;
	if( !defined( 'CONFIRMACCOUNT_CSS' ) )
		define('CONFIRMACCOUNT_CSS', $wgScriptPath.'/extensions/ConfirmAccount/confirmaccount.css' );
	efConfirmAccountInjectStyle();
}

function efConfirmAccountSchemaUpdates() {
	global $wgDBtype, $wgExtNewFields, $wgExtPGNewFields, $wgExtNewTables, $wgExtNewIndexes;
	
	$base = dirname(__FILE__);
	if( $wgDBtype == 'mysql' ) {
		$wgExtNewFields[] = array('account_requests', 'acr_filename',
			"$base/archives/patch-acr_filename.sql" );
			
		$wgExtNewTables[] = array('account_credentials', "$base/archives/patch-account_credentials.sql" );
		
		$wgExtNewFields[] = array('account_requests', 'acr_areas', "$base/archives/patch-acr_areas.sql" );
		
		$wgExtNewIndexes[] = array('account_requests', 'acr_email', "$base/archives/patch-email-index.sql" );
	} else if( $wgDBtype == 'postgres' ) {
		$wgExtPGNewFields[] = array('account_requests', 'acr_held', "TIMESTAMPTZ" );
		$wgExtPGNewFields[] = array('account_requests', 'acr_filename', "TEXT" );
		$wgExtPGNewFields[] = array('account_requests', 'acr_storage_key', "TEXT" );
		$wgExtPGNewFields[] = array('account_requests', 'acr_comment', "TEXT NOT NULL DEFAULT ''" );
		
		$wgExtPGNewFields[] = array('account_requests', 'acr_type', "INTEGER NOT NULL DEFAULT 0" );
		$wgExtNewTables[] = array('account_credentials', "$base/postgres/patch-account_credentials.sql" );
		$wgExtPGNewFields[] = array('account_requests', 'acr_areas', "TEXT" );
		$wgExtPGNewFields[] = array('account_credentials', 'acd_areas', "TEXT" );
		
		$wgExtNewIndexes[] = array('account_requests', 'acr_email', "$base/postgres/patch-email-index.sql" );
	}
	
	return true;
}
