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
$wgGroupPermissions['helper']['lookupuser'] = true;
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
$wgGroupPermissions['helper']['editusercss'] = true;
$wgGroupPermissions['helper']['edituserjs'] = true;
// SUS-870
$wgGroupPermissions['helper']['checkuser'] = true;
$wgGroupPermissions['helper']['checkuser-log'] = true;
$wgGroupPermissions['helper']['editinterfacetrusted'] = true;

$wgGroupPermissions['soap'] = [];
$wgGroupPermissions['soap']['autoconfirmed'] = true;
$wgGroupPermissions['soap']['block'] = true;
$wgGroupPermissions['soap']['blockemail'] = true;
$wgGroupPermissions['soap']['ipblock-exempt'] = true;
$wgGroupPermissions['soap']['protect'] = true;
$wgGroupPermissions['soap']['delete'] = true;
$wgGroupPermissions['soap']['bigdelete'] = true;
$wgGroupPermissions['soap']['undelete'] = true;
$wgGroupPermissions['soap']['deletedhistory'] = true;
$wgGroupPermissions['soap']['editinterface'] = true;
$wgGroupPermissions['soap']['autopatrol'] = true;
$wgGroupPermissions['soap']['move'] = true;
$wgGroupPermissions['soap']['move-subpages'] = true;
$wgGroupPermissions['soap']['move-rootuserpages'] = true;
$wgGroupPermissions['soap']['movefile'] = true;
$wgGroupPermissions['soap']['createpage'] = true;
$wgGroupPermissions['soap']['createtalk'] = true;
$wgGroupPermissions['soap']['reupload'] = true;
$wgGroupPermissions['soap']['reupload-shared'] = true;
$wgGroupPermissions['soap']['skipcaptcha'] = true;
$wgGroupPermissions['soap']['rollback'] = true;
$wgGroupPermissions['soap']['markbotedits'] = true;
$wgGroupPermissions['soap']['suppressredirect'] = true;
$wgGroupPermissions['soap']['apihighlimits'] = true;
$wgGroupPermissions['soap']['phalanx'] = true;
$wgGroupPermissions['soap']['phalanxexempt'] = true;
$wgGroupPermissions['soap']['commentmove'] = true;
$wgGroupPermissions['soap']['commentedit'] = true;
$wgGroupPermissions['soap']['commentdelete'] = true;
$wgGroupPermissions['soap']['deletedtext'] = true;
$wgGroupPermissions['soap']['multilookup'] = true;
$wgGroupPermissions['soap']['lookupcontribs'] = true;
$wgGroupPermissions['soap']['checkuser'] = true;
$wgGroupPermissions['soap']['checkuser-log'] = true;
$wgGroupPermissions['soap']['deleterevision'] = true;
$wgGroupPermissions['soap']['chatmoderator'] = true;
$wgGroupPermissions['soap']['tboverride'] = true;
$wgGroupPermissions['soap']['welcomeexempt'] = true;
$wgGroupPermissions['soap']['userrights'] = false;
$wgGroupPermissions['soap']['hideblockername'] = true;

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
$wgGroupPermissions['soap']['editinterfacetrusted'] = true;

/* Allow delete in MediaWiki namespace overwritten by editinterfacetrusted
 * To restrict deletetion remove both deleteinterfacetrusted and editinterfacetrusted */
$wgGroupPermissions['sysop']['deleteinterfacetrusted'] = true;

// For Volunteer Developers (CE-317)
$wgGroupPermissions['voldev']['voldev'] = true;

//add wikia staff tool rights to staff users
$wgGroupPermissions['*']['edithub'] = false;
$wgGroupPermissions['staff']['edithub'] = true;
$wgGroupPermissions['soap']['edithub'] = false;
$wgGroupPermissions['helper']['edithub'] = true;
$wgGroupPermissions['sysop']['edithub'] = false;

$wgGroupPermissions['staff']['noratelimit'] = true;
$wgGroupPermissions['helper']['noratelimit'] = true;
$wgGroupPermissions['soap']['noratelimit'] = true;
$wgGroupPermissions['bot-global']['noratelimit'] = true;
$wgGroupPermissions['wiki-manager']['noratelimit'] = true;
$wgGroupPermissions['content-team-member']['noratelimit'] = true;

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
$wgGroupPermissions['soap']['mcachepurge'] = true;
$wgGroupPermissions['helper']['mcachepurge'] = true;
$wgGroupPermissions['wiki-manager']['mcachepurge'] = true;

$wgGroupPermissions['vanguard']['protect'] = true;
$wgGroupPermissions['vanguard']['editinterface'] = true;
$wgGroupPermissions['vanguard']['wikifeatures'] = true;
$wgGroupPermissions['vanguard']['template-bulk-classification'] = true;

/**
 * Any user in a global group is exempt from seeing the first edit dialog.
 */
$wgGroupPermissions['staff']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['helper']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['soap']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['bot-global']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['util']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['vanguard']['first-edit-dialog-exempt'] = true;
$wgGroupPermissions['wiki-manager']['first-edit-dialog-exempt'] = true;

// SUS-1175: Allow Staff, Helpers, and SOAP to delete user profile masthead contents with one click
$wgGroupPermissions['soap']['clearuserprofile'] = true;
$wgGroupPermissions['staff']['clearuserprofile'] = true;
$wgGroupPermissions['helper']['clearuserprofile'] = true;

$wgGroupPermissions['global-discussions-moderator']['block'] = true;
$wgGroupPermissions['wiki-manager']['block'] = true;

$wgGroupPermissions['staff']['protectsite'] = true;
$wgGroupPermissions['helper']['protectsite'] = true;
$wgGroupPermissions['soap']['protectsite'] = true;
$wgGroupPermissions['wiki-manager']['protectsite'] = true;

$wgGroupPermissions['helper']['protectsite-exempt'] = true;
$wgGroupPermissions['staff']['protectsite-exempt'] = true;
$wgGroupPermissions['soap']['protectsite-exempt'] = true;
$wgGroupPermissions['sysop']['protectsite-exempt'] = true;
$wgGroupPermissions['wiki-manager']['protectsite-exempt'] = true;
$wgGroupPermissions['content-team-member']['protectsite-exempt'] = true;

$wgGroupPermissions['helper']['protectsite-nolimit'] = true;
$wgGroupPermissions['staff']['protectsite-nolimit'] = true;
$wgGroupPermissions['wiki-manager']['protectsite-nolimit'] = true;

$wgGroupPermissions['wiki-manager']['admindashboard'] = true;
$wgGroupPermissions['wiki-manager']['apihighlimits']    = true;
$wgGroupPermissions['wiki-manager']['autoconfirmed'] = true;
$wgGroupPermissions['wiki-manager']['autopatrol'] = true;
$wgGroupPermissions['wiki-manager']['bigdelete'] = true;
$wgGroupPermissions['wiki-manager']['blockemail'] = true;
$wgGroupPermissions['wiki-manager']['blog-articles-edit'] = true;
$wgGroupPermissions['wiki-manager']['blog-articles-move'] = true;
$wgGroupPermissions['wiki-manager']['blog-comments-toggle'] = true;
$wgGroupPermissions['wiki-manager']['browsearchive'] = true;
$wgGroupPermissions['wiki-manager']['checkuser'] = true;
$wgGroupPermissions['wiki-manager']['checkuser-log'] = true;
$wgGroupPermissions['wiki-manager']['clearuserprofile'] = true;
$wgGroupPermissions['wiki-manager']['commentdelete'] = true;
$wgGroupPermissions['wiki-manager']['commentedit'] = true;
$wgGroupPermissions['wiki-manager']['commentmove'] = true;
$wgGroupPermissions['wiki-manager']['createpage'] = true;
$wgGroupPermissions['wiki-manager']['createtalk'] = true;
$wgGroupPermissions['wiki-manager']['delete'] = true;
$wgGroupPermissions['wiki-manager']['deletedhistory'] = true;
$wgGroupPermissions['wiki-manager']['deletedtext'] = true;
$wgGroupPermissions['wiki-manager']['dumpsondemand'] = true;
$wgGroupPermissions['wiki-manager']['edit'] = true;
$wgGroupPermissions['wiki-manager']['editinterface'] = true;
$wgGroupPermissions['wiki-manager']['editinterfacetrusted'] = true;
$wgGroupPermissions['wiki-manager']['hideblockername'] = true;
$wgGroupPermissions['wiki-manager']['import'] = true;
$wgGroupPermissions['wiki-manager']['importupload'] = true;
$wgGroupPermissions['wiki-manager']['ipblock-exempt'] = true;
$wgGroupPermissions['wiki-manager']['lookupcontribs'] = true;
$wgGroupPermissions['wiki-manager']['lookupuser'] = true;
$wgGroupPermissions['wiki-manager']['markbotedits'] = true;
$wgGroupPermissions['wiki-manager']['move'] = true;
$wgGroupPermissions['wiki-manager']['move-rootuserpages'] = true;
$wgGroupPermissions['wiki-manager']['move-subpages'] = true;
$wgGroupPermissions['wiki-manager']['movefile'] = true;
$wgGroupPermissions['wiki-manager']['multilookup'] = true;
$wgGroupPermissions['wiki-manager']['patrol'] = true;
$wgGroupPermissions['wiki-manager']['phalanx'] = true;
$wgGroupPermissions['wiki-manager']['phalanxexempt'] = true;
$wgGroupPermissions['wiki-manager']['protect'] = true;
$wgGroupPermissions['wiki-manager']['proxyunbannable'] = true;
$wgGroupPermissions['wiki-manager']['quicktools'] = true;
$wgGroupPermissions['wiki-manager']['reupload'] = true;
$wgGroupPermissions['wiki-manager']['reupload-shared'] = true;
$wgGroupPermissions['wiki-manager']['rollback'] = true;
$wgGroupPermissions['wiki-manager']['skipcaptcha'] = true;
$wgGroupPermissions['wiki-manager']['smw-admin'] = true;
$wgGroupPermissions['wiki-manager']['smw-patternedit'] = true;
$wgGroupPermissions['wiki-manager']['specialvideosdelete'] = true;
$wgGroupPermissions['wiki-manager']['suppressredirect'] = true;
$wgGroupPermissions['wiki-manager']['tboverride'] = true;
$wgGroupPermissions['wiki-manager']['template-bulk-classification'] = true;
$wgGroupPermissions['wiki-manager']['themedesigner'] = true;
$wgGroupPermissions['wiki-manager']['unblockself'] = true;
$wgGroupPermissions['wiki-manager']['undelete'] = true;
$wgGroupPermissions['wiki-manager']['unwatchedpages'] = true;
$wgGroupPermissions['wiki-manager']['upload'] = true;
$wgGroupPermissions['wiki-manager']['upload_by_url'] = true;
$wgGroupPermissions['wiki-manager']['videoupload'] = true;
$wgGroupPermissions['wiki-manager']['wallfastadmindelete'] = true;
$wgGroupPermissions['wiki-manager']['welcomeexempt'] = true;
$wgGroupPermissions['wiki-manager']['wikianavlocal'] = true;
$wgGroupPermissions['wiki-manager']['wikifeatures'] = true;
$wgGroupPermissions['wiki-manager']['wteditimagelist'] = true;

$wgGroupPermissions['content-team-member']['admindashboard'] = true;
$wgGroupPermissions['content-team-member']['apihighlimits'] = true;
$wgGroupPermissions['content-team-member']['autoconfirmed'] = true;
$wgGroupPermissions['content-team-member']['autopatrol'] = true;
$wgGroupPermissions['content-team-member']['bigdelete'] = true;
$wgGroupPermissions['content-team-member']['blog-articles-edit'] = true;
$wgGroupPermissions['content-team-member']['blog-articles-move'] = true;
$wgGroupPermissions['content-team-member']['blog-comments-toggle'] = true;
$wgGroupPermissions['content-team-member']['checkuser'] = true;
$wgGroupPermissions['content-team-member']['clearuserprofile'] = true;
$wgGroupPermissions['content-team-member']['commentdelete'] = true;
$wgGroupPermissions['content-team-member']['commentedit'] = true;
$wgGroupPermissions['content-team-member']['commentmove'] = true;
$wgGroupPermissions['content-team-member']['createpage'] = true;
$wgGroupPermissions['content-team-member']['createtalk'] = true;
$wgGroupPermissions['content-team-member']['delete'] = true;
$wgGroupPermissions['content-team-member']['deletedhistory'] = true;
$wgGroupPermissions['content-team-member']['deletedtext'] = true;
$wgGroupPermissions['content-team-member']['edit'] = true;
$wgGroupPermissions['content-team-member']['editinterface'] = true;
$wgGroupPermissions['content-team-member']['editinterfacetrusted'] = true;
$wgGroupPermissions['content-team-member']['import'] = true;
$wgGroupPermissions['content-team-member']['importupload'] = true;
$wgGroupPermissions['content-team-member']['ipblock-exempt'] = true;
$wgGroupPermissions['content-team-member']['lookupcontribs'] = true;
$wgGroupPermissions['content-team-member']['move'] = true;
$wgGroupPermissions['content-team-member']['move-subpages'] = true;
$wgGroupPermissions['content-team-member']['movefile'] = true;
$wgGroupPermissions['content-team-member']['phalanxexempt'] = true;
$wgGroupPermissions['content-team-member']['protect'] = true;
$wgGroupPermissions['content-team-member']['proxyunbannable'] = true;
$wgGroupPermissions['content-team-member']['quicktools'] = true;
$wgGroupPermissions['content-team-member']['reupload'] = true;
$wgGroupPermissions['content-team-member']['reupload-shared'] = true;
$wgGroupPermissions['content-team-member']['rollback'] = true;
$wgGroupPermissions['content-team-member']['specialvideosdelete'] = true;
$wgGroupPermissions['content-team-member']['suppressredirect'] = true;
$wgGroupPermissions['content-team-member']['template-bulk-classification'] = true;
$wgGroupPermissions['content-team-member']['themedesigner'] = true;
$wgGroupPermissions['content-team-member']['unblockself'] = true;
$wgGroupPermissions['content-team-member']['undelete'] = true;
$wgGroupPermissions['content-team-member']['upload'] = true;
$wgGroupPermissions['content-team-member']['upload_by_url'] = true;
$wgGroupPermissions['content-team-member']['videoupload'] = true;
$wgGroupPermissions['content-team-member']['welcomeexempt'] = true;
$wgGroupPermissions['content-team-member']['wikifeatures'] = true;
