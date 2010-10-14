<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 * Returns formated RSS / Atom Feeds
 */

class PartnerFeed extends SpecialPage {
	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
	var $err;

	function  __construct() {
		parent::__construct( "PartnerFeed" , '' /*restriction*/);
		wfLoadExtensionMessages("PartnerFeed");
	}
	private function shortenString($sString, $length){
		return substr($sString,0,$length);
	}

	function execute() {
		global $wgLang, $wgAllowRealName, $wgRequest, $wgOut, $wgHubsPages;

		$this->mName = $wgRequest->getText( 'wpName' );
		$this->mRealName = $wgRequest->getText( 'wpContactRealName' );
		$this->mWhichWiki = $wgRequest->getText( 'wpContactWikiName' );
		$this->mProblem = $wgRequest->getText( 'wpContactProblem' );
		$this->mProblemDesc = $wgRequest->getText( 'wpContactProblemDesc' );
		$this->mPosted = $wgRequest->wasPosted();
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mEmail = $wgRequest->getText( 'wpEmail' );
		$this->mBrowser = $wgRequest->getText( 'wpBrowser' );
		$this->mCCme = $wgRequest->getCheck( 'wgCC' );

		$feed = $wgRequest->getText( "feed", false );
		$feedType = $wgRequest->getText ( "type", false );
		if (	$feed
			&& $feedType
			&& in_array( $feed, array( "rss", "atom" ) )
		) {
			// Varnish cache controll. Cache max for 12h.

			header( "Cache-Control: s-maxage=".( 60*60*12 ) );
			header( "X-Pass-Cache-Control: max-age=".( 60*60*12 ) );
			
			switch( $feedType ){
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
					$this->FeedRecentBlogPosts ( $feed );
				break;
				case 'RecentBlogComments':
					$this->FeedRecentBlogComments ( $feed );
				break;
				default :
					$this->showMenu();
				break;
			}
		} else {
			$this->showMenu();
		}

		return false;
	}


	private function showMenu(){

		global $wgOut, $wgEnableAchievementsExt, $wgEnableBlogArticles;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array (
			    'displayBlogs' => (!empty($wgEnableBlogArticles)),
			    'displayAchievements' => (!empty($wgEnableAchievementsExt))
			)
		);
		$wgOut->addHTML( $oTmpl->execute( "main-page" ) );
	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 *
 */
	private function FeedRecentBlogComments ( $format ){

		global	$wgEnableBlogArticles, $wgParser, $wgUser, $wgServer,
			$wgOut, $wgExtensionsPath, $wgRequest;

		if (empty($wgEnableBlogArticles)){
			$this->showMenu();
		} else {

			// local settings
			$maxNumberOfBlogComments = 10;
			$userAvatarSize = 48;

			$sBlogPost = $wgRequest->getText ( "blogpost", false );
			$oTitle = Title::newFromText( $sBlogPost , 500);
			if ( $oTitle->getArticleID() > 0 ){

				$articleCommentList = ArticleCommentList::newFromTitle($oTitle);
				$articleCommentList->newFromTitle( $oTitle );
				$aCommentPages = $articleCommentList->getCommentPages();

				$counter = $maxNumberOfBlogComments;
				$feedArray = array();
				foreach ($aCommentPages as $commentPage){

					if ( ( $maxNumberOfBlogComments-- ) == 0){
						break;
					}
					$tmpArticleComment = $commentPage['level1']->getData();

					$feedArray[] = array(
						'title' => '',
						'description' => $tmpArticleComment['text'],
						'url' => $oTitle->getFullURL(),
						'date' => $commentPage['level1']->mFirstRevision->getTimestamp(),
						'author' => $tmpArticleComment['author']->getName(),
						'otherTags' => array(
							'image' => AvatarService::getAvatarUrl( $commentPage['level1']->mUser->getName(), $userAvatarSize )
						)
					);
				}

				$this->showFeed( $format , wfMsg( 'feed-title-blogcomments', $oTitle->getFullText() ),  $feedArray);

			} else {

				$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$oTmpl->set_vars( array(
					"blogPostName"		=> $sBlogPost
				));
				$wgOut->addHTML( $oTmpl->execute( "error-page-blog-comments" ) );
			}
		}
	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 *
 */
	private function FeedRecentBlogPosts ( $format ){
		
		global	$wgParser, $wgUser, $wgServer, $wgOut, $wgExtensionsPath,
			$wgRequest, $wgEnableBlogArticles;

		if ( empty($wgEnableBlogArticles) ){
			$this->showMenu();
		} else {
			// local settings
			$maxNumberOfBlogPosts = 10;
			$postCharacterLimit = 293;
			$userAvatarSize = 48;

			// If blog listing does not exit treats parameter as empty;
			$sListing = $wgRequest->getVal( 'listing' );
			if ( !empty( $sListing ) && !Title::newFromText( $sListing, 502 )->exists() ){
				unset($sListing);
			};

			$oBlogListing = new CreateBlogListingPage;
			$oBlogListing->setFormData('listingAuthors', '');
			$oBlogListing->setFormData('tagContent', '');
			if ( !empty( $sListing ) ){
				$oBlogListing->parseTag( urldecode( $sListing ) );
				$subTitleName = wfMsg('blog-posts-from-listing', $sListing);
			} else {
				$oBlogListing->setFormData('listingCategories', '');
				$subTitleName = wfMsg('all-blog-posts');
			}

			$input = $oBlogListing->buildTagContent();

			$db = wfGetDB( DB_SLAVE, 'dpl' );

			$params = array (
				"summary" => true,
				"timestamp" => true,
				"count" => $maxNumberOfBlogPosts,
			);

			$result = BlogTemplateClass::parseTag( $input, $params, $wgParser, true );
			$feedArray = array();

			foreach( $result as $val ){
				$oTitle = Title::newFromID($val['page']);

				$aValue = explode('/' , $oTitle->getText());
				$feedArray[] = array(
					'title' => $aValue[1],
					'description' => substr( str_replace( '&nbsp;', ' ', strip_tags( $val['text'] ) ), 0, $postCharacterLimit ),
					'url' => $wgServer.$val['userpage'],
					'date' => $val['date'],
					'author' => $val['username'],
					'otherTags' => array(
						'image' => AvatarService::getAvatarUrl($val['username'], $userAvatarSize)
					)
				);
			}
			$this->showFeed( $format , wfMsg('feed-title-blogposts').' - '.$subTitleName, $feedArray);
		}
	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedRecentBadges ( $format ){

		global $wgUser, $wgOut, $wgExtensionsPath, $wgServer, $wgEnableAchievementsExt;

		if ( empty ($wgEnableAchievementsExt) ){
			$this->showMenu();
		} else {
			wfLoadExtensionMessages( 'AchievementsII' );
			// local settings
			$howOld = 30;
			$maxBadgesToDisplay = 6;
			$badgeImageSize = 56;
			$userNameLength = 22;
			$badgeNameLength = 29;
			$rankingService = new AchRankingService();

			// ignore welcome badges
			$blackList = array(BADGE_WELCOME);

			$awardedBadges = $rankingService->getRecentAwardedBadges( null, $maxBadgesToDisplay, $howOld, $blackList );

			$recents = array();
			$count = 1;

			$feedArray = array();
			// getRecentAwardedBadges can sometimes return more than $max items
			foreach ( $awardedBadges as $badgeData ) {
				$recents[] = $badgeData;
				$descriptionText = wfMsg('achievements-recent-info',
					$badgeData['user']->getUserPage()->getLocalURL(),
					substr($badgeData['user']->getName(), 0, $userNameLength),
					substr($badgeData['badge']->getName(), 0, $badgeNameLength),
					$badgeData['badge']->getGiveFor(),
					wfTimeFormatAgo($badgeData['date'])
				);
				$descriptionText = preg_replace('/<br\s*\/*>/i',"$1 $2",$descriptionText);
				$descriptionText = strip_tags($descriptionText);
				$feedArray[] = array (
					'title' => $badgeData['user']->mName ,
					'description' => $descriptionText,
					'url' => $badgeData['user']->getUserPage()->getFullURL(),
					'date' => $badgeData['date'],
					'author' => '',
					'otherTags' => array(
					    'image' => $badgeData['badge']->getPictureUrl($badgeImageSize),
					)
				);

				if ( $count++ >= $maxBadgesToDisplay ){
					break;
				}
			}
			$this->showFeed( $format , wfMsg('feed-title-recent-badges'),  $feedArray);
		}

	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedRecentImages ( $format ){
		
		global $wgTitle, $wgLang, $wgRequest;

		// local settings
		$maxImagesNumber = 20;
		$defaultWidth = 124;
		$defaultHeight = 72;

		$imageServing = new imageServing( array(), $defaultWidth, array("w" => $defaultWidth, "h" => $defaultHeight) );
		$dbw = wfGetDB( DB_SLAVE );

		$res = $dbw->select( 'image',
				array( "img_name", "img_user_text", "img_size", "img_width", "img_height" ),
				array(
					"img_media_type != 'VIDEO'",
					"img_width > 32",
					"img_height > 32"
				),
				false,
				array(
					"ORDER BY" => "img_timestamp DESC",
					"LIMIT" => $maxImagesNumber
				)
		);

		$thumbSize = $wgRequest->getText ( "size", false );
		
		if ( $defaultWidth ){
			$thumbSize = ( integer )$thumbSize;
		} else {
			$thumbSize = $defaultThumbSize;
		}

		$feedArray = array();
		
		while ( $row = $dbw->fetchObject( $res ) ) {
			
			$tmpTitle = Title::newFromText( $row->img_name, NS_FILE );
			$image = wfFindFile( $tmpTitle );

			if ( !$image ) continue;
			
			$testImage = wfReplaceImageServer(
				$image->getThumbUrl(
					$imageServing->getCut($row->img_width, $row->img_height)."-".$image->getName()
				)
			);

			$feedArray[] = array (
				'title' => '',
				'description' => '',
				'url' => '',
				'date' => $image->getTimestamp(),
				'author' => $row->img_user_text,
				'otherTags' => array(
						'image' => $testImage
					)
			);
		}

		$this->showFeed( $format , wfMsg( 'feed-title-recent-images' ),  $feedArray);
	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedHotContent ( $format ) {

		global $wgRequest;

		$defaultHubTitle ='tv';

		$hubTitle = $wgRequest->getVal( 'hub' );
		$allowedHubs = $this->allowedHubs();
		
		if ( isset( $allowedHubs[ $hubTitle ] ) && !is_array( $allowedHubs[ $hubTitle ] ) ){
			$oTitle = Title::newFromText( $hubTitle, 150 );
		} else {
			$oTitle = Title::newFromText( $defaultHubTitle, 150 );
		}
		$hubId = AutoHubsPagesHelper::getHubIdFromTitle( $oTitle );
		$feedArray = $this->PrepareHotContentFeed( $hubId );
		$this->showFeed( $format, wfMsg( 'feed-title-hot-content', $oTitle->getText() ), $feedArray );
	}
	
/**
 * @author Jakub Kurcek
 * @param hubId integer
 * @param forceRefresh boolean - if true clears the cache and creates new one.
 *
 * Returns data for feed creation. If no cache - creates one.
 */
	private function PrepareHotContentFeed ( $hubId, $forceRefresh = false ){

		global $wgMemc, $wgHTTPTimeout;

		// local settings
		$lang = "en";
		$thumbSize = 288;
		$thumbHeight = 124;
		$resultsNumber = 10;
		$stopCache = false; // switch to false after tests

		if ( $forceRefresh ) $this->clearCache( $hubId );
		$memcFeedArray = $this->getFromCache( $hubId );
		if ( $memcFeedArray == null  || !empty($stopCache) ){
		
			$datafeeds = new WikiaStatsAutoHubsConsumerDB( DB_SLAVE );
			$out = $datafeeds->getTopArticles($hubId, $lang, $resultsNumber);
			$feedArray = array();
			foreach( $out['value'] as $key => $val ){

				$httpResultArr = $this->getDataFromApi(
					$val['wikiurl'].'/api.php?action=imagecrop&imgId='.$val['page_id'].'&imgSize='.(integer)$thumbSize.'&imgHeight='.(integer)$thumbHeight.'&format=json'
				);

				$feedArray[] = array(
					'title' => $val['page_name'],
					'description' => $val['all_count'],
					'url' => $val['page_url'],
					'date' => time(),
					'author' => 'Wikia',
					'otherTags' => array(
						'image' => $httpResultArr
					)
				);
			}
			$this->saveToCache( $hubId, $feedArray );

		} else {
			$feedArray = $memcFeedArray;
		}
		return $feedArray;
	}

/**
 * @author Jakub Kurcek
 * @param url string url to data source
 */
	private function getDataFromApi( $url ){

		global $wgIsDevBoxEnvironment, $wgHTTPProxy;

		$retry = 0;

		// #rt:68146 retries to prevent empty results caused by error 503

		while( $retry <= 3 ) {

			if ( !empty( $wgIsDevBoxEnvironment ) ){
				$httpResult = Http::get( $url, 15, array(CURLOPT_PROXY => $wgHTTPProxy) );
			}else{
				$httpResult = Http::get( $url, 15 );
			}
			$httpResultArr = json_decode( $httpResult );

			// in case of proper data ( even empty ) 
			if ( isset( $httpResultArr->image->imagecrop ) ){
				return $httpResultArr->image->imagecrop;
			};
			$retry++;
		}
		// in case of error returns empty string
		return '';

	}
/**
 * @author Jakub Kurcek
 * @param hubId integer
 *
 * Public controller for forced caching of specified hub results. Used for maintance script.
 */
	public function ReloadHotContentFeed ( $hubId ){

		$this->PrepareHotContentFeed( (integer) $hubId , true);
		
	}

/**
 * @author Jakub Kurcek
 * @param hubId integer
 * @param content array
 *
 * Caching functions.
 */
	private function getKey( $hubId ) {
		
		return wfSharedMemcKey( 'widgetbox_hub_hotcontent', $hubId );
	}

	private function saveToCache( $hubId, $content ) {

		global $wgMemc;
		$memcData = $this->getFromCache( $hubId );
		if ( $memcData == null ){
			$wgMemc->set( $this->getKey( $hubId ), $content, 60*60*12);
			return false;
		}
		return true;
	}

	private function getFromCache ( $hubId ){

		global $wgMemc;
		return $wgMemc->get( $this->getKey( $hubId ) );
	}

	private function clearCache ( $hubId ){

		global $wgMemc;
		return $wgMemc->delete( $this->getKey( $hubId ) );
	}

/**
 * @author Jakub Kurcek
 *
 * Returns array of accepted hubs. 
 */

	public function allowedHubs (){

		global $wgHubsPages;
		return $wgHubsPages['en'];
	}
	
/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedAchivementsLeaderboard ( $format ) {

		global	$wgEnableAchievementsExt, $wgLang, $wgServer, $wgOut,
			$wgExtensionsPath, $wgStyleVersion, $wgSupressPageTitle,
			$wgUser, $wgWikiaBotLikeUsers, $wgJsMimeType;

		if ( empty($wgEnableAchievementsExt) ){
			$this->showMenu();
		} else {
			wfLoadExtensionMessages('AchievementsII');

			// local settings
			$maxEntries = 20;
			$howOld = 3;
			$userAvatarSize = 48;

			$rankingService = new AchRankingService();
			$ranking = $rankingService->getUsersRanking( 20, true );

			$levels = array( BADGE_LEVEL_PLATINUM, BADGE_LEVEL_GOLD, BADGE_LEVEL_SILVER, BADGE_LEVEL_BRONZE );
			$recents = array();

			foreach( $levels as $level ) {
				$limit = 3;
				$blackList = null;
				if( $level == BADGE_LEVEL_BRONZE ) {
					if( $maxEntries <= 0 ) break;

					$limit = $maxEntries;
					$blackList = array( BADGE_WELCOME );
				}

				$awardedBadges = $rankingService->getRecentAwardedBadges( $level, $limit, $howOld, $blackList );

				if ( $total = count ( $awardedBadges ) ) {
					$recents[$level] = $awardedBadges;
					$maxEntries -= $total;
				}
			}
			$feedArray = array();
			foreach( $ranking as $rank => $rankedUser ){
				++$rank;
				$name = htmlspecialchars( $rankedUser->getName() );
				$feedArray[] = array(
					'title' =>  $rank,
					'description' => $name,
					'url' => $wgServer.$rankedUser->getUserPageUrl(),
					'date' => time(),
					'author' => 'Wikia',
					'',
					'otherTags' => array(
						'image' =>AvatarService::getAvatarUrl( $rankedUser->getName(), $userAvatarSize ),
						'score' => $wgLang->formatNum( $rankedUser->getScore() )
					)
				);
			}
			$this->showFeed( $format , wfMsg('feed-title-leaderboard'),  $feedArray);
		}
	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 * @param subtitle string
 * @param feedData array
 *
 * returns RSS/Atom feed
 */
	private function showFeed( $format, $subtitle, $feedData ) {
		
		global $wgOut, $wgRequest, $wgParser, $wgMemc, $wgTitle, $wgSitename;
		
		wfProfileIn( __METHOD__ );
		$sFeedName = self::getFeedClass( $format );
		$feed = new $sFeedName( wfMsg('feed-main-title'),  $subtitle, $wgTitle->getFullUrl() );
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

	private static function getFeedClass ( $format ){
		
		if ( $format == 'atom' ){
			return 'PartnerAtomFeed';
		} else {
			return 'PartnerRSSFeed';
		}
	}
}

