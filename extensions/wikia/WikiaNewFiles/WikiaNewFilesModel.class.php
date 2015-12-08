<?php

class WikiaNewFilesModel extends WikiaModel {
	/**
	 * @var Database
	 */
	private $dbr;

	/**
	 * @var string
	 */
	private $hideBotsSql = '';

	/**
	 * @param bool $hideBots Whether to hide images uploaded by bots or not
	 */
	public function __construct( $hideBots ) {
		$this->dbr = wfGetDB( DB_SLAVE );
		if ( $hideBots ) {
			$this->hideBots();
		}
	}

	/**
	 * Get SQL fragment (a LEFT JOIN) for filtering images to those not uploaded by bots
	 *
	 * This LEFT JOIN, in conjunction with "WHERE ug_group IS NULL", returns
	 * only those rows from IMAGE where the uploading user is not a member of
	 * a group which has the 'bot' permission set.
	 *
	 * @return string the SQL fragment to include (may be empty if there are no bot groups)
	 */
	private function hideBots() {
		# Make a list of group names which have the 'bot' flag set.
		$botconds = array();
		foreach ( User::getGroupsWithPermission( 'bot' ) as $groupname ) {
			$botconds[] = 'ug_group = ' . $this->dbr->addQuotes( $groupname );
		}

		if ( $botconds ) {
			$isbotmember = $this->dbr->makeList( $botconds, LIST_OR );

			$ug = $this->dbr->tableName( 'user_groups' );
			$this->hideBotsSql = " LEFT JOIN $ug ON img_user=ug_user AND ($isbotmember)";
		}
	}

	/**
	 * Query the database to find out what is the timestamp of the newest image uploaded
	 *
	 * @return string the timestamp of the newest image in MediaWiki format (YmdHis)
	 */
	public function getLatestTS() {
		$image = $this->dbr->tableName( 'image' );

		$sql = "SELECT img_timestamp from $image";
		if ( $this->hideBotsSql ) {
			$sql .= $this->hideBotsSql . ' WHERE ug_group IS NULL';
		}
		$sql .= ' ORDER BY img_timestamp DESC LIMIT 1';
		$res = $this->dbr->query( $sql, __FUNCTION__ );
		$row = $this->dbr->fetchRow( $res );
		if ( $row !== false ) {
			$ts = $row[0];
		} else {
			$ts = false;
		}
		$this->dbr->freeResult( $res );

		return wfTimestamp( TS_MW, $ts );
	}

	/**
	 * Get the images (limit + 1) from the database
	 *
	 * TODO: extract until and from to params
	 *
	 * @param string $from only show images newer than this
	 * @param string $until only show images older than this
	 * @param int $limit how many images to fetch
	 * @param Title $nt Title object for the image search query
	 *
	 * @return array the fetched images as array
	 */
	public function getImages( $from, $until, $limit ) {
		$image = $this->dbr->tableName( 'image' );

		$where = array();

		$invertSort = false;
		if ( $until ) {
			$where[] = "img_timestamp < '" . $this->dbr->timestamp( $until ) . "'";
		}
		if ( $from ) {
			$where[] = "img_timestamp >= '" . $this->dbr->timestamp( $from ) . "'";
			$invertSort = true;
		}
		$sql = 'SELECT img_size, img_name, img_user, img_user_text,' .
			"img_description,img_timestamp FROM $image";

		if ( $this->hideBotsSql ) {
			$sql .= $this->hideBotsSql;
			$where[] = 'ug_group IS NULL';
		}

		// hook by Wikia, Bartek Lapinski 26.03.2009, for videos and stuff
		wfRunHooks( 'SpecialNewImages::beforeQuery', array( &$where ) );

		if ( count( $where ) ) {
			$sql .= ' WHERE ' . $this->dbr->makeList( $where, LIST_AND );
		}
		$sql .= ' ORDER BY img_timestamp ' . ( $invertSort ? '' : ' DESC' );
		$sql .= ' LIMIT ' . ( $limit + 1 );

		$res = $this->dbr->query( $sql, __FUNCTION__ );

		/**
		 * We have to flip things around to get the last N after a certain date
		 */
		$images = array();
		while ( $s = $this->dbr->fetchObject( $res ) ) {
			if ( $invertSort ) {
				array_unshift( $images, $s );
			} else {
				array_push( $images, $s );
			}
		}
		$this->dbr->freeResult( $res );

		return $images;
	}
}
