<?php

class MercuryApi {

	const AUTHOR_AVATAR_SIZE = 50;

	/**
	 * @desc Fetch Article comments count
	 *
	 * @param Title $title - Article title
	 * @return integer
	 */
	public function articleCommentsCount( Title $title ) {
		$articleCommentList = new ArticleCommentList();
		$articleCommentList->setTitle( $title );
		return $articleCommentList->getCountAll();
	}

	/**
	 * @desc Fetch all time top contributors for article
	 *
	 * @param Title $title - Article title
	 * @param $limit - maximum number of contributors to fetch
	 * @return array
	 */
	public function topContributorsPerArticle( Title $title, $limit) {
		$db = wfGetDB( DB_SLAVE );
		$res = $db->select(
			'revision',
			[
				'rev_user'
			],
			[
				'rev_page' => (int)$title->getArticleId(),
				'rev_deleted' => 0
			],
			__METHOD__,
			[
				'GROUP BY' => 'rev_user',
				'ORDER BY' => 'count(1) DESC',
				'LIMIT' => $limit
			]
		);
		$result = [];
		while($row = $db->fetchObject($res)) {
			$result[] = (int)$row->rev_user;
		}
		return $result;
	}

	/**
	 * @desc Get Current wiki settings
	 *
	 * @return mixed
	 */
	public function getWikiSettings() {
		global $wgLanguageCode;
		return [
			'language' => $wgLanguageCode,
			'theme' => SassUtil::getOasisSettings()
		];
	}

	/**
	 * Process comments and return two level comments
	 *
	 * @param array $commentsData
	 * @return array
	 */
	public function processArticleComments( Array $commentsData ) {
		$items = [];
		foreach ( $commentsData[ 'commentListRaw' ] as $pageId => $commentData) {
			$item = null;
			foreach ( $commentData as $level => $commentBody) {
				if ( $level === 'level1' ) {
					$comment = $this->getComment( $pageId );
					if ( $comment ) {
						$item = $comment;
					}
				}
				if ( $level === 'level2' && !empty( $item ) ) {
					$item->items = [];
					foreach ( array_keys( $commentBody ) as $articleId ) {
						$comment = $this->getComment( $articleId );
						if ( $comment ) {
							$item->items[] = $comment;
						}
					}
				}
			}
			$items[] = $item;
		}
		return $items;
	}

	/**
	 * Generate comment item object from comment article id
	 *
	 * @param integer $articleId
	 * @return null|stdClass
	 */
	private function getComment( $articleId ) {
		$articleComment = ArticleComment::newFromId( $articleId );
		if ( empty ($articleComment) ) {
			return null;
		}
		$commentData = $articleComment->getData();
		$result = new stdClass();
		$result->id = $commentData['id'];
		$result->text = $commentData['text'];
		$result->created = (int)$commentData['rawmwtimestamp'];
		$result->user = new stdClass();
		$result->user->id = $commentData['author']->mId;
		$result->user->name = $commentData['author']->mName;
		$result->user->avatar = AvatarService::getAvatarUrl( $result->user->name, self::AUTHOR_AVATAR_SIZE );
		$result->user->url = $commentData['userurl'];
		return $result;
	}

}
