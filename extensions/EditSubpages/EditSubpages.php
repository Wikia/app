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
'description' => "Allows sysops to unlock a page and all subpages of that page for anonymous editing via [[MediaWiki:Unlockedpages]]",
'descriptionmsg' => 'editsubpages-desc',
'author' => "<span class=\"plainlinks\">[http://strategywiki.org/wiki/User:Ryan_Schmidt Ryan Schmidt] and [http://strategywiki.org/wiki/User:Prod Prod]</span>",
'url' => "http://www.mediawiki.org/wiki/Extension:EditSubpages",
'version' => "3.0",
);

$wgHooks['userCan'][] = 'EditSubpages';
$wgGroupPermissions['*']['edit'] = true;
$wgGroupPermissions['*']['createpage'] = true;
$wgGroupPermissions['*']['createtalk'] = true;
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['EditSubpages'] = $dir .'EditSubpages.i18n.php';
$evEditSubpagesCache = array();

function EditSubpages($title, $user, $action, $result) {
	global $evEditSubpagesCache;
	$pagename = $title->getText(); //name of page w/ spaces, not underscores
	if(!array_key_exists('pagename', $evEditSubpagesCache) || $pagename != $evEditSubpagesCache['pagename']) {
		$ns = $title->getNsText(); //namespace
		if( $title->isTalkPage() ) {
			$ns = $title->getTalkNsText();
			$nstalk = '';
		} else {
			$nstalk = $title->getTalkNsText();
		}
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
		//underscores -> spaces
		$ns = str_replace('_', ' ', $ns);
		$nstalk = str_replace('_', ' ', $nstalk);
		$pages = explode ("\n", wfMsg ('unlockedpages')); //grabs MediaWiki:Unlockedpages
		//cache the values so future checks on the same page take less time
		$evEditSubpagesCache = array(
			'pagename' => $pagename,
			'ns' => $ns,
			'nstalk' => $nstalk,
			'text' => $text,
			'talktext' => $talktext,
			'pages' => $pages,
			'loggedin' => $user->isLoggedIn(),
		);
	}
	if(($action == 'edit' || $action == 'submit')){
		foreach($evEditSubpagesCache['pages'] as $value) {
			if( strpos( $value, '*' ) === false || strpos( $value, '*' ) !== 0 )
				continue; // "*" doesn't start the line, so treat it as a comment (aka skip over it)
			$flags = array( 's' => 1, 'c' => 1, 't' => 1, 'e' => 1, 'b' => 0, 'u' => 0, 'i' => 0, 'n' => 0, 'r' => 0, 'w' => 0 ); //default flags
			$value = trim( trim( trim( trim( $value ), "*[]" ) ), "*[]" );
			/* flags
			 * s = unlock subpages
			 * c = allow page creation
			 * t = unlock talk pages
			 * e = allow editing existing pages
			 * b = unlock base pages
			 * u = apply restrictions to users as well
			 * i = case insensitive
			 * n = namespace inspecific
			 * r = regex fragment
			 * w = wildcard matching
			*/
			$pieces = explode('|', $value, 3);
			if( isset($pieces[1]) && strpos($pieces[1], '+') === 0 ) {
				//flag parsing
				$flaglist1 = explode('+', $pieces[1], 2);
				if(isset($flaglist1[1])) {
					$flaglist2 = explode('-', $flaglist1[1], 2);
				} else {
					$flaglist2 = explode('-', $pieces[1], 2);
				}
				$flagpos = str_split($flaglist2[0]);
				if(isset($flaglist2[1])) {
					$flagneg = str_split($flaglist2[1]);
				} else {
					$flagneg = array('');
				}
				foreach($flagpos as $flag) {
					$flags[$flag] = 1;
				}
				foreach($flagneg as $flag) {
					$flags[$flag] = 0;
				}
			}
			$found = checkPage($pieces[0], $evEditSubpagesCache['text'], $flags);
			if(!$found && $flags['n'])
				$found = checkPage($pieces[0], $evEditSubpagesCache['pagename'], $flags);
			if(!$found && $flags['t']) {
				$newtitle = Title::newFromText($pieces[0]);
				//make sure that it's a valid title
				if( $newtitle instanceOf Title && !$newtitle->isTalkPage() ) {
					$talk = $newtitle->getTalkPage();
					$talkpage = $talk->getPrefixedText();
					$found = checkPage($talkpage, $evEditSubpagesCache['talktext'], $flags);
					if(!$found)
						$found = checkPage($talkpage, $evEditSubpagesCache['text'], $flags);
				}
			}
			if(!$found)
				continue;
				
			if(!$flags['u'] && $evEditSubpagesCache['loggedin'])
				return true;
			//the page matches, now process it and let the software know whether or not to allow the user to do this action
			if(!$flags['c'] && !$newtitle->exists()) {
				$result = false;
				return false;
			}
			if(!$flags['e'] && $newtitle->exists()) {
				$result = false;
				return false;
			}
			$result = true;
			return false;
		}
		if(!$evEditSubpagesCache['loggedin']) {
			$result = false;
			return false;
		}
	}
	return true;
}

function checkPage($page, $check, $flags) {
	if( $flags['w'] && !$flags['r'] ) {
		$flags['r'] = 1;
		$page = preg_quote( $page, '/' );
		$page = str_replace( '\\\\', '\\', $page );
		$page = str_replace( '\?', '?', $page );
		$page = str_replace( '\*', '*', $page );
		$page = str_replace( '\?', "\x00", $page );
		$page = str_replace( '?', '.?', $page );
		$page = str_replace( "\x00", '\?', $page );
		$page = str_replace( '\*', "\x00", $page );
		$page = str_replace( '*', '.*', $page );
		$page = str_replace( "\x00", '\*', $page );
	}
	if( $flags['r'] ) {
		$i = '';
		if( $flags['i'] )
			$i = 'i';
		$page = preg_replace( '/(\\\\)?\//', '\\/', $page );
		return preg_match( '/^' . $page . '$/' . $i, $check );
	}
	if( $flags['i'] ) {
		$page = strtolower($page);
		$check = strtolower($check);
	}
	if( $page == $check )
		return true;
	if( $flags['s'] && strpos( $check, $page . '/' ) === 0 )
		return true;
	if( $flags['b'] && strpos( $page, $check . '/' ) === 0 )
		return true;
	return false;
}