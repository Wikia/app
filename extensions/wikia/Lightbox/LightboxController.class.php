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
		$type = $this->request->getVal('type', '');
		$initialFileDetail = array();
		if(!empty($title) && !empty($type)) {
			// send request to getImageDetail()
			if($type === 'image') {
				$initialFileDetail = $this->app->sendRequest('Lightbox', 'getImageDetail', array('title' => $title))->getData();
			}
		}
		
		$this->initialFileDetail = $initialFileDetail;
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
	 * @brief - Returns complete details about a single image.  JSON only, no associated template to this method.
	 * @requestParam string title
	 * @responseParam string imageUrl - thumb image url that is scaled to max width of 1000 px (no max height)
	 * @responseParam string fileUrl - url to file page
	 * @responseParam string rawImageUrl - url to raw image
	 * @responseParam string caption - image caption
	 * @responseParam string description - image description (apparantly, this is just file page content, look in spec or ask Yoko)
	 * @responseParam string userThumbUrl - user avatar thumbUrl scaled to 30x30
	 * @responseParam string userName - user name
	 * @responseParam string userPageUrl - url to user profile page
	 * @responseParam string articles - name and url of the articles this image is posted to
	 */
	public function getImageDetail() {
		$imageTitle = $this->request->getVal('title');
		$title = F::build('Title', array($imageTitle, NS_FILE), 'newFromText');
		
		/* initial values */
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
		$image = wfFindFile($imageTitle);
		
		if(!empty($image)) {
			/* normalize size of image to max 1000 width.  height does not matter */
			$width = $image->getWidth();
			$height = $image->getHeight();
			$width = $width > 1000 ? 1000 : $width;
			
			/* get thumb */
			$thumb = $image->getThumbnail($width, $height);
			
			/* get article content of this file */
			$articleId = $title->getArticleID();
			$article = Article::newFromID($articleId);
			
			/* get user who uploaded this */
			$userId = $image->getUser('id');
			$user = F::build('User', array($userId), 'newFromId' );
			
			$imageUrl = $thumb->getUrl();
			$fileUrl = $title->getLocalUrl();
			$rawImageUrl = $image->getUrl();
			$caption = '';	/* caption doesn't look like it's been structured, and it's just wikitext? (hyun) */
			$description = $article->getContent();
			$userName = $user->getName();
			$userThumbUrl = F::build( 'AvatarService', array($user->getId() , 30 ), 'getAvatarUrl' );
			$userPageUrl = $user->getUserPage()->getFullURL();
			$articles = array(
				array('articleUrl' => '', 'articleTitle' => 'Some Article')
			);	/* sample */
		}
		
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
	
	
	/**
	 * @brief - Returns complete details about a single video.  JSON only, no associated template to this method.
	 * @requestParam string title
	 * @responseParam string videoEmbedCode - embed html code
	 * @responseParam string imageUrl - thumb image url that is hard scaled to 660x360
	 * @responseParam string fileUrl - url to file page
	 * @responseParam string caption - video caption
	 * @responseParam string description - video description (apparantly, this is just file page content, look in spec or ask Yoko)
	 * @responseParam string userThumbUrl - user avatar thumbUrl scaled to 30x30
	 * @responseParam string userName - user name
	 * @responseParam string userPageUrl - url to user profile page
	 * @responseParam string articleTitle - name of the Article this image is posted to
	 * @responseParam string articleUrl - url to the article
	 */
	public function getVideoDetail() {
		$videoTitle = $this->request->getVal('title');
		
		/* initial values */
		$videoEmbedCode = '';
		$imageUrl = '';
		$fileUrl = '';
		$caption = '';
		$description = '';
		$userThumbUrl = '';
		$userName = '';
		$userPageUrl = '';
		$articleTitle = '';
		$articleUrl = '';
		
		/* do data query here */
		$video = wfFindFile($videoTitle);
		
		$this->videoEmbedCode = $videoEmbedCode;
		$this->imageUrl = $imageUrl;
		$this->fileUrl = $fileUrl;
		$this->caption = $caption;
		$this->description = $description;
		$this->userThumbUrl = $thumbUrl;
		$this->userName = $userName;
		$this->userPageUrl = $userPageUrl;
		$this->articleTitle = $articleTitle;
		$this->articleUrl = $articleUrl;
	}
	
}