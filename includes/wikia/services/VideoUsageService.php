<?php
class VideoUsageService extends Service {
	const videoWikiDBName = 'video151';
	const maxResults = 1000;  // Limit results to an arbitrary but large number

	static public function titlesByWiki ( $videoName ) {
		$dbr = wfGetDB( DB_SLAVE, array(), self::videoWikiDBName );

		$res = $dbr->select(
				array( 'globalimagelinks' ),
				array( 'gil_wiki as dbName', 'gil_page as pageID' ),
				array( 'gil_to' => $videoName ),
				__METHOD__,
				array( 'limit '.self::maxResults )
		);

$handle = fopen("/tmp/debug.out", 'a');
fwrite($handle, 'RES: '. print_r($res, true));
fclose($handle);

		$info = array();
		foreach ( $res as $row ) {
			$wikiId = WikiFactory::DBtoID($row->dbName);
			$title = GlobalTitle::newFromId($row->pageID, $wikiId);
$handle = fopen("/tmp/debug.out", 'a');
fwrite($handle, "DBNAME = ".$row->dbName." PAGEID = ".$row->pageID);
fclose($handle);
			$info[$wikiId][] = $title;
		}

		return count($info) ? $info : null;
	}

	static public function summaryInfoByWiki ( $videoName ) {
		$info = self::titlesByWiki( $videoName );

		if (empty($info)) {
			return null;
		}

		$summary = array();

$handle = fopen("/tmp/debug.out", 'a');
fwrite($handle, "\n\nINFO: ". print_r($info, true));
fclose($handle);

		# Iterate through each wiki ID
		foreach ($info as $wikiID => $titleObjs) {

			# Iterate through each title per wiki ID
			foreach ($titleObjs as $title) {
				$service = new ArticleService( $title->getArticleId() );
				$snippet = $service->getTextSnippet();

				$dbName = WikiFactory::IDtoDB($wikiID);
				$wikiUrl = 'http://'.WikiFactory::DBtoDomain($dbName);
				$imageURL = self::articleImage($dbName, $title->getArticleID());

				$summary[$wikiID][] = array(
					'titleDBkey' => $title->getPrefixedDBkey(),
					'title'      => $title,
					'titleText'  => $title->getFullText(),
					'articleId'  => $title->getArticleID(),
					'imageUrl'   => $imageURL,
					'url'        => $title->getFullURL(),
					'wiki'       => $this->wg->Sitename,
					'wikiUrl'    => $wikiUrl,
					'snippet'    => $snippet,
				);
			}
		}

		return $summary;
	}

	static private function articleImage ( $dbName, $pageID ) {
		$db = wfGetDB( DB_SLAVE, array(), $dbName);
		$imageServing = new ImageServing( array($pageID), 200, array( 'w' => 2, 'h' => 1 ), $db );
		$images = $imageServing->getImages(1); // get just one image per article

		if ( isset( $images[$pageID] ) ) {
			$image = $images[$pageID][0];
			return $image['url'];
		}
		return null;
	}
}