<?php

class ImageStateUpdater extends WikiaModel {

	/**
	 * update image state
	 * @param array $images
	 * @param int $userId
	 */
	public function update( array $images, int $userId ) {
		wfProfileIn( __METHOD__ );

		$deletionList = [];
		$statsInsert = [];

		$sqlWhere = [
			ImageReviewStates::APPROVED => [],
			ImageReviewStates::REJECTED => [],
			ImageReviewStates::QUESTIONABLE => [],
		];

		foreach ( $images as $image ) {
			$sqlWhere[ $image['state'] ][] = "( wiki_id = $image[wikiId] AND page_id = $image[pageId]) ";

			if ( $image['state'] == ImageReviewStates::DELETED ) {
				$deletionList[] = [ $image['wikiId'], $image['pageId'] ];
			}

			$statsInsert[] = [
				'wiki_id' => $image['wikiId'],
				'page_id' => $image['pageId'],
				'review_state' => $image['state'],
				'reviewer_id' => $userId
			];
		}

		$db = $this->getDatawareDB( DB_MASTER );
		foreach( $sqlWhere as $state => $where ) {
			if ( !empty($where) ) {
				$db->update(
					'image_review',
					[
						'reviewer_id' => $userId,
						'state' => $state,
						'review_end = now()',
					],
					[ implode(' OR ', $where ) ],
					__METHOD__
				);
			}
		}

		if ( !empty( $statsInsert ) ) {
			$db->insert(
				'image_review_stats',
				$statsInsert,
				__METHOD__
			);
		}

		$db->commit();

		$this->createDeleteImagesTask( $deletionList );
	}

	/**
	 * Creates a task removing listed images
	 * @param  array  $imagesToDelete  An array of [ city_id, page_id ] arrays.
	 * @return void
	 */
	public function createDeleteImagesTask( array $imagesToDelete ) {
		if ( !empty( $imagesToDelete ) ) {
			$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
			$task->call( 'delete', $imagesToDelete );
			$task->prioritize();
			$task->queue();
		}
	}
}
