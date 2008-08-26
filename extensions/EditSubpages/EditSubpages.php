<?php

/**
* Allows sysops to unlock a page and all subpages of that page for anonymous editing
* via MediaWiki:Unlockedpages
*/

if(!defined('MEDIAWIKI')) {
	echo('This file is an extension to the MediaWiki software and cannot be used standalone');
	die(1);
}

$wgExtensionCredits['other'][] = array(
'name' => "EditSubpages",
'description' => "Allows sysops to unlock a page and all subpages of that page
for anonymous editing via [[MediaWiki:Unlockedpages]]",
'descriptionmsg' => 'editsubpages-desc',
'author' => "<span class=\"plainlinks\">[http://strategywiki.org/wiki/User:Ryan_Schmidt Ryan Schmidt] and [http://strategywiki.org/wiki/User:Prod Prod]</span>",
'url' => "http://www.mediawiki.org/wiki/Extension:EditSubpages",
'version' => "2.2",
);

$wgHooks['userCan'][] = 'EditSubpages';
$wgGroupPermissions['*']['edit'] = true;
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['EditSubpages'] = $dir .'EditSubpages.i18n.php';

function EditSubpages($title, $user, $action, $result) {
	if(($action == 'edit' || $action == 'submit') && !$user->isLoggedIn() ){
		$result = false;
		$pagename = $title->getText(); //name of page w/ spaces, not underscores
		$ns = $title->getNsText(); //namespace
		if( $title->isTalkPage() ) {
			$ns = $title->getTalkNsText();
			$nstalk = '';
		} else {
			$nstalk = $title->getTalkNsText();
		}
		//underscores -> spaces
		$ns = str_replace('_', ' ', $ns);
		$nstalk = str_replace('_', ' ', $nstalk);
		if($ns == '') {
			$text = $pagename;
		} else {
			$text = $ns . ":" . $pagename;
		}
		if( $nstalk != '' ) {
			$talktext = $nstalk . ":" . $pagename;
		} else {
			$talktext = $pagename;
		}
		$pages = explode ("\n", wfMsg ('unlockedpages')); //grabs MediaWiki:Unlockedpages
		foreach($pages as $value) {
			if( strpos( $value, '*' ) === false || strpos( $value, '*' ) !== 0 )
				continue; // "*" doesn't start the line, so treat it as a comment (aka skip over it)
			$value = trim( trim( trim( trim( $value ), "*[]" ) ), "*[]" );
			if ( $value == $text || strpos( $text, $value . '/' ) === 0 ) {
				$result = true;
				break;
			}
			$title = Title::newFromText($value);
			if( !$title->isTalkPage() ) {
				$talk = $title->getTalkPage();
				$talkpage = $talk->getPrefixedText();
				if($talkpage == $talktext || $talkpage == $text || strpos( $talktext, $talkpage . '/' ) === 0 || strpos( $text, $talkpage . '/' ) === 0 ) {
					$result = true;
					break;
				}
			}
		}
		return false; //so internal checks cannot override
	}
	return true;
}