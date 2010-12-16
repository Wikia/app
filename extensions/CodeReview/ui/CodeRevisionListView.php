<?php

// Special:Code/MediaWiki
class CodeRevisionListView extends CodeView {
	public $mRepo, $mPath;
	function __construct( $repoName ) {
		global $wgRequest;
		parent::__construct();
		$this->mRepo = CodeRepository::newFromName( $repoName );
		$this->mPath = htmlspecialchars( trim( $wgRequest->getVal( 'path' ) ) );
		if ( strlen( $this->mPath ) && $this->mPath[0] !== '/' ) {
			$this->mPath = "/{$this->mPath}"; // make sure this is a valid path
		}
		$this->mAuthor = null;
		$this->mAppliedFilter = null;
	}

	function execute() {
		global $wgOut, $wgUser, $wgRequest;
		if ( !$this->mRepo ) {
			$view = new CodeRepoListView();
			$view->execute();
			return;
		}

		// Check for batch change requests.
		$editToken = $wgRequest->getVal( 'wpBatchChangeEditToken' );
		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $editToken ) ) {
			$this->doBatchChange();
			return;
		}

		$this->showForm();
		
		//get the total count across all pages
		$dbr = wfGetDB( DB_SLAVE );
		$revCountRes = $this->getRevCountQuery( $dbr );
		$revCount = 0;		 
		if ( $revCountRes !== false ) {		
			$revCount = $revCountRes->rev_count;
		}
		
		$pager = $this->getPager();

		// Build batch change interface as needed
		$this->batchForm = $wgUser->isAllowed( 'codereview-set-status' ) ||
			$wgUser->isAllowed( 'codereview-add-tag' );

		$wgOut->addHTML(
			'<table><tr><td>' .
			$pager->getNavigationBar() .
			$pager->getLimitForm() .
			'</td><td style="padding-left: 2em;">' . 
			'&nbsp;<strong>' . wfMsgHtml( 'code-rev-total', $revCount ) . '</strong>' . 
			'</td></tr></table>' .  
			Xml::openElement( 'form',
				array( 'action' => $pager->getTitle()->getLocalURL(), 'method' => 'post' )
			) . 
			$pager->getBody() .
			$pager->getNavigationBar() .
			( $this->batchForm ? $this->buildBatchInterface( $pager ) : "" ) .
			Xml::closeElement( 'form' )
		);
	}

	function doBatchChange() {
		global $wgRequest;

		$revisions = $wgRequest->getArray( 'wpRevisionSelected' );
		$removeTags = $wgRequest->getVal( 'wpRemoveTag' );
		$addTags = $wgRequest->getVal( 'wpTag' );
		$status = $wgRequest->getVal( 'wpStatus' );

		// Grab data from the DB
		$dbr = wfGetDB( DB_SLAVE );
		$revObjects = array();
		$res = $dbr->select( 'code_rev', '*', array( 'cr_id' => $revisions ), __METHOD__ );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$revObjects[] = CodeRevision::newFromRow( $this->mRepo, $row );
		}

		global $wgUser;
		if ( $wgUser->isAllowed( 'codereview-add-tag' ) &&
				$addTags || $removeTags ) {
			$addTags = array_map( 'trim', explode( ",", $addTags ) );
			$removeTags = array_map( 'trim', explode( ",", $removeTags ) );

			foreach ( $revObjects as $id => $rev ) {
				$rev->changeTags( $addTags, $removeTags, $wgUser );
			}
		}

		if ( $wgUser->isAllowed( 'codereview-set-status' ) &&
				$revObjects[0]->isValidStatus( $status ) ) {
			foreach ( $revObjects as $id => $rev ) {
				$rev->setStatus( $status, $wgUser );
			}
		}

		// Automatically refresh
		// This way of getting GET parameters is horrible, but effective.
		$fields = array_merge( $_GET, $_POST );
		foreach ( array_keys( $fields ) as $key ) {
			if ( substr( $key, 0, 2 ) == 'wp' || $key == 'title' )
				unset( $fields[$key] );
		}

		global $wgOut;
		$wgOut->redirect( $this->getPager()->getTitle()->getFullURL( $fields ) );
	}

	protected function buildBatchInterface( $pager ) {
		global $wgUser;

		$changeInterface = '';
		$changeFields = array();

		if ( $wgUser->isAllowed( 'codereview-set-status' ) ) {
			$changeFields['code-batch-status'] =
				Xml::tags( 'select', array( 'name' => 'wpStatus' ),
					Xml::tags( 'option',
						array( 'value' => '', 'selected' => 'selected' ), ' '
					) .
					CodeRevisionView::buildStatusList( null, $this )
				);
		}

		if ( $wgUser->isAllowed( 'codereview-add-tag' ) ) {
			$changeFields['code-batch-tags'] = CodeRevisionView::addTagForm( '', '' );
		}

		if ( !count( $changeFields ) ) return ''; // nothing to do here

		$changeInterface = Xml::fieldset( wfMsg( 'codereview-batch-title' ),
				Xml::buildForm( $changeFields, 'codereview-batch-submit' ) );

		$changeInterface .= $pager->getHiddenFields();
		$changeInterface .= Xml::hidden( 'wpBatchChangeEditToken', $wgUser->editToken() );

		return $changeInterface;
	}

	function showForm( $path = '' ) {
		global $wgOut, $wgScript;
		if ( $this->mAuthor ) {
			$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/author/' . $this->mAuthor );
		} else {
			$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/path' );
		}
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'action' => $wgScript, 'method' => 'get' ) ) .
			"<fieldset><legend>" . wfMsgHtml( 'code-pathsearch-legend' ) . "</legend>" .
				'<table width="100%"><tr><td>' .
				Xml::inputlabel( wfMsg( "code-pathsearch-path" ), 'path', 'path', 55, $this->mPath ) .
				'&nbsp;' . Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . 
				'</td>'
		);
		if ( strlen( $this->mAppliedFilter) ) {
			$wgOut->addHTML(
				'<td>' .  
				Xml::label(wfMsg( 'code-pathsearch-filter' ), 'revFilter' ) . '<strong>' .
				Xml::span( $this->mAppliedFilter, '') . '</strong>&nbsp;' .
				Xml::submitButton( wfMsg( 'code-revfilter-clear' ) ) . 
				'</td>' .
				Xml::hidden( 'title', SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() ) )
			);
		} else {
			$wgOut->addHTML( Xml::hidden( 'title', $special->getPrefixedDBKey() ) );
		}
		$wgOut->addHTML( "</tr></table></fieldset>" . Xml::closeElement( 'form' ) );
	}

	function getPager() {
		return new SvnRevTablePager( $this );
	}
	
	function getRevCountQuery( $dbr ) {
		$tables = array( 'code_rev' );
		$selectFields = array( 'COUNT( DISTINCT cr_id ) AS rev_count' );
		// count if code_rev where path matches
		if ( strlen($this->mPath) ) {
			$tables[] = 'code_paths';
			$whereCond = array('cr_repo_id' => $this->mRepo->getId(),
							'cr_id = cp_rev_id', 
							' cp_path' . $dbr->buildLike( $this->mPath, $dbr->anyString() ),
							// performance
							' cp_rev_id > ' . ( $this->mRepo->getLastStoredRev() - 20000 )
						);
		// No path; count of code_rev
		} else {
			$whereCond = array('cr_repo_id' => $this->mRepo->getId());
		}
		$whereCond = array_merge( $whereCond, $this->getSpecializedWhereClause( $dbr ) );
		return $dbr->selectRow( $tables, $selectFields, $whereCond );
	}
	
	function getSpecializedWhereClause( $dbr ) {
		return array();
	}
	
}

// Pager for CodeRevisionListView
class SvnRevTablePager extends SvnTablePager {

	function getSVNPath() {
		return $this->mView->mPath;
	}

	function isFieldSortable( $field ) {
		return $field == $this->getDefaultSort();
	}

	function getDefaultSort() {
		return strlen( $this->mView->mPath ) ? 'cp_rev_id' : 'cr_id';
	}

	function getQueryInfo() {
		// Path-based query...
		if ( $this->getDefaultSort() === 'cp_rev_id' ) {
			return array(
				'tables' => array( 'code_paths', 'code_rev', 'code_comment' ),
				'fields' => $this->getSelectFields(),
				'conds' => array(
					'cp_repo_id' => $this->mRepo->getId(),
					'cp_path LIKE ' . $this->mDb->addQuotes( $this->mDb->escapeLike( $this->getSVNPath() ) . '%' ),
					// performance
					'cp_rev_id > ' . ( $this->mRepo->getLastStoredRev() - 20000 )
				),
				'options' => array( 'GROUP BY' => 'cp_rev_id', 'USE INDEX' => array( 'code_path' => 'cp_repo_id' ) ),
				'join_conds' => array(
					'code_rev' => array( 'INNER JOIN', 'cr_repo_id = cp_repo_id AND cr_id = cp_rev_id' ),
					'code_comment' => array( 'LEFT JOIN', 'cc_repo_id = cp_repo_id AND cc_rev_id = cp_rev_id' ),
				)
			);
		// No path; entire repo...
		} else {
			return array(
				'tables' => array( 'code_rev', 'code_comment' ),
				'fields' => $this->getSelectFields(),
				'conds' => array( 'cr_repo_id' => $this->mRepo->getId() ),
				'options' => array( 'GROUP BY' => 'cr_id' ),
				'join_conds' => array(
					'code_comment' => array( 'LEFT JOIN', 'cc_repo_id = cr_repo_id AND cc_rev_id = cr_id' ),
				)
			);
		}
		return false;
	}

	function getSelectFields() {
		return array( $this->getDefaultSort(),
			'cr_id',
			'cr_repo_id',
			'cr_status',
			'COUNT(DISTINCT cc_id) AS comments',
			'cr_path',
			'cr_message',
			'cr_author',
			'cr_timestamp' );
	}

	function getFieldNames() {
		$fields = array(
			$this->getDefaultSort() => wfMsg( 'code-field-id' ),
			'cr_status' => wfMsg( 'code-field-status' ),
			'comments' => wfMsg( 'code-field-comments' ),
			'tests' => wfMsg( 'code-field-tests' ),
			'cr_path' => wfMsg( 'code-field-path' ),
			'cr_message' => wfMsg( 'code-field-message' ),
			'cr_author' => wfMsg( 'code-field-author' ),
			'cr_timestamp' => wfMsg( 'code-field-timestamp' ),
		);
		# Only show checkboxen as needed
		if ( !empty( $this->mView->batchForm ) ) {
			$fields = array( 'selectforchange' => wfMsg( 'code-field-select' ) ) + $fields;
		}
		return $fields;
	}
	
	function formatValue( $name, $value ) { } // unused

	function formatRevValue( $name, $value, $row ) {
		global $wgLang;
		$pathQuery = ( strlen($this->mView->mPath) ) ? array('path' => $this->mView->mPath) : array();

		switch( $name ) {
		case 'selectforchange':
			$sort = $this->getDefaultSort();
			return Xml::check( "wpRevisionSelected[]", false, array( 'value' => $row->$sort ) );
		case 'cp_rev_id':
		case 'cr_id':
			return $this->mView->mSkin->link(
				SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/' . $value ),
				htmlspecialchars( $value ),
				array(),
				array( 'path' => $this->mView->mPath )
			);
		case 'cr_status':
			return $this->mView->mSkin->link(
				SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/status/' . $value ),
				htmlspecialchars( $this->mView->statusDesc( $value ) ),
				array(),
				$pathQuery
			);
		case 'cr_author':
			return $this->mView->authorLink( $value, $pathQuery );
		case 'cr_message':
			return $this->mView->messageFragment( $value );
		case 'cr_timestamp':
			global $wgLang;
			return $wgLang->timeanddate( $value, true );
		case 'comments':
			if ( $value ) {
				$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/' . $row-> { $this->getDefaultSort() } );
				$special->setFragment( '#code-comments' );
				return $this->mView->mSkin->link( $special, htmlspecialchars( $value ) );
			} else {
				return intval( $value );
			}
		case 'tests':
			// fixme -- this still isn't too efficient...
			$rev = CodeRevision::newFromRow( $this->mRepo, $row );
			$runs = $rev->getTestRuns();
			if( empty( $runs ) ) {
				return '&nbsp;';
			} else {
				$total = 0;
				$success = 0;
				$progress = false;
				foreach( $runs as $run ) {
					$total += $run->countTotal;
					$success += $run->countSuccess;
					if( $run->status == 'running' ) {
						$progress = true;
					}
				}
				if( $progress ) {
					global $wgStylePath;
					return Xml::element( 'img', array(
						'src' => "$wgStylePath/common/images/spinner.gif",
						'width' => 20,
						'height' => 20,
						'alt' => "...",
						'title' => "Tests in progress...",
					));
				}
				if( $success == $total ) {
					$class = 'mw-codereview-success';
				} else {
					$class = 'mw-codereview-fail';
				}
				return "<span class='$class'><strong>$success</strong>/$total</span>";
			}
		case 'cr_path':
			return Xml::openElement( 'div', array( 'title' => (string)$value ) ) .
					$this->mView->mSkin->link(
					SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/path' ),
					$wgLang->truncate( (string)$value, 50 ),
					array( 'title' => (string)$value ),
					array( 'path' => (string)$value ) ) . "</div>";
		}
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
			$formatted = strval( $this->formatRevValue( $field, $value, $row ) );
			if ( $formatted == '' ) {
				$formatted = '&nbsp;';
			}
			$class = 'TablePager_col_' . htmlspecialchars( $field );
			$s .= "<td class=\"$class\">$formatted</td>\n";
		}
		$s .= "</tr>\n";
		return $s;
	}

	function getTitle() {
		return SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() );
	}
}
