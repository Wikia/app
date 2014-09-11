<?php

use Wikia\Util\GlobalStateWrapper;

class MercuryApi {

	const MERCURY_SKIN_NAME = 'mercury';
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
	 * @param int $articleId - Article id
	 * @param $limit - maximum number of contributors to fetch
	 * @return array
	 */
	public function topContributorsPerArticle( $articleId, $limit) {
		$db = wfGetDB( DB_SLAVE );
		$res = $db->select(
			'revision',
			[
				'rev_user'
			],
			[
				'rev_page' => $articleId,
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
			$result[] = (int) $row->rev_user;
		}
		return $result;
	}

	/**
	 * @desc Get Current wiki settings
	 *
	 * @return mixed
	 */
	public function getWikiVariables() {
		global $wgLanguageCode,
			   $wgCityId,
			   $wgDBname,
			   $wgSitename,
			   $wgCacheBuster;

		return [
			'cacheBuster' => (int) $wgCacheBuster,
			'dbName' => $wgDBname,
			'id' => (int) $wgCityId,
			'language' => $wgLanguageCode,
			'namespaces' => MWNamespace::getCanonicalNamespaces(),
			'siteName' => $wgSitename,
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
	public function getAdsContext( Title $title, WikiaGlobalRegistry $wg, Array $articleCategories ) {
		$wrapper = new GlobalStateWrapper(
			[ 'wgTitle' => $title ]
		);
		$categories = $this->getArticleCategoriesTitles( $articleCategories );

		return $wrapper->wrap(function () use ($title, $wg, $categories) {

			// This function modifies wgDartCustomKeyValues
			(new Wikia\NLP\Entities\WikiEntitiesService)->registerLdaTopicsWithDFP();

			$requestContext = RequestContext::newExtraneousContext( $title );

			// Get article to find out if the page is an article
			$article = Article::newFromTitle( $title, $requestContext );

			// Get AdEngine variables
			$adEngineVariables = AdEngine2Service::getTopJsVariables();

			return [
				'opts' => [
					'adsInHead' => $adEngineVariables[ 'wgLoadAdsInHead' ],
					'disableLateQueue' => $adEngineVariables[ 'wgAdEngineDisableLateQueue' ],
					'lateAdsAfterPageLoad' => $adEngineVariables[ 'wgLoadLateAdsAfterPageLoad' ],
					'pageType' => $adEngineVariables[ 'adEnginePageType' ],
					'showAds' => $adEngineVariables[ 'wgShowAds' ],
					'usePostScribe' => $adEngineVariables[ 'wgUsePostScribe' ],
					'trackSlotState' => $adEngineVariables[ 'wgAdDriverTrackState' ],
				],
				'targeting' => [
					'enableKruxTargeting' => $adEngineVariables[ 'wgEnableKruxTargeting' ],
					'kruxCategoryId' => isset( $adEngineVariables[ 'wgKruxCategoryId' ] ) ?
							$adEngineVariables['wgKruxCategoryId'] :
							0,
					'pageArticleId' => $title->getArticleId(),
					'pageCategories' => $adEngineVariables[ 'wgAdDriverUseCatParam' ] ?
							$categories :
							[],
					'pageIsArticle' => $article instanceof Article,
					'pageIsHub' => $adEngineVariables[ 'wikiaPageIsHub' ],
					'pageName' => $title->getPrefixedDBKey(),
					'pageType' => $adEngineVariables[ 'wikiaPageType' ],
					'sevenOneMediaSub2Site' => $adEngineVariables[ 'wgAdDriverSevenOneMediaOverrideSub2Site' ],
					'skin' => self::MERCURY_SKIN_NAME,
					'wikiCategory' => $adEngineVariables[ 'cityShort' ],
					'wikiCustomKeyValues' => $adEngineVariables[ 'wgDartCustomKeyValues' ],
					'wikiDbName' => $wg->DBname,
					'wikiDirectedAtChildren' => $adEngineVariables[ 'wgWikiDirectedAtChildren' ],
					'wikiLanguage' => $title->getPageLanguage()->getCode(),
					'wikiVertical' => $adEngineVariables[ 'cscoreCat' ],
				],
				'providers' => [
					'ebay' => $adEngineVariables[ 'wgAdDriverUseEbay' ],
					'sevenOneMedia' => $adEngineVariables[ 'wgAdDriverUseSevenOneMedia' ],
					'sevenOneMediaCombinedUrl' => isset( $adEngineVariables[ 'wgAdDriverSevenOneMediaCombinedUrl' ] ) ?
							$adEngineVariables[ 'wgAdDriverSevenOneMediaCombinedUrl' ] :
							null,
					'remnantGptMobile' => $wg->AdDriverEnableRemnantGptMobile,
				],
				'slots' => [
					'bottomLeaderboardImpressionCapping' => isset(
						$adEngineVariables[ 'wgAdDriverBottomLeaderboardImpressionCapping ']
						) ?
							$adEngineVariables[ 'wgAdDriverBottomLeaderboardImpressionCapping '] :
							null
				],
				'forceProviders' => [
					'directGpt' => $adEngineVariables[ 'wgAdDriverForceDirectGptAd' ],
					'liftium' => $adEngineVariables[ 'wgAdDriverForceLiftiumAd' ],
				]
			];
		});
	}
}
