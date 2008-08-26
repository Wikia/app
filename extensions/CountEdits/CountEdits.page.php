<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**
 * Special page class for the CountEdits extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

class SpecialCountEdits extends SpecialPage {

	var $target;

	public function __construct() {
		SpecialPage::SpecialPage( 'CountEdits' );
	}

	public function execute( $params ) {
		global $wgOut, $wgUser;
		wfLoadExtensionMessages( 'CountEdits' );
		$skin = $wgUser->getSkin();
		$this->setHeaders();
		$this->loadRequest( $params );
		$wgOut->addHtml( $this->makeForm() );
		if( $this->target ) {
			if( User::isIP( $this->target ) ) {
				$this->showResults( $this->countEditsReal( 0, $this->target ) );
			} else {
				$id = User::idFromName( $this->target );
				if( $id ) {
					$this->showResults( $this->countEditsReal( $id, false ), $id );
				} else {
					$wgOut->addHtml( '<p>' . wfMsgHtml( 'countedits-nosuchuser', htmlspecialchars( $this->target ) ) . '</p>' );
				}
			}
		}
		$this->showTopTen( $wgOut );
		return true;
	}

	function loadRequest( $params ) {
		global $wgRequest;
		if( $params ) {
			$this->target = $params;
		} else {
			$target = $wgRequest->getText( 'target' );
			$this->target = $target ? $target : '';
		}
	}

	function makeForm() {
		$self = $this->getTitle();
		$form  = '<form method="post" action="'. $self->getLocalUrl() . '">';
		$form .= '<p><label for="target">' . wfMsgHtml( 'countedits-username' ) . '</label>&nbsp;';
		$form .= '<input type="text" name="target" id="target" size="25" value="' . htmlspecialchars( $this->target ) . '" />&nbsp;';
		$form .= '<input type="submit" name="countedits" value="' . wfMsgHtml( 'countedits-ok' ) . '" />';
		$form .= '</p></form>';
		return $form;
	}

	function countEditsReal( $id, $text = false ) {
		global $wgVersion;
		$dbr =& wfGetDB( DB_SLAVE );
		# MediaWiki 1.9.x has a user.user_editcount column we can use,
		# but this is not useful for older versions or anon. checks
		if( $text === false && version_compare( $wgVersion, '1.9alpha', '>=' ) ) {
			$conds = array( 'user_id' => $id );
			return $dbr->selectField( 'user', 'user_editcount', $conds, 'CountEdits::countEditsReal' );
		} else {
			$conds = array( 'rev_user' => $id );
			if( $text )
				$conds['rev_user_text'] = $text;
			return $dbr->selectField( 'revision', 'COUNT(rev_id)', $conds, 'CountEdits::countEditsReal' );
		}
	}

	function showResults( $count, $id = 0 ) {
		global $wgOut, $wgUser, $wgLang;
		$skin =& $wgUser->getSkin();
		$wgOut->addHtml( '<h2>' . wfMsgHtml( 'countedits-resultheader', htmlspecialchars( $this->target ) ) . '</h2>' );
		$links = $skin->userLink( $id, $this->target ) . $skin->userToolLinks( $id, $this->target );
		$wgOut->addHtml( '<p>' . wfMsgHtml( 'countedits-resulttext', $links, $count ) . '</p>' );
		$wgOut->addWikiText( wfMsg( 'countedits-warning' ) );
	}

	function showTopTen( &$out ) {
		global $wgCountEditsMostActive;
		if( $wgCountEditsMostActive )
			$out->addHtml( $this->getMostActive() );
	}

	function getMostActive() {
		global $wgUser, $wgLang;
		$dbr =& wfGetDB( DB_SLAVE );
		$rev = $dbr->tableName( 'revision' );
		$sql  = "SELECT COUNT(*) AS count, rev_user, rev_user_text FROM $rev";
		$groupby = "GROUP BY rev_user_text";
		if( !$dbr->implicitGroupby() )
			$groupby .= ", rev_user";
		$orderby = "ORDER BY count DESC LIMIT 11";
		$sql .= " $groupby $orderby";
		$res = $dbr->query( $sql );
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$skin = $wgUser->getSkin();
			$out  = '<h2>' . wfMsgHtml( 'countedits-mostactive' ) . '</h2>';
			$out .= '<ul>';
			while( $row = $dbr->fetchObject( $res ) ) {
				if( $row->rev_user_text != 'MediaWiki default' ) {
					$out .= '<li>' . $skin->userLink( $row->rev_user, $row->rev_user_text );
					$out .= $skin->userToolLinks( $row->rev_user, $row->rev_user_text );
					$out .= ' [' . $wgLang->formatNum( $row->count ) . ']</li>';
				}
			}
			$dbr->freeResult( $res );
			$out .= '</ul>';
			return $out;
		} else {
			return '';
		}
	}
}
