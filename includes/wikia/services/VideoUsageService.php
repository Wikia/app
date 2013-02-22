<?php
class VideoUsageService extends Service {
	const videoWikiDBName = 'video151';

	static public function searchByName ( $name ) {
		$dbr = wfGetDB( DB_SLAVE, array(), self::videoWikiDBName );

		$res = $dbr->select(
				array( 'globalimagelinks' ),
				array( 'gil_wiki as dbName', 'gil_page as pageID' ),
				array( 'gil_to' => $name ),
				__METHOD__
		);

		$info = array();
		foreach ( $res as $row ) {
			$wikiId = WikiFactory::DBtoID($row->dbName);
			$title = GlobalTitle::newFromId($row->pageID, $wikiId);
			$info[$wikiId][] = $title;
		}

		return $info;
	}
}