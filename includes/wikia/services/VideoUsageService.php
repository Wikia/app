<?php
class VideoUsageService extends Service {
	const videoWikiDBName = 'video151';
	const maxResults = 1000;  // Limit results to an arbitrary but large number

	static public function titlesByWiki ( $name ) {
		$dbr = wfGetDB( DB_SLAVE, array(), self::videoWikiDBName );

		$res = $dbr->select(
				array( 'globalimagelinks' ),
				array( 'gil_wiki as dbName', 'gil_page as pageID' ),
				array( 'gil_to' => $name ),
				__METHOD__,
				array( 'limit '.self::maxResults )
		);

		$info = array();
		foreach ( $res as $row ) {
			$wikiId = WikiFactory::DBtoID($row->dbName);
			$title = GlobalTitle::newFromId($row->pageID, $wikiId);
			$info[$wikiId][] = $title;
		}

		return count($info) ? $info : null;
	}

	static public function summaryInfoByWiki ( $name ) {
		$info = self::titlesByWiki( $name );

		if (empty($info)) {
			return null;
		}

		# Iterate through each wiki ID
		foreach ($info as $wikiID) {
			# Iterate through each title per wiki ID
			foreach ($info[$wikiID] as $title) {
				# TBD
			}
		}
	}
}