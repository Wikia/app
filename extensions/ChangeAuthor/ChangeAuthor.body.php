<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright (C) 2007 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows changing the author of a revision
 * Written for the Bokt Wiki <http://www.bokt.nl/wiki/> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 *
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install the ChangeAuthor extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ChangeAuthor/ChangeAuthor.setup.php" );
EOT;
	exit(1);
}

class ChangeAuthor extends SpecialPage
{
	var $selfTitle, $skin;
	function __construct()
	{
		global $wgUser;
		self::loadMessages();
		parent::__construct(wfMsg('changeauthor-short'), 'changeauthor');
		$this->selfTitle = Title::makeTitleSafe(NS_SPECIAL, wfMsg('changeauthor-short'));
		$this->skin = $wgUser->getSkin();
	}

	function execute($par)
	{
		global $wgRequest, $wgOut, $wgContLang, $wgUser;
		$this->setHeaders();
		if(!$this->userCanExecute($wgUser))
		{
			$this->displayRestrictionError();
			return;
		}
		
		$wgOut->setPageTitle(wfMsg('changeauthor-title'));
		
		if(!is_null($par))
		{
			$obj = $this->parseTitleOrRevID($par);
			if($obj instanceof Title)
			{
				if($obj->exists())
					$wgOut->addHTML($this->buildRevisionList($obj));
				else
					$wgOut->addHTML($this->buildInitialForm(wfMsg('changeauthor-nosuchtitle', $obj->getPrefixedText())));
				return;
			}
			else if($obj instanceof Revision)
			{
				$wgOut->addHTML($this->buildOneRevForm($obj));
				return;
			}
		}
		
		$action = $wgRequest->getVal('action');
		if($wgRequest->wasPosted() && $action == 'change')
		{		
			$arr = $this->parseChangeRequest();
			if(!is_array($arr))
			{
				$targetPage = $wgRequest->getVal('targetpage');
				if(!is_null($targetPage))
				{
					$wgOut->addHTML($this->buildRevisionList(Title::newFromURL($targetPage), $arr));
					return;
				}
				$targetRev = $wgRequest->getVal('targetrev');
				if(!is_null($targetRev))
				{
					$wgOut->addHTML($this->buildOneRevForm(Revision::newFromId($targetRev), $arr));
					return;
				}
				$wgOut->addHTML($this->buildInitialForm());
			}
			else
			{
				$this->changeRevAuthors($arr, $wgRequest->getVal('comment'));
				$wgOut->addWikiText(wfMsg('changeauthor-success'));
			}
			return;
		}
		if($wgRequest->wasPosted() && $action == 'list')
		{
			$obj = $this->parseTitleOrRevID($wgRequest->getVal('pagename-revid'));
			if($obj instanceof Title)
			{
				if($obj->exists())
					$wgOut->addHTML($this->buildRevisionList($obj));
				else
					$wgOut->addHTML($this->buildInitialForm(wfMsg('changeauthor-nosuchtitle', $obj->getPrefixedText())));
			}
			else if($obj instanceof Revision)
			{
				$wgOut->addHTML($this->buildOneRevForm($obj));
			}
			return;
		}
		$wgOut->addHTML($this->buildInitialForm());
	}

	private function parseTitleOrRevID($str)
	{
		// Parse what can be a revision ID or an article name
		// Returns: Title or Revision object, or NULL
		$retval = false;
		if(is_numeric($str))
			$retval = Revision::newFromID($str);
		if(!$retval)
			$retval = Title::newFromURL($str);
		return $retval;
	}

	private function buildInitialForm($errMsg = '')
	{
		// Builds the form that asks for a page name or revid
		// $errMsg: Error message
		// Returns: HTML
		
		global $wgScript;
		$retval = Xml::openElement('form', array('method' => 'POST', 'action' => $wgScript));
		$retval .= Xml::hidden('title', $this->selfTitle->getPrefixedDbKey());
		$retval .= Xml::hidden('action', 'list');
		$retval .= Xml::openElement('fieldset');
		$retval .= Xml::element('legend', array(), wfMsg('changeauthor-search-box'));
		$retval .= Xml::inputLabel(wfMsg('changeauthor-pagename-or-revid'),
				'pagename-revid', 'pagename-revid');
		$retval .= Xml::submitButton(wfMsg('changeauthor-pagenameform-go'));
		if($errMsg != '')
		{	
			$retval .= Xml::openElement('p') . Xml::openElement('b');
			$retval .= Xml::element('font', array('color' => 'red'), $errMsg);
			$retval .= Xml::closeElement('b') . Xml::closeElement('p');
		}
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('form');
		return $retval;
	}
	
	private function buildRevisionLine($rev, $title, $isFirst = false, $isLast = false)
	{
		// Builds a line for revision $rev
		// Helper to buildRevisionList() and buildOneRevForm()
		// $rev: Revision object
		// $title: Title object
		// $isFirst: Set to true if $rev is the first revision
		// $isLast: Set to true if $rev is the last revision
		// Returns: HTML
		
		// Build curlink
		if($isFirst)
			$curLink = wfMsgExt('cur', array('escape'));
		else
			$curLink = $this->skin->makeKnownLinkObj($title,
					wfMsgExt('cur', array('escape')),
					"oldid={$rev->getId()}&diff=cur");
					
		if($isLast)
			$lastLink = wfMsgExt('last', array('escape'));
		else
			$lastLink = $this->skin->makeKnownLinkObj($title,
					wfMsgExt('last', array('escape')),
					"oldid=prev&diff={$rev->getId()}");
					
		// Build oldid link
		global $wgLang;
		$date = $wgLang->timeanddate(wfTimeStamp(TS_MW, $rev->getTimestamp()), true);
		if($rev->userCan(Revision::DELETED_TEXT))
			$link = $this->skin->makeKnownLinkObj($title, $date, "oldid={$rev->getId()}");
		else
			$link = $date;
		
		// Build user textbox
		global $wgRequest;
		$userBox = Xml::input("user-new-{$rev->getId()}", 50, $wgRequest->getVal("user-{$rev->getId()}", $rev->getUserText()));
		$userText = Xml::hidden("user-old-{$rev->getId()}", $rev->getUserText()) . $rev->getUserText();
		
		if (!is_null($size = $rev->getSize()))
		{
			if ($size == 0)
				$stxt = wfMsgHtml('historyempty');
			else
				$stxt = wfMsgHtml('historysize', $wgLang->formatNum( $size ) );
		}
		else
			$stxt = ''; // Stop PHP from whining about unset variables
                $comment = $this->skin->commentBlock($rev->getComment(), $title);
		
		// Now put it all together
		return "<li>($curLink) ($lastLink) $link . . $userBox ($userText) $stxt $comment</li>\n";
	}
	
	private function buildRevisionList($title, $errMsg = '')
	{
		// Builds a form listing the last 50 revisions of $pagename
		// that allows changing authors
		// $pagename: Title object
		// $errMsg: Error message
		// Returns: HTML.
		global $wgScript;
		$dbr = wfGetDb(DB_SLAVE);
		$res = $dbr->select(
					'revision',
					Revision::selectFields(),
					array('rev_page' => $title->getArticleId()),
					__METHOD__,
					array('ORDER BY' => 'rev_timestamp DESC', 'LIMIT' => 50)
		);
		$revs = array();
		while(($r = $dbr->fetchObject($res)))
			$revs[] = new Revision($r);
		if(empty($revs))
			// That's *very* weird
			return wfMsg('changeauthor-weirderror');
		
		$retval = Xml::openElement('form', array('method' => 'POST', 'action' => $wgScript));
		$retval .= Xml::hidden('title', $this->selfTitle->getPrefixedDbKey());
		$retval .= Xml::hidden('action', 'change');
		$retval .= Xml::hidden('targetpage', $title->getPrefixedDbKey());
		$retval .= Xml::openElement('fieldset');
		$retval .= Xml::element('p', array(), wfMsg('changeauthor-explanation-multi'));
		$retval .= Xml::inputLabel(wfMsg('changeauthor-comment'), 'comment', 'comment', 50);
		$retval .= Xml::submitButton(wfMsg('changeauthor-changeauthors-multi'));
		if($errMsg != '')
		{	
			$retval .= Xml::openElement('p') . Xml::openElement('b');
			$retval .= Xml::element('font', array('color' => 'red'), $errMsg);
			$retval .= Xml::closeElement('b') . Xml::closeElement('p');
		}
		$retval .= Xml::element('h2', array(), $title->getPrefixedText());
		$retval .= Xml::openElement('ul');
		$count = count($revs);
		foreach($revs as $i => $rev)
			$retval .= $this->buildRevisionLine($rev, $title, ($i == 0), ($i == $count - 1));
		$retval .= Xml::closeElement('ul');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('form');
		return $retval;		
	}
	
	private function buildOneRevForm($rev, $errMsg = '')
	{
		// Builds a form that allows changing one revision's author
		// $rev: Revision object
		// $errMsg: Error message
		// Returns: HTML
		global $wgScript;
		$retval = Xml::openElement('form', array('method' => 'POST', 'action' => $wgScript));
		$retval .= Xml::hidden('title', $this->selfTitle->getPrefixedDbKey());
		$retval .= Xml::hidden('action', 'change');
		$retval .= Xml::hidden('targetrev', $rev->getId());
		$retval .= Xml::openElement('fieldset');
		$retval .= Xml::element('p', array(), wfMsg('changeauthor-explanation-single'));
		$retval .= Xml::inputLabel(wfMsg('changeauthor-comment'), 'comment', 'comment');
		$retval .= Xml::submitButton(wfMsg('changeauthor-changeauthors-single'));
		if($errMsg != '')
		{	
			$retval .= Xml::openElement('p') . Xml::openElement('b');
			$retval .= Xml::element('font', array('color' => 'red'), $errMsg);
			$retval .= Xml::closeElement('b') . Xml::closeElement('p');
		}
		$retval .= Xml::element('h2', array(), wfMsg('changeauthor-revview', $rev->getId(), $rev->getTitle()->getPrefixedText()));
		$retval .= Xml::openElement('ul');
		$retval .= $this->buildRevisionLine($rev, $rev->getTitle());
		$retval .= Xml::closeElement('ul');
		$retval .= Xml::closeElement('fieldset');
		$retval .= Xml::closeElement('form');
		return $retval;		
	}
	
	private function parseChangeRequest()
	{
		// Extracts an array needed by changeRevAuthors() from $wgRequest
		// Returns: array
		global $wgRequest;
		$vals = $wgRequest->getValues();
		$retval = array();
		foreach($vals as $name => $val)
		{
			if(substr($name, 0, 9) != 'user-new-')
				continue;
			$revid = substr($name, 9);
			if(!is_numeric($revid))
				continue;
				
			$new = User::newFromName($val, false);
			if(!$new) // Can this even happen?
				return wfMsg('changeauthor-invalid-username', $val);
			if($new->getId() == 0 && $val != 'MediaWiki default' && !User::isIP($new->getName()))
				return wfMsg('changeauthor-nosuchuser', $val);
			$old = User::newFromName($wgRequest->getVal("user-old-$revid"), false);
			if(!$old->getName())
				return wfMsg('changeauthor-invalidform');
			if($old->getName() != $new->getName())
				$retval[$revid] = array($old, $new);
		}
		return $retval;
	}
	
	private function changeRevAuthors($authors, $comment)
	{
		// Changes revision authors in the database
		// $authors: array, key=revid value=array(User from, User to)
		$dbw = wfGetDb(DB_MASTER);
		$dbw->begin();
		$editcounts = array(); // Array to keep track of EC mutations; key=userid, value=mutation
		$log = new LogPage('changeauth');
		foreach($authors as $id => $users)
		{
			$dbw->update('revision',
				array(	'rev_user' => $users[1]->getId(), // SET
					 	'rev_user_text' => $users[1]->getName()),
				array(	'rev_id' => $id), // WHERE
				__METHOD__);
			$rev = Revision::newFromId($id);
			$log->addEntry('changeauth', $rev->getTitle(), $comment, array(wfMsg('changeauthor-rev', $id), $users[0]->getName(), $users[1]->getName()));
			$editcounts[$users[1]->getId()]++;
			$editcounts[$users[0]->getId()]--;
		}
		foreach($editcounts as $userid => $mutation)
		{
			if($mutation == 0 || $userid == 0)
				continue;
			if($mutation > 0)
				$mutation = "+$mutation";
			$dbw->update('user',
				array(	"user_editcount=user_editcount$mutation"),
				array(	'user_id' => $userid),
				__METHOD__);
			if($dbw->affectedRows() == 0)
			{
				// Let's have mercy on those who don't have a proper DB server
				// (but not enough to spare their master)
				$count = $dbw->selectField('revision', 'COUNT(rev_user)',
						array('rev_user' => $userid), __METHOD__);
				$dbw->update('user',
					array(	'user_editcount' => $count),
					array(	'user_id' => $userid),
					__METHOD);
			}
		}
		$dbw->commit();
	}
		
	static function loadMessages()
	{
		static $messagesLoaded = false;
		if (!$messagesLoaded)
		{
			$messagesLoaded = true;
			wfLoadExtensionMessages('ChangeAuthor');
		}
		return true;
	}
}
