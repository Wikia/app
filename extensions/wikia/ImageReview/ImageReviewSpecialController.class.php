<?php

class ImageReviewSpecialController extends WikiaSpecialPageController {

	const LIMIT_IMAGES = 20;

	const STATE_UNREVIEWED = 0;
	const STATE_IN_REVIEW = 1;
	const STATE_APPROVED = 2;
	const STATE_REJECTED = 3;
	const STATE_DELETED = 4;
	const STATE_Q = 5;

	public function __construct() {
		parent::__construct('ImageReview', 'imagereview', false /* $listed */);
	}

	public function index() {
		$this->wg->Out->setPageTitle('Image Review tool');

		// check permissions
		if (!$this->specialPage->userCanExecute($this->wg->User)) {
			$this->specialPage->displayRestrictionError();
			return false;
		}

		$this->submitUrl = $this->wg->Title->getLocalUrl();

		// get more space for images
		$this->wg->SuppressSpotlights = true;
		$this->wg->SuppressWikiHeader = true;
		$this->wg->SuppressPageHeader = true;
		$this->wg->SuppressFooter = true;

		$imageList = array();
		if( $this->wg->request->wasPosted() ) {
			$action = $this->wg->request->getVal( 'action', '' );
			if ( $action == 'next' ) {
				$data = $this->wg->request->getValues();
				if ( !empty($data) ) {
					$review_end = time();
					$images = array();

					foreach( $data as $name => $value ) {
						if (preg_match('/img-(\d*)-(\d*)/', $name, $matches)) {
							if ( !empty($matches[1]) && !empty($matches[2]) ) {
								$images[] = array(
									'wikiId' => $matches[1],
									'pageId' => $matches[2],
									'state' => $value,
								);
							}
						}
					}

					$this->updateImageState( $images, $review_end );
				}
			} else if ( $action == 'back' ) {
				$timestamp = $this->wg->request->getVal( 'reviewtime', '' );
				$imageList = $this->getImagesFromReviewerId( $timestamp );
			}
		}

		$this->timestamp = ( empty($review_end) ) ? '' : $review_end;
		$this->imageList = ( empty($imageList) ) ? $this->getImageList() : $imageList;
	}

	/**
	 * get image list from reviewer id
	 * @param integer review_end
	 * @return array images
	 */
	protected function getImagesFromReviewerId( $review_end ) {
		$this->wf->ProfileIn( __METHOD__ );

		$imageList = array();

		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		$result = $db->select(
			array( 'image_review' ),
			array( 'wiki_id, page_id, state' ),
			array(
				'reviewer_id' => $this->wg->user->getId(),
				'review_end = '.$review_end
				),
			__METHOD__,
			array( 'ORDER BY' => 'priority desc, last_edited desc', 'LIMIT' => self::LIMIT_IMAGES )
		);

		while( $row = $db->fetchObject($result) ) {
			$tmp['wikiId'] = $row->wiki_id;
			$tmp['pageId'] = $row->page_id;
			$tmp['state'] = $row->state;
			$tmp['url'] = $this->getImageUrl( $row->wiki_id, $row->page_id );
			$imageList[] = $tmp;
		}
		$db->freeResult( $result );

		$this->wf->ProfileOut( __METHOD__ );

		return $images;
	}

	/**
	 * update image state
	 * @param array images
	 * @param integer review_end
	 */
	protected function updateImageState( $images, $review_end ) {
		$this->wf->ProfileIn( __METHOD__ );

		$deletionList = array();
		$sqlWhere = array();

		foreach ( $images as $image ) {
			if ( $image['state'] == self::STATE_APPROVED ) {
				$sqlWhere[self::STATE_APPROVED][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			} else if ( $image['state'] == self::STATE_DELETED ) {
				$sqlWhere[self::STATE_DELETED][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
				$deletionList[$image['wikiId']] = $image['pageId'];
			} else if ( $image['state'] == self::STATE_Q ) {
				$sqlWhere[self::STATE_Q][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";
			}
		}

		foreach( $sqlWhere as $state => $where ) {
			if ( !empty($where) ) {
				$db->update(
					'image_review',
					array(
						'reviewer_id' => $this->wg->user->getId(),
						'state' => $state,
						'review_end' => $review_end,
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
	 */
	protected function resetAbandonedWork() {
		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		// update review to unreview
		$db->update(
			'image_review',
			array(
				'reviewer_id = null',
				'state' => self::STATE_UNREVIEWED,
			),
			array(
				"review_start < now() - interval 1 hour",
				"review_end = '0000-00-00 00:00:00'",
				'state' => self::STATE_IN_REVIEW,
			),
			__METHOD__
		);
		$db->commit();

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * get image list
	 * @return array imageList
	 */
	protected function getImageList() {
		$this->wf->ProfileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

		// for testing
		$this->resetAbandonedWork();
		
		// get images
		$imageList = array();
		$reviewList = array();

		$result = $db->select(
			array( 'image_review' ),
			array( 'wiki_id, page_id, state' ),
			array( "state = ".self::STATE_UNREVIEWED ),
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

		if ( !empty($imageList) ) {
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
					'review_start = now()',
				),
				array( implode(' OR ', $sqlWhere ) ),
				__METHOD__
			);
			$db->commit();
		}

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

}
