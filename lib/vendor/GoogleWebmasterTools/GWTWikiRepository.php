<?php

class GWTWikiRepository {
	/**
	 * @var DatabaseMysql|null
	 */
	private $databaseConnection;

	function __construct( $databaseConnection = null ) {
		if ( $databaseConnection == null ) {
			global $wgExternalSharedDB;
			$app = F::app();
			$databaseConnection = wfgetDB( DB_MASTER, array(), $wgExternalSharedDB);
		}
		$this->databaseConnection = $databaseConnection;
	}

	/**
	 * @param $resultObject
	 * @return GWTWiki
	 */
	private function materialize( $resultObject ) {
		return new GWTWiki( $resultObject->wiki_id, $resultObject->user_id, $resultObject->upload_date, $resultObject->page_count );
	}

	/**
	 * @param ResultWrapper $queryResult
	 * @return array
	 */
	private function materializeList( $queryResult ) {
		$list = array();
		while ( $obj = $queryResult->fetchObject() ) {
			$list[] = $this->materialize($obj);
		}
		return $list;
	}

	/**
	 * @return GWTWiki[]
	 */
	public function allUnassigned() {
		$result = $this->databaseConnection->select("webmaster_sitemaps"
			, array("user_id", "wiki_id", "upload_date", "page_count")
			, array("upload_date" => null )
			, __METHOD__
			, [ "ORDER BY" => "page_count DESC" ]);
		return $this->materializeList($result);
	}

	/**
	 * Get all unassigned wikis with page_count larger than $minPageCount
	 * @param $minPageCount
	 * @return GWTWiki[]
	 */
	public function allUnassignedGt( $minPageCount ) {
		$result = $this->databaseConnection->select("webmaster_sitemaps"
			, ["user_id", "wiki_id", "upload_date", "page_count"]
			, ["upload_date" => null, "page_count > " . intval($minPageCount) ]
			, __METHOD__
			, [ "ORDER BY" => "page_count DESC" ]);
		return $this->materializeList($result);
	}

	/**
	 * @param integer $wikiId
	 * @return GWTWiki[]
	 */
	public function allByWikiId( $wikiId ) {
		$result = $this->databaseConnection->select("webmaster_sitemaps"
			, array("user_id", "wiki_id", "upload_date", "page_count")
			, array("wiki_id" => $wikiId));
		return $this->materializeList($result);
	}

	/**
	 * @param integer $wikiId
	 * @throws GWTException
	 * @return GWTWiki
	 */
	public function getById( $wikiId ) {
		$wikis = $this->allByWikiId( $wikiId );
		if( count( $wikis ) == 0 ) { return null; }
		if( count( $wikis ) == 1 ) { return $wikis[0]; }
		throw new GWTException("Fetched wrong number of wikis (id=".$wikiId."). Expected 0 or 1, was " . (int) count($wikis));
	}

	/**
	 * @param $wikiId
	 * @throws GWTException
	 */
	public function deleteAllByWikiId( $wikiId ) {
		$result = $this->databaseConnection->delete("webmaster_sitemaps"
			, array("wiki_id" => $wikiId));
		if( !$result ) throw new GWTException("Cannot delete sitemap by id ( id = " . $wikiId . " ) ");
	}

	/**
	 * @param int $wikiId
	 * @return bool
	 */
	public function exists( $wikiId ) {
		$res = $this->databaseConnection->select("webmaster_sitemaps",
			array('wiki_id'),
			array(
				"wiki_id" => $wikiId,
			),
			__METHOD__
		);
		if ( $res->fetchRow() ) return false;
		return true;
	}

	/**
	 * @param $wikiId
	 * @param int $userId
	 * @param null $uploadDate
	 * @param null $pageCount
	 * @return GWTWiki
	 */
	public function create( $wikiId, $userId = 0, $uploadDate = null, $pageCount = null  ) {
		return $this->insert( $wikiId, $userId, $uploadDate, $pageCount );
	}

	/**
	 * @param $wikiId
	 * @param int $userId
	 * @param null|string $uploadDate
	 * @param null|int $pageCount
	 * @return GWTWiki
	 * @throws GWTException
	 */
	public function insert( $wikiId, $userId = 0, $uploadDate = null, $pageCount = null ) {
		if ( ! $this->databaseConnection->insert("webmaster_sitemaps", array(
			"wiki_id" => $wikiId,
			"user_id" => $userId,
			"upload_date" => $uploadDate,
			"page_count"  => $pageCount,
		))) {
			throw new GWTException("can't insert wiki id = " . $wikiId);
		}
		return new GWTWiki( $wikiId, $userId, $uploadDate, $pageCount);
	}

	/**
	 * @param GWTWiki $gwtWikiObject
	 * @throws GWTException
	 */
	public function updateWiki( GWTWiki $gwtWikiObject ) {
		$userId = $gwtWikiObject->getUserId();
		$res = $this->databaseConnection->update("webmaster_sitemaps",
			array(
				"user_id" => $userId,
				"upload_date" => $gwtWikiObject->getUploadDate(),
				"page_count" => $gwtWikiObject->getPageCount(),
			),
			array(
				"wiki_id" => $gwtWikiObject->getWikiId(),
			));
		if( !$res ) throw new GWTException("Failed to update " . $gwtWikiObject->getUserId() . " " . $gwtWikiObject->getWikiId());
	}
}
