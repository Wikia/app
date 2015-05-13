<?php

class MercuryApi {

	const MERCURY_SKIN_NAME = 'mercury';

	const CACHE_TIME_TOP_CONTRIBUTORS = 2592000; // 30 days

	const SITENAME_MSG_KEY = 'pagetitle-view-mainpage';

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

	public static function getTopContributorsKey ( $articleId, $limit ) {
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
		$contributions = WikiaDataAccess::cache( $key, self::CACHE_TIME_TOP_CONTRIBUTORS,
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
				while ( $row = $db->fetchObject( $res ) ) {
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
		global $wgSitename, $wgCacheBuster, $wgDBname, $wgDefaultSkin,
			   $wgLang, $wgLanguageCode, $wgContLang, $wgCityId;
		return [
			'cacheBuster' => (int) $wgCacheBuster,
			'dbName' => $wgDBname,
			'defaultSkin' => $wgDefaultSkin,
			'id' => (int) $wgCityId,
			'language' => [
				'user' => $wgLang->getCode(),
				'userDir' => SassUtil::isRTL() ? 'rtl' : 'ltr',
				'content' => $wgLanguageCode,
				'contentDir' => $wgContLang->getDir()
			],
			'namespaces' => $wgContLang->getNamespaces(),
			'siteMessage' => $this->getSiteMessage(),
			'siteName' => $wgSitename,
			'mainPageTitle' => Title::newMainPage()->getPrefixedDBkey(),
			'theme' => SassUtil::getOasisSettings(),
			'wikiCategories' => WikiFactoryHub::getInstance()->getWikiCategoryNames( $wgCityId ),
		];
	}

	/**
	 * @desc Gets a wikia site message
	 * When message doesn't exist - return false
	 *
	 * @return Boolean|String
	 */
	public function getSiteMessage() {
		$msg = wfMessage( static::SITENAME_MSG_KEY )->inContentLanguage();
		if ( !$msg->isDisabled() ) {
			$msgText = $msg->text();
		}
		return !empty( $msgText ) ? $msgText : false;
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
	private function addUser( Array $commentData ) {
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
	 * Get ads context for Title
	 * @param Title $title Title object
	 * @return array Article Ad context
	 */
	public function getAdsContext( Title $title ) {
		$adContext = new AdEngine2ContextService();
		return $adContext->getContext( $title, self::MERCURY_SKIN_NAME );
	}

	public function processCuratedContent( $data ) {
		if ( empty( $data ) ) {
			return false;
		}

		$process = false;

		if ( !empty( $data[ 'featured' ] ) ) {
			$process = 'featured';
		} else if ( !empty( $data[ 'items' ] ) ) {
			$process = 'items';
		}

		if ( $process ) {
			$items = [];
			foreach ( $data[ $process ] as $item ) {
				$processedItem = $this->processCuratedContentItem( $item );
				if ( !empty( $processedItem ) ) {
					$items[] = $processedItem;
				}
			}
		}

		return $data;
	}

	/**
	 * @desc Mercury can't open article using ID - we need to create a local link.
	 * If article doesn't exist (Title is null) return null.
	 * In other case return item with updated article_local_url.
	 * TODO Implement cache for release version.
	 * Platform Team is OK with hitting DB for MVP (10-15 wikis)
	 *
	 * @param $item
	 * @return mixed
	 */
	private function processCuratedContentItem( $item ) {
		if ( !empty( $item[ 'article_id' ] ) ) {
			$title = Title::newFromID( $item[ 'article_id' ] );
			if ( !empty( $title ) ) {
				$item[ 'article_local_url' ] = $title->getLocalURL();
				return $item;
			}
		}
		return null;
	}
}
