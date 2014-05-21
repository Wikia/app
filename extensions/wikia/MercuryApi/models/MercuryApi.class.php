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
	 * @desc Get Current wiki theme settings
	 *
	 * @return mixed
	 */
	public function getWikiTheme() {
		return SassUtil::getOasisSettings();
	}
}
