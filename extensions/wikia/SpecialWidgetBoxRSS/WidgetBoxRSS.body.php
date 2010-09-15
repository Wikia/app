<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 * Returns WidgetBox formatted RSS / Atom Feeds
 */

class WidgetBoxRSS extends SpecialPage {
	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
	var $err;

	function  __construct() {
		parent::__construct( "WidgetBoxRSS" , '' /*restriction*/);
		wfLoadExtensionMessages("WidgetBoxRSS");
	}

	function execute() {
		global $wgLang, $wgAllowRealName, $wgRequest, $wgOut;

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
				default :
					$this->showFeed( $feed );
				break;
			}
		} else {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$wgOut->addHTML( $oTmpl->execute( "main-page" ) );
		}
		return;
		
	}
/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 *
 */
	private function FeedRecentBlogPosts ( $format ){
		
		global $wgParser, $wgUser, $wgOut, $wgExtensionsPath, $wgRequest;

		// local settings
		$maxNumberOfBlogPosts = 10;

		$sArticle = $wgRequest->getVal( 'article' );
		if ( !empty( $sArticle ) ){
			$oBlogListing = new CreateBlogListingPage;
			$oBlogListing->setFormData('listingAuthors', '');
			$oBlogListing->setFormData('tagContent', '');
			$oBlogListing->parseTag( urldecode( $sArticle ) );

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
				$aValue = explode('/' , $val['title']);

				$feedArray[] = array(
					'title' =>  str_replace( '&nbsp;', ' ', strip_tags( $aValue[1] ) ),
					'description' => str_replace( '&nbsp;', ' ', strip_tags( $val['text'] ) ),
					'url' => 'http://'.$_SERVER['HTTP_HOST'].$val['userpage'],
					'date' => $val['date'],
					'author' => $val['username'],
					'otherTags' => array(
						'image' => $val['avatar'],
					)
				);
			}
			$this->showFeed( $format , wfMsg('feed-title-blogposts'),  $feedArray);
		} else {
			Wikia::log( __METHOD__, false, wfMsg('error-no-article') );
		}
	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedRecentBadges ( $format ){

		global $wgUser, $wgOut, $wgExtensionsPath;
		wfLoadExtensionMessages( 'AchievementsII' );

		// local settings
		$howOld = 30;
		$maxBadgesToDisplay = 6;
		$badgeImageSize = 40;
		
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
				$badgeData['user']->getName(),
				$badgeData['badge']->getName(),
				$badgeData['badge']->getGiveFor(),
				wfTimeFormatAgo($badgeData['date'])
			);
			$feedArray[] = array (
				'title' => $badgeData['user']->mName ,
				'description' => strip_tags( str_replace( "<br />" , " ", $descriptionText ) ),
				'url' => 'http://'.$_SERVER['HTTP_HOST'].$badgeData['user']->getUserPage()->getLocalURL(),
				'date' => $badgeData['date'],
				'author' => '',
				'otherTags' => array(
				    'image' => 'http://'.$_SERVER['HTTP_HOST'].$badgeData['badge']->getPictureUrl($badgeImageSize),
				)
			);

			if ( $count++ >= $maxBadgesToDisplay ){
				break;
			}
		}

		$this->showFeed( $format , wfMsg('feed-title-recent-badges'),  $feedArray);

	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedRecentImages ( $format ){
		
		global $wgTitle, $wgLang, $wgRequest;
		
		// local settings
		$maxImagesNumber = 20;
		$defaultThumbSize = 150;

		$dbw = wfGetDB( DB_SLAVE );
		$res = $dbw->select( array( 'image' ),
				array( "img_name", "img_user_text", "img_size", "img_width", "img_height"  ),
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

		$feedArray = array();
		
		$thumbSize = $wgRequest->getText ( "size", false );
		
		if ( $thumbSize ){
			$thumbSize = ( integer )$thumbSize;
		} else {
			$thumbSize = $defaultThumbSize;
		}
		
		while ( $row = $dbw->fetchObject( $res ) ) {
			
			$tmp = Title::newFromText( $row->img_name, NS_FILE );
			$image = wfFindFile( $tmp );
			if( !$image ) continue;

			// get thumbnail limited only by given width
			if ( $image->width > $thumbSize ) {
				$imageHeight = round( $image->height * ($thumbSize / $image->width) );
				$imageWidth = $thumbSize;
			} else {
				$imageHeight = $image->height;
				$imageWidth = $image->width;
			}

			$thumb = $image->getThumbnail($imageWidth, $imageHeight);
			//$HTMLimage = "<img src='".$thumb->url."' />";
			$feedArray[] = array (
				'title' => '',
				'description' => '',
				'url' => $thumb->url,
				'date' => $image->getTimestamp(),
				'author' => $image->author,
				'otherTags' => array(
						'image' => $thumb->url
					)
			);
		}
		Wikia::log('::::::::::::::::::::::::::!!!!');
		$this->showFeed( $format , wfMsg('feed-title-recent-images'),  $feedArray);
	}

/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedHotContent ( $format ) {

		global $wgRequest;

		$hubTitle = $wgRequest->getVal( 'hub' );
		$allowedHubs = $this->allowedHubs();
		if ( isset( $allowedHubs[ $hubTitle ] ) ){
			$hubId = $allowedHubs[ $hubTitle ];
		} else {
			$hubId = reset( $allowedHubs );
			$hubTitle = key( $allowedHubs );
		}
		
		$feedArray = $this->PrepareHotContentFeed( $hubId );
		$this->showFeed( $format, 'Achivements leaderboard - '. $hubTitle,  $feedArray );
	}
	
/**
 * @author Jakub Kurcek
 * @param hubId integer
 * @param forceRefresh boolean - if true clears the cache and creates new one.
 *
 * Returns data for feed creatinon. If no cache - creates one.
 */
	private function PrepareHotContentFeed ( $hubId, $forceRefresh = false ){

		global $wgMemc;

		// local settings
		$lang = "en";
		$thumbSize = 75;
		$resultsNumber = 10;
		$isDevBox = true; // switch to false after tests

		if ( $forceRefresh ) $this->clearCache( $hubId );
		$memcFeedArray = $this->getFromCache( $hubId );
		if ( $memcFeedArray == null ){
		
			$datafeeds = new WikiaStatsAutoHubsConsumerDB( DB_SLAVE );
			$out = $datafeeds->getTopArticles($hubId, $lang, $resultsNumber);
			$feedArray = array();
			foreach( $out['value'] as $key => $val ){

				if ( $isDevBox ){ // fake DevBox data
					$fakePageId = array( 119949, 119950, 32, 49, 83, 54 );
					$httpResult = Http::get( 'http://muppets.jakub.wikia-dev.com/api.php?action=imagecrop&imgId='.$fakePageId[rand(0,5)].'&imgSize='.$thumbSize.'&format=json&timestamp='.rand( 0,time() ) );
				}else{
					$httpResult = Http::get( $val['wikiurl'].'/api.php?action=imagecrop&imgId='.$val['page_id'].'&imgSize=75&format=json' );
				}
				$httpResultArr = json_decode( $httpResult );
				$feedArray[] = array(
					'title' =>  $val['page_name'],
					'description' => $val['all_count'],
					'url' => $val['page_url'],
					'date' => time(),
					'author' => 'Wikia',
					'otherTags' => array(
						'image' => ( isset($httpResultArr->image->imagecrop ) ) ? $httpResultArr->image->imagecrop : ''
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
 * @param hubId integer
 *
 * Public controller for forced caching of specified hub results. Used for maintance script.
 */

	public function ReloadHotContentFeed ( $hubId ){
		
		$this->PrepareHotContentFeed( (integer)$hubId , true);
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
			$wgMemc->set( $this->getKey( $hubId ), $content );
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
 * Returns array of accepted hubs. key is Id and val is title.
 */

	public function allowedHubs (){
		return 	array(	"PC Games" => 1,
				"Wii Games" => 3,
				"Handheld" => 4,
				"Television" => 6,
				"Anime" => 9,
				"PS3 Games" => 16,
				"Horror" => 26,
				"Music" => 29,
				"Lifestyle" => 127,
				"Entertainment" => 129,
				"Gaming" => 131	,
				"Xbox 360 Games" => 143,
				"Sci-Fi" => 144,
				"Movies" => 147
			);
	}
/**
 * @author Jakub Kurcek
 * @param format string 'rss' or 'atom'
 */
	private function FeedAchivementsLeaderboard ( $format ) {

		global $wgLang, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgSupressPageTitle, $wgUser, $wgWikiaBotLikeUsers, $wgJsMimeType;
		wfLoadExtensionMessages('AchievementsII');

		// local settings
		$maxEntries = 20;
		$howOld = 30;
		
		$rankingService = new AchRankingService();
		$ranking = $rankingService->getUsersRanking(20, true);
		//var_dump($ranking); exit;
		// recent
		$levels = array(BADGE_LEVEL_PLATINUM, BADGE_LEVEL_GOLD, BADGE_LEVEL_SILVER, BADGE_LEVEL_BRONZE);
		$recents = array();
		
		foreach($levels as $level) {
			$limit = 3;
			$blackList = null;
			if($level == BADGE_LEVEL_BRONZE) {
				if($maxEntries <= 0) break;

				$limit = $maxEntries;
				$blackList = array(BADGE_WELCOME);
			}

			$awardedBadges = $rankingService->getRecentAwardedBadges($level, $limit, 3, $blackList);

			if ( $total = count ( $awardedBadges ) ) {
				$recents[$level] = $awardedBadges;
				$maxEntries -= $total;
			}
		}
		$feedArray = array();
		foreach($ranking as $rank => $rankedUser){
			++$rank;
			$name = htmlspecialchars( $rankedUser->getName() );
			
			$feedArray[] = array(
				'title' =>  $rank,
				'description' => $name,
				'url' => 'http://'.$_SERVER['HTTP_HOST'].$rankedUser->getUserPageUrl(),
				'date' => time(),
				'author' => 'Wikia',
				'',
				'otherTags' => array(
					'image' => $rankedUser->getAvatarUrl(),
					'score' => $wgLang->formatNum($rankedUser->getScore())
				)
			);			
  		}

		$this->showFeed( $format , wfMsg('feed-title-leaderboard'),  $feedArray);
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
		global $wgOut, $wgRequest, $wgParser, $wgMemc, $wgTitle;
		global $wgSitename;
		Wikia::log('::::::::::::::::::::::::::-1');
		wfProfileIn( __METHOD__ );
		Wikia::log('::::::::::::::::::::::::::0');
		$sFeedName = self::getFeedClass( $format );
		$feed = new $sFeedName( wfMsg('feed-main-title'),  $subtitle, $wgTitle->getFullUrl() );
		Wikia::log('::::::::::::::::::::::::::1');
		$feed->outHeader();
		Wikia::log('::::::::::::::::::::::::::2');
		foreach ( $feedData as $val ){
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
		Wikia::log('::::::::::::::::::::::::::3');
		$feed->outFooter();
		Wikia::log('::::::::::::::::::::::::::4');
		wfProfileOut( __METHOD__ );
	}

	private static function getFeedClass ( $format ){
		global $wgFeedClasses;
		return 'WidgetBox'.$wgFeedClasses[ $format ];
	}
}

