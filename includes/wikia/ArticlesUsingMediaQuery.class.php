<?php
/*
 * ArticlesUsingMediaQuery returns an array of articles ( ns, title, url ) that are using File ( image or video )
 *
 */

class ArticlesUsingMediaQuery {
	/* @var Title */
	private $fileTitle;
	private $app;
	private $memc;

	const IMAGELINKS_LIMIT = 500;

	/*
	 * @param Title $fileTitle
	 */
	public function __construct($fileTitle) {
		$this->fileTitle = $fileTitle;
		$this->app = F::app();
		$this->memc = $this->app->wg->Memc;
	}

	/*
	 * @param bool $purgeCache - force the script to do the real DB query
	 * @return array article list ( ns, title, url )
	 */
	public function getArticleList($purgeCache = false) {
		wfProfileIn( __METHOD__ );

		if ( !$purgeCache ) {
			$data = $this->memc->get( $this->getMemcKey() );

			if ( is_array($data) ) {
				wfProfileOut(__METHOD__);
				return $data;
			}
		}

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			array( 'imagelinks', 'page' ),
			array( 'page_namespace', 'page_title' ),
			array( 'il_to' => $this->fileTitle->getDBKey(), 'il_from = page_id' ),
			__METHOD__,
			[
				'LIMIT' => self::IMAGELINKS_LIMIT, # BAC-265
				'ORDER BY' => 'page_namespace ASC'
			]
		);

		$data = array() ;
		while ( $s = $res->fetchObject() ) {
			$title = Title::makeTitle($s->page_namespace, $s->page_title);
			$data[] = array( 'ns' => $s->page_namespace,
			                 'title' => $s->page_title,
			                 'titleText' => $title->getPrefixedText(),
			                 'url' => $title->getLocalURL()
			);
		}

		$this->memc->set( $this->getMemcKey(), $data );

		wfProfileOut(__METHOD__);

		return $data;
	}

	public function getMemcKey() {
		return wfMemcKey( 'ArticlesUsingMediaQuery', 'v3', md5( $this->fileTitle->getDBKey() ) );
	}

	public function unsetCache() {
		$this->memc->set( $this->getMemcKey(), null );
	}

	public static function onArticleSaveComplete($article, $user, $revision, $status) {
		wfProfileIn(__METHOD__);

		$insertedImages = Wikia::getVar('imageInserts');
		$imageDeletes = Wikia::getVar('imageDeletes');

		$changedImages = $imageDeletes;
		foreach($insertedImages as $img) {
			$changedImages[ $img['il_to'] ] = true;
		}

		$sendTrackEvent = false;
		foreach( $changedImages as $imageDBName => $dummy ) {
			$title = Title::newFromDBkey( $imageDBName );
			if ( !empty( $title ) ) {
				$mq = new self( $title );
				$mq->unsetCache();

				$sendTrackEvent = true;
			}
		}

		// send track event if embed change
		if ( $sendTrackEvent ) {
			Track::event( 'embed_change' );
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * @param $article WikiPage
	 * @param bool $wgUser
	 * @param bool $reason
	 * @param bool $error
	 * @return bool
	 */
	public static function onArticleDelete( &$article, &$wgUser=false, &$reason=false, &$error=false ) {
		$id = $article->mTitle->getArticleID();
		$dbr = wfGetDB( DB_SLAVE );

		if ( (int) $id > 0 ) {
			$res = $dbr->select(
				array( 'imagelinks' ),
				array( 'il_to' ),
				array( 'il_from='.$id ),
				__METHOD__
			);

			while ( $s = $res->fetchObject() ) {
				$title = Title::newFromDBkey( $s->il_to );
				if ( !empty( $title ) ) {
					$mq = new self( $title );
					$mq->unsetCache();
				}
			}
		}

		return true;
	}

}
