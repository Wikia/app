<?php
/**
 * Generates a list of changes for a collaborative watchlist. Builds on the EnhancedChangesList
 */
class CollabWatchlistChangesList extends EnhancedChangesList {
	protected $user;
	protected $tagCheckboxIndex = 0;

	/**
	 * Collaborative Watchlist contructor
	 * @param User $user
	 * @param Skin $skin
	 */
	public function __construct( $skin, $user ) {
		parent::__construct( $skin );
		$this->user = $user;
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/EnhancedChangesList#beginRecentChangesList()
	 */
	public function beginRecentChangesList() {
		global $wgRequest;
		$gwlSpeciaPageTitle = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$result = Xml::openElement( 'form', array(
			'class' => 'mw-collaborative-watchlist-addtag-form',
			'method' => 'post',
			'action' => $gwlSpeciaPageTitle->getLocalUrl( array( 'action' => 'setTags' ) ) ) );
		$result .= Xml::input( 'redirTarget', false, $wgRequest->getFullRequestURL(), array( 'type' => 'hidden' ) );
		$result .= parent::beginRecentChangesList();
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/EnhancedChangesList#endRecentChangesList()
	 */
	public function endRecentChangesList() {
		global $wgRequest;
		$collabWatchlist = $wgRequest->getIntOrNull( 'collabwatchlist' );
		$result = '';
		$result .= parent::endRecentChangesList();
		$glWlIdAndName = $this->getCollabWatchlistIdAndName( $this->user->getId() );
		$result .= $this->collabWatchlistAndTagSelectors( $glWlIdAndName, $collabWatchlist, null, 'collabwatchlist', wfMsg( 'collabwatchlist' ) ) . '&nbsp;';
		$result .= Xml::label( wfMsg( 'collabwatchlisttagcomment' ), 'tagcomment' ) . '&nbsp;' . Xml::input( 'tagcomment' ) . '&nbsp;';
		if ( $this->user->useRCPatrol() )
			$result .= Xml::checkLabel( wfMsg( 'collabwatchlistpatrol' ), 'setpatrolled', 'setpatrolled', true ) . '&nbsp;';
		$result .= Xml::submitButton( wfMsg( 'collabwatchlistsettagbutton' ) );
		$result .= Xml::closeElement( 'form' );
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/EnhancedChangesList#insertBeforeRCFlags($r, $rcObj)
	 */
	protected function insertBeforeRCFlags( &$r, &$rcObj ) {
		$r .= Xml::element( 'input', array(
			'name' => 'collaborative-watchlist-addtag-' . $this->tagCheckboxIndex,
			'type' => 'checkbox',
			'value' => ( $rcObj->getTitle() . '|' . $rcObj->getAttribute( 'rc_this_oldid' ) . '|' . $rcObj->getAttribute( 'rc_id' ) ) ) );
		$this->tagCheckboxIndex++;
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/EnhancedChangesList#insertBeforeRCFlagsBlock($r, $block)
	 */
	protected function insertBeforeRCFlagsBlock( &$r, &$block ) {
		$r .= Xml::element( 'input', array(
			'name' => 'collaborative-watchlist-addtag-placeholder',
			'type' => 'checkbox',
			'style' => 'visibility: hidden;' ) );
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/ChangesList#insertRollback($s, $rc)
	 */
	public function insertRollback( &$s, &$rc ) {
		global $wgUser;
		parent::insertRollback( $s, $rc );
		if ( !$rc->mAttribs['rc_new'] && $rc->mAttribs['rc_this_oldid'] && $rc->mAttribs['rc_cur_id'] ) {
			if ( $wgUser->isAllowed( 'edit' ) ) {
				$rev = new Revision( array(
						'id'        => $rc->mAttribs['rc_this_oldid'],
						'user'      => $rc->mAttribs['rc_user'],
						'user_text' => $rc->mAttribs['rc_user_text'],
						'deleted'   => $rc->mAttribs['rc_deleted']
				) );
				$undoAfter = $rev->getPrevious();
				$undoLink = $this->generateUndoLink( $this->skin, $rc->getTitle(), $rev, $undoAfter );
				if ( isset( $undoLink ) )
					$s .= '&nbsp;' . $undoLink;
			}
		}
	}

	/**
	 * Fetch an appropriate changes list class for the specified user
	 * Some users might want to use an enhanced list format, for instance
	 *
	 * @param $user User to fetch the list class for
	 * @return ChangesList derivative
	 */
	public static function newFromUser( &$user ) {
		$sk = $user->getSkin();
		$list = null;
		if ( wfRunHooks( 'FetchChangesList', array( &$user, &$sk, &$list ) ) ) {
			return new CollabWatchlistChangesList( $sk, $user );
		} else {
			return $list;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/ChangesList#insertTags($s, $rc, $classes)
	 */
	public function insertTags( &$s, &$rc, &$classes ) {
		if ( !empty( $rc->mAttribs['collabwatchlist_tags'] ) ) {
			list( $tagSummary, $newClasses ) = $this->formatReviewSummaryRow( $rc, 'changeslist' );
			$classes = array_merge( $classes, $newClasses );
			$s .= ' ' . $tagSummary;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/EnhancedChangesList#insertHistLink($s, $rc, $title, $params, $sep)
	 */
	protected function insertHistLink( &$s, &$rc, $title, $params = array(), $sep = null ) {
		// No history
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/EnhancedChangesList#insertCurrAndLastLinks($s, $rc)
	 */
	protected function insertCurrAndLastLinks( &$s, &$rc ) {
		$s .= ' (';
		$s .= $rc->curlink;
		$s .= ')';
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/EnhancedChangesList#insertUserAndTalkLinks($s, $rc)
	 */
	protected function insertUserAndTalkLinks( &$s, &$rc ) {
		$s .= $rc->userlink;
	}

	/**
	 * Insert the tags of the given change
	 */
	private function formatReviewSummaryRow( $rc, $page ) {
		global $wgRequest;
		$s = '';
		if ( !$rc )
			return $s;

		$attr = $rc->mAttribs;
		$tagRows = $attr['collabwatchlist_tags'];

		$classes = array();

		$displayTags = array();
		foreach ( $tagRows as $tagRow ) {
			$tag = $tagRow['ct_tag'];
			$collabwatchlistTag = Xml::tags(
				'span',
				array(	'class' => 'mw-collabwatchlist-tag-marker ' .
								Sanitizer::escapeClass( "mw-collabwatchlist-tag-marker-$tag" ),
						'title' => $tagRow['rrt_comment'] ),
				ChangeTags::tagDescription( $tag )
			);
			$classes[] = Sanitizer::escapeClass( "mw-collabwatchlist-tag-$tag" );

			/** Insert links to user page, user talk page and eventually a blocking link */
			$userLink = $this->skin->userLink( $tagRow['user_id'], $tagRow['user_name'] );
			$delTagTarget = CollabWatchlistEditor::getUnsetTagUrl( $wgRequest->getFullRequestURL(), $attr['rc_title'], $tagRow['cw_id'], $tag, $attr['rc_id'] );
			$delTagLink = Xml::element( 'a', array( 'href' => $delTagTarget, 'class' => 'mw-collabwatchlist-unsettag-' . $tag ), wfMsg( 'collabwatchlist-unset-tag' ) );
			$displayTags[] = $collabwatchlistTag . ' ' . $delTagLink . ' ' . $userLink;
		}
		$markers = '(' . implode( ', ', $displayTags ) . ')';
		$markers = Xml::tags( 'span', array( 'class' => 'mw-collabwatchlist-tag-markers' ), $markers );
		return array( $markers, $classes );
	}

	/** Generate a form 'select' element for the collaborative watchlists and a 'select' element for choosing a tag.
	 * The tag selector reacts on the watchlist selector and displays the relevant tags only, if javascript is enabled.
	 *
	 * @see #collabWatchlistSelector()
	 * @see #tagSelector()
	 * @param String $rlLabel The label for the collab watchlist select tag
	 * @param String $rlElementId The id for the collab watchlist select tag
	 * @param String $tagLabel The label for the tag selector
	 * @return A string containing HTML
	 */
	public static function collabWatchlistAndTagSelectors( $glWlIdAndName, $selected = '', $all = null, $element_name = 'collabwatchlist', $rlLabel = null, $rlElementId = 'collabwatchlist', $tagLabel = null ) {
		global $wgJsMimeType;
		$tagElementIdBase = 'mw-collaborative-watchlist-addtag-selector';
		$ret = self::collabWatchlistSelector( $glWlIdAndName, $selected, $all, $element_name, $rlLabel, $rlElementId, $tagElementIdBase );
		$ret .= '&nbsp;';
		$ret .= self::tagSelector( array_keys( $glWlIdAndName ), $tagLabel );
		// Make sure the correct tags for the default selection are set
		$ret .= Xml::element( 'script',
			array(
				'type' => $wgJsMimeType,
			),
			'window.onLoad = onCollabWatchlistSelection(\'' . $tagElementIdBase . '\', document.getElementById(\'' . $rlElementId . '\').value)', false
		);
		return $ret;
	}

	/**
	 * Build a drop-down box for selecting a collaborative watchlist
	 * This method optionally adds javascript for changing a tag selector
	 * depending on the selected review list.
	 *
	 * @param $glWlIdAndName Mixed: The result from getCollabWatchlistIdAndName()
	 * @param $selected Mixed: Reviewlist which should be pre-selected
	 * @param $all Mixed: Value of an item denoting all collaborative watchlists, or null to omit
	 * @param $element_name String: value of the "name" attribute of the select tag
	 * @param $label String: optional label to add to the field
	 * @param $element_id String: optional the id of the select element
	 * @param $tagElementIdBase String: optional the base id of the collabl watchlist tag selector for javascript functionality.
	 * @return string
	 */
	public static function collabWatchlistSelector( $glWlIdAndName, $selected = '', $all = null, $element_name = 'collabwatchlist', $label = null, $element_id = 'collabwatchlist', $tagElementIdBase = null ) {
		global $wgOut;
		$wgOut->addModules( 'ext.CollabWatchlist' );
		$ret = '';
		$options = array();

		// Godawful hack... we'll be frequently passed selected namespaces
		// as strings since PHP is such a shithole.
		// But we also don't want blanks and nulls and "all"s matching 0,
		// so let's convert *just* string ints to clean ints.
		if ( preg_match( '/^\d+$/', $selected ) ) {
			$selected = intval( $selected );
		}

		if ( !is_null( $all ) )
			$glWlIdAndName = array( $all => wfMsg( 'collabwatchlistsall' ) ) + $glWlIdAndName;
		foreach ( $glWlIdAndName as $index => $name ) {
			if ( $index < NS_MAIN )
				continue;
			if ( $index === 0 )
				$name = wfMsg( 'blankcollabwatchlist' );
			$options[] = Xml::option( $name, $index, $index === $selected, isset( $tagElementIdBase ) ?
				array( 'onclick' => 'onCollabWatchlistSelection("' . $tagElementIdBase . '", this.value)' ) :
				array()
			);
		}

		$selectorHtml = Xml::openElement( 'select', array(
			'id' => $element_id, 'name' => $element_name,
			'class' => 'collabwatchlistselector', ) )
			. "\n"
			. implode( "\n", $options )
			. "\n"
			. Xml::closeElement( 'select' );
		if ( !is_null( $label ) ) {
			$ret .= Xml::label( $label, $element_name ) . '&nbsp;' . $selectorHtml;
		} else {
			$ret .= $selectorHtml;
		}
		return $ret;
	}

	/**
	 * Build a drop-down box for selecting a collaborative watchlist tag
	 *
	 * @param array $rlIds A list of collaborative watchlist ids
	 * @param String $label The label for the select tag
	 * @param String $elemId The id of the select tag
	 * @return String A string containing HTML
	 */
	public static function tagSelector( $rlIds, $label = '', $elemId = 'mw-collaborative-watchlist-addtag-selector' ) {
		global $wgContLang;
		$tagsAndInfo = CollabWatchlistChangesList::getValidTagsAndInfo( $rlIds );
		$optionsAll = array();
		$options = array();
		foreach ( $tagsAndInfo as $tagName => $info ) {
			$optionsAll[] = Xml::option( $tagName . ' ' . $info['rt_description'], $tagName );
			foreach ( $info['cw_ids'] as $rlId ) {
				$options[$rlId][] = Xml::option( $tagName, $tagName );
			}
		}
		$ret = Xml::openElement( 'select', array(
			'id' => $elemId,
			'name' => 'collabwatchlisttag',
			'class' => 'mw-collaborative-watchlist-tag-selector' ) ) .
			implode( "\n", $optionsAll ) .
			Xml::closeElement( 'select' );
		if ( !is_null( $label ) ) {
			$ret = Xml::label( $label, $elemId ) . '&nbsp;' . $ret;
		}
		foreach ( $options as $rlId => $optionsRl ) {
			$ret .= Xml::openElement( 'select', array(
				'style' => 'display: none;',
				'id' => $elemId . '-' . $rlId,
				'name' => 'collabwatchlisttag-rl',
				'class' => 'mw-collaborative-watchlist-tag-selector' ) ) .
				implode( "\n", $optionsRl ) .
				Xml::closeElement( 'select' );
		}
		$ret .= Xml::openElement( 'select', array(
			'style' => 'display: none;',
			'id' => $elemId . '-empty',
			'name' => 'collabwatchlisttag-rl',
			'class' => 'mw-collaborative-watchlist-tag-selector' ) ) .
		Xml::closeElement( 'select' );

		return $ret;
	}

	/** Returns an array mapping from collab watchlist tag names to information about the tag
	 *
	 * The info is an array with the following keys:
	 * 'rt_description' The description of the tag
	 * 'cw_ids' An array of collab watchlist ids the tag belongs to
	 * @param array $rlIds A list of collab watchlist ids
	 * @return array Mapping from tag name to info
	 */
	public static function getValidTagsAndInfo( $rlIds ) {
		if ( !isset( $rlIds ) || empty( $rlIds ) ) {
			return array();
		}
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( array( 'collabwatchlisttag' ), # Tables
			array( 'rt_name', 'rt_description', 'cw_id' ), # Fields
			array( 'cw_id' => $rlIds ),  # Conditions
			__METHOD__
		);
		$list = array();
		foreach ( $res as $row ) {
			if ( array_key_exists( $row->rt_name, $list ) ) {
				$list[$row->rt_name]['cw_ids'][] = $row->cw_id;
			} else {
				$list[$row->rt_name] = array( 'rt_description' => $row->rt_description, 'cw_ids' => array( $row->cw_id ) );
			}
		}
		return $list;
	}

	// XXX Cache the result of this method in this class
	/** Get an array mapping from collab watchlist id to its name, filtering by member type
	 * The method return only collab watchlist the given user is a member of, restricted by the allowed member types
	 * @param int $user_id The id of the collab watchlist user
	 * @param array $member_types A list of allowed membership types
	 * @return array Mapping from collab watchlist id to its name
	 */
	public static function getCollabWatchlistIdAndName( $user_id, $member_types = NULL ) {
		global $wgDBprefix;
		if ( is_null($member_types) )
			$member_types = array( CollabWatchlist::$USER_OWNER, CollabWatchlist::$USER_USER );
		$dbr = wfGetDB( DB_SLAVE );
		$list = array();
		// $table, $vars, $conds='', $fname = 'Database::select', $options = array(), $join_conds = array()
		$res = $dbr->select( array( 'collabwatchlist', 'collabwatchlistuser' ), # Tables
			array( $wgDBprefix . 'collabwatchlist.cw_id', 'cw_name' ), # Fields
			array( 'rlu_type' => $member_types, $wgDBprefix . 'collabwatchlistuser.user_id' => $user_id ),  # Conditions
			__METHOD__, array(),
			 # Join conditions
			array(	'collabwatchlistuser' => array( 'JOIN', $wgDBprefix . 'collabwatchlist.cw_id = ' . $wgDBprefix . 'collabwatchlistuser.cw_id' ) )
		);
		foreach ( $res as $row ) {
			$list[$row->cw_id] = $row->cw_name;
		}
		return $list;
	}

	// XXX Copied from HistoryPage, we should patch HistoryPage to export that functionality
	// as a static function
	/**
	 * @param Skin $skin
	 * @param Title $title
	 * @param Revision $revision
	 * @param Revision $undoAfterRevision
	 * @return String Undo Link
	 */
	public static function generateUndoLink( $skin, $title, $revision, $undoAfterRevision ) {
		if ( ! $revision instanceof Revision || ! $undoAfterRevision instanceof Revision ||
			! $title instanceof Title || !$skin instanceof Skin )
			return null;
		# Create undo tooltip for the first (=latest) line only
		$undoTooltip = $revision->isCurrent()
			? array( 'title' => wfMsg( 'tooltip-undo' ) )
			: array();
		$undolink = $skin->link(
			$title,
			wfMsgHtml( 'editundo' ),
			$undoTooltip,
			array(
				'action' => 'edit',
				'undoafter' => $undoAfterRevision->getId(),
				'undo' => $revision->getId()
			),
			array( 'known', 'noclasses' )
		);
		return "<span class=\"mw-history-undo\">{$undolink}</span>";
	}
}
