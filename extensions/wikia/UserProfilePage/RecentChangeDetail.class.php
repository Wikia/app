<?php

class RecentChangeDetail {

	private $wikiId = 0;
	private $wikiCatId = 0;
	private $userId = 0;
	private $revisionId = 0;
	private $pageId = 0;
	private $pageNs = 0;
	private $key = null;
	private $value = null;

	private function __construct( $userId, $revisionId, $pageId, $pageNs ) {
		global $wgCityId;

		$this->wikiId = $wgCityId;
		$this->wikiCatId = WikiFactoryHub::getInstance()->getCategoryId( $wgCityId );
		$this->userId = $userId;
		$this->revisionId = $revisionId;
		$this->pageId = $pageId;
		$this->pageNs = $pageNs;
		$this->key = $key;
		$this->value = $value;
	}

	/**
	 * @param RecentChange $recentChange
	 * @return RecentChangeDetail
	 */
	public static function newFromRecentChange( RecentChange $recentChange) {
		wfProfileIn(__METHOD__);

		$rcDetails = new RecentChangeDetail(
			$recentChange->getAttribute('rc_user'),
			$recentChange->getAttribute('rc_id'),
			$recentChange->getAttribute('rc_cur_id'),
			$recentChange->getAttribute('rc_namespace')
		);

		wfProfileOut(__METHOD__);
		return $rcDetails;
	}

	static public function registerMediaInsertEvent( LinksUpdate $linksUpdate ) {
		wfProfileIn(__METHOD__);

		$recentChange = Wikia::getVar( 'rc' );
		//var_dump( $recentChange );

		switch( $recentChange->getAttribute('rc_type')) {
			case RC_EDIT:
			case RC_NEW:
				if( $recentChange->getAttribute('rc_user') != 0 ) {
					$imageInserts = Wikia::getVar('imageInserts');
					if( !empty($imageInserts) ) {
						foreach( $imageInserts as $image ) {
							$rcDetails = RecentChangeDetail::newFromRecentChange( $recentChange );
							$rcDetails ->setKey( 'inserted-image' );
							$rcDetails ->setValue( $image['il_to'] );
							$rcDetails ->save();
						}
					}
				}
				break;
			case RC_DELETE:
				//TODO: handle deletes ?
				break;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function setKey( $key ) {
		$this->key = $key;
	}

	public function setValue( $value ) {
		$this->value = $value;
	}

	public function save() {
		global $wgExternalStatsDB;

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalStatsDB );
		$row = array(
			'wiki_id' => $this->wikiId,
			'wiki_cat_id' => $this->wikiCatId,
			'user_id' => $this->userId,
			'rev_id' => $this->revisionId,
			'page_id' => $this->pageId,
			'page_ns' => $this->pageNs,
			'detail_key' => $this->key,
			'detail_value' => $this->value,
			'timestamp' => date('Y-m-d H:i:s')
		);

		$dbw->insert( 'recentchanges_detail', $row, __METHOD__ );
		$dbw->commit();
	}

}