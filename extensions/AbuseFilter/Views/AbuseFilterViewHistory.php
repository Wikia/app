<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class AbuseFilterViewHistory extends AbuseFilterView {
	function __construct( $page, $params ) {
		parent::__construct( $page, $params );
		$this->mFilter = $page->mFilter;
	}

	function show() {
		$out = $this->getOutput();
		$filter = $this->mFilter;

		if ( $filter ) {
			$out->setPageTitle( wfMsg( 'abusefilter-history', $filter ) );
		} else {
			$out->setPageTitle( wfMsg( 'abusefilter-filter-log' ) );
		}

		# Check perms
		if ( $filter &&
				!$this->getUser()->isAllowed( 'abusefilter-modify' ) &&
				AbuseFilter::filterHidden( $filter ) ) {
			$out->addWikiMsg( 'abusefilter-history-error-hidden' );
			return;
		}

		# Useful links
		$sk = $this->getSkin();
		$links = array();
		if ( $filter ) {
			$links['abusefilter-history-backedit'] = $this->getTitle( $filter );
		}

		foreach ( $links as $msg => $title ) {
			$links[$msg] = $sk->link( $title, wfMsgExt( $msg, 'parseinline' ) );
		}

		$backlinks = $this->getLanguage()->pipeList( $links );
		$out->addHTML( Xml::tags( 'p', null, $backlinks ) );

		# For user
		$user = $this->getRequest()->getText( 'user' );
		if ( $user ) {
			$out->setSubtitle(
				wfMsg(
					'abusefilter-history-foruser',
					$sk->userLink( 1 /* We don't really need to get a user ID */, $user ),
					$user // For GENDER
				)
			);
		}

		// Add filtering of changes et al.
		$fields['abusefilter-history-select-user'] = Xml::input( 'user', 45, $user );

		$filterForm = Xml::buildForm( $fields, 'abusefilter-history-select-submit' );
		$filterForm .= "\n" . Html::hidden( 'title', $this->getTitle( "history/$filter" ) );
		$filterForm = Xml::tags( 'form',
			array(
				'action' => $this->getTitle( "history/$filter" )->getLocalURL(),
				'method' => 'get'
			),
			$filterForm
		);
		$filterForm = Xml::fieldset( wfMsg( 'abusefilter-history-select-legend' ), $filterForm );
		$out->addHTML( $filterForm );

		$userId = User::idFromName( $user );

		$pager = new AbuseFilterHistoryPager( $filter, $this, $userId );
		$table = $pager->getBody();

		$out->addHTML( $pager->getNavigationBar() . $table . $pager->getNavigationBar() );
	}
}

class AbuseFilterHistoryPager extends TablePager {

	/**
	 * @param $filter
	 * @param $page Article
	 * @param $user User
	 */
	function __construct( $filter, $page, $userId ) {
		$this->mFilter = $filter;
		$this->mPage = $page;
		$this->mUserId = $userId;
		$this->mDefaultDirection = true;
		parent::__construct( $this->mPage->getContext() );
	}

	function getFieldNames() {
		static $headers = null;

		if ( !empty( $headers ) ) {
			return $headers;
		}

		$headers = array(
			'afh_timestamp' => 'abusefilter-history-timestamp',
			'afh_user_text' => 'abusefilter-history-user',
			'afh_public_comments' => 'abusefilter-history-public',
			'afh_flags' => 'abusefilter-history-flags',
			'afh_actions' => 'abusefilter-history-actions',
			'afh_id' => 'abusefilter-history-diff'
		);

		if ( !$this->mFilter ) {
			// awful hack
			$headers = array( 'afh_filter' => 'abusefilter-history-filterid' ) + $headers;
			unset( $headers['afh_comments'] );
		}

		$headers = array_map( 'wfMsg', $headers );

		return $headers;
	}

	function formatValue( $name, $value ) {
		$sk = $this->getSkin();
		$lang = $this->getLanguage();

		$row = $this->mCurrentRow;

		switch( $name ) {
			case 'afh_filter':
				$formatted = $lang->formatNum ( $row->afh_filter );
				break;
			case 'afh_timestamp':
				$title = SpecialPage::getTitleFor( 'AbuseFilter',
					'history/' . $row->afh_filter . '/item/' . $row->afh_id );
				$formatted = $sk->link( $title, $lang->timeanddate( $row->afh_timestamp, true ) );
				break;
			case 'afh_user_text':
				$userName = User::getUsername( $row->afh_user, $row->afh_user_text );
				$formatted =
					$sk->userLink( $row->afh_user, $userName ) . ' ' .
					$sk->userToolLinks( $row->afh_user, $userName );
				break;
			case 'afh_public_comments':
				$formatted = $this->getOutput()->parse( $value );
				break;
			case 'afh_flags':
				$formatted = AbuseFilter::formatFlags( $value );
				break;
			case 'afh_actions':
				$actions = unserialize( $value );

				$display_actions = '';

				foreach ( $actions as $action => $parameters ) {
					$displayAction = AbuseFilter::formatAction( $action, $parameters );
					$display_actions .= Xml::tags( 'li', null, $displayAction );
				}
				$display_actions = Xml::tags( 'ul', null, $display_actions );

				$formatted = $display_actions;
				break;
			case 'afh_filter':
				$title = $this->mPage->getTitle( strval( $value ) );
				$formatted = $sk->link( $title, $value );
				break;
			case 'afh_id':
				$title = $this->mPage->getTitle(
							'history/' . $row->afh_filter . "/diff/prev/$value" );
				$formatted = $sk->link( $title, wfMsgExt( 'abusefilter-history-diff', 'parseinline' ) );
				break;
			default:
				$formatted = "Unable to format $name";
				break;
		}

		$mappings = array_flip( AbuseFilter::$history_mappings ) +
			array( 'afh_actions' => 'actions', 'afh_id' => 'id' );
		$changed = explode( ',', $row->afh_changed_fields );

		$fieldChanged = false;
		if ( $name == 'afh_flags' ) {
			// This is a bit freaky, but it works.
			// Basically, returns true if any of those filters are in the $changed array.
			$filters = array( 'af_enabled', 'af_hidden', 'af_deleted', 'af_global' );
			if ( count( array_diff( $filters, $changed ) ) < count( $filters ) ) {
				$fieldChanged = true;
			}
		} elseif ( in_array( $mappings[$name], $changed ) ) {
			$fieldChanged = true;
		}

		if ( $fieldChanged ) {
			$formatted = Xml::tags( 'div',
				array( 'class' => 'mw-abusefilter-history-changed' ),
				$formatted
			);
		}

		return $formatted;
	}

	function getQueryInfo() {
		$info = array(
			'tables' => array( 'abuse_filter_history', 'abuse_filter' ),
			'fields' => array(
				'afh_filter',
				'afh_timestamp',
				'afh_user_text',
				'afh_public_comments',
				'afh_flags',
				'afh_comments',
				'afh_actions',
				'afh_id',
				'afh_user',
				'afh_changed_fields',
				'afh_pattern',
				'afh_id',
				'af_hidden'
			),
			'conds' => array(),
			'join_conds' => array(
					'abuse_filter' =>
						array(
							'LEFT JOIN',
							'afh_filter=af_id',
						),
				),
		);

		if ( $this->mUserId ) {
			$info['conds']['afh_user'] = $this->mUserId;
		}

		if ( $this->mFilter ) {
			$info['conds']['afh_filter'] = $this->mFilter;
		}

		if ( !$this->getUser()->isAllowed( 'abusefilter-modify' ) ) {
			// Hide data the user can't see.
			$info['conds']['af_hidden'] = 0;
		}

		return $info;
	}

	function getIndexField() {
		return 'afh_timestamp';
	}

	function getDefaultSort() {
		return 'afh_timestamp';
	}

	function isFieldSortable( $name ) {
		$sortable_fields = array( 'afh_timestamp' );
		return in_array( $name, $sortable_fields );
	}

	/**
	 * Title used for self-links. Override this if you want to be able to
	 * use a title other than $wgTitle
	 *
	 * @return Title
	 */
	function getTitle() {
		return $this->mPage->getTitle( 'history/' . $this->mFilter );
	}
}
