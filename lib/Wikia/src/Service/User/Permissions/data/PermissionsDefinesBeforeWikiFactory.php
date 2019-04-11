<?php

$wgGroupPermissions = array();

// Implicit group for all visitors
$wgGroupPermissions['*']['createaccount']    = true;
$wgGroupPermissions['*']['read']             = true;
$wgGroupPermissions['*']['edit']             = true;
$wgGroupPermissions['*']['createpage']       = true;
$wgGroupPermissions['*']['createtalk']       = true;
$wgGroupPermissions['*']['writeapi']         = true;
$wgGroupPermissions['*']['editmyoptions']    = true;
$wgGroupPermissions['*']['commentcreate']    = true;

// Implicit group for all logged-in accounts
$wgGroupPermissions['user']['move']             = true;
$wgGroupPermissions['user']['move-subpages']    = true;
$wgGroupPermissions['user']['move-rootuserpages'] = true; // can move root userpages
$wgGroupPermissions['user']['read']             = true;
$wgGroupPermissions['user']['edit']             = true;
$wgGroupPermissions['user']['createpage']       = true;
$wgGroupPermissions['user']['createtalk']       = true;
$wgGroupPermissions['user']['writeapi']         = true;
$wgGroupPermissions['user']['upload']           = true;
$wgGroupPermissions['user']['reupload']         = true;
$wgGroupPermissions['user']['reupload-shared']  = true;
$wgGroupPermissions['user']['minoredit']        = true;
$wgGroupPermissions['user']['purge']            = true; // can use ?action=purge without clicking "ok"
$wgGroupPermissions['user']['sendemail']        = true;

// Implicit group for accounts that pass $wgAutoConfirmAge
$wgGroupPermissions['autoconfirmed']['autoconfirmed'] = true;

// Users with bot privilege can have their edits hidden
// from various log pages by default
$wgGroupPermissions['bot']['bot']              = true;
$wgGroupPermissions['bot']['autoconfirmed']    = true;
$wgGroupPermissions['bot']['nominornewtalk']   = true;
$wgGroupPermissions['bot']['autopatrol']       = true;
$wgGroupPermissions['bot']['suppressredirect'] = true;
$wgGroupPermissions['bot']['apihighlimits']    = true;
$wgGroupPermissions['bot']['writeapi']         = true;

// Most extra permission abilities go to this group
$wgGroupPermissions['sysop']['block']            = true;
$wgGroupPermissions['sysop']['createaccount']    = true;
$wgGroupPermissions['sysop']['delete']           = true;
$wgGroupPermissions['sysop']['bigdelete']        = true; // can be separately configured for pages with > $wgDeleteRevisionsLimit revs
$wgGroupPermissions['sysop']['deletedhistory']   = true; // can view deleted history entries, but not see or restore the text
$wgGroupPermissions['sysop']['deletedtext']      = true; // can view deleted revision text
$wgGroupPermissions['sysop']['undelete']         = true;
$wgGroupPermissions['sysop']['editinterface']    = true;
$wgGroupPermissions['sysop']['editusercss']      = true;
$wgGroupPermissions['sysop']['edituserjs']       = true;
$wgGroupPermissions['sysop']['import']           = true;
$wgGroupPermissions['sysop']['importupload']     = true;
$wgGroupPermissions['sysop']['move']             = true;
$wgGroupPermissions['sysop']['move-subpages']    = true;
$wgGroupPermissions['sysop']['move-rootuserpages'] = true;
$wgGroupPermissions['sysop']['patrol']           = true;
$wgGroupPermissions['sysop']['autopatrol']       = true;
$wgGroupPermissions['sysop']['protect']          = true;
$wgGroupPermissions['sysop']['proxyunbannable']  = true;
$wgGroupPermissions['sysop']['rollback']         = true;
$wgGroupPermissions['sysop']['upload']           = true;
$wgGroupPermissions['sysop']['reupload']         = true;
$wgGroupPermissions['sysop']['reupload-shared']  = true;
$wgGroupPermissions['sysop']['unwatchedpages']   = true;
$wgGroupPermissions['sysop']['autoconfirmed']    = true;
$wgGroupPermissions['sysop']['upload_by_url']    = true;
$wgGroupPermissions['sysop']['ipblock-exempt']   = true;
$wgGroupPermissions['sysop']['blockemail']       = true;
$wgGroupPermissions['sysop']['markbotedits']     = true;
$wgGroupPermissions['sysop']['apihighlimits']    = true;
$wgGroupPermissions['sysop']['browsearchive']    = true;
$wgGroupPermissions['sysop']['movefile']         = true;
$wgGroupPermissions['sysop']['unblockself']      = true;
$wgGroupPermissions['sysop']['suppressredirect'] = true;
$wgGroupPermissions['sysop']['smw-patternedit']  = true;
$wgGroupPermissions['sysop']['smw-admin'] = true;

// Add a new permission level for editing templates
$wgGroupPermissions['user']['edittemplates'] = true;

// Create rollback group with rollback permission
$wgGroupPermissions['rollback']['rollback'] = true;

// Bureaucrat permissions
$wgGroupPermissions['bureaucrat']['ipblock-exempt'] = true; //should be allowed to unblock self (and IP)
$wgGroupPermissions['bureaucrat']['block'] = true; // should be allowed to unblock self
$wgGroupPermissions['bureaucrat']['unblockself'] = true; // should be allowed to unblock self

// too many groups inherit from sysop - createaccount is user vs staff right only
unset($wgGroupPermissions['sysop']['createaccount']);

$wgGroupPermissions['sysop']['suppressredirect'] = true;
$wgGroupPermissions['sysop']['editinterface'] = true;
$wgGroupPermissions['sysop']['editusercss'] = false;
$wgGroupPermissions['sysop']['edituserjs'] = false;
$wgGroupPermissions['sysop']['import'] = false;

// Staff permissions
if ( empty( $wgGroupPermissions['staff'] ) ) {
	$wgGroupPermissions['staff'] = array();
}

$wgGroupPermissions['staff'] = array_merge ($wgGroupPermissions['staff'], $wgGroupPermissions['sysop'] );
$wgGroupPermissions['staff']['edit'] = true;
$wgGroupPermissions['staff']['createaccount'] = true;
$wgGroupPermissions['staff']['siteadmin'] = true;
$wgGroupPermissions['staff']['imageservingtest'] = true;
$wgGroupPermissions['staff']['stafflog'] = true;
$wgGroupPermissions['staff']['multilookup'] = true;
$wgGroupPermissions['staff']['createwikilimitsexempt'] = true;
$wgGroupPermissions['staff']['corporatepagemanager'] = true;
$wgGroupPermissions['staff']['phalanx'] = true;
$wgGroupPermissions['staff']['phalanxemailblock'] = true;
$wgGroupPermissions['staff']['phalanxexempt'] = true;
$wgGroupPermissions['staff']['commentmove'] = true;
$wgGroupPermissions['staff']['commentedit'] = true;
$wgGroupPermissions['staff']['commentdelete'] = true;
$wgGroupPermissions['staff']['cacheepoch'] = true;	#Special:CacheEpoch
$wgGroupPermissions['staff']['userdata'] = true;	#Special:UserData
$wgGroupPermissions['staff']['runjob'] = true;	#ApiRunJob
$wgGroupPermissions['staff']['writeapi'] = true;	#ApiRunJob
$wgGroupPermissions['staff']['lookupuser'] = true;
$wgGroupPermissions['staff']['tboverride'] = true;
$wgGroupPermissions['staff']['welcomeexempt'] = true;
$wgGroupPermissions['staff']['editinterface'] = true;
$wgGroupPermissions['staff']['editusercss'] = true;
$wgGroupPermissions['staff']['edituserjs'] = true;
$wgGroupPermissions['staff']['hideblockername'] = true;
$wgGroupPermissions['staff']['smw-patternedit'] = true;
$wgGroupPermissions['staff']['smw-admin'] = true;
$wgGroupPermissions['staff']['showfeaturedvideo'] = true;

// Util permissions (BugId:9238)
$wgGroupPermissions['util'] = array();
$wgGroupPermissions['util']['userrights'] = false; // Temp removal so that util can't add wikifactory group to their own account: CE-2847
$wgGroupPermissions['util']['checkuser'] = true;
$wgGroupPermissions['util']['checkuser-log'] = true;
$wgGroupPermissions['util']['deleterevision'] = true;
$wgGroupPermissions['util']['suppressrevision'] = true; #addons for deleterevision
$wgGroupPermissions['util']['suppressionlog'] = true;  #addons for deleterevision
$wgGroupPermissions['util']['lookupuser'] = true;
$wgGroupPermissions['util']['newwikislist'] = true;
$wgGroupPermissions['util']['wikifactory'] = true;

// No steward
unset( $wgGroupPermissions['steward'] );

// Helper permissions
$wgGroupPermissions['helper'] = $wgGroupPermissions['sysop'];
$wgGroupPermissions['helper']['lookupcontribs'] = true;
$wgGroupPermissions['helper']['userrights'] = false; // #2892
$wgGroupPermissions['helper']['edit'] = true;
$wgGroupPermissions['helper']['move'] = true;
$wgGroupPermissions['helper']['upload'] = true;
$wgGroupPermissions['helper']['reupload'] = true;
$wgGroupPermissions['helper']['createpage'] = true;
$wgGroupPermissions['helper']['createtalk'] = true;
$wgGroupPermissions['helper']['InterwikiEdit'] = true;
$wgGroupPermissions['helper']['multilookup'] = true;
$wgGroupPermissions['helper']['createwikilimitsexempt'] = true;
$wgGroupPermissions['helper']['phalanx'] = true;
$wgGroupPermissions['helper']['phalanxexempt'] = true;
$wgGroupPermissions['helper']['commentdelete'] = true;
$wgGroupPermissions['helper']['tboverride'] = true;
$wgGroupPermissions['helper']['welcomeexempt'] = true;
$wgGroupPermissions['helper']['commentedit'] = true;
$wgGroupPermissions['helper']['commentmove'] = true;
$wgGroupPermissions['helper']['skipcaptcha'] = true;
$wgGroupPermissions['helper']['dumpsondemand'] = true;
$wgGroupPermissions['helper']['wallfastadmindelete'] = true;
$wgGroupPermissions['helper']['quicktools'] = true;
$wgGroupPermissions['helper']['hideblockername'] = true;
// SUS-870
$wgGroupPermissions['helper']['checkuser'] = true;
$wgGroupPermissions['helper']['checkuser-log'] = true;
$wgGroupPermissions['helper']['editinterfacetrusted'] = true;

// VSTF permissions rt#27789
$wgGroupPermissions['vstf'] = [];
$wgGroupPermissions['vstf']['autoconfirmed'] = true;
$wgGroupPermissions['vstf']['block'] = true;
$wgGroupPermissions['vstf']['blockemail'] = true;
$wgGroupPermissions['vstf']['ipblock-exempt'] = true;
$wgGroupPermissions['vstf']['protect'] = true;
$wgGroupPermissions['vstf']['delete'] = true;
$wgGroupPermissions['vstf']['bigdelete'] = true;
$wgGroupPermissions['vstf']['undelete'] = true;
$wgGroupPermissions['vstf']['deletedhistory'] = true;
$wgGroupPermissions['vstf']['editinterface'] = true;
$wgGroupPermissions['vstf']['autopatrol'] = true;
$wgGroupPermissions['vstf']['move'] = true;
$wgGroupPermissions['vstf']['move-subpages'] = true;
$wgGroupPermissions['vstf']['move-rootuserpages'] = true;
$wgGroupPermissions['vstf']['movefile'] = true;
$wgGroupPermissions['vstf']['createpage'] = true;
$wgGroupPermissions['vstf']['createtalk'] = true;
$wgGroupPermissions['vstf']['reupload'] = true;
$wgGroupPermissions['vstf']['reupload-shared'] = true;
$wgGroupPermissions['vstf']['skipcaptcha'] = true;
$wgGroupPermissions['vstf']['rollback'] = true;
$wgGroupPermissions['vstf']['markbotedits'] = true;
$wgGroupPermissions['vstf']['suppressredirect'] = true;
$wgGroupPermissions['vstf']['apihighlimits'] = true;
$wgGroupPermissions['vstf']['phalanx'] = true;
$wgGroupPermissions['vstf']['phalanxexempt'] = true;
$wgGroupPermissions['vstf']['commentmove'] = true;
$wgGroupPermissions['vstf']['commentedit'] = true;
$wgGroupPermissions['vstf']['commentdelete'] = true;
$wgGroupPermissions['vstf']['deletedtext'] = true;
$wgGroupPermissions['vstf']['multilookup'] = true;
$wgGroupPermissions['vstf']['lookupcontribs'] = true;
$wgGroupPermissions['vstf']['checkuser'] = true;
$wgGroupPermissions['vstf']['checkuser-log'] = true;
$wgGroupPermissions['vstf']['deleterevision'] = true;
$wgGroupPermissions['vstf']['chatmoderator'] = true;
$wgGroupPermissions['vstf']['tboverride'] = true;
$wgGroupPermissions['vstf']['welcomeexempt'] = true;

$wgGroupPermissions['vstf']['userrights'] = false; // just in case
$wgGroupPermissions['vstf']['hideblockername'] = true;

// global version of the bot group
$wgGroupPermissions['bot-global']['bot'] = true;
$wgGroupPermissions['bot-global']['autopatrol'] = true;
$wgGroupPermissions['bot-global']['welcomeexempt'] = true;

// restricted-login group
$wgGroupPermissions['restricted-login']['login-restrict-username-password'] = true;
$wgGroupPermissions['restricted-login']['login-restrict-facebook'] = true;
$wgGroupPermissions['restricted-login']['password-reset-restrict'] = true;

// restricted-login-auto group
$wgGroupPermissions['restricted-login-auto'] = $wgGroupPermissions['restricted-login'];

$wgRestrictedAccessGroups = [ 'staff', 'util', 'content-reviewer' ];
if ($wgWikiaEnvironment == WIKIA_ENV_DEV) {
	$wgRestrictedAccessGroups = [];
}

// restricted-login-exempt
$wgGroupPermissions['restricted-login-exempt'] = [];
$wgRestrictedAccessExemptGroups = [ 'restricted-login-exempt' ];

// PLATFORM-1734: "Content Moderator" group
$wgGroupPermissions['content-moderator']['delete'] = true;
$wgGroupPermissions['content-moderator']['undelete'] = true;
$wgGroupPermissions['content-moderator']['commentdelete'] = true; // SUS-2593
$wgGroupPermissions['content-moderator']['protect'] = true;
$wgGroupPermissions['content-moderator']['suppressredirect'] = true;
$wgGroupPermissions['content-moderator']['movefile'] = true;
$wgGroupPermissions['content-moderator']['reupload'] = true;
$wgGroupPermissions['content-moderator']['patrol'] = true;
$wgGroupPermissions['content-moderator']['autopatrol'] = true;
$wgGroupPermissions['content-moderator']['rollback'] = true;
$wgGroupPermissions['content-moderator']['deletedtext'] = true;
$wgGroupPermissions['content-moderator']['deletedhistory'] = true;

// SUS-3850: introduce 'Content Volunteer' group
$wgGroupPermissions["content-volunteer"]["admindashboard"] = true;
$wgGroupPermissions["content-volunteer"]["autoconfirmed"] = true;
$wgGroupPermissions["content-volunteer"]["batchmove"] = true;
$wgGroupPermissions["content-volunteer"]["bigdelete"] = true;
$wgGroupPermissions["content-volunteer"]["blog-articles-edit"] = true;
$wgGroupPermissions["content-volunteer"]["blog-articles-move"] = true;
$wgGroupPermissions["content-volunteer"]["blog-comments-toggle"] = true;
$wgGroupPermissions["content-volunteer"]["commentmove"] = true;
$wgGroupPermissions["content-volunteer"]["curatedcontent"] = true;
$wgGroupPermissions["content-volunteer"]["delete"] = true;
$wgGroupPermissions["content-volunteer"]["editinterface"] = true;
$wgGroupPermissions["content-volunteer"]["move"] = true;
$wgGroupPermissions["content-volunteer"]["movefile"] = true;
$wgGroupPermissions["content-volunteer"]["move-subpages"] = true;
$wgGroupPermissions["content-volunteer"]["pageviews"] = true;
$wgGroupPermissions["content-volunteer"]["protect"] = true;
$wgGroupPermissions["content-volunteer"]["reupload"] = true;
$wgGroupPermissions["content-volunteer"]["reupload-shared"] = true;
$wgGroupPermissions["content-volunteer"]["skipcaptcha"] = true;
$wgGroupPermissions["content-volunteer"]["specialvideosdelete"] = true;
$wgGroupPermissions["content-volunteer"]["suppressredirect"] = true;
$wgGroupPermissions["content-volunteer"]["tboverride"] = true;
$wgGroupPermissions["content-volunteer"]["template-bulk-classification"] = true;
$wgGroupPermissions["content-volunteer"]["themedesigner"] = true;
$wgGroupPermissions["content-volunteer"]["undelete"] = true;
$wgGroupPermissions["content-volunteer"]["unwatchedpages"] = true;
$wgGroupPermissions["content-volunteer"]["upload"] = true;
$wgGroupPermissions["content-volunteer"]["upload_by_url"] = true;
$wgGroupPermissions["content-volunteer"]["wikianavlocal"] = true;
$wgGroupPermissions["content-volunteer"]["wikifeatures"] = true;
$wgGroupPermissions["content-volunteer"]["wteditimagelist"] = true;

// For community council wiki access, and proper setup of global group
$wgGroupPermissions['council']['council'] = true;

// For authenticated users (FB: 17047)
$wgGroupPermissions['authenticated']['authenticated'] = true;

// Allow edit in MediaWiki namespace
$wgGroupPermissions['util']['editinterfacetrusted'] = true;
$wgGroupPermissions['vstf']['editinterfacetrusted'] = true;

/* Allow delete in MediaWiki namespace overwritten by editinterfacetrusted
 * To restrict deletetion remove both deleteinterfacetrusted and editinterfacetrusted */
$wgGroupPermissions['sysop']['deleteinterfacetrusted'] = true;

// For Volunteer Developers (CE-317)
$wgGroupPermissions['voldev']['voldev'] = true;

//add wikia staff tool rights to staff users
$wgGroupPermissions['*']['edithub'] = false;
$wgGroupPermissions['staff']['edithub'] = true;
$wgGroupPermissions['vstf']['edithub'] = false;
$wgGroupPermissions['helper']['edithub'] = true;
$wgGroupPermissions['sysop']['edithub'] = false;

$wgGroupPermissions['staff']['noratelimit'] = true;
$wgGroupPermissions['helper']['noratelimit'] = true;
$wgGroupPermissions['vstf']['noratelimit'] = true;
$wgGroupPermissions['bot-global']['noratelimit'] = true;

/**
 * Limit the edit rights of wiki nav messages to staff members
 */

$wgGroupPermissions['*']['wikianavglobal'] = false;
$wgGroupPermissions['*']['wikianavlocal'] = false;

$wgGroupPermissions['sysop']['wikianavlocal'] = true;

$wgGroupPermissions['staff']['wikianavglobal'] = true;
$wgGroupPermissions['staff']['wikianavlocal'] = true;

$wgGroupPermissions['sysop']['tboverride'] = true;

/**
 * Setup default rights for wgAllVideosAdminOnly
 */
$wgGroupPermissions['*']['videoupload'] = true;

/**
 * Allow use of the 'mcache' query string parameter.
 */
$wgGroupPermissions['staff']['mcachepurge'] = true;
$wgGroupPermissions['vstf']['mcachepurge'] = true;
$wgGroupPermissions['helper']['mcachepurge'] = true;

$wgGroupPermissions['vanguard']['protect'] = true;
$wgGroupPermissions['vanguard']['editinterface'] = true;
$wgGroupPermissions['vanguard']['wikifeatures'] = true;
$wgGroupPermissions['vanguard']['template-bulk-classification'] = true;

/**
 * Any user in a global group is exempt from seeing the first edit dialog.
 */
$wgGroupPermissions['staff']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['helper']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['vstf']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['bot-global']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['util']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['vanguard']['first-edit-dialog-exempt'] = true;

// SUS-1175: Allow Staff, Helpers, and VSTF to delete user profile masthead contents with one click
$wgGroupPermissions['vstf']['clearuserprofile'] = true;
$wgGroupPermissions['staff']['clearuserprofile'] = true;
$wgGroupPermissions['helper']['clearuserprofile'] = true;

$wgGroupPermissions['global-discussions-moderator']['block'] = true;

$wgGroupPermissions['staff']['protectsite'] = true;
$wgGroupPermissions['helper']['protectsite'] = true;
$wgGroupPermissions['vstf']['protectsite'] = true;

$wgGroupPermissions['helper']['protectsite-exempt'] = true;
$wgGroupPermissions['staff']['protectsite-exempt'] = true;
$wgGroupPermissions['vstf']['protectsite-exempt'] = true;
$wgGroupPermissions['sysop']['protectsite-exempt'] = true;

$wgGroupPermissions['helper']['protectsite-nolimit'] = true;
$wgGroupPermissions['staff']['protectsite-nolimit'] = true;
