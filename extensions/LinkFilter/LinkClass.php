<?php
/**
 * Link class
 * Functions for managing Link pages.
 */
class Link {

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {
	}

	static $link_types = array(
		1 => 'Arrest Report',
		2 => 'Awesome',
		3 => 'Cool',
		4 => 'Funny',
		6 => 'Interesting',
		7 => 'Obvious',
		8 => 'OMG WTF?!?',
		9 => 'Rumor',
		10 => 'Scary',
		11 => 'Stupid'
	);

	public static function getSubmitLinkURL() {
		$title = SpecialPage::getTitleFor( 'LinkSubmit' );
		return $title->escapeFullURL();
	}

	public static function getLinkAdminURL() {
		$title = SpecialPage::getTitleFor( 'LinkApprove' );
		return $title->escapeFullURL();
	}

	public static function getHomeLinkURL() {
		$title = SpecialPage::getTitleFor( 'LinksHome' );
		return $title->escapeFullURL();
	}

	/**
	 * Checks if user is allowed to access LinkFilter's special pages
	 *
	 * @return Boolean: true if s/he has linkadmin permission or is in the
	 *                  linkadmin user group, else false
	 */
	public static function canAdmin() {
		global $wgUser;

		if(
			$wgUser->isAllowed( 'linkadmin' ) ||
			in_array( 'linkadmin', $wgUser->getGroups() )
		)
		{
			return true;
		}

		return false;
	}

	/**
	 * Checks if $code is an URL.
	 *
	 * @return Boolean: true if it's an URL, otherwise false
	 */
	public static function isURL( $code ) {
		return preg_match( '%^(?:http|https|ftp)://(?:www\.)?.*$%i', $code ) ? true : false;
	}

	/**
	 * Adds a link to the database table.
	 *
	 * @param $title String: link title as supplied by the user
	 * @param $desc String: link description as supplied by the user
	 * @param $url String: the actual URL
	 * @param $type Integer: link type, either from the global variable or from
	 *						this class' static array.
	 */
	public function addLink( $title, $desc, $url, $type ) {
		global $wgUser;

		$dbw = wfGetDB( DB_MASTER );

		wfSuppressWarnings();
		$date = date( 'Y-m-d H:i:s' );
		wfRestoreWarnings();

		$dbw->insert(
			'link',
			array(
				'link_name' => $title,
				'link_page_id' => 0,
				'link_url' => $url,
				'link_description' => $desc,
				'link_type' => intval( $type ),
				'link_status' => 0,
				'link_submitter_user_id' => $wgUser->getID(),
				'link_submitter_user_name' => $wgUser->getName(),
				'link_submit_date' => $date
			),
			__METHOD__
		);

		// If SocialProfile extension is installed, increase social statistics.
		if( class_exists( 'UserStatsTrack' ) ) {
			$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
			$stats->incStatField( 'links_submitted' );
		}
	}

	public function approveLink( $id ) {
		$link = $this->getLink( $id );

		// Create the wiki page for the newly-approved link
		$linkTitle = Title::makeTitleSafe( NS_LINK, $link['title'] );
		$article = new Article( $linkTitle );
		$article->doEdit( $link['url'], wfMsgForContent( 'linkfilter-edit-summary' ) );
		$newPageId = $article->getID();

		// Tie link record to wiki page
		$dbw = wfGetDB( DB_MASTER );

		wfSuppressWarnings();
		$date = date( 'Y-m-d H:i:s' );
		wfRestoreWarnings();

		$dbw->update(
			'link',
			/* SET */array(
				'link_page_id' => intval( $newPageId ),
				'link_approved_date' => $date
			),
			/* WHERE */array( 'link_id' => intval( $id ) ),
			__METHOD__
		);
		$dbw->commit();

		if( class_exists( 'UserStatsTrack' ) ) {
			$stats = new UserStatsTrack( $link['user_id'], $link['user_name'] );
			$stats->incStatField( 'links_approved' );
		}
	}

	/**
	 * Gets a link entry by given page ID.
	 *
	 * @param $pageId Integer: page ID number
	 * @return array
	 */
	public function getLinkByPageID( $pageId ) {
		global $wgOut;

		if( !is_numeric( $pageId ) ) {
			return '';
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'link',
			array(
				'link_id', 'link_name', 'link_url', 'link_description',
				'link_type', 'link_status', 'link_page_id',
				'link_submitter_user_id', 'link_submitter_user_name'
			),
			array( "link_page_id = $pageId" ),
			__METHOD__,
			array(
				'OFFSET' => 0,
				'LIMIT' => 1
			)
		);

		$row = $dbr->fetchObject( $res );

		$link = array();
		if( $row ) {
			$link['id'] = $row->link_id;
			$link['title'] = $row->link_name;
			$link['url'] = $row->link_url;
			$link['type'] = $row->link_type;
			$link['description'] = $wgOut->parse( $row->link_description, false );
			$link['type_name'] = self::getLinkType( $row->link_type );
			$link['status'] = $row->link_status;
			$link['page_id'] = $row->link_page_id;
			$link['user_id'] = $row->link_submitter_user_id;
			$link['user_name'] = $row->link_submitter_user_name;
		}

		return $link;
	}

	static function getLinkTypes() {
		global $wgLinkFilterTypes;

		if( is_array( $wgLinkFilterTypes ) ) {
			return $wgLinkFilterTypes;
		} else {
			return self::$link_types;
		}
	}

	/**
	 * @param $index Integer: numerical index representing the link filter type
	 * @return String: link type name or nothing
	 */
	static function getLinkType( $index ) {
		global $wgLinkFilterTypes;

		if(
			is_array( $wgLinkFilterTypes ) &&
			!empty( $wgLinkFilterTypes[$index] )
		)
		{
			return $wgLinkFilterTypes[$index];
		} elseif( isset( self::$link_types[$index] ) ) {
			return self::$link_types[$index];
		} else {
			return '';
		}
	}

	/**
	 * Gets a link entry by given link ID number.
	 * @param $id Integer: link ID number
	 * @return array
	 */
	public function getLink( $id ) {
		global $wgOut;

		if( !is_numeric( $id ) ) {
			return '';
		}

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'link',
			array(
				'link_id', 'link_name', 'link_url', 'link_description',
				'link_type', 'link_status', 'link_page_id',
				'link_submitter_user_id', 'link_submitter_user_name'
			),
			array( "link_id = $id" ),
			__METHOD__,
			array(
				'OFFSET' => 0,
				'LIMIT' => 1
			)
		);

		$row = $dbr->fetchObject( $res );
		$link = array();
		if( $row ) {
			$link['id'] = $row->link_id;
			$link['title'] = $row->link_name;
			$link['url'] = $row->link_url;
			$link['description'] = $wgOut->parse( $row->link_description, false );
			$link['type'] = $row->link_type;
			$link['type_name'] = self::getLinkType( $row->link_type );
			$link['status'] = $row->link_status;
			$link['page_id'] = $row->link_page_id;
			$link['user_id'] = $row->link_submitter_user_id;
			$link['user_name'] = $row->link_submitter_user_name;
		}

		return $link;
	}
}

class LinkList {

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {
	}

	/**
	 * @param $status Integer: link status
	 * @param $type Integer: link type (one of Link::$link_types integers)
	 * @param $limit Integer: LIMIT for SQL query, 0 by default.
	 * @param $page Integer: used to build the OFFSET in the SQL query.
	 * @param $order String: ORDER BY clause for SQL query.
	 */
	public function getLinkList( $status, $type, $limit = 0, $page = 0, $order = 'link_submit_date' ) {
		$dbr = wfGetDB( DB_SLAVE );

		$params['ORDER BY'] = "$order DESC";
		if( $limit ) {
			$params['LIMIT'] = $limit;
		}
		if( $page ) {
			$params['OFFSET'] = $page * $limit - ( $limit );
		}

		if( $type > 0 ) {
			$where['link_type'] = $type;
		}
		if( is_numeric( $status ) ) {
			$where['link_status'] = $status;
		}

		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			array( 'link' ),
			array(
				'link_id', 'link_page_id', 'link_type', 'link_status',
				'link_name', 'link_description', 'link_url',
				'link_submitter_user_id', 'link_submitter_user_name',
				'link_submit_date', 'UNIX_TIMESTAMP(link_submit_date) AS submit_timestamp',
				'UNIX_TIMESTAMP(link_approved_date) AS approved_timestamp',
				'link_comment_count'
			),
			$where,
			__METHOD__,
			$params
		);

		$links = array();

		foreach( $res as $row ) {
			$linkPage = Title::makeTitleSafe( NS_LINK, $row->link_name );
			$links[] = array(
				'id' => $row->link_id,
				'timestamp' => ( $row->submit_timestamp ),
				'approved_timestamp' => ( $row->approved_timestamp ),
				'url' => $row->link_url,
				'title' => $row->link_name,
				'description' => ( $row->link_description ),
				'page_id' => $row->link_page_id,
				'type' => $row->link_type,
				'status' => $row->link_status,
				'type_name' => Link::getLinkType( $row->link_type ),
				'user_id' => $row->link_submitter_user_id,
				'user_name' => $row->link_submitter_user_name,
				'wiki_page' => ( ( $linkPage ) ? $linkPage->escapeFullURL() : null ),
				'comments' => ( ( $row->link_comment_count ) ? $row->link_comment_count : 0 )
			);
		}

		return $links;
	}

	/**
	 * Get the number of links matching the given criteria.
	 *
	 * @param $status Integer: link status
	 * @param $type Integer: link type (one of Link::$link_types integers)
	 * @return Integer: number of links matching the given criteria
	 */
	public function getLinkListCount( $status, $type ) {
		$dbr = wfGetDB( DB_SLAVE );

		$where = array();
		if( $type > 0 ) {
			$where['link_type'] = $type;
		}
		if( is_numeric( $status ) ) {
			$where['link_status'] = $status;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'link',
			array( 'COUNT(*) AS count' ),
			$where,
			__METHOD__
		);

		return $s->count;
	}

}