<?php

/**
 * The entry page for SecurePoll. Shows a list of elections.
 */
class SecurePoll_EntryPage extends SecurePoll_Page {
	/**
	 * Execute the subpage.
	 * @param $params array Array of subpage parameters.
	 */
	function execute( $params ) {
		global $wgOut;
		$pager = new SecurePoll_ElectionPager( $this );
		$wgOut->addWikiMsg( 'securepoll-entry-text' );
		$wgOut->addHTML(
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}

	/**
	 * @return Title
	 */
	function getTitle() {
		return $this->parent->getTitle( 'entry' );
	}
}

/**
 * Pager for an election list. See TablePager documentation.
 */
class SecurePoll_ElectionPager extends TablePager {
	var $subpages = array(
		'vote' => array(
			'public' => true,
			'visible-after-close' => false,
		),
		'translate' => array(
			'public' => true,
			'visible-after-close' => true,
		),
		'list' => array(
			'public' => true,
			'visible-after-close' => true,
		),
		'dump' => array(
			'public' => false,
			'visible-after-close' => true,
		),
		'tally' => array(
			'public' => false,
			'visible-after-close' => true,
		),
	);
	var $fields = array(
		'el_title',
		'el_start_date',
		'el_end_date',
		'links'
	);
	var $entryPage;

	function __construct( $parent ) {
		$this->entryPage = $parent;
		parent::__construct();
	}

	function getQueryInfo() {
		return array(
			'tables' => 'securepoll_elections',
			'fields' => '*',
			'conds' => false,
			'options' => array()
		);
	}

	function isFieldSortable( $field ) {
		return in_array( $field, array(
			'el_title', 'el_start_date', 'el_end_date'
		) );
	}

	/**
	 * Add classes based on whether the poll is open or closed
	 * @param $row database object
	 * @return String
	 * @see TablePager::getRowClass()
	 */
	function getRowClass( $row ) {
		return $row->el_end_date > wfTimestampNow( TS_DB )
			? 'securepoll-election-open'
			: 'securepoll-election-closed';
	}

	function formatValue( $name, $value ) {
		global $wgLang;
		switch ( $name ) {
		case 'el_start_date':
		case 'el_end_date':
			return $wgLang->timeanddate( $value );
		case 'links':
			return $this->getLinks();
		default:
			return htmlspecialchars( $value );
		}
	}

	function formatRow( $row ) {
		global $wgUser;
		$id = $row->el_entity;
		$this->election = $this->entryPage->context->getElection( $id );
		if( !$this->election ) {
			$this->isAdmin = false;
		} else {
			$this->isAdmin = $this->election->isAdmin( $wgUser );
		}
		return parent::formatRow( $row );
	}

	function getLinks() {
		global $wgUser;
		$id = $this->mCurrentRow->el_entity;

		$s = '';
		$sep = wfMsg( 'pipe-separator' );
		$skin = $wgUser->getSkin();
		foreach ( $this->subpages as $subpage => $props ) {
			// Message keys used here:
			// securepoll-subpage-vote, securepoll-subpage-translate,
			// securepoll-subpage-list, securepoll-subpage-dump,
			// securepoll-subpage-tally

			$linkText = wfMsgExt( "securepoll-subpage-$subpage", 'parseinline' );
			if ( $s !== '' ) {
				$s .= $sep;
			}
			if( ( $this->isAdmin || $props['public'] )
			    && ( !$this->election->isFinished() || $props['visible-after-close'] ) )
			{
				$title = $this->entryPage->parent->getTitle( "$subpage/$id" );
				$s .= $skin->makeKnownLinkObj( $title, $linkText );
			} else {
				$s .= "<span class=\"securepoll-link-disabled\">" .
					$linkText . "</span>";
			}
		}
		return $s;
	}

	function getDefaultSort() {
		return 'el_start_date';
	}

	function getFieldNames() {
		$names = array();
		foreach ( $this->fields as $field ) {
			if ( $field == 'links' ) {
				$names[$field] = '';
			} else {
				$msgName = 'securepoll-header-' .
					strtr( $field, array( 'el_' => '', '_' => '-' ) );
				$names[$field] = wfMsg( $msgName );
			}
		}
		return $names;
	}

	function getTitle() {
		return $this->entryPage->getTitle();
	}
}

