<?php
/**
 * PageBy renderer for PageBy extension.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "Not a valid entry point.\n" );
	die( 1 );
}

class PageByRenderer {
	var $nominor;
	var $noanon;
	var $nobot;

	var $parser;
	var $title;
	var $otherpage;

	var $showtime;
	var $showfirst;
	var $showcomments;

	function __construct( $page, $argv, $parser ) {
		global $wgTitle;

		$this->parser = $parser;

		if ($page===null || $page===false || trim($page)==='') {
			$this->title = $wgTitle;
			$this->otherpage = false;
		}
		else {
			$this->title = Title::newFromText( trim($page) );
			$this->otherpage = true; #TODO: set to false if this is the current page
		}

		$this->nominor = isset($argv['nominor']) ? $argv['nominor'] : true;
		if ( $this->nominor === 'false' || $this->nominor === 'no' || $this->nominor === '0' )
			$this->nominor = false;

		$this->nobot = isset($argv['nobot']) ? $argv['nobot'] : true;
		if ( $this->nobot === 'false' || $this->nobot === 'no' || $this->nobot === '0' )
			$this->nobot = false;

		$this->noanon = isset($argv['noanon']) ? $argv['noanon'] : false;
		if ( $this->noanon === 'false' || $this->noanon === 'no' || $this->noanon === '0' )
			$this->noanon = false;

		$this->showfirst = isset($argv['creation']) ? $argv['creation'] : true;
		if ( $this->showfirst === 'false' || $this->showfirst === 'no' || $this->showfirst === '0' )
			$this->showfirst = false;

		$this->showcomments = isset($argv['comments']) ? $argv['comments'] : true;
		if ( $this->showcomments === 'false' || $this->showcomments === 'no' || $this->showcomments === '0' )
			$this->showcomments = false;

		$this->showtime = isset($argv['time']) ? $argv['time'] : false;
		if ( $this->showtime === 'false' || $this->showtime === 'no' || $this->showtime === '0' )
			$this->showtime = false;
	}

	function collectInfo( ) {
		$dbr = wfGetDB( DB_SLAVE );
		list( $trevision, $tuser, $tuser_groups ) = $dbr->tableNamesN( 'revision', '$tuser', 'user_groups' );

		#TODO: use query cache, check against page-timestamp
		#NOTE: if $this->otherpage == false, the parser cache already takes care of this...

		$sql = "SELECT $trevision.* FROM $trevision ";
		$sql .= "WHERE rev_deleted = 0 AND rev_page = " . (int)$this->title->getArticleID() . " ";
		$sql .= "ORDER BY rev_id ASC";

		#TODO: limit?

		$res = $dbr->query( $sql, 'PageByRenderer::collectInfo' );

		$users = array();
		$first = null;
		$last = null;
		$edits = 0;
		while ($row = $dbr->fetchObject( $res )) {
			$edits += 1;

			if ($first===null) $first = $row;
			$last = $row;

			if ($this->nominor && $row->rev_minor_edit) continue;
			if ($this->noanon && !$row->rev_user) continue; //FIXE: this also ignores imported revisions!

			if (!isset($users[$row->rev_user])) {
				$users[$row->rev_user] = array(
					'name' => $row->rev_user ? User::newFromId( $row->rev_user )->getName() : null,
					'id' => $row->rev_user,
					'count' => 0,
				);
			}

			$users[$row->rev_user]['count'] += 1;
		}
		$dbr->freeResult($res);

		if (!$edits) return false; #no revision -> no page

		if ($this->nobot) {
			$userids = array_keys($users);
			$userids = array_diff($userids, array( 0 )); //ignore anon

			if ($userids) {
				$sql = "SELECT $tuser_groups.* FROM $tuser_groups ";
				$sql .= "WHERE ug_user IN ( " . $dbr->makeList( $userids ) . " ) ";
				$sql .= "AND ug_group = 'bot' ";

				$res = $dbr->query( $sql, 'PageByRenderer::collectInfo#bots' );
				while ($row = $dbr->fetchObject( $res )) {
					unset($users[$row->ug_user]); #strip bots
				}
				$dbr->freeResult($res);
			}
		}

		$info = array();
		$info['edits'] = $edits;
		$info['first'] = $first;
		$info['last'] = $last;
		$info['users'] = $users;

		return $info;
	}

	function renderPageBy( ) {
		global $wgContLang, $wgUser;
		$sk = $wgUser->getSkin();

		if ($this->otherpage) {
			#TODO: if we can't use the parser cache, we should use the query cache
			$this->parser->disableCache();
		}

		$info = $this->collectInfo();
		if (!$info) return false; #TODO: report error!

		extract($info);

		$html = '<ul class="pageby">';

		
		#TODO: somehere link the page history. And mention the page name, if it's not the local page.

		if ($this->showfirst) {
			$firstUserName = User::newFromId( $first->rev_user )->getName();
			$firstuser = Title::makeTitle( NS_USER, $firstUserName );
			$ulink =  $sk->makeLinkObj( $firstuser, htmlspecialchars( $firstUserName ) );
			$date = $this->showtime ? $wgContLang->timeanddate($first->rev_timestamp) : $wgContLang->date($first->rev_timestamp);
			$diff = $this->title->getLocalURL('diff=' . $first->rev_id);
			$comment = htmlspecialchars( $first->rev_comment );

			$html .= '<li class="pageby-first">';
			$html .= wfMsg('pageby-first', $ulink, $date, $diff);
			if ($this->showcomments) $html .= '<span class="pageby-comment">: <i>' . $comment . '</i></span>';
			$html .= '</li>';
			$html .= "\n";
		}

		if ( sizeof($users) > 1 && ( (!$this->showfirst && $edits>1) || $edits>2) ) {
			$contributors = '';

			foreach ($users as $u) {
				if (!$u['id']) {
					$ulink = wfMsg('pageby-anon');
				}
				else {
					$cuser = Title::makeTitle(NS_USER, $u['name']);
					$ulink =  $sk->makeLinkObj($cuser, htmlspecialchars($u['name']));
				}

				if ($contributors !== '') $contributors .= ', ';

				$contributors .= '<span class="pageby-contributor">';
				$contributors .= $ulink;
				$contributors .= ' <span class="pageby-contribcount">x';
				$contributors .= $u['count'];
				$contributors .= '</span>';
				$contributors .= '</span>';
			}

			$html .= '<li class="pageby-contribs">';
			$html .= wfMsg('pageby-contributors');
			$html .= ' ';
			$html .= $contributors;
			$html .= '</li>';
			$html .= "\n";
		}

		if (!$this->showfirst || $edits > 1) {
			$lastUserName = User::newFromId( $last->rev_user );
			$lastuser = Title::makeTitle( NS_USER, $lastUserName );
			$ulink =  $sk->makeLinkObj( $lastuser, htmlspecialchars( $lastUserName ) );
			$date = $this->showtime ? $wgContLang->timeanddate($last->rev_timestamp) : $wgContLang->date($last->rev_timestamp);
			$diff = $this->title->getLocalURL('diff=' . $last->rev_id);
			$comment = htmlspecialchars( $last->rev_comment );

			$html .= '<li class="pageby-last">';
			$html .= wfMsg('pageby-last', $ulink, $date, $diff);
			if ($this->showcomments) $html .= '<span class="pageby-comment">: <i>' . $comment . '</i></span>';
			$html .= '</li>';
		}

		$html .= '</ul>';
		$html .= "\n";

		return $html;
	}
}
