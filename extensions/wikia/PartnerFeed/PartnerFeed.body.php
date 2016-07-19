<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 * Returns formated RSS / Atom Feeds
 */

use Wikia\Logger\WikiaLogger;

class PartnerFeed extends SpecialPage {
	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
	var $err;

	function  __construct() {
		parent::__construct( "PartnerFeed" , '' /*restriction*/ );
	}

	function execute( $par ) {
		$req = $this->getRequest();

		$this->mName = $req->getText( 'wpName' );
		$this->mRealName = $req->getText( 'wpContactRealName' );
		$this->mWhichWiki = $req->getText( 'wpContactWikiName' );
		$this->mProblem = $req->getText( 'wpContactProblem' );
		$this->mProblemDesc = $req->getText( 'wpContactProblemDesc' );
		$this->mPosted = $req->wasPosted();
		$this->mAction = $req->getVal( 'action' );
		$this->mEmail = $req->getText( 'wpEmail' );
		$this->mBrowser = $req->getText( 'wpBrowser' );
		$this->mCCme = $req->getCheck( 'wgCC' );

		$feed = $req->getText( "feed", false );
		$feedType = $req->getText ( "type", false );
		if ( $feed && $feedType && in_array( $feed, [ "rss", "atom" ] ) ) {
			// Varnish cache controll. Cache max for 12h.
			header( "Cache-Control: s-maxage=" . ( 60 * 60 * 12 ) );
			header( "X-Pass-Cache-Control: max-age=" . ( 60 * 60 * 12 ) );
			$isFeed = true;
			switch( $feedType ) {
				case 'AchivementsLeaderboard':
					$this->FeedAchivementsLeaderboard( $feed );
				break;
				case 'RecentImages':
					$this->FeedRecentImages( $feed );
				break;
				case 'RecentBadges':
					$this->FeedRecentBadges( $feed );
				break;
				case 'HotContent':
					$this->FeedHotContent( $feed );
				break;
				case 'RecentBlogPosts':
					$this->FeedRecentBlogPosts( $feed );
				break;
				case 'RecentBlogComments':
					$this->FeedRecentBlogComments( $feed );
				break;
				case 'RecentChanges':
					$this->FeedRecentChanges( $feed );
				break;
				default :
					$isFeed = false;
					$this->showMenu();
				break;
			}
			if ( $isFeed ) {
				header( "Content-Type: application/rss+xml" );
			}
		} else {
			$this->showMenu();
		}
		return false;
	}

	private function showMenu() {
		$wg = F::app()->wg;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( [
			'displayBlogs' => !empty( $wg->EnableBlogArticles ),
			'displayAchievements' => !empty( $wg->EnableAchievementsExt )
		] );
		$wg->Out->addHTML( $oTmpl->render( "main-page" ) );
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format 'rss' or 'atom'
	 *
	 * @throws MWException
	 */
	private function FeedRecentBlogComments ( $format ) {
		$wg = F::app()->wg;

		if ( empty( $wg->EnableBlogArticles ) ) {
			$this->showMenu();
		} else {
			// local settings
			$maxNumberOfBlogComments = 10;
			$userAvatarSize = 48;

			$sBlogPost = $wg->Request->getText ( "blogpost", false );
			$oTitle = Title::newFromText( $sBlogPost , 500 );
			if ( $oTitle && $oTitle->getArticleID() > 0 ) {

				$articleCommentList = ArticleCommentList::newFromTitle( $oTitle );
				$articleCommentList->newFromTitle( $oTitle );
				$aCommentPages = $articleCommentList->getCommentPages();

				$feedArray = [];
				foreach ( $aCommentPages as $commentPage ) {

					if ( ( $maxNumberOfBlogComments-- ) == 0 ) {
						break;
					}

					/** @var ArticleComment $levelOne */
					$levelOne = $commentPage['level1'];

					// make sure all data is loaded
					if ( $levelOne->load() ) {
						$tmpArticleComment = $levelOne->getData();

						/** @var Revision $revision */
						$firstRevision = $levelOne->mFirstRevision;
						if ( !$firstRevision instanceof Revision ) {
							$tmpArticleComment['mFirstRevision'] = $firstRevision;
							$this->logError( 'Comment has no first revision', $tmpArticleComment );
							break;
						}

						/** @var User $commentAuthor */
						$commentAuthor = $tmpArticleComment[ 'author' ];
						$feedArray[] = [
							'title' => '',
							'description' => $tmpArticleComment[ 'text' ],
							'url' => $oTitle->getFullURL(),
							'date' => $firstRevision->getTimestamp(),
							'author' => $commentAuthor->getName(),
							'otherTags' => [
								'image' => AvatarService::getAvatarUrl( $levelOne->mUser->getName(), $userAvatarSize )
							]
						];
					} else {
						$this->logError( 'Comment page loading failed', $commentPage );
					}
				}

				$this->showFeed(
					$format,
					wfMessage( 'feed-title-blogcomments', $oTitle->getFullText() )->text(),
					$feedArray
				);
			} else {
				$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$oTmpl->set_vars( [ "blogPostName" => $sBlogPost ] );
				$wg->Out->addHTML( $oTmpl->render( "error-page-blog-comments" ) );
			}
		}
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format 'rss' or 'atom'
	 *
	 * @throws MWException
	 */
	private function FeedRecentChanges ( $format ) {
		$userAvatarSize = 48;

		$aReturn = ApiService::call(
			[
				'action' => 'query',
				'list' => 'recentchanges',
				'rclimit' => '30',
				'rcprop' => 'user|comment|timestamp|title|ids',
				'rctype' => 'new|edit',
				'rcshow' => '!anon|!bot',
				'rcnamespace' => '0'
			]
		);

		$feedArray = [];
		foreach ( $aReturn['query']['recentchanges'] as $val ) {

			$oTitle = Title::newFromText( $val['title'] );

			if ( $val['type'] == 'edit' ) {
				$action = 'edited';
			} else {
				$action = 'created';
			};

			$feedArray[] = [
				'title' => $val['title'],
				'description' => $val['user'] . ' ' . $action . ' the ' . $val['title'],
				'url' => $oTitle->getFullURL(),
				'date' => $val['timestamp'],
				'author' => $val['user'],
				'otherTags' => [
					'image' => AvatarService::getAvatarUrl( $val['user'], $userAvatarSize )
				]
			];
		}

		$this->showFeed( $format, wfMessage( 'feed-title-recentchanges' )->text(), $feedArray );
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format 'rss' or 'atom'
	 *
	 * @throws MWException
	 */
	private function FeedRecentBlogPosts ( $format ) {
		$wg = F::app()->wg;

		if ( empty( $wg->EnableBlogArticles ) ) {
			$this->showMenu();
		} else {
			// local settings
			$maxNumberOfBlogPosts = 10;
			$postCharacterLimit = 293;
			$userAvatarSize = 48;

			// If blog listing does not exit treats parameter as empty;
			$sListing = $wg->Request->getVal( 'listing' );
			$title = Title::newFromText( $sListing, NS_BLOG_LISTING );
			if ( !empty( $sListing ) && ( $title == null || !$title->exists() ) ) {
				unset( $sListing );
			};

			$oBlogListing = new CreateBlogListingPage;
			$oBlogListing->setFormData( 'listingAuthors', '' );
			$oBlogListing->setFormData( 'tagContent', '' );
			if ( !empty( $sListing ) ) {
				$oBlogListing->parseTag( urldecode( $sListing ) );
				$subTitleName = wfMessage( 'blog-posts-from-listing', $sListing )->text();
			} else {
				$oBlogListing->setFormData( 'listingCategories', '' );
				$subTitleName = wfMessage( 'all-blog-posts' )->text();
			}

			$input = $oBlogListing->buildTagContent();

			$params = [
				"summary" => true,
				"timestamp" => true,
				"count" => $maxNumberOfBlogPosts,
			];

			$result = BlogTemplateClass::parseTag( $input, $params, $wg->Parser, null, true );
			$feedArray = [];

			foreach ( $result as $val ) {
				$oTitle = Title::newFromID( $val['page'] );

				$aValue = explode( '/' , $oTitle->getText() );
				$feedArray[] = [
					'title' => $aValue[1],
					'description' => substr( str_replace( '&nbsp;', ' ', strip_tags( $val['text'] ) ), 0, $postCharacterLimit ),
					'url' => $oTitle->getFullURL(),
					'date' => $val['date'],
					'author' => $val['username'],
					'otherTags' => [
						'image' => AvatarService::getAvatarUrl( $val['username'], $userAvatarSize )
					]
				];
			}
			$this->showFeed(
				$format,
				wfMessage( 'feed-title-blogposts' )->text() . ' - ' . $subTitleName,
				$feedArray
			);
		}
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format 'rss' or 'atom'
	 */
	private function FeedRecentBadges ( $format ) {
		$wg = F::app()->wg;

		if ( empty ( $wg->EnableAchievementsExt ) ) {
			$this->showMenu();
		} else {
			// local settings
			$howOld = 30;
			$maxBadgesToDisplay = 6;
			$badgeImageSize = 56;
			$rankingService = new AchRankingService();

			// ignore welcome badges
			$blackList = [ BADGE_WELCOME ];

			$awardedBadges = $rankingService->getRecentAwardedBadges( null, $maxBadgesToDisplay, $howOld, $blackList );

			$recents = [];
			$count = 1;

			$feedArray = [];
			// getRecentAwardedBadges can sometimes return more than $max items
			foreach ( $awardedBadges as $badgeData ) {
				$recents[] = $badgeData;

				/** @var AchBadge $badge */
				$badge = $badgeData['badge'];
				$descriptionText = $badge->getName() . $badge->getGiveFor();
				$descriptionText = preg_replace( '/<br\s*\/*>/i', "$1 $2", $descriptionText );
				$descriptionText = strip_tags( $descriptionText );
				$imgURL = $badge->getPictureUrl( $badgeImageSize );
				if ( strpos( $imgURL, 'http' ) === false ) {
					$imgURL = sprintf( "%s/%s", $wg->Server, $imgURL );
				}

				/** @var User $badgeUser */
				$badgeUser = $badgeData['user'];
				$feedArray[] = [
					'title' => $badgeUser->getName(),
					'description' => $descriptionText,
				    	'url' => $badgeUser->getUserPage()->getFullURL(),
					'date' => $badgeData['date'],
					'author' => '',
					'otherTags' => [
					    'image' => $imgURL,
					    'earnedby' => $badgeUser->getName(),
					    'nicedate' => wfTimeFormatAgo( $badgeData['date'] )
					]
				];

				if ( $count++ >= $maxBadgesToDisplay ) {
					break;
				}
			}
			$this->showFeed( $format, wfMessage( 'feed-title-recent-badges' )->text(), $feedArray );
		}
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format 'rss' or 'atom'
	 *
	 * @throws MWException
	 */
	private function FeedRecentImages ( $format ) {
		// local settings
		$maxImagesNumber = 20;
		$defaultWidth = 124;
		$defaultHeight = 72;

		$imageServing = new ImageServing( [], $defaultWidth, [ "w" => $defaultWidth, "h" => $defaultHeight ] );
		$dbw = wfGetDB( DB_SLAVE );

		$res = $dbw->select( 'image',
				[ "img_name", "img_user_text", "img_size", "img_width", "img_height" ],
				[
					"img_media_type != 'VIDEO'",
					"img_width > 32",
					"img_height > 32"
				],
				false,
				[
					"ORDER BY" => "img_timestamp DESC",
					"LIMIT" => $maxImagesNumber
				]
		);

		$feedArray = [];

		while ( $row = $dbw->fetchObject( $res ) ) {

			$tmpTitle = Title::newFromText( $row->img_name, NS_FILE );
			$image = wfFindFile( $tmpTitle );

			if ( !$image ) continue;

			$testImage = wfReplaceImageServer(
				$image->getThumbUrl(
					$imageServing->getCut( $row->img_width, $row->img_height ) . "-" . $image->getName()
				)
			);

			$feedArray[] = [
				'title' => '',
				'description' => $row->img_name,
				'url' => $tmpTitle->getFullURL(),
				'date' => $image->getTimestamp(),
				'author' => $row->img_user_text,
				'otherTags' => [
						'image' => $testImage
				]
			];
		}

		$this->showFeed( $format, wfMessage( 'feed-title-recent-images' )->text(), $feedArray );
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format 'rss' or 'atom'
	 *
	 * @throws MWException
	 */
	private function FeedHotContent ( $format ) {
		# this method should be redesigned

		$defaultHubTitle = 'tv';

		$hubTitle = $this->getRequest()->getVal( 'hub' );
		$allowedHubs = $this->allowedHubs();

		if ( isset( $allowedHubs[ $hubTitle ] ) && !is_array( $allowedHubs[ $hubTitle ] ) ) {
			$oTitle = Title::newFromText( $hubTitle, 150 );
		} else {
			$oTitle = Title::newFromText( $defaultHubTitle, 150 );
		}
		$this->showFeed( $format, wfMessage( 'feed-title-hot-content', $oTitle->getText() )->text(), [] );
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * Returns array of accepted hubs.
	 */
	public function allowedHubs () {
		return F::app()->wg->HubsPages['en'];
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format 'rss' or 'atom'
	 */
	private function FeedAchivementsLeaderboard ( $format ) {
		$wg = F::app()->wg;

		if ( empty( $wg->EnableAchievementsExt ) ) {
			$this->showMenu();
		} else {

			// local settings
			$maxEntries = 20;
			$howOld = 3;
			$userAvatarSize = 48;

			$rankingService = new AchRankingService();
			$ranking = $rankingService->getUsersRanking( 20 );

			$levels = [ BADGE_LEVEL_PLATINUM, BADGE_LEVEL_GOLD, BADGE_LEVEL_SILVER, BADGE_LEVEL_BRONZE ];
			$recents = [];

			$specialPage = SpecialPageFactory::getPage( 'Leaderboard' );
			$specialPageTitle = $specialPage->getTitle();
			$pageUrl = $specialPageTitle->getFullUrl();

			foreach ( $levels as $level ) {
				$limit = 3;
				$blackList = null;
				if ( $level == BADGE_LEVEL_BRONZE ) {
					if ( $maxEntries <= 0 ) break;

					$limit = $maxEntries;
					$blackList = [ BADGE_WELCOME ];
				}

				$awardedBadges = $rankingService->getRecentAwardedBadges( $level, $limit, $howOld, $blackList );

				if ( $total = count ( $awardedBadges ) ) {
					$recents[$level] = $awardedBadges;
					$maxEntries -= $total;
				}
			}
			$feedArray = [];
			foreach ( $ranking as $rank => $rankedUser ) {
				/** @var AchRankedUser $rankedUser */
				$name = htmlspecialchars( $rankedUser->getName() );
				$feedArray[] = [
					'title' =>  $name,
					'description' => $wg->Lang->formatNum( $rankedUser->getScore() ),
					'url' => $pageUrl,
					'date' => time(),
					'author' => '',
					'',
					'otherTags' => [
						'media:thumbnail' => AvatarService::getAvatarUrl( $rankedUser->getName(), $userAvatarSize ),
					]
				];
			}
			$this->showFeed( $format, wfMessage( 'feed-title-leaderboard' )->text(), $feedArray );
		}
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * @param string $format
	 * @param string $subtitle
	 * @param array $feedData
	 *
	 * @internal param string $format 'rss' or 'atom'
	 * @internal param string $subtitle
	 * @internal param array $feedData returns RSS/Atom feed*
	 * returns RSS/Atom feed
	 */
	private function showFeed( $format, $subtitle, $feedData ) {
		wfProfileIn( __METHOD__ );
		$sFeedName = self::getFeedClass( $format );

		/** @var ChannelFeed $feed */
		$feed = new $sFeedName(
			wfMessage( 'feed-main-title' )->text(),
			$subtitle,
			F::app()->wg->Title->getFullUrl()
		);
		$feed->outHeader();
		foreach ( $feedData as $val ) {
			$item = new ExtendedFeedItem(
				$val['title'],
				$val['description'],
				$val['url'],
				$val['date'],
				$val['author'],
				'',
				$val['otherTags']

			);
			$feed->outItem( $item );
		}
		$feed->outFooter();
		wfProfileOut( __METHOD__ );
	}

	private static function getFeedClass ( $format ) {
		if ( $format == 'atom' ) {
			return 'PartnerAtomFeed';
		} else {
			return 'PartnerRSSFeed';
		}
	}

	private function logError ( $message, $param = null ) {
		WikiaLogger::instance()->error( 'PartnerFeed: ' . $message, $param );
	}
}

