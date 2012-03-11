<?php

/**
 * ImageReview Helper
 */
class ImageReviewHelper extends WikiaModel {

	protected static $instance = NULL;

	const LIMIT_IMAGES = 3;

	const STATE_UNREVIEWED = 0;
	const STATE_IN_REVIEW = 1;
	const STATE_APPROVED = 2;
	const STATE_REJECTED = 3;
	const STATE_DELETED = 4;
	const STATE_QUESTIONABLE = 5;

	public static function getInstance() {
		if (self::$instance === NULL) {
			$class = __CLASS__;
			self::$instance = F::build( $class );
		}
		return self::$instance;
	}

	/**
	 * update image state
	 * @param array images
	 * @param integer review_end
	 */
	public function updateImageState( $images ) {
		$this->wf->ProfileIn( __METHOD__ );

		$deletionList = array();
		$sqlWhere = array();

		foreach ( $images as $image ) {
			if ( $image['state'] == self::STATE_APPROVED ) {
				$sqlWhere[self::STATE_APPROVED][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			} else if ( $image['state'] == self::STATE_DELETED ) {
				$sqlWhere[self::STATE_DELETED][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$deletionList[$image['wikiId']] = $image['pageId'];
			} else if ( $image['state'] == self::STATE_QUESTIONABLE ) {
				$sqlWhere[self::STATE_QUESTIONABLE][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			}
		}

		foreach( $sqlWhere as $state => $where ) {
			if ( !empty($where) ) {
				$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

				$db->update(
					'image_review',
					array(
						'reviewer_id' => $this->wg->user->getId(),
						'state' => $state,
						'review_end = now()',
					),
					array( implode(' OR ', $where ) ),
					__METHOD__
				);

				$db->commit();
			}
		}

		if ( !empty( $deletionList ) ) {
			$task = new ImageReviewTask();
			$task->createTask(
				array(
					'page_list' => $deletionList,
				)
			);
		}
		
		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * reset state in abandoned work
	 * @todo remove this this (cron worker to take over)
	 */
	public function resetAbandonedWork() {
		if ( !$this->wg->DevelEnvironment ) {
			return true;
		}

		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		$timeLimit = 1; // 1 sec

		$db->update(
			'image_review',
			array(
				'reviewer_id = null',
				'state' => self::STATE_UNREVIEWED,
			),
			array(
				"review_start < now() - ".$timeLimit,
				"review_end = '0000-00-00 00:00:00'",
				'reviewer_id' =>  $this->wg->User->getId(),
				'state' => self::STATE_IN_REVIEW,
			),
			__METHOD__
		);
		$db->commit();
	}

	/**
	* get image list from reviewer id based on the timestamp
	* @param integer review_end
	* @return array images
	*/	
	public function refetchImageListByTimestamp($timestamp) {
		$this->wf->ProfileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		// try to re-fetch the previuos set of images
		// TODO: optimize it, so we don't do it on every request

		$result = $db->select(
			array( 'image_review' ),
			array( 'wiki_id, page_id, state' ),
			array( 'review_start = FROM_UNIXTIME(' . $timestamp . ')', 'reviewer_id' =>  $this->wg->user->getId()),
			__METHOD__,
			array( 'ORDER BY' => 'priority desc, last_edited desc', 'LIMIT' => self::LIMIT_IMAGES )
		);

		$imageList = array();
		while( $row = $db->fetchObject($result) ) {
			$tmp = array(
				'wikiId' => $row->wiki_id,
				'pageId' => $row->page_id,
				'state' => $row->state,
				'src' => $this->getImageSrc( $row->wiki_id, $row->page_id ),
				'url' => $this->getImagePage( $row->wiki_id, $row->page_id ),
			);
			$imageList[] = $tmp;
		}
		$db->freeResult( $result );

		error_log("ImageReview : refetched " . count($imageList) . " images based on timestamp");

		$this->wf->ProfileOut( __METHOD__ );

		return $imageList;
	}
	
	/**
	 * get image list
	 * @return array imageList
	 */
	/**
	 * get image list
	 * @return array imageList
	 */
	public function getImageList( $timestamp, $state = self::STATE_UNREVIEWED ) {
		$this->wf->ProfileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		// for testing
		$this->resetAbandonedWork();
		
		// get images
		$imageList = array();
		$reviewList = array();

		$where = array();
		$list = $this->getWhitelistedWikis();
		if(!empty($list)) {
			$where[] = 'wiki_id not in('.implode(',', $list).')';
		}

		$where[] = "state = ".$state;  
		
		$result = $db->select(
			array( 'image_review' ),
			array( 'wiki_id, page_id, state' ),
			$where,
			__METHOD__,
			array( 'ORDER BY' => 'priority desc, last_edited desc', 'LIMIT' => self::LIMIT_IMAGES )
		);

		while( $row = $db->fetchObject($result) ) {
			$tmp = array(
				'wikiId' => $row->wiki_id,
				'pageId' => $row->page_id,
				'state' => $row->state,
				'src' => $this->getImageSrc( $row->wiki_id, $row->page_id ),
				'url' => $this->getImagePage( $row->wiki_id, $row->page_id ),
			);
			$imageList[] = $tmp;
		}
		$db->freeResult( $result );

		// NOT update state if the state is STATE_QUESTIONABLE
		if ( !empty($imageList) && $state != self::STATE_QUESTIONABLE ) {
			// update state to review
			$sqlWhere = array();
			foreach ( $imageList as $image ) {
				$sqlWhere[] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			}
			$db->update(
				'image_review',
				array(
					'reviewer_id' => $this->wg->user->getId(),
					'state' => self::STATE_IN_REVIEW,
					"review_start = from_unixtime($timestamp)",
				),
				array( implode(' OR ', $sqlWhere ) ),
				__METHOD__
			);
			$db->commit();
		}

		error_log("ImageReview : fetched new " . count($imageList) . " images");

		$this->wf->ProfileOut( __METHOD__ );

		return $imageList;
	}

	/**
	 * get image thumbnail
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string imageUrl
	 */
	protected function getImageSrc( $wikiId, $pageId ) {
		$this->wf->ProfileIn( __METHOD__ );

		$dbname = WikiFactory::IDtoDB( $wikiId );
		$param = array(
			'action' => 'imagecrop',
			'imgId' => $pageId,
			'imgSize' => 250,
		);
		$response = ApiService::foreignCall( $dbname, $param );

		$imageSrc = ( empty($response['image']['imagecrop']) ) ? '' : $response['image']['imagecrop'] ;

		$this->wf->ProfileOut( __METHOD__ );

		return $imageSrc;
	}


	/**
	 * get image page url
	 * @param integer wikiId
	 * @param integer pageId
	 * @return string image page URL
	 */
	protected function getImagePage( $wikiId, $pageId ) {
		$this->wf->ProfileIn( __METHOD__ );

		$title = GlobalTitle::newFromId($pageId, $wikiId);
		$imagePage = ($title instanceof Title) ? $title->getFullURL() : '';

		$this->wf->ProfileOut( __METHOD__ );
		return $imagePage;
	}	

	
	protected function getWhitelistedWikis() {
		$this->wf->ProfileIn( __METHOD__ );

		$topWikis =  $this->getTopWikis();
		$whitelistedWikis =  $this->getWhitelistedWikisFromWF();
		
		$out = $whitelistedWikis + $topWikis;
		return array_keys($out);
		$this->wf->ProfileOut( __METHOD__ );
	}
	
	protected function getWhitelistedWikisFromWF() {
		$this->wf->ProfileIn( __METHOD__ );
		$key = wfMemcKey( 'ImageReviewSpecialController', __METHOD__ );

		$data = $this->wg->memc->get($key, null); 
		
		if(!empty($data)) {
			$this->wf->ProfileOut( __METHOD__ );
			return $data;
		}
		
		$oVariable = WikiFactory::getVarByName( 'wgImageReviewWhitelisted', 177 );
		$fromWf = WikiFactory::getListOfWikisWithVar($oVariable->cv_variable_id, 'bool', '=' ,true);

		$this->wg->memc->set($key, $fromWf, 60*10);
		$this->wf->ProfileOut( __METHOD__ );
		return $fromWf;
	}
	
	protected function getTopWikis() {
		$this->wf->ProfileIn( __METHOD__ );
		$key = wfMemcKey( 'ImageReviewSpecialController', __METHOD__ );
		$data = $this->wg->memc->get($key, null); 		
		if(!empty($data)) {
			$this->wf->ProfileOut( __METHOD__ );
			return $data;
		}
		
		$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);
		$ids = array();
		
		if ( !$this->wg->DevelEnvironment ) {
			$result = $db->select(
				array( 'google_analytics.pageviews' ),
				array( 'city_id', 'sum(pageviews) as cnt' ),
				array( 'date > curdate() - interval 31 day' ),
				__METHOD__,
				array( 
					'GROUP BY'=> 'city_id', 
					'HAVING' => '150000'
				)
			);

			while( $row = $db->fetchObject($result) ) {
				$ids[$row['city_id']] = 1;
			}
		}
 	
		$this->wg->memc->set($key,$ids, 60*60*24);
		$this->wf->ProfileOut( __METHOD__ );
		return $ids;
	}
}
