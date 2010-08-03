<?php
if (!defined('MEDIAWIKI')) {
echo "Vote extension";
exit(1);
}

/**
 * Special page allows users to register votes for a particular
 * option in a predefined list
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */
 
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Vote',
	'svn-date' => '$LastChangedDate: 2008-12-18 06:56:43 +0100 (czw, 18 gru 2008) $',
	'svn-revision' => '$LastChangedRevision: 44752 $',
	'author' => 'Rob Church',
	'description' => 'Provides simple polling capabilities',
	'descriptionmsg' => 'vote-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Vote',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Vote'] = $dir . 'Vote.i18n.php';
$wgExtensionAliasesFiles['Vote'] = $dir . 'Vote.alias.php';
$wgAutoloadClasses['SpecialVote'] = $dir . 'Vote.page.php';
$wgSpecialPages['Vote'] = 'SpecialVote';
$wgExtensionFunctions[] = 'efVote';

/**
 * Users who can vote
 */
$wgGroupPermissions['user']['vote'] = true;

/**
 * Users who can view vote results
 */
$wgGroupPermissions['bureaucrat']['voteadmin'] = true;

$wgAvailableRights[] = 'vote';
$wgAvailableRights[] = 'voteadmin';

/**
 * Extension setup function
 */
function efVote() {
	global $wgHooks;
	$wgHooks['SkinTemplateSetupPageCss'][] = 'efVoteCss';
}

/**
 * Add extra CSS to the skin
 */
function efVoteCss( &$css ) {
	global $wgTitle;
	if( $wgTitle->isSpecial( 'Vote' ) ) {
		$file = dirname( __FILE__ ) . '/Vote.css';
		$css .= "/*<![CDATA[*/\n" . htmlspecialchars( file_get_contents( $file ) ) . "\n/*]]>*/";
	}
	return true;
}
