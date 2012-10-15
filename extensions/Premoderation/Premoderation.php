<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgExtensionCredits['antispam'][] = array(
	'path' => __FILE__,
	'name' => 'Premoderation',
	'author' => array( 'Cryptocoryne' ),
	'descriptionmsg' => 'premoderation-desc',
	'version' => '1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Premoderation',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['Premoderation'] =  "$dir/Premoderation.i18n.php";
$wgAutoloadClasses['Premoderation'] = "$dir/Premoderation.class.php";
$wgAutoloadClasses['SpecialPremoderation'] = "$dir/SpecialPremoderation.php";
$wgAutoloadClasses['SpecialPremoderationWhiteList'] = "$dir/SpecialPremoderationWhiteList.php";

$wgSpecialPages['Premoderation'] = 'SpecialPremoderation';
$wgSpecialPages['PremoderationWhiteList'] = 'SpecialPremoderationWhiteList';
$wgSpecialPageGroups['Premoderation'] = 'wiki';
$wgSpecialPageGroups['PremoderationWhiteList'] = 'wiki';

$wgAvailableRights[] = 'premoderation';
$wgAvailableRights[] = 'premoderation-log';
$wgAvailableRights[] = 'premoderation-viewip';
$wgAvailableRights[] = 'premoderation-wlist';
$wgAvailableRights[] = 'skipmoderation';

$wgLogTypes[] = 'prem-public';
$wgLogTypes[] = 'prem-private';
$wgLogTypes[] = 'prem-whitelist';
$wgLogNames['prem-public'] = 'prem-public-logname';
$wgLogNames['prem-private'] = 'prem-private-logname';
$wgLogNames['prem-whitelist'] = 'prem-whitelist-logname';
$wgLogHeaders['prem-public'] = 'prem-public-logtext';
$wgLogHeaders['prem-private'] = 'prem-private-logtext';
$wgLogHeaders['prem-whitelist'] = 'prem-whitelist-logtext';
$wgLogActions['prem-public/create'] = 'prem-log-approve-create';
$wgLogActions['prem-public/update'] = 'prem-log-approve-update';
$wgLogActions['prem-public/updateold'] = 'prem-log-approve-updateold';
$wgLogActions['prem-private/status'] = 'prem-log-status';
$wgLogActions['prem-whitelist/add'] = 'prem-log-whitelist-add';
$wgLogActions['prem-whitelist/delete'] = 'prem-log-whitelist-delete';
$wgLogRestrictions['prem-private'] = 'premoderation-log';
$wgLogRestrictions['prem-whitelist'] = 'premoderation-wlist';

// Handler: 'all' or 'abusefilter'
$wgPremoderationType = 'all';

// Disable approved revision in pages with new published revisions
$wgPremoderationStrict = false;

// Disable editing of pages with unapproved revisions in moderation queue
$wgPremoderationLockPages = false;

// Lifetime of revisions in moderation queue
$wgPremoderationDeclinedPurge = 86400 * 3;
$wgPremoderationNewPurge = 86400 * 14;

$wgExtensionFunctions[] = 'Premoderation::initialize';