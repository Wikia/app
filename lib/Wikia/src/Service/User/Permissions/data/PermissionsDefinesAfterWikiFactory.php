<?php
/**
 * before main variable case we set/unset anonymous edititng
 */
if( !empty( $wgDisableAnonymousEditing ) || !empty( $wgWikiDirectedAtChildrenByStaff ) ){
	$wgGroupPermissions['*']['edit'] = false;
}

if ( !empty( $wgWikiaProtectSiteLocal ) ) {
	$wgGroupPermissions['sysop']['protectsite'] = true;
}

if (!empty($wgEnableSemanticMediaWikiExt)) {
	// Access right for SemanticMediaWiki Special:Ask
	$wgGroupPermissions['*']['smwallowaskpage'] = false;
	$wgGroupPermissions['user']['smwallowaskpage'] = true;
}

if (!empty($wgEnableAbuseFilterExtension)) {
	/* set this to TRUE to NOT use these default rights.
		if you do, you have to do it ALL on your own in wgGroupPermissionsLocal.
	*/
	if( empty($wgWikiaManualAbuseFilterRights) ) {
		$wgGroupPermissions['*']['abusefilter-view'] = true;

		$wgGroupPermissions['user']['abusefilter-log'] = true;

		#this var defaults to true, but can be overridden in wikifactory to FALSE,
		#  so that AF can be enabled, but only for VHS
		if( !empty($wgEnableAbuseFilterExtensionForSysop) ) {
			$wgGroupPermissions['sysop']['abusefilter-modify'] = true;
			$wgGroupPermissions['sysop']['abusefilter-modify-restricted'] = true;
			$wgGroupPermissions['sysop']['abusefilter-revert'] = true;
			$wgGroupPermissions['sysop']['abusefilter-log-detail'] = true;
			$wgGroupPermissions['sysop']['abusefilter-private'] = false;
		}

		$wgGroupPermissions['soap']['abusefilter-modify'] = true;
		$wgGroupPermissions['soap']['abusefilter-modify-restricted'] = true;
		$wgGroupPermissions['soap']['abusefilter-revert'] = true;
		$wgGroupPermissions['soap']['abusefilter-log-detail'] = true;
		$wgGroupPermissions['soap']['abusefilter-private'] = true;

		$wgGroupPermissions['helper']['abusefilter-modify'] = true;
		$wgGroupPermissions['helper']['abusefilter-modify-restricted'] = true;
		$wgGroupPermissions['helper']['abusefilter-revert'] = true;
		$wgGroupPermissions['helper']['abusefilter-log-detail'] = true;
		$wgGroupPermissions['helper']['abusefilter-private'] = true;

		$wgGroupPermissions['staff']['abusefilter-modify'] = true;
		$wgGroupPermissions['staff']['abusefilter-modify-restricted'] = true;
		$wgGroupPermissions['staff']['abusefilter-revert'] = true;
		$wgGroupPermissions['staff']['abusefilter-log-detail'] = true;
		$wgGroupPermissions['staff']['abusefilter-private'] = true;

		$wgGroupPermissions['wiki-manager']['abusefilter-modify'] = true;
		$wgGroupPermissions['wiki-manager']['abusefilter-modify-restricted'] = true;
		$wgGroupPermissions['wiki-manager']['abusefilter-revert'] = true;
		$wgGroupPermissions['wiki-manager']['abusefilter-log-detail'] = true;
		$wgGroupPermissions['wiki-manager']['abusefilter-private'] = true;

		$wgGroupPermissions['content-team-member']['abusefilter-modify'] = true;
		$wgGroupPermissions['content-team-member']['abusefilter-modify-restricted'] = true;
		$wgGroupPermissions['content-team-member']['abusefilter-revert'] = true;
		$wgGroupPermissions['content-team-member']['abusefilter-log-detail'] = true;
		$wgGroupPermissions['content-team-member']['abusefilter-private'] = true;

	}
}

if (!empty($wgEnableNukeExt)) {
	$wgGroupPermissions['staff']['nuke'] = true;
	$wgGroupPermissions['helper']['nuke'] = true;
	$wgGroupPermissions['soap']['nuke'] = true;
	$wgGroupPermissions['content-team-member']['nuke'] = true;
	$wgGroupPermissions['wiki-manager']['nuke'] = true;
	$wgGroupPermissions['sysop']['nuke'] = false;
	if( !empty($wgWikiaNukeLocal) ){
		$wgGroupPermissions['sysop']['nuke'] = true;
	}
}

/**
 * Set conditional groups when wgAllVideosAdminOnly is set.
 * Default is set in CommonSettings.php
 */
if ( !empty($wgAllVideosAdminOnly) ) {
	$wgGroupPermissions['*']['videoupload'] = false;
	$wgGroupPermissions['staff']['videoupload'] = true;
	$wgGroupPermissions['sysop']['videoupload'] = true;
}

//From app files

$wgGroupPermissions[ 'user' ][ 'MultiFileUploader' ] = true;

/**
 * Users who can vote
 */
$wgGroupPermissions['checkuser']['checkuser'] = true;
$wgGroupPermissions['checkuser']['checkuser-log'] = true;

/**
 * The 'skipcaptcha' permission key can be given out to
 * let known-good users perform triggering actions without
 * having to go through the captcha.
 *
 * By default, sysops and registered bot accounts will be
 * able to skip, while others have to go through it.
 */
$wgGroupPermissions['*'                  ]['skipcaptcha'] = false;
$wgGroupPermissions['user'               ]['skipcaptcha'] = false;
$wgGroupPermissions['autoconfirmed'      ]['skipcaptcha'] = false;
$wgGroupPermissions['bot'                ]['skipcaptcha'] = true; // registered bots
$wgGroupPermissions['sysop'              ]['skipcaptcha'] = true;
$wgGroupPermissions['content-team-member']['skipcaptcha'] = true;

if ( !empty( $wgEnableCaptchaExt ) ) {
	$wgGroupPermissions['staff']['skipcaptcha'] = true;
	$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = true;
}

# Users that can geocode. By default the same as those that can edit.
foreach ( $wgGroupPermissions as $group => $rights ) {
	if ( array_key_exists( 'edit' , $rights ) ) {
		$wgGroupPermissions[$group]['geocode'] = $wgGroupPermissions[$group]['edit'];
	}
}

$wgGroupPermissions['*']['viewedittab'] = true;

# ##
# Permission to edit form fields defined as 'restricted'
# ##
$wgGroupPermissions['sysop']['editrestrictedfields'] = true;
$wgGroupPermissions['wiki-manager']['editrestrictedfields'] = true;

# ##
# Permission to view, and create pages with, Special:CreateClass
# ##
$wgGroupPermissions['user']['createclass'] = true;

$wgGroupPermissions['user']['torunblocked'] = true;

/*
 * permissions setup
 */
$wgGroupPermissions['*']['abtestpanel'] = false;
$wgGroupPermissions['staff']['abtestpanel'] = true;

// perms
$wgGroupPermissions[ '*' ][ 'abusefilter-bypass' ] = false;
$wgGroupPermissions[ 'staff' ][ 'abusefilter-bypass' ] = true;
$wgGroupPermissions[ 'wiki-manager' ]['abusefilter-bypass'] = true;
$wgGroupPermissions[ 'content-team-member' ]['abusefilter-bypass'] = true;
$wgGroupPermissions[ 'helper' ]['abusefilter-bypass'] = true;

// RIGHTS
$wgGroupPermissions['*']['platinum'] = false;
$wgGroupPermissions['staff']['platinum'] = true;
$wgGroupPermissions['helper']['platinum'] = true;
$wgGroupPermissions['wiki-manager']['platinum'] = true;

$wgGroupPermissions['*']['sponsored-achievements'] = false;
$wgGroupPermissions['staff']['sponsored-achievements'] = true;

$wgGroupPermissions['*']['achievements-exempt'] = false;
$wgGroupPermissions['helper']['achievements-exempt'] = true;
$wgGroupPermissions['staff']['achievements-exempt'] = true;
$wgGroupPermissions['soap']['achievements-exempt'] = true;
$wgGroupPermissions['wiki-manager']['achievements-exempt'] = true;
$wgGroupPermissions['content-team-member']['achievements-exempt'] = true;

// overrides acievements-exempt
$wgGroupPermissions['*']['achievements-explicit'] = false;
$wgGroupPermissions['sysop']['achievements-explicit'] = true;

$wgGroupPermissions['*']['admindashboard'] = false;
$wgGroupPermissions['global-discussions-moderator']['admindashboard'] = true;
$wgGroupPermissions['helper']['admindashboard'] = true;
$wgGroupPermissions['staff']['admindashboard'] = true;
$wgGroupPermissions['sysop']['admindashboard'] = true;
$wgGroupPermissions['threadmoderator']['admindashboard'] = true;
$wgGroupPermissions['soap']['admindashboard'] = true;

$wgGroupPermissions['sysop']['commentmove'] = true;
$wgGroupPermissions['sysop']['commentedit'] = true;
$wgGroupPermissions['sysop']['commentdelete'] = true;

# PLATFORM-1707: threadmoderator additional rights
$wgGroupPermissions['threadmoderator']['commentmove'] = true;
$wgGroupPermissions['threadmoderator']['commentedit'] = true;
$wgGroupPermissions['threadmoderator']['commentdelete'] = true;

// perms
$wgGroupPermissions[ '*' ][ 'becp_user' ] = false;
$wgGroupPermissions[ 'staff' ][ 'becp_user' ] = true;
$wgGroupPermissions[ 'sysop' ][ 'becp_user' ] = true;

/**
 * permissions (eventually will be moved to CommonSettings.php)
 */
$wgGroupPermissions['*'][ 'blog-comments-toggle' ] = false;
$wgGroupPermissions['sysop'][ 'blog-comments-toggle' ] = true;
$wgGroupPermissions['staff'][ 'blog-comments-toggle' ] = true;
$wgGroupPermissions['helper'][ 'blog-comments-toggle' ] = true;
$wgGroupPermissions['wiki-manager']['blog-comments-toggle'] = true;
$wgGroupPermissions['content-team-member']['blog-comments-toggle'] = true;

$wgGroupPermissions['*'][ 'blog-comments-delete' ] = false;
$wgGroupPermissions['sysop'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['staff'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['helper'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['threadmoderator'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['wiki-manager'][ 'blog-comments-delete' ] = true;
$wgGroupPermissions['content-team-member'][ 'blog-comments-delete' ] = true;

$wgGroupPermissions['*'][ 'blog-articles-edit' ] = false;
$wgGroupPermissions['sysop'][ 'blog-articles-edit' ] = true;
$wgGroupPermissions['staff'][ 'blog-articles-edit' ] = true;
$wgGroupPermissions['helper'][ 'blog-articles-edit' ] = true;

$wgGroupPermissions['*'][ 'blog-articles-move' ] = false;
$wgGroupPermissions['sysop'][ 'blog-articles-move' ] = true;
$wgGroupPermissions['staff'][ 'blog-articles-move' ] = true;
$wgGroupPermissions['helper'][ 'blog-articles-move' ] = true;

$wgGroupPermissions['*'][ 'blog-articles-protect' ] = false;
$wgGroupPermissions['sysop'][ 'blog-articles-protect' ] = true;
$wgGroupPermissions['staff'][ 'blog-articles-protect' ] = true;
$wgGroupPermissions['helper'][ 'blog-articles-protect' ] = true;
$wgGroupPermissions['wiki-manager']['blog-articles-protect'] = true;
$wgGroupPermissions['content-team-member']['blog-articles-protect'] = true;

/**
 * The 'skipcaptcha' permission key can be given out to
 * let known-good users perform triggering actions without
 * having to go through the captcha.
 *
 * By default, sysops and registered bot accounts will be
 * able to skip, while others have to go through it.
 */
$wgGroupPermissions['*']['skipcaptcha'] = false;
$wgGroupPermissions['bot']['skipcaptcha'] = true; // registered bots
$wgGroupPermissions['sysop']['skipcaptcha'] = true;

// rights
$wgGroupPermissions['*']['chatmoderator'] = false;
$wgGroupPermissions['sysop']['chatmoderator'] = true;
$wgGroupPermissions['staff']['chatmoderator'] = true;
$wgGroupPermissions['helper']['chatmoderator'] = true;
$wgGroupPermissions['chatmoderator']['chatmoderator'] = true;
$wgGroupPermissions['threadmoderator']['chatmoderator'] = true;
$wgGroupPermissions['wiki-manager']['chatmoderator'] = true;

$wgGroupPermissions['*']['chatstaff'] = false;
$wgGroupPermissions['staff']['chatstaff'] = true;
$wgGroupPermissions['wiki-manager']['chatstaff'] = true;

$wgGroupPermissions['*']['chatadmin'] = false;
$wgGroupPermissions['sysop']['chatadmin'] = true;

$wgGroupPermissions['*']['chat'] = false;
$wgGroupPermissions['staff']['chat'] = true;
$wgGroupPermissions['user']['chat'] = true;

$wgGroupPermissions['util']['chatfailover'] = true;

// New user right, required to use the extension.
$wgGroupPermissions['*']['commentcsv'] = false;
$wgGroupPermissions['staff']['commentcsv'] = true;

/**
 * Groups and permissions
 */
$wgGroupPermissions['*']['content-review'] = false;
$wgGroupPermissions['content-reviewer']['content-review'] = true;

$wgGroupPermissions['user']['content-review-test-mode'] = true;

$wgGroupPermissions['util']['coppatool'] = true;

// permissions
$wgGroupPermissions['*']['createnewwiki'] = true;
$wgGroupPermissions['staff']['createnewwiki'] = true;

$wgGroupPermissions['staff']['createwikilimitsexempt'] = true;
$wgGroupPermissions['wiki-manager']['createwikilimitsexempt'] = true;

$wgGroupPermissions['*']['curatedcontent'] = false;
$wgGroupPermissions['staff']['curatedcontent'] = true;
$wgGroupPermissions['helper']['curatedcontent'] = true;
$wgGroupPermissions['sysop']['curatedcontent'] = true;
$wgGroupPermissions['content-team-member']['curatedcontent'] = true;
$wgGroupPermissions['wiki-manager']['curatedcontent'] = true;


$wgGroupPermissions['*']['curatedcontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['curatedcontent-switchforadmins'] = true;

$wgGroupPermissions['util']['dmcarequestmanagement'] = true;

// New user right, required to use the extension.
$wgGroupPermissions['*']['editaccount'] = false;
$wgGroupPermissions['util']['editaccount'] = true;

$wgGroupPermissions['*']['access-sendemail'] = false;
$wgGroupPermissions['staff']['access-sendemail'] = true;
$wgGroupPermissions['helper']['access-sendemail'] = true;
$wgGroupPermissions['translator']['access-sendemail'] = true;
$wgGroupPermissions['wiki-manager']['access-sendemail'] = true;

$wgGroupPermissions['staff']['emailsstorage'] = true;

$wgGroupPermissions['*']['flags-administration'] = false;
$wgGroupPermissions['sysop']['flags-administration'] = true;
$wgGroupPermissions['staff']['flags-administration'] = true;
$wgGroupPermissions['wiki-manager']['flags-administration'] = true;


$wgGroupPermissions['*']['forum'] = false;
$wgGroupPermissions['staff']['forum'] = true;
$wgGroupPermissions['sysop']['forum'] = true;
$wgGroupPermissions['helper']['forum'] = true;
$wgGroupPermissions['wiki-manager']['forum'] = true;

$wgGroupPermissions['*']['boardedit'] = false;
$wgGroupPermissions['staff']['boardedit'] = true;

$wgGroupPermissions['*']['forumoldedit'] = false;
$wgGroupPermissions['staff']['forumoldedit'] = true;
$wgGroupPermissions['helper']['forumoldedit'] = true;
$wgGroupPermissions['sysop']['forumoldedit'] = true;
$wgGroupPermissions['wiki-manager']['forumoldedit'] = true;

$wgGroupPermissions['*']['forumadmin'] = false;
$wgGroupPermissions['staff']['forumadmin'] = true;
$wgGroupPermissions['helper']['forumadmin'] = true;
$wgGroupPermissions['sysop']['forumadmin'] = true;
$wgGroupPermissions['threadmoderator']['forumadmin'] = true;
$wgGroupPermissions['wiki-manager']['forumadmin'] = true;
$wgGroupPermissions['content-team-member']['forumadmin'] = true;

$wgGroupPermissions['*']['gameguidespreview'] = false;
$wgGroupPermissions['staff']['gameguidespreview'] = true;
$wgGroupPermissions['sysop']['gameguidespreview'] = true;
$wgGroupPermissions['wiki-manager']['gameguidespreview'] = true;

$wgGroupPermissions['*']['gameguidescontent'] = false;
$wgGroupPermissions['staff']['gameguidescontent'] = true;
$wgGroupPermissions['helper']['gameguidescontent'] = true;
$wgGroupPermissions['wiki-manager']['gameguidescontent'] = true;

if ( $wgGameGuidesContentForAdmins ) {
	$wgGroupPermissions['sysop']['gameguidescontent'] = true;
}

$wgGroupPermissions['*']['gameguidescontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['gameguidescontent-switchforadmins'] = true;

$wgGroupPermissions['*']['gameguidessponsored'] = false;
$wgGroupPermissions['staff']['gameguidessponsored'] = true;

$wgGroupPermissions['bot']['welcomeexempt'] = true;
$wgGroupPermissions['staff']['welcomeexempt'] = true;

$wgGroupPermissions['reviewer']['deletedhistory'] = true;
$wgGroupPermissions['reviewer']['deletedtext'] = true;
$wgGroupPermissions['reviewer']['edit'] = false;

$wgGroupPermissions['util']['imagereviewstats'] = true;
$wgGroupPermissions['staff']['imagereviewstats'] = true;

$wgGroupPermissions['*']['insights'] = true;

$wgGroupPermissions['staff']['lookupcontribs'] = true;

// New user right, required to use the special page
$wgGroupPermissions['util']['lookupuser'] = true;

$wgGroupPermissions['*']['minieditor-specialpage'] = false;
$wgGroupPermissions['staff']['minieditor-specialpage'] = true;

$wgGroupPermissions['staff']['multidelete'] = true;
$wgGroupPermissions['helper']['multidelete'] = true;
$wgGroupPermissions['soap']['multidelete'] = true;
$wgGroupPermissions['wiki-manager']['multidelete'] = true;

$wgGroupPermissions['staff']['multiwikiedit'] = true;
$wgGroupPermissions['helper']['multiwikiedit'] = true;
$wgGroupPermissions['wiki-manager']['multiwikiedit'] = true;

$wgGroupPermissions['staff']['multiwikifinder'] = true;
$wgGroupPermissions['helper']['multiwikifinder'] = true;
$wgGroupPermissions['soap']['multiwikifinder'] = true;
$wgGroupPermissions['wiki-manager']['multiwikifinder'] = true;

$wgGroupPermissions['util']['piggyback'] = true;

$wgGroupPermissions['*']['places-enable-category-geolocation'] = false;
$wgGroupPermissions['sysop']['places-enable-category-geolocation'] = true;

$wgGroupPermissions['*']['metadata'] = false;
$wgGroupPermissions['staff']['metadata'] = true;

$wgGroupPermissions['util']['quicktools'] = true;
$wgGroupPermissions['soap']['quicktools'] = true;
$wgGroupPermissions['util']['quickadopt'] = true;

$wgGroupPermissions['staff']['restrictsession'] = true;
$wgGroupPermissions['util']['restrictsession'] = true;

$wgGroupPermissions['*']['performancestats'] = false;
$wgGroupPermissions['staff']['performancestats'] = true;
$wgGroupPermissions['helper']['performancestats'] = true; // BugId:5497
$wgGroupPermissions['wiki-manager']['performancestats'] = true;

//Allow group STAFF to use this extension.
$wgGroupPermissions['*']['messagetool'] = false;
$wgGroupPermissions['staff']['messagetool'] = true;
$wgGroupPermissions['util']['messagetool'] = true;

// basic permissions
#$wgGroupPermissions['sysop']['setadminskin'] = true; #rt74835

$wgGroupPermissions['staff']['setadminskin'] = true;

$wgGroupPermissions['*']['forceview'] = false;
$wgGroupPermissions['staff']['forceview'] = true;

$wgGroupPermissions['*']['edithub'] = false;
$wgGroupPermissions['staff']['edithub'] = true;
$wgGroupPermissions['helper']['edithub'] = true;
$wgGroupPermissions['wiki-manager']['edithub'] = true;

$wgGroupPermissions ['staff']['InterwikiEdit'] = true;
$wgGroupPermissions ['wiki-manager']['InterwikiEdit'] = true;

//add wikia staff tool rights to staff users
$wgGroupPermissions['*']['managewikiahome'] = false;
$wgGroupPermissions['staff']['managewikiahome'] = true;
$wgGroupPermissions['util']['managewikiahome'] = true;
$wgGroupPermissions['soap']['managewikiahome'] = false;
$wgGroupPermissions['helper']['managewikiahome'] = false;
$wgGroupPermissions['sysop']['managewikiahome'] = false;

$wgGroupPermissions['*']['newwikislist'] = false;
$wgGroupPermissions['staff']['newwikislist'] = true;
$wgGroupPermissions['helper']['newwikislist'] = true;

$wgGroupPermissions['*']['restricted_promote'] = false;
$wgGroupPermissions['staff']['restricted_promote'] = true;
$wgGroupPermissions['helper']['restricted_promote'] = true;
$wgGroupPermissions['sysop']['restricted_promote'] = false;
$wgGroupPermissions['wiki-manager']['restricted_promote'] = true;

$wgGroupPermissions['*']['specialvideosdelete'] = false;
$wgGroupPermissions['staff']['specialvideosdelete'] = true;
$wgGroupPermissions['sysop']['specialvideosdelete'] = true;
$wgGroupPermissions['helper']['specialvideosdelete'] = true;
$wgGroupPermissions['soap']['specialvideosdelete'] = true;

$wgGroupPermissions['staff']['stafflog'] = true;
$wgGroupPermissions['helper']['stafflog'] = true;
$wgGroupPermissions['wiki-manager']['stafflog'] = true;

$wgGroupPermissions['staff']['unblockable'] = true;
$wgGroupPermissions['helper']['unblockable'] = true;
$wgGroupPermissions['soap']['unblockable'] = true;
$wgGroupPermissions['wiki-manager']['unblockable'] = true;
$wgGroupPermissions['content-team-member']['unblockable'] = true;

$wgGroupPermissions['*']['tagsreport'] = true;

$wgGroupPermissions['soap']['taskmanager'] = true;
$wgGroupPermissions['helper']['taskmanager'] = true;
$wgGroupPermissions['staff']['taskmanager'] = true;
$wgGroupPermissions['wiki-manager']['taskmanager'] = true;

$wgGroupPermissions['util']['taskmanager'] = true;
$wgGroupPermissions['util']['taskmanager-action'] = true;

$wgGroupPermissions['soap']['tasks-user'] = true;
$wgGroupPermissions['helper']['tasks-user'] = true;
$wgGroupPermissions['staff']['tasks-user'] = true;
$wgGroupPermissions['util']['tasks-user'] = true;
$wgGroupPermissions['wiki-manager']['tasks-user'] = true;

$wgGroupPermissions['*']['template-bulk-classification'] = false;
$wgGroupPermissions['helper']['template-bulk-classification'] = true;
$wgGroupPermissions['soap']['template-bulk-classification'] = true;
$wgGroupPermissions['staff']['template-bulk-classification'] = true;
$wgGroupPermissions['sysop']['template-bulk-classification'] = true;

$wgGroupPermissions['*']['templatedraft'] = false;
$wgGroupPermissions['util']['templatedraft'] = true;
$wgGroupPermissions['staff']['templatedraft'] = true;
$wgGroupPermissions['helper']['templatedraft'] = true;
$wgGroupPermissions['soap']['templatedraft'] = true;
$wgGroupPermissions['voldev']['templatedraft'] = true;
$wgGroupPermissions['user']['templatedraft'] = true;
$wgGroupPermissions['content-team-member']['templatedraft'] = true;
$wgGroupPermissions['wiki-manager']['templatedraft'] = true;

$wgGroupPermissions['staff']['textregex'] = true;

// Ability to access ThemeDesigner.
$wgGroupPermissions['*']['themedesigner'] = false;
$wgGroupPermissions['sysop']['themedesigner'] = true;
$wgGroupPermissions['helper']['themedesigner'] = true;
$wgGroupPermissions['staff']['themedesigner'] = true;

$wgGroupPermissions['util']['usermanagement'] = true;

# --- permissions
$wgGroupPermissions['staff']['removeavatar'] = true;
# $wgGroupPermissions['sysop']['removeavatar'] = true;
$wgGroupPermissions['helper']['removeavatar'] = true;
$wgGroupPermissions['wiki-manager']['removeavatar'] = true;


// new right for dropdown menu of action button
$wgGroupPermissions['sysop']['renameprofilev3'] = true;
$wgGroupPermissions['soap']['renameprofilev3'] = true;
$wgGroupPermissions['staff']['renameprofilev3'] = true;
$wgGroupPermissions['helper']['renameprofilev3'] = true;
$wgGroupPermissions['wiki-manager']['renameprofilev3'] = true;

$wgGroupPermissions['sysop']['deleteprofilev3'] = true;
$wgGroupPermissions['soap']['deleteprofilev3'] = true;
$wgGroupPermissions['staff']['deleteprofilev3'] = true;
$wgGroupPermissions['helper']['deleteprofilev3'] = true;
$wgGroupPermissions['wiki-manager']['deleteprofilev3'] = true;

// new right to edit profile v3
$wgGroupPermissions['staff']['editprofilev3'] = true;
$wgGroupPermissions['soap']['editprofilev3'] = true;
$wgGroupPermissions['helper']['editprofilev3'] = true;
$wgGroupPermissions['wiki-manager']['editprofilev3'] = true;

$wgGroupPermissions['*']['renameuser'] = true;
$wgGroupPermissions['*']['renameanotheruser'] = false;
$wgGroupPermissions['staff']['renameanotheruser'] = true;

$wgGroupPermissions['staff']['specialvideohandler'] = true;

// wall
$wgGroupPermissions['*']['walldelete'] = false;
$wgGroupPermissions['util']['walldelete'] = true;

$wgGroupPermissions['*']['walladmindelete'] = false;
$wgGroupPermissions['staff']['walladmindelete'] = true;
$wgGroupPermissions['soap']['walladmindelete'] = true;
$wgGroupPermissions['helper']['walladmindelete'] = true;
$wgGroupPermissions['sysop']['walladmindelete'] = true;
$wgGroupPermissions['wiki-manager']['walladmindelete'] = true;
$wgGroupPermissions['content-team-member']['walladmindelete'] = true;

$wgGroupPermissions['*']['wallarchive'] = false;
$wgGroupPermissions['staff']['wallarchive'] = true;
$wgGroupPermissions['soap']['wallarchive'] = true;
$wgGroupPermissions['helper']['wallarchive'] = true;
$wgGroupPermissions['sysop']['wallarchive'] = true;
$wgGroupPermissions['threadmoderator']['wallarchive'] = true;
$wgGroupPermissions['wiki-manager']['wallarchive'] = true;

$wgGroupPermissions['*']['wallremove'] = false;
$wgGroupPermissions['staff']['wallremove'] = true;
$wgGroupPermissions['soap']['wallremove'] = true;
$wgGroupPermissions['helper']['wallremove'] = true;
$wgGroupPermissions['sysop']['wallremove'] = true;
$wgGroupPermissions['threadmoderator']['wallremove'] = true;
$wgGroupPermissions['wiki-manager']['wallremove'] = true;
$wgGroupPermissions['content-team-member']['wallremove'] = true;

$wgGroupPermissions['*']['walledit'] = false;
$wgGroupPermissions['staff']['walledit'] = true;
$wgGroupPermissions['soap']['walledit'] = true;
$wgGroupPermissions['helper']['walledit'] = true;
$wgGroupPermissions['sysop']['walledit'] = true;
$wgGroupPermissions['threadmoderator']['walledit'] = true;
$wgGroupPermissions['wiki-manager']['walledit'] = true;
$wgGroupPermissions['content-team-member']['walledit'] = true;

$wgGroupPermissions['*']['editwallarchivedpages'] = false;
$wgGroupPermissions['sysop']['editwallarchivedpages'] = true;
$wgGroupPermissions['soap']['editwallarchivedpages'] = true;
$wgGroupPermissions['staff']['editwallarchivedpages'] = true;
$wgGroupPermissions['helper']['editwallarchivedpages'] = true;
$wgGroupPermissions['wiki-manager']['editwallarchivedpages'] = true;
$wgGroupPermissions['content-team-member']['editwallarchivedpages'] = true;

$wgGroupPermissions['*']['wallshowwikiaemblem'] = false;
$wgGroupPermissions['staff']['wallshowwikiaemblem'] = true;

$wgGroupPermissions['*']['wallfastadmindelete'] = false;
$wgGroupPermissions['sysop']['wallfastadmindelete'] = false;
$wgGroupPermissions['soap']['wallfastadmindelete'] = true;
$wgGroupPermissions['staff']['wallfastadmindelete'] = true;

$wgGroupPermissions['*']['wallmessagemove'] = false;
$wgGroupPermissions['threadmoderator']['wallmessagemove'] = true;
$wgGroupPermissions['sysop']['wallmessagemove'] = true;
$wgGroupPermissions['soap']['wallmessagemove'] = true;
$wgGroupPermissions['helper']['wallmessagemove'] = true;
$wgGroupPermissions['staff']['wallmessagemove'] = true;
$wgGroupPermissions['wiki-manager']['wallmessagemove'] = true;
$wgGroupPermissions['content-team-member']['wallmessagemove'] = true;

$wgGroupPermissions['util']['wdacreview'] = true;

$wgGroupPermissions['staff']['WhereIsExtension'] = true;
$wgGroupPermissions['util']['WhereIsExtension'] = true;

$wgGroupPermissions['sysop']['wteditimagelist'] = true;
$wgGroupPermissions['staff']['wteditimagelist'] = true;

// canremove -- give it to users who can remove maps
$wgGroupPermissions['*']['canremovemap'] = false;
$wgGroupPermissions['sysop']['canremovemap'] = true;
$wgGroupPermissions['staff']['canremovemap'] = true;
$wgGroupPermissions['helper']['canremovemap'] = true;
$wgGroupPermissions['wiki-manager']['canremovemap'] = true;

$wgGroupPermissions['user']['upload_by_url']   = true;

$wgGroupPermissions['*']['wikiaquiz'] = false;
$wgGroupPermissions['staff']['wikiaquiz'] = true;

$wgGroupPermissions['*']['dumpsondemand'] = false;
$wgGroupPermissions['staff']['dumpsondemand'] = true;
$wgGroupPermissions['sysop']['dumpsondemand'] = true;

$wgGroupPermissions['*']['wikifeatures'] = false;
$wgGroupPermissions['staff']['wikifeatures'] = true;
$wgGroupPermissions['sysop']['wikifeatures'] = true;
$wgGroupPermissions['helper']['wikifeatures'] = true;

$wgGroupPermissions['*']['wikifeaturesview'] = false;
$wgGroupPermissions['user']['wikifeaturesview'] = true;

if( !empty($wgWikiaStarterLockdown) ) {
	#knock out a bunch of permissions
	$wgGroupPermissions['*']['edit'] = false;
	$wgGroupPermissions['*']['createaccount'] = false;
	$wgGroupPermissions['user']['createaccount'] = false;
	$wgGroupPermissions['user']['edit'] = false;
	$wgGroupPermissions['user']['move'] = false;
	$wgGroupPermissions['user']['upload'] = false;
	$wgGroupPermissions['sysop']['edit'] = true;
	$wgGroupPermissions['sysop']['move'] = true;
	$wgGroupPermissions['sysop']['upload'] = true;

	#not sure if this is needed, but better safe then sorry
	$wgGroupPermissions['user']['reupload'] = false;
	$wgGroupPermissions['user']['reupload-shared'] = false;
	$wgGroupPermissions['sysop']['reupload'] = true;
}

$wgGroupPermissions['*']['portabilitydashboard'] = true;

// Grants access to upstream wp-admin interface
$wgGroupPermissions['*']['fandom-admin'] = false;
$wgGroupPermissions['staff']['fandom-admin'] = true;
$wgGroupPermissions['fandom-editor']['fandom-admin'] = true;

$wgGroupPermissions['*']['exportuserdata'] = false;
$wgGroupPermissions['util']['exportuserdata'] = true;

// request to be forgotten
$wgGroupPermissions['*']['requesttobeforgotten'] = false;
$wgGroupPermissions['request-to-be-forgotten-admin']['requesttobeforgotten'] = true;

// SUS-5473 | allow staff members to request a run of updateSpecialPages
$wgGroupPermissions['*']['schedule-update-special-pages'] = false;
$wgGroupPermissions['staff']['schedule-update-special-pages'] = true;
$wgGroupPermissions['wiki-manager']['schedule-update-special-pages'] = true;
$wgGroupPermissions['content-team-member']['schedule-update-special-pages'] = true;
$wgGroupPermissions['vanguard']['schedule-update-special-pages'] = true;
$wgGroupPermissions['helper']['schedule-update-special-pages'] = true;

// DE-4374 | allow staff members, helpers and wikis admins to access Special:Analytics
$wgGroupPermissions['*']['analytics'] = false;
$wgGroupPermissions['sysop']['analytics'] = true;
$wgGroupPermissions['helper']['analytics'] = true;
$wgGroupPermissions['staff']['analytics'] = true;
$wgGroupPermissions['wiki-manager']['analytics'] = true;
$wgGroupPermissions['content-team-member']['analytics'] = true;
