<?php
/**
 * Prevents non-logged in (anon) users from editing NS_FORUM:Index (or its talk)
 * @package MediaWiki
 *
 * @author Chris Stafford <uberfuzzy@wikia-inc.com>
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ForumIndexProtector',
	'author' => array('[http://central.wikia.com/wiki/User:Uberfuzzy Chris Stafford (uberfuzzy)]', ),
	'version' => '1.0',
	'description' => 'Prevents anon users from editing Forum:Index',
);

$wgHooks['getUserPermissionsErrors'][] = 'fnForumIndexProtector';

function fnForumIndexProtector( Title &$title, User &$user, $action, &$result) {

	if( $user->isLoggedIn() ) {
		#this doesnt apply to logged in users, bail, but keep going
		return true;
	}

	if( $action != 'edit' && $action != 'create') {
		#only kill editing actions (what else can anons even do?), bail, but keep going
		return true;
	}

	#this only applies to Forum:Index and Forum_talk:Index

	#check pagename
	if( $title->getText() != 'Index' ) {
		#wrong pagename, bail, but keep going
		return true;
	}

	$ns = $title->getNamespace();

	#check namespace(s)
	if($ns == NS_FORUM || $ns == NS_FORUM_TALK ) {
		#bingo bango, its a match!
		$result = array('protectedpagetext');
		Wikia::log(__METHOD__, __LINE__, "anon trying to edit forum:index, killing request");

		#bail, and stop the request
		return false;
	}

	return true;
}
