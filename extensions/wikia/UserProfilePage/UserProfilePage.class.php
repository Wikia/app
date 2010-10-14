<?php

class UserProfilePage {
	/**
	 * @var User
	 */
	private $user;

	public function __construct( User $user ) {
		$this->user = $user;
	}

	public function get( $pageBody ) {
		global $wgOut, $wgSitename, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;

		//$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/UserProfilePage/js/UserProfilePage.js?{$wgStyleVersion}\" ></script>\n" );

		$userContribsProvider = new UserContribsProviderService;

		$template = new EasyTemplate( dirname(__FILE__) . "/templates/" );
		$template->set_vars(
			array(
				'wikiName'     => $wgSitename,
				'userName'     => $this->user->getName(),
				'userPageUrl'  => $this->user->getUserPage()->getLocalUrl(),
				'activityFeed' => $this->renderUserActivityFeed( $userContribsProvider->get( 6, $this->user ) ),
				'imageFeed'    => $this->populateImageFeedVars(),
				'wikiSwitch'   => $this->populateWikiSwitchVars(),
				'topPages'     => $this->getTopPages(),
				'aboutSection' => $this->populateAboutSectionVars(),
				'pageBody'     => $pageBody,
			));

		return $template->render( 'user-profile-page' );
	}

	/**
	 * render user's activity feed
	 * @param array $data
	 * @return string
	 */
	private function renderUserActivityFeed( Array $data ) {
		global $wgBlankImgUrl;
		wfProfileIn(__METHOD__);

		$template = new EasyTemplate( dirname(__FILE__) . "/templates/" );
		$template->set_vars(
			array(
				'data' => $data,
				'assets' => array( 'blank' => $wgBlankImgUrl )
			)
		);

		// add header and wrap
		//if (!empty($wrap)) {
		//	$content = $this->wrap($content, false);
		//}

		wfProfileOut(__METHOD__);
		return $template->render( 'user-contributions' );
	}

	private function populateAboutSectionVars() {
		global $wgOut;
		$sTitle = $this->user->getUserPage()->getText() . '/' . wfMsg( 'userprofilepage-about-article-title' );
		$oTitle = Title::newFromText( $sTitle, NS_USER );
		$oArticle = new Article($oTitle, 0);

		$oSpecialPageTitle = Title::newFromText( 'CreateFromTemplate', NS_SPECIAL );

		if( $oTitle->exists() ) {
			$sArticleBody = $wgOut->parse( $oArticle->getContent() );
			$sArticleEditUrl = $oTitle->getLocalURL( 'action=edit' );
		}
		else {
			$sArticleBody = wfMsg( 'userprofilepage-about-empty-section' );
			$sArticleEditUrl = $oSpecialPageTitle->getLocalURL( 'type=aboutuser&wpTitle=' . $oTitle->getPrefixedURL() . '&returnto=' . $this->user->getUserPage()->getFullUrl( 'action=purge' ) );
		}

		return array( 'body' => $sArticleBody, 'articleEditUrl' => $sArticleEditUrl );
	}

	/*
	private function populateActivityFeedVars() {
		return array('types' => array(	'all'    => $this->getRecentActivity(),
										'media'  => $this->getRecentActivity('media'),
										'create' => $this->getRecentActivity('create'),
										'tend'   => $this->getRecentActivity('tend'),
										'talk'   => $this->getRecentActivity('talk'),
					));
	}
	*/

	private function populateImageFeedVars() {
		return array('images' => $this->getRecentUploadedPhotos());
	}

	private function populateWikiSwitchVars() {
		return array( 'topWikis' => $this->getTopWikis() );
	}

	static public function outputPageHook( $skin, $template ) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('MyHome');

		// Return without any changes if this isn't in the user namespace OR
		// if the user is doing something besides viewing or purging this page
		$action = $wgRequest->getVal('action', 'view');
		if ($skin->mTitle->getNamespace() != NS_USER || ($action != 'view' && $action != 'purge')) {
			return true;
		}

		$user = User::newFromName( $skin->mTitle->getDBKey() );

		// sanity check
		if ( !is_object( $user ) ) {
			return true;
		}
		$user->load();

		$profilePage = new UserProfilePage( $user );
		$template->data['bodytext'] = $profilePage->get( $template->data['bodytext'] );

		wfProfileOut(__METHOD__);
		return true;
	}

	/*
	function getRecentActivity ($filter = false) {
		$feedProxy = new ActivityFeedAPIProxy();
		$feedProxy->APIparams['rcuser_text'] = $this->user->getName();

		$feedData = null;

		if ($filter == 'media') {
			$feedData['results'] = array();
			$data = array(); //RecentChangeDetail::getUserChanges($this->user->getId(), 'imageInserts', 5);


			foreach ($data as $detail) {
				$rc = $detail->recentChange();
				if (!$rc) continue;

				$key = $rc->getAttribute('rc_title');

				$result = null;
				if (!isset($feedData['results'][$key])) {
					$title = Title::makeTitle($rc->getAttribute('rc_namespace'),
											  $rc->getAttribute('rc_title'));

					$type = $rc->getAttribute('rc_type');
					switch ( $type ) {
						case RC_EDIT:  $type = 'edit'; break;
						case RC_NEW:   $type = 'new'; break;
					}

					$userLink = null;
					$userText = $rc->getAttribute('rc_user_text');
					$ut = Title::newFromText($userText, NS_USER);
					if($ut->isKnown()) {
						$userLink = Xml::element('a', array('href' => $ut->getLocalUrl(), 'rel' => 'nofollow'), $userText);
					} else {
						//$users[$res['user']] = Xml::element('a', array('href' => $ut->getLocalUrl(), 'rel' => 'nofollow', 'class' => 'new'), $res['user']);
						$userLink = Xml::element('a', array('href' => Skin::makeSpecialUrl('Contributions').'/'.$userText, 'rel' => 'nofollow'), $userText);
					}

					$result = array(
						'type'      => $type,
						'title'     => $title->getText(),
						'url'       => $title->getLocalUrl(),
						'diff'      => '',
						'timestamp' => $detail->timestamp,
						'user'      => $userLink,
						'ns'        => $detail->pageNs
					);
					$feedData['results'][$key] = $result;
				} else {
					$result = $feedData['results'][$key];
				}

				// Reuse code from the MyHome extension via DataFeedProvider
				$imageName = $detail->value;
				if($imageName{0} == ':') { // video
					$video = DataFeedProvider::getVideoThumb(substr($imageName, 1));
					if (isset($video))
						$result['new_videos'][] = $video;
				} else {
					$image = DataFeedProvider::getImageThumb($imageName);
					if (isset($image))
						$result['new_images'][] = $image;
				}

				// Set this back in case $result was null before
				$feedData['results'][$key] = $result;
 			}
		} elseif ($filter == 'create') {
			$feedProxy->APIparams['rcnamespace'] = NS_MAIN;
			$feedProxy->APIparams['rctype'] = 'new';
		} elseif ($filter == 'tend') {
			$feedProxy->APIparams['rcshow'] = '!bot|minor';
		} elseif ($filter == 'talk') {
			$feedProxy->APIparams['rcnamespace'] = NS_USER_TALK;
		}

		if (!isset($feedData)) {
			$feedProvider = new DataFeedProvider($feedProxy);
			$feedData = $feedProvider->get(5);
		}

		$parameters = null;
		$feedRenderer = new ActivityFeedRenderer();

		if (count($feedData['results'])) {
			return $feedRenderer->render($feedData, false, $parameters);
		} else {
			return '';
		}
	}
	*/

	public function getRecentUploadedPhotos() {
		$dbs = wfGetDB(DB_SLAVE);
		$res = $dbs->select(
			array( 'recentchanges' ),
			array( 'rc_title' ),
			array( 'rc_user'      => $this->user->getId(),
				   'rc_namespace' => NS_FILE,
				   'rc_type'      => RC_LOG),
			__METHOD__,
			array(
				'ORDER BY' => 'rc_timestamp DESC',
				'LIMIT'    => 5
			)
		);

		$photos = array();
		while($row = $dbs->fetchObject($res)) {
			$img = wfFindFile($row->rc_title);

			if ($img->getHeight() > $img->getWidth()) {
				$thumbWidth = 96;
				$thumbHeight = round(96*($img->getHeight()/$img->getWidth()));
				$pad = round(($thumbHeight - $thumbWidth)/2);
				$clip     = $pad."px 96px ".(96+$pad)."px 0px";
				$top_pad  = '-'.$pad.'px';
				$left_pad = '0px';
			} else {
				$thumbHeight = 96;
				$thumbWidth = round(96*($img->getWidth()/$img->getHeight()));
				$pad = round(($thumbWidth - $thumbHeight)/2);
				$clip     = "0px ".(96+$pad)."px 96px ".$pad."px";
				$top_pad  = '0px';
				$left_pad = '-'.$pad.'px';
			}

			$thumb = $img->transform(array(	'width'  => $thumbWidth,
											'height' => $thumbHeight));
			$thumbUrl = $thumb->getUrl();
			$thumbUrl = preg_replace('/images\d+.wikia.nocookie.net/', 'garth.wikia-dev.com', $thumbUrl);

			$photos[] = array('name'     => $row->rc_title,
							  'thumbUrl' => $thumbUrl,
							  'height'   => $thumbHeight,
							  'width'    => $thumbWidth,
							  'clip'     => $clip,
				              'topPad'  => $top_pad,
				              'leftPad' => $left_pad
							 );
		}

		return $photos;
	}

	public function getTopPages() {
		global $wgMemc, $wgStatsDB, $wgCityId, $wgContentNamespaces;

		//select page_id, count(page_id) from stats.events where wiki_id = N and user_id = N and event_type in (1,2) group by 1 order by 2 desc limit 10;
		$dbs = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$res = $dbs->select(
			array( 'stats.events' ),
			array( 'page_id', 'count(page_id) AS count' ),
			array(
				'wiki_id' => $wgCityId,
				'user_id' => $this->user->getId() ),
				'event_type IN (1,2)',
				'page_ns IN (' . join( ',', $wgContentNamespaces ) . ')',
			__METHOD__,
			array(
				'GROUP BY' => 'page_id',
				'ORDER BY' => 'count DESC',
				'LIMIT' => 6
			)
		);

		/* revision
		$dbs = wfGetDB( DB_SLAVE );
		$res = $dbs->select(
			array( 'revision' ),
			array( 'rev_page', 'count(*) AS count' ),
			array( 'rev_user' => $this->user->getId() ),
			__METHOD__,
			array(
				'GROUP BY' => 'rev_page',
				'ORDER BY' => 'count DESC',
				'LIMIT' => 6
			)
		);
		*/

		$pages = array();
		while($row = $dbs->fetchObject($res)) {
			$pageId = $row->page_id;
			$title = Title::newFromID( $pageId );
			if( ( $title instanceof Title ) && ( $title->getArticleID() != 0 ) ) {
				$pages[ $pageId ] = array( 'id' => $pageId, 'url' => $title->getFullUrl(), 'title' => $title->getText(), 'imgUrl' => null, 'editCount' => $row->count );
			}
		}

		if( class_exists('imageServing') ) {
			// ImageServing extension enabled, get images
			$imageServing = new imageServing( array_keys( $pages ), 100, array( 'w' => 1, 'h' => 1 ) );
			$images = $imageServing->getImages(1); // get just one image per article

			foreach( $pages as $pageId => $data ) {
				if( isset( $images[$pageId] ) ) {
					$image = $images[$pageId][0];
					$data['imgUrl'] = $image['url'];
				}
				$pages[ $pageId ] = $data;
			}
		}

		return $pages;
	}

	public function getTopWikis() {
		global $wgExternalDatawareDB;

		// alternate query:
		// SELECT city_id, sum(edit_count) from user_edits_summary where user_id='259228' group by 1 order by 2 desc limit 10;

		// SELECT lu_wikia_id, lu_rev_cnt FROM city_local_users WHERE lu_user_id=$userId ORDER BY lu_rev_cnt DESC LIMIT $limit;
		$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
		$res = $dbs->select(
			array( 'city_local_users' ),
			array( 'lu_wikia_id', 'lu_rev_cnt' ),
			array( 'lu_user_id' => $this->user->getId() ),
			__METHOD__,
			array(
				'ORDER BY' => 'lu_rev_cnt DESC',
				'LIMIT' => 4
			)
		);

		$wikis = array();
		while($row = $dbs->fetchObject($res)) {
			$wikiId = $row->lu_wikia_id;
			$editCount = $row->lu_rev_cnt;
			$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
			$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
			$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
			$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'editCount' => $editCount );
		}

		// tmp - local only
		$wikis = array( 4832 => 72, 3613 => 60, 4036 => 35, 177 => 72 ); // test data
		foreach($wikis as $wikiId => $editCount) {
			$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
			$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
			$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
			$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'editCount' => $editCount );
		}
		//

		return $wikis;
	}

}
