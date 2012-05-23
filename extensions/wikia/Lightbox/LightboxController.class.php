<?php

/**
 * Lightbox controller
 * @author Hyun
 * @author Liz
 */
class LightboxController extends WikiaController {
	
	const THUMBNAIL_WIDTH = 90;
	const THUMBNAIL_HEIGHT = 55;
	
	public function __construct() {
	}
	
	
	public function lightboxModalContent() {
		// TODO: get article name from request
		$mediaTitle = $this->request->getVal('mediaTitle');
		$articleTitle = $this->request->getVal('articleTitle');
		$carouselType = $this->request->getVal('carouselType');
		
		switch($carouselType) {
			case "articleMedia":
				$method = "getArticleMediaThumbs";
				break;
			case "relatedVideos":
				$method = "getRelatedVideosThumbs";
				break;
			case "latestPhotos":
				$method = "getLatestPhotosThumbs";
				break;
		} 
		
		$initialFileDetail = array();
		if(!empty($mediaTitle)) {
			// send request to getImageDetail()
			$initialFileDetail = $this->app->sendRequest('Lightbox', 'getMediaDetail', array('title' => $mediaTitle))->getData();
			$mediaThumbs = $this->app->sendRequest('Lightbox', $method, array('title' => $articleTitle))->getData();
		}
		
		$this->initialFileDetail = $initialFileDetail;
		$this->mediaThumbs = $mediaThumbs;
	}


	/**
	 * @brief - Returns a list of relatedVideos for the wiki
	 * @responseParam array thumbs - thumbnail data
	 */	
	public function getRelatedVideosThumbs() {
		wfProfileIn(__METHOD__);
		// sample data
		$thumbs = array(
			array(
				'thumbUrl' => '',	// 90x55 images
				'type' => 'video',
				'title' => 'video name',
				'playButtonSpan' => WikiaFileHelper::videoPlayButtonOverlay(90, 55),
			),
			array(
				'thumbUrl' => '',
				'type' => 'image',
				'title' => 'an image name',
				'playButtonSpan' => WikiaFileHelper::videoPlayButtonOverlay(90, 55),
			),
			array(
				'thumbUrl' => '',
				'type' => 'image',
				'title' => 'an image name',
				'playButtonSpan' => WikiaFileHelper::videoPlayButtonOverlay(90, 55),
			),
		);
	
		$this->response->setVal( 'thumbs', $thumbs );
		wfProfileOut(__METHOD__);
	}


	/**
	 * @brief - Returns a list of latest photos for the wiki
	 * @requestParam string wikiName - DB name of the wiki.  (optional, default to current wiki if null)
	 * @responseParam array thumbs - thumbnail data
	 */	
	public function getLatestPhotosThumbs() {
	
		// sample data
		$thumbs = array(
			array(
				'thumbUrl' => '',	// 90x55 images
				'type' => 'video',
				'title' => 'video name',
				'playButtonSpan' => '',
			),
			array(
				'thumbUrl' => '',
				'type' => 'image',
				'title' => 'an image name',
				'playButtonSpan' => '',
			),
			array(
				'thumbUrl' => '',
				'type' => 'image',
				'title' => 'an image name',
				'playButtonSpan' => '',
			),
		);
	
		$this->thumbs = $thumbs;
	}
	
	protected static function getArticleMediaThumbsMemcKey($title) {
		return F::app()->wf->MemcKey( 'ArticleMediaThumbs', '1.0', $title->getDBkey() );
	}
	
	public static function onArticleEditUpdates( &$article, &$editInfo, $changed ) {
		// article links are updated, so we invalidate the cache
		F::app()->wg->memc->delete( self::getArticleMediaThumbsMemcKey( $article->getTitle() ) );
		return true;
	}
	
	/**
	 * @brief - Returns a list of all media for the article.
	 * @requestParam string title - title of the Article
	 * @responseParam array thumbs - thumbnail data
	 */
	public function getArticleMediaThumbs() {
		/*
		 * getArticleMediaThumbs() should return a list of thumbnail data in context of the current article.
		* The response format should be the same.  There is no maximum, and it should return ALL items pertaining
		* to that article.  The title of the article will be part of the request parameter to that method.
		*/
		wfProfileIn(__METHOD__);
		
		$thumbs = null;
		
		$title = F::build('Title', array( $this->request->getVal('title') ), 'newFromText');
		if ( $title ) {
			$memcKey = self::getArticleMediaThumbsMemcKey( $title );
			$thumbs = $this->wg->memc->get( $memcKey );
			if ( empty( $thumbs ) ) {
				$mediaQuery =  F::build( 'MediaQueryService' );
				$mediaTable = $mediaQuery->getMediaFromArticle($title);
				$thumbs = array();
				foreach ($mediaTable as $entry) {
					$media = F::build('Title', array($entry['title'], NS_FILE), 'newFromText');
					$file = wfFindFile($media);
					if ( !empty( $file ) ) {
						$trans = $file->transform( array( 'width' => self::THUMBNAIL_HEIGHT, 'height'=> self::THUMBNAIL_WIDTH ) );
						$thumbs[] = array(
								'thumbUrl' => $trans->url,
								'type' => $entry['type'],
								'title' => $media->getText(),
								'playButtonSpan' => $entry['type'] == 'video' ? WikiaFileHelper::videoPlayButtonOverlay(90, 55) : '',
						);
					}
				}
				$this->wg->memc->set($memcKey, $thumbs);
			}
		}
		
		$this->response->setVal( 'thumbs', empty($thumbs) ? array() : $thumbs );
		
		wfProfileOut(__METHOD__);
		
	}
	
	
	/**
	 * @brief - Returns complete details about a single media (file).  JSON only, no associated template to this method.
	 * @requestParam string title
	 * @requestParam string sourceArticleId (optional) - article id that the file belongs to
	 * @responseParam string mediaType - media type.  either image or video
	 * @responseParam string videoEmbedCode - embed html code if video
	 * @responseParam string imageUrl - thumb image url that is hard scaled
	 * @responseParam string fileUrl - url to file page
	 * @responseParam string caption - video caption
	 * @responseParam string description - video description (apparantly, this is just file page content, look in spec or ask Yoko)
	 * @responseParam string userThumbUrl - user avatar thumbUrl scaled to 30x30
	 * @responseParam string userName - user name
	 * @responseParam string userPageUrl - url to user profile page
	 * @responseParam array articles - array of articles that has title and url
	 */
	public function getMediaDetail() {
		$fileTitle = $this->request->getVal('title', '');
		$title = F::build('Title', array($fileTitle, NS_FILE), 'newFromText');
		
		$data = WikiaFileHelper::getMediaDetail($title, array('imageMaxWidth'  => 1000,
									'contextWidth'   => $this->request->getVal('width', 660),
									'contextHeight'  => $this->request->getVal('height', 360),
									'userAvatarWidth'=> 16
							));
							
		$articles = $data['articles'];
		$smallerArticleList = array();
		$articleListIsSmaller = 0;
		if(!empty($articles)) {
			$numOfArticles = count($articles);
			for($i = 0; $i < $numOfArticles && $i < 2; $i++) {
				$smallerArticleList[] = $articles[$i];
			}
			$articleListIsSmaller = $numOfArticles > 2 ? 1 : 0;
		}

		/* temporary placeholders */
		$caption = 'CAPTION HERE?';
		$description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a diam lectus. Sed sit amet ipsum mauris. Maecenas congue ligula ac quam viverra nec consectetur ante hendrerit. Donec et mollis dolor. Praesent et diam eget libero egestas mattis sit amet vitae augue. Nam tincidunt congue enim, ut porta lorem lacinia consectetur. Donec ut libero sed arcu vehicula ultricies a non tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut gravida lorem. Ut turpis felis, pulvinar a semper sed, adipiscing id dolor. Pellentesque auctor nisi id magna consequat sagittis. Curabitur dapibus enim sit amet elit pharetra tincidunt feugiat nisl imperdiet. Ut convallis libero in urna ultrices accumsan. Donec sed odio eros. Donec viverra mi quis quam pulvinar at malesuada arcu rhoncus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In rutrum accumsan ultricies. Mauris vitae nisi at sem facilisis semper ac in est.';
		$articles = array(
			array('articleUrl' => '/wiki/CArticle_626', 'articleTitle' => 'Some Article'),
			array('articleUrl' => '/wiki/CArticle_627', 'articleTitle' => 'Some Article2')
		);
		/* /placeholders */
		
		$this->fileTitle = $fileTitle;
		$this->mediaType = $data['mediaType'];
		$this->videoEmbedCode = $data['videoEmbedCode'];
		$this->playerAsset = $data['playerAsset'];
		$this->imageUrl = $data['imageUrl'];
		$this->fileUrl = $data['fileUrl'];
		$this->rawImageUrl = $data['rawImageUrl'];
		$this->description = $data['description'];
		$this->userThumbUrl = $data['userThumbUrl'];
		$this->userName = $data['userName'];
		$this->userPageUrl = $data['userPageUrl'];
		$this->articles = $data['articles'];
		$this->smallerArticleList = $smallerArticleList;
		$this->articleListIsSmaller = $articleListIsSmaller;
	}
	
	/**
	 * @brief - Returns complete details about a single media (file).  JSON only, no associated template to this method.
	 * @requestParam string fileTitle
	 * @requestParam string articleTitle
	 * @responseParam string networks - contains id(facebook, twitter, etc) and url
	 */
	public function getShareNetworks() {
		$fileTitle = $this->request->getVal('fileTitle');
		$articleTitle = $this->request->getVal('articleTitle');
		$title = F::build('Title', array($articleTitle), 'newFromText');
		
		$networks = array();	// return value
		
		$fileParam = preg_replace('/[^a-z0-9_]/i', '-', Sanitizer::escapeId($fileTitle));
		$link = $title->getFullURL("file=$fileParam");
		$linkDescription = wfMsg('lightbox-share-description', $title->getText(), $this->wg->Sitename);
		
		$shareNetworks = F::build( 'SocialSharingService' )->getNetworks( array(
			'facebook',
			'twitter',
			'stumbleupon',
			'reddit'
		) );
		foreach($shareNetworks as $network) {
			$networks[] = array(
				'id' => $network->getId(),
				'url' => $network->getUrl($link, $linkDescription)
			);
		}
		
		$this->networks = $networks;
	}
}