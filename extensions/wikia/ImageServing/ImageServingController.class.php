<?php

class ImageServingController extends WikiaController {
	public function index() {
		$this->forward( __CLASS__, 'getImages' );
	}

	/**
	 * @brief Returns an array containing result from Image Serving
	 *
	 * @requestParam Array $ids an array of Article IDs from which to retrieve images
	 * @requestParam int $width the desired thumbnail width in pixels
	 * @requestParam mixed $height the desired thumbnail height in pixels or an array of proportions (@see
	 *     ImageServing::getImages)
	 * @requestParam int $count the maximum number of images to retrieve for each Article ID
	 *
	 * @responseParam Array $result a multi-dimensional array whith the Article ID as the key and an array of image
	 *     URL's as the values
	 */
	public function getImages() {
		$this->response->setFormat( 'json' );

		if ( !$this->wg->User->isAllowed( 'read' ) ) {
			$this->setVal( 'status', 'error' );
			$this->setVal( 'result', 'User is not allowed to read' );

			return true;
		}

		$ids = $this->getVal( 'ids' );

		if ( !is_array( $ids ) ) {
			$this->setVal( 'status', 'error' );
			$this->setVal( 'result', 'ids list needs to be an array' );

			return true;
		}

		foreach ( $ids as $key => $val ) {
			$ids[$key] = (int) $ids[$key];
		}

		$height = $this->getVal( 'height' );

		if ( !is_array( $height ) ) {
			$height = (int) $height;
		}

		$width = (int) $this->getVal( 'width' );
		$count = (int) $this->getVal( 'count' );

		if ( ( !is_array( $height ) && $height < 1 ) || $count < 1 || $width < 1 || count( $ids ) < 1 ) {
			$this->setVal( 'status', 'error' );
			$this->setVal( 'result', 'height, width, count and the total of passed in ID\'s need to be bigger than 0' );

			return true;
		}

		$is = new ImageServing( $ids, $width, $height );

		$this->setVal( 'status', 'ok' );
		$this->setVal( 'result', $is->getImages( $count ) );
	}

	public function getImageUrl() {
		$filePageId = $this->getVal( 'id' );
		$title = Title::newFromID( $filePageId );

		if ( empty( $title ) || !$title->exists() || $title->getNamespace() != NS_FILE ) {
			throw new NotFoundException();
		}

		$revisionId = $this->getVal( 'revision' ) ?? $title->getLatestRevID();

		$db = wfGetDB( DB_SLAVE );
		$timestamp = $db->selectField(
			[ 'revision' ],
			'rev_timestamp',
			[
				'rev_page' => $filePageId,
				'rev_id' => $revisionId,
			],
			__METHOD__
		);

		if ( empty( $timestamp ) ) {
			throw new NotFoundException();
		}

		if ( $this->isOldImageRevision( $db, $timestamp, $title->getDBkey() ) ) {
			$oldLocalFile = OldLocalFile::newFromTitle( $title, RepoGroup::singleton()->getLocalRepo(), $timestamp );
			$this->response->setCode( 301 );
			$url = $oldLocalFile->getUrl();
		} else {
			$localFile = LocalFile::newFromTitle( $title, RepoGroup::singleton()->getLocalRepo() );
			$this->response->setCode( 302 );
			$url = $localFile->getUrl();
		}

		$this->response->setHeader( 'Location', $url );
		$this->skipRendering();
	}

	private function isOldImageRevision( $db, $revisionTimestamp, $fileName ): bool {
		return !empty(
			$db->selectField(
				[ 'oldimage' ],
				'1 as latest',
				[
					'oi_name' => $fileName,
					'oi_timestamp' => $revisionTimestamp
				]
			)
		);
	}
}
