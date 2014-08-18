<?php

class CoppaImageReviewHelper extends WikiaModel {

	const LIMIT_IMAGES = 20;

	/**
	 * Get image list
	 *
	 * @param  integer $userId ID of the user to get the list for
	 * @param  string  $from   Timestamp to get images before
	 * @return array           List of images
	 */
	public function getImageList( $userId, $from = null ) {
		wfProfileIn( __METHOD__ );

		$imageList = [];

		$db = $this->getDatawareDB( DB_MASTER );

		$where = [
			'user_id' => $userId,
			'state != ' . ImageReviewStatuses::STATE_DELETED . ' AND state != ' . ImageReviewStatuses::STATE_WIKI_DISABLED,
		];

		$from = wfTimestampOrNull( TS_DB, $from );
		if ( !empty( $from ) ) {
			$where[] = 'last_edited < ' . $db->addQuotes( $from );
		}

		$result = $db->select(
			[ 'image_review' ],
			[ 'wiki_id, page_id, state, flags, priority, last_edited' ],
			$where,
			__METHOD__,
			[
				'ORDER BY' => 'last_edited desc',
				'LIMIT' => self::LIMIT_IMAGES,
			]
		);

		foreach ( $result as $row ) {
			$img = ImagesService::getImageSrc( $row->wiki_id, $row->page_id );
			$wikiRow = WikiFactory::getWikiByID( $row->wiki_id );

			$extension = pathinfo( strtolower( $img['page'] ), PATHINFO_EXTENSION );

			$isThumb = true;
			if ( empty( $img['src'] ) ) {
				// If we don't have a thumb by this point, we still need to display something, fall back to placeholder
				$globalTitle = GlobalTitle::newFromId( $row->page_id, $row->wiki_id );
				if ( is_object( $globalTitle ) ) {
					$img['page'] = $globalTitle->getFullUrl();
					// @TODO this should be taken from the code instead of being hardcoded
					$img['src'] = '//images.wikia.com/central/images/8/8c/Wikia_image_placeholder.png';
				} else {
					// This should never happen
					continue;
				}
			}

			if ( in_array( $extension, [ 'gif', 'svg' ] ) ) {
				$img = ImagesService::getImageOriginalUrl( $row->wiki_id, $row->page_id );
				$isThumb = false;
			}

			$imageList[] = [
				'wikiId' 	=> $row->wiki_id,
				'pageId' 	=> $row->page_id,
				'state' 	=> $row->state,
				'src' 		=> $img['src'],
				'priority' 	=> $row->priority,
				'url' 		=> $img['page'],
				'isthumb' 	=> $isThumb,
				'flags' 	=> $row->flags,
				'wiki_url' 	=> isset( $wikiRow->city_url ) ? $wikiRow->city_url : '',
				'user_page' => '', // @TODO fill this with url to user page
				'last_edited' => $row->last_edited,
			];
		}

		$db->freeResult( $result );

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	/**
	 * Delete images that have been marked for deletion
	 *
	 * @param  array   $images List of images to process
	 * @param  integer $userId ID of the user reviewing the images
	 */
	public function updateImageState( $images, $userId ) {
		wfProfileIn( __METHOD__ );

		$deletionList = [];

		$sqlWhere = [];

		foreach ( $images as $image ) {
			if ( $image['state'] == ImageReviewStatuses::STATE_DELETED ) {
				$deletionList[] = [ $image['wikiId'], $image['pageId'] ];
				$sqlWhere[] = "( wiki_id = {$image['wikiId']} AND page_id = {$image['pageId']} )";
			}
		}

		if ( !empty( $sqlWhere ) ) {
			$db = $this->getDatawareDB( DB_MASTER );

			$db->update(
				'image_review',
				[
					'reviewer_id' => $userId,
					'state' => ImageReviewStatuses::STATE_DELETED,
					'review_end = now()',
				],
				[ implode( ' OR ', $sqlWhere ) ],
				__METHOD__
			);

			$db->commit();
		}

		if ( !empty( $deletionList ) ) {
			$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
			$task->call('delete', $deletionList, true);
			$task->prioritize();
			$task->queue();
		}

		wfProfileOut( __METHOD__ );
	}

}
