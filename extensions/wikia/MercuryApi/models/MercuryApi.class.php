<?php

class MercuryApi {

	/**
	 * Aggregated list of comments users
	 *
	 * @var array
	 */
	 private $users = [];

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
		$this->clearUsers();
		$comments = [];
		foreach ( $commentsData['commentListRaw'] as $pageId => $commentData ) {
			$item = null;
			foreach ( $commentData as $level => $commentBody ) {
				if ( $level === 'level1' ) {
					$comment = $this->getComment( $pageId );
					if ( $comment ) {
						$item = $comment;
					}
				}
				if ( $level === 'level2' && !empty( $item ) ) {
					$item['comments'] = [];
					foreach ( array_keys( $commentBody ) as $articleId ) {
						$comment = $this->getComment( $articleId );
						if ( $comment ) {
							$item['comments'][] = $comment;
						}
					}
				}
			}
			$comments[] = $item;
		}
		return [
			'comments' => $comments,
			'users' => $this->getUsers(),
		];
	}

	/**
	 * Generate comment item object from comment article id
	 *
	 * @param integer $articleId
	 * @return null|mixed
	 */
	private function getComment( $articleId ) {
		$articleComment = ArticleComment::newFromId( $articleId );
		if ( !( $articleComment instanceof ArticleComment ) ) {
			return null;
		}
		$commentData = $articleComment->getData();
		return [
			'id' => $commentData['id'],
			'text' => $commentData['text'],
			'created' => (int)wfTimestamp( TS_UNIX, $commentData['rawmwtimestamp'] ),
			'userName' => $this->addUser( $commentData ),
		];
	}

	/**
	 * Add user to aggregated user array
	 *
	 * @param array $commentData - ArticleComment Data
	 * @return string userName
	 */
	private function addUser(Array $commentData) {
		$userName = trim( $commentData['author']->mName );
		if ( !isset( $this->users[$userName] ) ) {
			$this->users[$userName] = [
				'id' => (int)$commentData['author']->mId,
				'avatar' => AvatarService::getAvatarUrl(
						$commentData['author']->mName, AvatarService::AVATAR_SIZE_MEDIUM
					),
				'url' => $commentData['userurl']
			];
		}
		return $userName;
	}

	/**
	 * Get list of aggregated users
	 *
	 * @return array
	 */
	private function getUsers() {
		return $this->users;
	}

	/**
	 * Clear list of aggregated users
	 */
	private function clearUsers() {
		$this->users = [];
	}

	/**
	 * Edit a selected snippet of text.
	 * @param $articleId
	 * @param $origText
	 * @param $newText
	 * @return array
	 */
	public function editSnippet( $articleId, $origText, $newText ) {
		$article = Article::newFromID( $articleId );
		$oldContent = $article->getContent();
		$newContent = preg_replace("/$origText/", $newText, $oldContent );
		$status = $article->doEdit( $newContent, 'mobile edit', EDIT_UPDATE | EDIT_MINOR, false );

		return [
			"success" => $status->isOK() ? true : false,
			"message" => $status->isOK() ? "Successfully edit" : $status->getMessage()
		];
	}
}
