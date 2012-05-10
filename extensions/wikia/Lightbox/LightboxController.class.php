<?php

/**
 * Lightbox controller
 * @author Hyun
 * @author Liz
 */
class LightboxController extends WikiaController {

	public function __construct() {
	}
	
	
	public function lightboxModalContent() {
		$title = $this->request->getVal('title');
		$initialFileDetail = array();
		if(!empty($title)) {
			// send request to getImageDetail()
			$initialFileDetail = $this->app->sendRequest('Lightbox', 'getMediaDetail', array('title' => $title))->getData();
			$mediaThumbs = $this->app->sendRequest('Lightbox', 'getArticleMediaThumbs')->getData();
		}
		
		$this->initialFileDetail = $initialFileDetail;
		$this->mediaThumbs = $mediaThumbs;
	}


	/**
	 * @brief - Returns a list of all media for the wiki
	 * @requestParam string wikiName - DB name of the wiki.  (optional, default to current wiki if null)
	 * @responseParam array thumbs - thumbnail data
	 */	
	public function getWikiMediaThumbs() {
	
		// sample data
		$thumbs = array(
			array(
				'thumbUrl' => '',	// 90x55 images
				'type' => 'video',
				'title' => 'video name'
			),
			array(
				'thumbUrl' => '',
				'type' => 'image',
				'title' => 'an image name'
			),
			array(
				'thumbUrl' => '',
				'type' => 'image',
				'title' => 'an image name'
			),
		);
	
		$this->thumbs = $thumbs;
	}
	
	
	/**
	 * @brief - Returns a list of all media for the article.
	 * @requestParam string title - title of the Article
	 * @responseParam array thumbs - thumbnail data
	 */
	public function getArticleMediaThumbs() {
	
		// sample data
		$thumbs = array(
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120427205649/devbox/images/thumb/2/27/IMG_1535.jpg/90px-IMG_1535.jpg', // 90x55 images
				'type' => 'image',
				'title' => '500x1700.jpeg'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120423092715/devbox/images/thumb/1/19/Avatar.jpg/90px-Avatar.jpg',	
				'type' => 'image',
				'title' => 'IMG 1535.jpg'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120427205649/devbox/images/thumb/2/27/IMG_1535.jpg/90px-IMG_1535.jpg',	
				'type' => 'image',
				'title' => 'Avatar.jpg'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120423092715/devbox/images/thumb/1/19/Avatar.jpg/90px-Avatar.jpg',	
				'type' => 'video',
				'title' => 'The Dark Knight (2008) - Hit Me!'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120427205649/devbox/images/thumb/2/27/IMG_1535.jpg/90px-IMG_1535.jpg',
				'type' => 'video',
				'title' => 'Return to Fallout New Vegas Walkthrough with Commentary Part 1 - The High-Five Returns'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120423092715/devbox/images/thumb/1/19/Avatar.jpg/90px-Avatar.jpg',	
				'type' => 'image',
				'title' => '500x1700.jpeg'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120427205649/devbox/images/thumb/2/27/IMG_1535.jpg/90px-IMG_1535.jpg',	
				'type' => 'image',
				'title' => 'IMG 1535.jpg'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120423092715/devbox/images/thumb/1/19/Avatar.jpg/90px-Avatar.jpg',	
				'type' => 'image',
				'title' => 'Avatar.jpg'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120427205649/devbox/images/thumb/2/27/IMG_1535.jpg/90px-IMG_1535.jpg',
				'type' => 'video',
				'title' => 'The Dark Knight (2008) - Hit Me!'
			),
			array(
				'thumbUrl' => 'http://images.liz.wikia-dev.com/__cb20120423092715/devbox/images/thumb/1/19/Avatar.jpg/90px-Avatar.jpg',	
				'type' => 'video',
				'title' => 'Return to Fallout New Vegas Walkthrough with Commentary Part 1 - The High-Five Returns'
			),
		);
	
		$this->thumbs = $thumbs;
	
	}
	
	
	/**
	 * @brief - Returns complete details about a single media (file).  JSON only, no associated template to this method.
	 * @requestParam string title
	 * @responseParam string mediaType - media type.  either image or video
	 * @responseParam string videoEmbedCode - embed html code if video
	 * @responseParam string imageUrl - thumb image url that is hard scaled
	 * @responseParam string fileUrl - url to file page
	 * @responseParam string caption - video caption
	 * @responseParam string description - video description (apparantly, this is just file page content, look in spec or ask Yoko)
	 * @responseParam string userThumbUrl - user avatar thumbUrl scaled to 30x30
	 * @responseParam string userName - user name
	 * @responseParam string userPageUrl - url to user profile page
	 * @responseParam string articleTitle - name of the Article this image is posted to
	 * @responseParam string articleUrl - url to the article
	 */
	public function getMediaDetail() {
		$fileTitle = $this->request->getVal('title');
		$fileType = $this->request->getVal('type', '');
		$title = F::build('Title', array($fileTitle, NS_FILE), 'newFromText');
		
		/* initial values */
		$mediaType = 'image';
		$videoEmbedCode = '';
		$playerAsset = '';
		$imageUrl = '';
		$fileUrl = '';
		$rawImageUrl = '';
		$caption = '';
		$description = '';
		$userThumbUrl = '';
		$userName = '';
		$userPageUrl = '';
		$articles = array();
		
		/* do data query here */
		$file = wfFindFile($fileTitle);
		
		if(!empty($file)) {
			/* figure out resource type */
			$isVideo = F::build('WikiaVideoService')->isFileTypeVideo($file);
		
			 /* do media specific business logic */ 
			 if(!$isVideo) {
				/* normalize size of image to max 1000 width.  height does not matter */
				$width = $file->getWidth();
				$height = $file->getHeight();
				$width = $width > 1000 ? 1000 : $width;
			} else {
				$height = $this->request->getVal('height', 360); 
				$width = $this->request->getVal('width', 660); 
				
				$mediaType = 'video';
				$videoEmbedCode = $file->getEmbedCode( $width, true, true);
				$playerAsset = $file->getPlayerAssetUrl();
			}
			
			 /* everything after this point should be shared business logic */ 
			/* get thumb */
			$thumb = $file->getThumbnail($width, $height);
			
			/* get article content of this file */
			$articleId = $title->getArticleID();
			$article = Article::newFromID($articleId);
			
			/* get user who uploaded this */
			$userId = $file->getUser('id');
			$user = F::build('User', array($userId), 'newFromId' );
			
			$imageUrl = $thumb->getUrl();
			$fileUrl = $title->getLocalUrl();
			$rawImageUrl = $file->getUrl();
			$caption = '';	/* caption doesn't look like it's been structured, and it's just wikitext? (hyun) */
			//$description = $article->getContent();	TODO: broken, needs to be fixed
			$userName = $user->getName();
			$userThumbUrl = F::build( 'AvatarService', array($user->getId() , 16 ), 'getAvatarUrl' );
			$userPageUrl = $user->getUserPage()->getFullURL();
			$articles = array(
				array('articleUrl' => '', 'articleTitle' => 'Some Article')
			);	/* sample */
			/* article that image is embedded to needs to be implemented.  currently, there's an implementation on LatestPhotosModule->getLinkedFiles */
		}
		
		$this->fileTitle = $fileTitle;
		$this->mediaType = $mediaType;
		$this->videoEmbedCode = $videoEmbedCode;
		$this->playerAsset = $playerAsset;
		$this->imageUrl = $imageUrl;
		$this->fileUrl = $fileUrl;
		$this->rawImageUrl = $rawImageUrl;
		$this->caption = $caption;
		$this->description = $description;
		$this->userThumbUrl = $userThumbUrl;
		$this->userName = $userName;
		$this->userPageUrl = $userPageUrl;
		$this->articles = $articles;
	}
}