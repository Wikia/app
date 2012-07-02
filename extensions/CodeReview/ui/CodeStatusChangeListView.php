<?php

// Special:Code/MediaWiki
class CodeStatusChangeListView extends CodeRevisionListView {
	function getPager() {
		return new CodeStatusChangeTablePager( $this );
	}

	function getRevCount( $dbr ) {
		return -1;
	}
}

// Pager for CodeRevisionListView
class CodeStatusChangeTablePager extends SvnTablePager {

	function isFieldSortable( $field ) {
		return $field == 'cpc_timestamp';
	}

	function getDefaultSort() {
		return 'cpc_timestamp';
	}

	function getQueryInfo() {
		$query = array(
			'tables' => array( 'code_prop_changes', 'code_rev' ),
			'fields' => array_keys( $this->getFieldNames() ),
			'conds' => array( 'cpc_repo_id' => $this->mRepo->getId(), 'cpc_attrib' => 'status' ),
			'join_conds' => array(
				'code_rev' => array( 'LEFT JOIN', 'cpc_repo_id = cr_repo_id AND cpc_rev_id = cr_id' )
			),
			'options' => array(),
		);

		if( count( $this->mView->mPath ) ) {
			$query['tables'][] = 'code_paths';
			$query['join_conds']['code_paths'] = array( 'INNER JOIN', 'cpc_repo_id = cp_repo_id AND cpc_rev_id = cp_rev_id' );
			$query['conds']['cp_path'] = $this->mView->mPath;
		}
		if ( $this->mView->mAuthor ) {
			$query['conds']['cpc_user_text'] = User::newFromName( $this->mView->mAuthor )->getName();
		}

		return $query;
	}

	function getFieldNames() {
		return array(
			'cpc_timestamp' => wfMsg( 'code-field-timestamp' ),
			'cpc_user_text' => wfMsg( 'code-field-user' ),
			'cpc_rev_id' => wfMsg( 'code-field-id' ),
			'cr_author' => WfMsg( 'code-field-author' ),
			'cr_message' => wfMsg( 'code-field-message' ),
			'cpc_removed' => wfMsg( 'code-old-status' ),
			'cpc_added' => wfMsg( 'code-new-status' ),
			'cr_status' => wfMsg( 'code-field-status' ),
		);
	}

	function formatValue( $name, $value ) {
		switch( $name ) {
		case 'cpc_rev_id':
			return $this->mView->skin->link(
				SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/' . $value . '#code-changes' ),
				htmlspecialchars( $value ) );
		case 'cr_author':
			return $this->mView->authorLink( $value );
		case 'cr_message':
			return $this->mView->messageFragment( $value );
		case 'cr_status':
			return $this->mView->skin->link(
				SpecialPage::getTitleFor( 'Code',
					$this->mRepo->getName() . '/status/' . $value ),
				htmlspecialchars( $this->mView->statusDesc( $value ) ) );
		case 'cpc_user_text':
			return $this->mView->skin->userLink( - 1, $value );
		case 'cpc_removed':
			return wfMsgHtml( $value ? "code-status-$value" : "code-status-new" );
		case 'cpc_added':
			return wfMsgHtml( "code-status-$value" );
		case 'cpc_timestamp':
			global $wgLang;
			return $wgLang->timeanddate( $value, true );
		}
	}

	function getTitle() {
		return SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/statuschanges' );
	}
}
