<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Vote extension";
	exit( 1 );
}

/**
 * Special page allows users to register votes for a particular
 * option in a predefined list
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Vote',
	'version' => '1.0.2',
	'author' => 'Rob Church',
	'descriptionmsg' => 'vote-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Vote',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Vote'] = $dir . 'Vote.i18n.php';
$wgExtensionMessagesFiles['VoteAlias'] = $dir . 'Vote.alias.php';
$wgAutoloadClasses['SpecialVote'] = $dir . 'Vote.page.php';
$wgSpecialPages['Vote'] = 'SpecialVote';

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
