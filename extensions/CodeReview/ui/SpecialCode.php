<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class SpecialCode extends SpecialPage {
	function __construct() {
		parent::__construct( 'Code' , 'codereview-use' );
	}

	function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgUser, $wgScriptPath, $wgCodeReviewStyleVersion;

		wfLoadExtensionMessages( 'CodeReview' );

		if( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();
		$wgOut->addStyle( "$wgScriptPath/extensions/CodeReview/codereview.css?$wgCodeReviewStyleVersion" );
		# Remove stray slashes
		$subpage = preg_replace( '/\/$/', '', $subpage );
		if ( $subpage == '' ) {
			$view = new CodeRepoListView();
		} else {
			$params = explode( '/', $subpage );
			switch( count( $params ) ) {
			case 1:
				$view = new CodeRevisionListView( $params[0] );
				break;
			case 2:
				if ( $params[1] === 'tag' ) {
					$view = new CodeTagListView( $params[0] );
					break;
				} elseif ( $params[1] === 'author' ) {
					$view = new CodeAuthorListView( $params[0] );
					break;
				} elseif ( $params[1] === 'status' ) {
					$view = new CodeStatusListView( $params[0] );
					break;
				} elseif ( $params[1] === 'comments' ) {
					$view = new CodeCommentsListView( $params[0] );
					break;
				} elseif ( $params[1] === 'statuschanges' ) {
					$view = new CodeStatusChangeListView( $params[0] );
					break;
				} elseif ( $params[1] === 'releasenotes' ) {
					$view = new CodeReleaseNotes( $params[0] );
					break;
				} else if ( $wgRequest->wasPosted() && !$wgRequest->getCheck( 'wpPreview' ) ) {
					# Add any tags, Set status, Adds comments
					$submit = new CodeRevisionCommitter( $params[0], $params[1] );
					$submit->execute();
					return;
				} else { // revision details
					$view = new CodeRevisionView( $params[0], $params[1] );
					break;
				}
			case 3:
				if ( $params[1] === 'tag' ) {
					$view = new CodeRevisionTagView( $params[0], $params[2] );
					break;
				} elseif ( $params[1] === 'author' ) {
					$view = new CodeRevisionAuthorView( $params[0], $params[2] );
					break;
				} elseif ( $params[1] === 'status' ) {
					$view = new CodeRevisionStatusView( $params[0], $params[2] );
					break;
				} elseif ( $params[1] === 'comments' ) {
					$view = new CodeCommentsListView( $params[0] );
					break;
				} else {
					# Nonsense parameters, back out
					if ( empty( $params[1] ) )
						$view = new CodeRevisionListView( $params[0] );
					else
						$view = new CodeRevisionView( $params[0], $params[1] );
					break;
				}
			case 4:
				if ( $params[1] == 'author' && $params[3] == 'link' ) {
					$view = new CodeRevisionAuthorLink( $params[0], $params[2] );
					break;
				}
			default:
				if ( $params[2] == 'reply' ) {
					$view = new CodeRevisionView( $params[0], $params[1], $params[3] );
					break;
				}
				$wgOut->addWikiText( wfMsg( 'nosuchactiontext' ) );
				$wgOut->returnToMain( null, SpecialPage::getTitleFor( 'Code' ) );
				return;
			}
		}
		$view->execute();

		// Add subtitle for easy navigation
		global $wgOut;
		if ( $view instanceof CodeView && ( $repo = $view->getRepo() ) ) {
			$wgOut->setSubtitle(
				wfMsgExt( 'codereview-subtitle', 'parse', CodeRepoListView::getNavItem( $repo ) )
			);
		}
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

	function authorLink( $author, $extraParams=array() ) {
		$repo = $this->mRepo->getName();
		$special = SpecialPage::getTitleFor( 'Code', "$repo/author/$author" );			
		return $this->mSkin->link( $special, htmlspecialchars( $author ), array(),  $extraParams);
	}

	function statusDesc( $status ) {
		return wfMsg( "code-status-$status" );
	}

	function formatMessage( $text ) {
		$text = nl2br( htmlspecialchars( $text ) );
		$linker = new CodeCommentLinkerHtml( $this->mRepo );
		return $linker->link( $text );
	}

	function messageFragment( $value ) {
		global $wgLang;
		$message = trim( $value );
		$lines = explode( "\n", $message, 2 );
		$first = $lines[0];
		$html = $this->formatMessage( $first );
		$linker = new CodeCommentLinkerHtml( $this->mRepo );
		return $linker->truncateHtml( $html, 80 );
	}
	/*
	 * Formatted HTML array for properties display
	 * @param array fields : 'propname' => HTML data
	 */
	function formatMetaData( $fields ) {
		$html = '<table class="mw-codereview-meta">';
		foreach ( $fields as $label => $data ) {
			$html .= "<tr><td>" . wfMsgHtml( $label ) . "</td><td>$data</td></tr>\n";
		}
		return $html . "</table>\n";
	}

	function getRepo() {
		if ( $this->mRepo )
			return $this->mRepo;
		return false;
	}
}

abstract class SvnTablePager extends TablePager {

	function __construct( $view ) {
		global $IP;
		$this->mView = $view;
		$this->mRepo = $view->mRepo;
		$this->mDefaultDirection = true;
		$this->mCurSVN = SpecialVersion::getSvnRevision( $IP );
		parent::__construct();
	}

	function isFieldSortable( $field ) {
		return $field == $this->getDefaultSort();
	}

	// Note: this function is poorly factored in the parent class
	function formatRow( $row ) {
		global $wgWikiSVN;
		$css = "mw-codereview-status-{$row->cr_status}";
		if ( $this->mRepo->mName == $wgWikiSVN ) {
			$css .= " mw-codereview-" . ( $row-> { $this->getDefaultSort() } <= $this->mCurSVN ? 'live' : 'notlive' );
		}
		$s = "<tr class=\"$css\">\n";
		// Some of this stolen from Pager.php...sigh
		$fieldNames = $this->getFieldNames();
		$this->mCurrentRow = $row;  # In case formatValue needs to know
		foreach ( $fieldNames as $field => $name ) {
			$value = isset( $row->$field ) ? $row->$field : null;
			$formatted = strval( $this->formatValue( $field, $value, $row ) );
			if ( $formatted == '' ) {
				$formatted = '&nbsp;';
			}
			$class = 'TablePager_col_' . htmlspecialchars( $field );
			$s .= "<td class=\"$class\">$formatted</td>\n";
		}
		$s .= "</tr>\n";
		return $s;
	}
}
