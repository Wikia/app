<?php

class RevisionApiController extends WikiaApiController {
	const ROWS_PATTERN = '/<tr>(.*?)<\/tr>/s';
	const CELLS_PATTERN = '/<td .*?class="(.*?)">(.*?)<\/td>/s';

	/**
	 * Gets diff between two revisions.
	 * Also includes data about revision and article
	 *
	 * @param int $oldId old revision id (required)
	 * @param int $newId new revision id (required)
	 * @param bool $avatar should get user avatar
	 * @param bool $oldRev should get data about old revision
	 *
	 * @throws MissingParameterApiException
	 */
	public function getRevisionsDiff() {
		$request = $this->getRequest();

		$oldId = $request->getVal( 'oldId' );
		$newId = $request->getVal( 'newId' );

		if ( empty( $oldId ) ) {
			throw new MissingParameterApiException( 'oldId' );
		}

		if ( empty( $newId ) ) {
			throw new MissingParameterApiException( 'newId' );
		}

		$params = $this->getParams( $request );

		$data = [];
		$revision = Revision::newFromId( $newId );

		if ( $revision ) {
			$diffs = $this->getDiffs( $revision->getTitle(), $oldId, $newId );
			$revisionData = $this->prepareRevisionData( $revision, $params );
			$pageData = $this->preparePageData( $revision );

			$data = [
				'article' => $pageData,
				'diffs' => $diffs,
				'revision' => $revisionData
			];

			if ( $params['oldRev'] ) {
				$oldRevision = Revision::newFromId( $oldId );
				if ( $oldRevision ) {
					$data['oldRevision'] = $this->prepareRevisionData( $oldRevision, $avatar );
				}
			}
		}

		$this->setResponseData( $data );
	}

	/**
	 * Prepares data about article
	 *
	 * @param Revision $revision
	 * @return array
	 */
	private function preparePageData( Revision $revision ) {
		$title = $revision->getTitle();

		return [
			'pageId' => $revision->getPage(),
			'ns' => $title->getNamespace(),
			'title' => $title->getText()
		];
	}

	/**
	 * Prepares data about revision
	 *
	 * @param Revision $revision
	 * @param array $params
	 * @return array
	 */
	private function prepareRevisionData( Revision $revision, $params ) {
		$comment = $revision->getComment();
		$revisionData = [
			'comment' => $comment,
			'isDeleted' => $revision->getDeleted(),
			'isMinor' => $revision->isMinor(),
			'parsedComment' => Linker::formatComment( $comment, $revision->getTitle() ),
			'revisionId' => $revision->getId(),
			'userId' => $revision->getUser(),
			'userName' => $revision->getUserText(),
			'timestamp' => wfTimestamp( TS_UNIX, $revision->getTimestamp() ),
			'size' => $revision->getSize(),
		];

		if ( $params['avatar'] ) {
			$revisionData['userAvatar'] = AvatarService::getAvatarUrl( $revision->getUserText() );
		}

		if ( $params['upvotes'] ) {
			$upvotes = ( new RevisionUpvotesService() )->getRevisionUpvotes( $this->wg->CityId, $revision->getId() );
			$revisionData['upvotes'] = $upvotes['upvotes'];
			$revisionData['upvotesCount'] = $upvotes['count'];
		}

		return $revisionData;
	}

	/**
	 * Get params from request
	 *
	 * @param WikiaRequest $request
	 * @return array
	 */
	private function getParams( WikiaRequest $request ) {
		return [
			'avatar' => $request->getBool( 'avatar' ),
			'oldRev' => $request->getBool( 'oldRev' ),
			'upvotes' => $request->getBool( 'upvotes' )
		];
	}

	/**
	 * Gets diff between two diffs using DifferenceEngine.
	 * The output is returned as table html format where each difference is wrapped by <td> and <tr> tag
	 *
	 * @param Title $title
	 * @param int $oldId
	 * @param int $newId
	 * @return array
	 */
	private function getDiffs( Title $title, $oldId, $newId ) {
		$engine = new DifferenceEngine( $title, $oldId, $newId );
		$text = $engine->getDiffBody();

		$diffsData = $this->getDiffData( $text );
		$diffs = $this->prepareDiffs( $diffsData );

		return $diffs;
	}

	/**
	 * Fetch raw diff data and classed from tabular output
	 *
	 * @param string $text
	 * @return array
	 */
	private function getDiffData( $text ) {
		$diffsData = [];

		preg_match_all( self::ROWS_PATTERN, $text, $rows );
		foreach ( $rows[1] as $row ) {
			$diff = [];
			preg_match_all( self::CELLS_PATTERN, $row, $cells );
			foreach ( $cells[1] as $index => $cell ) {
				if ( $cell !== 'diff-marker' && !empty( $cells[2][$index] ) ) {
					$diff[] = [
						'classes' =>  [ $cell ],
						'content' => $cells[2][$index]
					];
				}
			}
			if ( !empty( $diff ) ) {
				$diffsData[] = $diff;
			}
		}

		return $diffsData;
	}

	/**
	 * Prepare diff raw data
	 *
	 * @param array $diffsData
	 * @return array
	 */
	private function prepareDiffs( $diffsData ) {
		$diffs = [];

		foreach ( $diffsData as $diff ) {
			if ( in_array( 'diff-lineno', $diff[0]['classes'] ) ) {
				$diff[0]['type'] = 'line';
				$diffs[] = $diff[0];
			} elseif ( in_array( 'diff-context', $diff[0]['classes'] ) ) {
				$diff[0]['type'] = 'context';
				$diffs[] = $diff[0];
			} else {
				$diff[0]['type'] = 'previous';
				$diff[1]['type'] = 'current';

				if ( in_array( 'diff-empty', $diff[0]['classes'] ) ) {
					$diff[1]['classes'][] = 'all-changed';
					$diffs[] = $diff[1];
				} elseif ( in_array( 'diff-empty', $diff[1]['classes'] ) ) {
					$diff[0]['classes'][] = 'all-changed';
					$diffs[] = $diff[0];
				} else {
					$diffs[] = $diff[0];
					$diffs[] = $diff[1];
				}
			}
		}

		return $diffs;
	}
} 
