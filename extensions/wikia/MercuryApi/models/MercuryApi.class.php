<?php

class MercuryApi {

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

	public function getArticleComments( $app, $articleId, $page ) {
		$comments = $app->sendRequest( 'ArticleComments', 'WikiaMobileCommentsPage', array(
			'articleID' => $articleId,
			'page' => $page,
			'format' => 'json'
		) )->getData();
		$items = array();
		foreach ( array_keys( $comments['commentListRaw'] ) as  $pageId) {
			$comment = ArticleComment::newFromId( (int)$pageId );
			if ( !empty( $comment ) ) {
				$items[] = $this->getComment( $comment->getData() );
			}
		}
		return $items;
	}

	private function getComment( $commentData ) {
		$result = new stdClass();
		$result->id = $commentData['id'];
		$result->text = $commentData['text'];
		$result->created = (int)$commentData['rawmwtimestamp'];

		$result->user = new stdClass();
		$result->user->name = $commentData['author']->mName;
		$result->user->image = $commentData['avatar'];
		$result->user->url = $commentData['userurl'];
		return $result;
	}

}
