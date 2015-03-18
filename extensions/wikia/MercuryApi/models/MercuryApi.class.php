<?php

class MercuryApi {

	const MERCURY_SKIN_NAME = 'mercury';

	const CACHE_TIME_TOP_CONTRIBUTORS = 2592000; // 30 days

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

	public static function getTopContributorsKey ( $articleId, $limit ){
		return wfMemcKey( __CLASS__, __METHOD__, $articleId, $limit );
	}

	/**
	 * @desc Fetch all time top contributors for article
	 *
	 * @param int $articleId - Article id
	 * @param $limit - maximum number of contributors to fetch
	 * @return array
	 */
	public function topContributorsPerArticle( $articleId, $limit ) {
		$key = self::getTopContributorsKey( $articleId, $limit );
		$method = __METHOD__;
		$contributions = WikiaDataAccess::cache($key, self::CACHE_TIME_TOP_CONTRIBUTORS,
			function() use ( $articleId, $limit, $method ) {
				// Log DB hit
				Wikia::log( $method, false, sprintf( 'Cache for articleId: %d was empty', $articleId ) );
				$db = wfGetDB( DB_SLAVE );
				$res = $db->select(
					'revision',
					[
						'rev_user',
						'count(1) AS cntr'
					],
					[
						'rev_page = ' . $articleId,
						'rev_deleted = 0',
						'rev_user != 0'
					],
					$method,
					[
						'GROUP BY' => 'rev_user',
						'ORDER BY' => 'count(1) DESC',
						'LIMIT' => $limit
					]
				);
				$result = [];
				while($row = $db->fetchObject($res)) {
					$result[ (int) $row->rev_user ] = (int) $row->cntr;
				}
				return $result;
			}
		);
		// Cached results may contain more than the $limit results
		$contributions = array_slice ( $contributions , 0, $limit, true );
		return array_keys( $contributions );
	}

	/**
	 * @desc Get number of user's contributions for article
	 *
	 * @param $articleId
	 * @param $userId
	 * @return mixed
	 */
	public function getNumberOfUserContribForArticle( $articleId, $userId ) {
		$db = wfGetDB( DB_SLAVE );
		$row = $db->selectRow(
			'revision',
			[
				'count(*) AS cntr'
			],
			[
				'rev_page' => $articleId,
				'rev_user' => $userId,
				'rev_deleted' => 0
			],
			__METHOD__
		);
		return $row->cntr;
	}

	/**
	 * @desc Get Current wiki settings
	 *
	 * @return mixed
	 */
	public function getWikiVariables() {
		$wg = F::app()->wg;
		return [
			'cacheBuster' => (int) $wg->CacheBuster,
			'dbName' => $wg->DBname,
			'defaultSkin' => $wg->DefaultSkin,
			'id' => (int) $wg->CityId,
			'language' => [
				'user' => $wg->Lang->getCode(),
				'userDir' => SassUtil::isRTL() ? 'rtl' : 'ltr',
				'content' => $wg->LanguageCode,
				'contentDir' => $wg->ContLang->getDir()
			],
			'namespaces' => $wg->ContLang->getNamespaces(),
			'siteName' => $this->getSiteName(),
			'mainPageTitle' => Title::newMainPage()->getPrefixedDBkey(),
			'theme' => SassUtil::getOasisSettings(),
			'wikiCategories' => WikiFactoryHub::getInstance()->getWikiCategoryNames( $wg->CityId ),
		];
	}

	/**
	 * @desc Gets a wikia sitename from WF variable
	 *
	 * @return null|String
	 */
	public function getSiteName() {
		return F::app()->wg->Sitename;
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
		// According to `extensions/wikia/ArticleComments/classes/ArticleComment.class.php:179`
		// no revision data means that the comment should be ignored
		if ( $commentData === false ) {
			return null;
		}
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
	 * Get categories titles
	 *
	 * @param array $articleCategories
	 * @return array
	 */
	private function getArticleCategoriesTitles( Array $articleCategories ) {
		$categories = [];
		foreach ( $articleCategories as $category ) {
			$categories[] = $category[ 'title' ];
		}
		return $categories;
	}

	/**
	 * Get ads context for Title
	 * @param Title $title Title object
	 * @param WikiaGlobalRegistry $wg Reference to the Global registry
	 * @param array $articleCategories List of Categories
	 * @return array Article Ad context
	 */
	public function getAdsContext( Title $title ) {
		$adContext = new AdEngine2ContextService();
		return $adContext->getContext( $title, self::MERCURY_SKIN_NAME );
	}
}
