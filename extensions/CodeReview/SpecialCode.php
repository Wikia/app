<?php
if (!defined('MEDIAWIKI')) die();

class SpecialCode extends SpecialPage {
	function __construct() {
		parent::__construct( 'Code' );
	}

	function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgUser, $wgScriptPath, $wgCodeReviewStyleVersion;

		wfLoadExtensionMessages( 'CodeReview' );

		$this->setHeaders();
		$wgOut->addStyle( "$wgScriptPath/extensions/CodeReview/codereview.css?$wgCodeReviewStyleVersion" );

		if( $subpage == '' ) {
			$view = new CodeRepoListView();
		} else {
			$params = explode( '/', $subpage );
			switch( count( $params ) ) {
			case 1:
				$view = new CodeRevisionListView( $params[0] );
				break;
			case 2:
				if( $wgRequest->wasPosted() && !$wgRequest->getCheck('wpPreview') ) {
					# Add any tags, Set status, Adds comments 
					$submit = new CodeRevisionCommitter( $params[0], $params[1] );
					$submit->execute();
					return;
				} else if( $params[1] === 'tag' ) {
					$view = new CodeTagListView( $params[0] );
					break;
				} elseif( $params[1] === 'author' ) {
					$view = new CodeAuthorListView( $params[0] );
					break;
				} elseif( $params[1] === 'status' ) {
					$view = new CodeStatusListView( $params[0] );
					break;
				} elseif( $params[1] === 'comments' ) {
					$view = new CodeCommentsListView( $params[0] );
					break;
				} else { // revision details
					$view = new CodeRevisionView( $params[0], $params[1] );
					break;
				}
			case 3:
				if( $params[1] === 'tag' ) {
					$view = new CodeRevisionTagView( $params[0], $params[2] );
					break;
				} elseif( $params[1] === 'author' ) {
					$view = new CodeRevisionAuthorView( $params[0], $params[2] );
					break;
				} elseif( $params[1] === 'status' ) {
					$view = new CodeRevisionStatusView( $params[0], $params[2] );
					break;
				} else {
					# Nonsense parameters, back out
					if( empty($params[1]) )
						$view = new CodeRevisionListView( $params[0] );
					else
						$view = new CodeRevisionView( $params[0], $params[1] );
					break;
				}
			case 4:
				if ( $params[1] == 'author' && $params[3] == 'link') {
					$view = new CodeRevisionAuthorLink( $params[0], $params[2] );
					break;
				}
			default:
				if( $params[2] == 'reply' ) {
					$view = new CodeRevisionView( $params[0], $params[1], $params[3] );
					break;
				}
				$wgOut->addWikiText( wfMsg('nosuchactiontext') );
				$wgOut->returnToMain( null, SpecialPage::getTitleFor( 'Code' ) );
				return;
			}
		}
		$view->execute();
	}
}

/**
 * Extended by CodeRevisionListView and CodeRevisionView
 */
abstract class CodeView {
	var $mRepo;

	function __construct() {
		global $wgUser;
		$this->mSkin = $wgUser->getSkin();
	}
	
	function validPost( $permission ) {
		global $wgRequest, $wgUser;
		return $wgRequest->wasPosted()
			&& $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) 
			&& $wgUser->isAllowed( $permission );
	}

	abstract function execute();

	/* 
	 *	returns a User object if $author has a wikiuser associated,
	 *	of false
	*/
	function authorWikiUser( $author ) {
		return $this->mRepo->authorWikiUser( $author );
	}

	function authorLink( $author ) {
		$repo = $this->mRepo->getName();
		$special = SpecialPage::getTitleFor( 'Code', "$repo/author/$author" );
		return $this->mSkin->link( $special, htmlspecialchars( $author ) );
	}
	
	function statusDesc( $status ) {
		return wfMsg( "code-status-$status" );
	}

	function formatMessage( $text ){
		$text = nl2br( htmlspecialchars( $text ) );
		$linker = new CodeCommentLinkerHtml( $this->mRepo );
		return $linker->link( $text );
	}

	function messageFragment( $value ) {
		global $wgLang;
		$message = trim( $value );
		$lines = explode( "\n", $message, 2 );
		$first = $lines[0];
		$trimmed = $wgLang->truncate( $first, 80, '...' );
		return $this->formatMessage( $trimmed );
	}
	/*
	 * Formatted HTML array for properties display
	 * @param array fields : 'propname' => HTML data
	 */
	function formatMetaData( $fields ) {
		$html = '<table class="mw-codereview-meta">';
		foreach( $fields as $label => $data ) {
			$html .= "<tr><td>" . wfMsgHtml( $label ) . "</td><td>$data</td></tr>\n";
		}
		return $html . "</table>\n";
	}
}

class CodeCommentLinker {
	function __construct( $repo ) {
		global $wgUser;
		$this->mSkin = $wgUser->getSkin();
		$this->mRepo = $repo;
	}

	function link( $text ) {
		$text = preg_replace_callback( '/\br(\d+)\b/', array( $this, 'messageRevLink' ), $text );
		$text = preg_replace_callback( '/\bbug #?(\d+)\b/i', array( $this, 'messageBugLink' ), $text );
		return $text;
	}

	function messageBugLink( $arr ){
		$text = $arr[0];
		$bugNo = intval( $arr[1] );
		$url = $this->mRepo->getBugPath( $bugNo );
		if( $url ) {
			return $this->makeExternalLink( $url, $text );
		} else {
			return $text;
		}
	}

	function messageRevLink( $matches ) {
		$text = $matches[0];
		$rev = intval( $matches[1] );

		$repo = $this->mRepo->getName();
		$title = SpecialPage::getTitleFor( 'Code', "$repo/$rev" );

		return $this->makeInternalLink( $title, $text );
	}

}

class CodeCommentLinkerHtml extends CodeCommentLinker {
	function makeExternalLink( $url, $text ) {
		return $this->mSkin->makeExternalLink( $url, $text );
	}

	function makeInternalLink( $title, $text ) {
		return $this->mSkin->link( $title, $text );
	}
}

class CodeCommentLinkerWiki extends CodeCommentLinker {
	function makeExternalLink( $url, $text ) {
		return "[$url $text]";
	}

	function makeInternalLink( $title, $text ) {
		return "[[" . $title->getPrefixedText() . "|$text]]";
	}
}
