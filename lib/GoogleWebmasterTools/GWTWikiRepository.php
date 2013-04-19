<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 16:51
 */

class GWTWikiRepository {
	private $databaseConnection;

	function __construct( $databaseConnection = null )
	{
		if ( $databaseConnection == null ) {
			global $wgExternalSharedDB;
			$app = F::app();
			$databaseConnection = $app->wf->getDB( DB_MASTER, array(), $wgExternalSharedDB);
		}
		$this->databaseConnection = $databaseConnection;
	}

	private function materialize( $resultObject ) {
		return new GWTWiki( $resultObject->wiki_id, $resultObject->user_id, $resultObject->upload_date );
	}

	private function materializeList( $queryResult ) {
		$list = array();
		while ( $obj = $queryResult->fetchObject() ) {
			$list[] = $this->materialize($obj);
		}
		return $list;
	}

	public function all() {
		$result = $this->databaseConnection->select("webmaster_sitemaps", array("user_id", "wiki_id", "upload_date"));
		return $this->materializeList($result);
	}

	public function allUnassigned() {
		$result = $this->databaseConnection->select("webmaster_sitemaps"
			, array("user_id", "wiki_id", "upload_date")
			, array("upload_date" => null ) );
		return $this->materializeList($result);
	}

	public function allByWikiId( $wikiId ) {
		$result = $this->databaseConnection->select("webmaster_sitemaps"
			, array("user_id", "wiki_id", "upload_date")
			, array("wiki_id" => $wikiId));
		return $this->materializeList($result);
	}

	public function oneByWikiId( $wikiId ) {
		$wikis = $this->allByWikiId( $wikiId );
		if( count( $wikis ) == 1 ) return $wikis[0];
		throw new GWTException("Fetched wrong number of wikis (id=".$wikiId."). Expected 1, was " . count($wikis));
	}

	public function deleteAllByWikiId( $wikiId ) {
		$result = $this->databaseConnection->delete("webmaster_sitemaps"
			, array("wiki_id" => $wikiId));
		if( !$result ) throw new GWTException("Cannot delete sitemap by id ( id = " . $wikiId . " ) ");
	}

	public function exists( $wikiId ) {
		$wikiId = $this->wikiToId( $wikiId );
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

	public function create( $wikiId, $userId = 0, $uploadDate = null ) {
		return $this->insert( $wikiId, $userId, $uploadDate );
	}

	public function insert( $wikiId, $userId = null, $uploadDate = null ) {
		if ( ! $this->databaseConnection->insert("webmaster_sitemaps", array(
			"wiki_id" => $wikiId,
			"user_id" => $userId,
			"upload_date" => $uploadDate,
		))) {
			throw new Exception("can't insert wiki id = " . $wikiId);
		}
		return new GWTWiki( $wikiId, $userId, $uploadDate);
	}

	public function updateWiki( $gwtWikiObject ) {
		$res = $this->databaseConnection->update("webmaster_sitemaps",
			array(
				"user_id" => $gwtWikiObject->getUserId(),
				"upload_date" => $gwtWikiObject->getUploadDate(),
			),
			array(
				"wiki_id" => $gwtWikiObject->getWikiId(),
			));
		if( !$res ) throw new GWTException("Failed to update " . $gwtWikiObject->getUserId() . " " . $gwtWikiObject->getWikiId());
	}

	private function wikiToId( $wikiId ) {
		if( is_string( $wikiId ) ) {
			$wikiId = WikiFactory::UrlToID( $wikiId );
			if( $wikiId == null ) throw new Exception("Can't resolve " . $wikiId);
		}
		return $wikiId;
	}
}
