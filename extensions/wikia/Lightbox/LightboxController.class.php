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
		$articleId = $this->request->getVal('articleId');
		$carouselType = $this->request->getVal('carouselType');
		
		switch($carouselType) {
			case "articleMedia":
				$method = "getArticleMediaThumbs";
				break;
			case "relatedVideo":
				$method = "getRelatedVideosThumbs";
				break;
			case "latestPhotos":
			default:
				$method = "getLatestPhotosThumbs";
				break;
		} 
		
		$initialFileDetail = array();
		$mediaThumbs = array();
		if(!empty($mediaTitle)) {
			// send request to getImageDetail()
			$initialFileDetail = $this->app->sendRequest('Lightbox', 'getMediaDetail', array('title' => $mediaTitle))->getData();
			$mediaThumbs = $this->app->sendRequest('Lightbox', $method, array('title' => $articleTitle, 'articleId' => $articleId))->getData();
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

		$articleId = $this->request->getVal('articleId');

		$rvs = new RelatedVideosService();
		$data = $rvs->getRVforArticleId( $articleId );
		$mediaTable = array();
		foreach( $data as $video) {
			$mediaTable[] = array(
				'title' => $video['id'],
				'type' => 'video'
			);
		}
		$thumbs = $this->mediaTableToThumbs( $mediaTable );
	
		$this->response->setVal( 'thumbs', $thumbs );
		wfProfileOut(__METHOD__);
	}


	/**
	 * @brief - Returns a list of latest photos for the wiki
	 * @requestParam string wikiName - DB name of the wiki.  (optional, default to current wiki if null)
	 * @responseParam array thumbs - thumbnail data
	 */	
	public function getLatestPhotosThumbs() {
		$mediaQuery =  F::build( 'MediaQueryService' ); /* @var $mediaQuery MediaQueryService */
		$mediaTable = $mediaQuery->getRecentlyUploadedAsMediaTable(29);
		$thumbs = $this->mediaTableToThumbs( $mediaTable );

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
				$mediaQuery =  F::build( 'MediaQueryService' ); /* @var $mediaQuery MediaQueryService */
				$mediaTable = $mediaQuery->getMediaFromArticle($title);
				$thumbs = $this->mediaTableToThumbs( $mediaTable );
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

		// create a truncated list, and mark it if necessary (this is mostly for display, because mustache is a logicless templating system)
		// TODO: hyun - maybe move this to JS?
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
		
		// file details
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
	 * @brief - Returns pre-formatted social sharing urls and codes
	 * @requestParam string fileTitle
	 * @requestParam string articleTitle	(optional)
	 * @responseParam string url - raw url that is automically determined.  This is determined to be either article url or file page url.
	 * @responseParam string articleUrl - url to article page
	 * @responseParam string fileUrl - url to file page
	 * @responseParam string embedMarkup - embedable markup
	 * @responseParam string networks - contains id(facebook, twitter, etc) and urls of external social networks
	 */
	public function getShareCodes() {
		$fileTitle = $this->request->getVal('fileTitle', '');
		$file = wfFindFile($fileTitle);
		
		$shareUrl = '';
		$articleUrl = '';
		$embedMarkup = '';
		$fileUrl = '';
		$networks = array();
		
		if(!empty($file)) {
			$fileTitleObj =  F::build('Title', array($fileTitle, NS_FILE), 'newFromText');
			$articleTitle = $this->request->getVal('articleTitle');
			$articleTitleObj = F::build('Title', array($articleTitle), 'newFromText');
			
			if(!empty($articleTitleObj) && $articleTitleObj->exists()) {
				$fileParam = preg_replace('/[^a-z0-9_]/i', '-', Sanitizer::escapeId($fileTitle));
				$articleUrl = $articleTitleObj->getFullURL("file=$fileParam");
			}
			$fileUrl = $fileTitleObj->getFullURL();
			
			// determine share url
			$sharingNamespaces = array(
				NS_MAIN,
				NS_CATEGORY,
			);
			$shareUrl = !empty($articleUrl) && in_array($articleTitleObj->getNamespace(), $sharingNamespaces) ? $articleUrl : $fileUrl;
			
			$thumb = $file->getThumbnail(300, 250);
			$thumbUrl = $thumb->getUrl();
			$embedMarkup = "<a href=\"$shareUrl\"><img width=\"" . $thumb->getWidth() . "\" height=\"" . $thumb->getHeight() . "\" src=\"$thumbUrl\"/></a>";
			$linkDescription = wfMsg('lightbox-share-description', empty($articleUrl) ? $fileTitleObj->getText() : $articleTitleObj->getText(), $this->wg->Sitename);
			
			$shareNetworks = F::build( 'SocialSharingService' )->getNetworks( array(
				'facebook',
				'twitter',
				'stumbleupon',
				'reddit'
			) );
			foreach($shareNetworks as $network) {
				$networks[] = array(
					'id' => $network->getId(),
					'url' => $network->getUrl($shareUrl, $linkDescription)
				);
			}
		}
		
		$this->shareUrl = $shareUrl;
		$this->embedMarkup = $embedMarkup;
		$this->articleUrl = $articleUrl;
		$this->fileUrl = $fileUrl;
		$this->networks = $networks;
	}

	protected function mediaTableToThumbs( $mediaTable ) {
		$thumbs = array();
		foreach ($mediaTable as $entry) {
			if (is_string($entry['title'])) {
				$media = F::build('Title', array($entry['title'], NS_FILE), 'newFromText');
			} else {
				$media = $entry['title'];
			}
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
		return $thumbs;
	}

}