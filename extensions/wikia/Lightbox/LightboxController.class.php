<?php

/**
 * Lightbox controller
 * @author Hyun
 * @author Liz
 * @author Piotr Bablok
 * @author Saipetch Kongkatong
 */
class LightboxController extends WikiaController {

	const THUMBNAIL_WIDTH = 90;
	const THUMBNAIL_HEIGHT = 55;
	/** Default lightbox width */
	const CONTEXT_DEFAULT_WIDTH = 750;
	/** Default lightbox height */
	const CONTEXT_DEFAULT_HEIGHT = 415;
	const POSTED_IN_ARTICLES = 7;

	static $imageserving;

	/**
	 * get lightbox modal content mustache template
	 */
	public function lightboxModalContent() {
		// set cache control to 1 day
		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	public function lightboxModalContentError() {
		if ( $this->wg->User->isAllowed( 'read' ) ) {
			$this->error = wfMessage( 'lightbox-no-media-error', $this->wg->Sitename )->parse();
		} else {
			$this->error = htmlspecialchars( wfMessage( 'lightbox-no-permission-error' )->plain() );
		}

		// set cache control to 1 day
		$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Get a list of latest photos for the wiki
	 * @requestParam integer count - limit per request
	 * @requestParam string to - timestamp
	 * @requestParam string inclusive [true/false] - include Latest Photos
	 * @responseParam array thumbs - thumbnail data
	 * thumbs = array( 'title' => image title, 'type' => [image/video], 'thumbUrl' => thumbnail link )
	 */
	public function getThumbImages() {
		$count = $this->request->getInt( 'count', 20 );
		$to = $this->request->getVal( 'to', 0 );
		$includeLatestPhotos = $this->request->getVal( 'inclusive', '' );

		$thumbs = array();
		$minTimestamp = 0;
		$toTimestamp = wfTimestamp( TS_MW, $to );
		if ( !empty( $to ) ) {
			// get image list - exclude Latest Photos
			$images = array();
			$helper = $this->getLightboxHelper();
			$imageList = $helper->getImageList( $count, $toTimestamp );
			extract( $imageList );

			// add Latest Photos if not exist
			if ( $includeLatestPhotos == 'true' ) {
				$latestPhotos = $helper->getLatestPhotos();
				$images = array_merge( $latestPhotos, $images );
			}

			$thumbs = $this->mediaTableToThumbs( $images );
		}

		$this->thumbs = $thumbs;
		$this->to = $minTimestamp;

		// set cache control to 1 hour
		$this->response->setCacheValidity( LightboxHelper::CACHE_TTL );
	}

	/**
	 * Transform array into different array
	 *
	 * converts array in format of
	 *   title (as text or object)
	 *   type (video or image)
	 * into array that includes thumburl and title is always text
	 *
	 * @param $mediaTable
	 * @return array
	 */
	protected function mediaTableToThumbs( $mediaTable ) {
		$thumbs = array();
		foreach ( $mediaTable as $entry ) {
			$thumb = $this->createCarouselThumb( $entry );
			if ( !empty( $thumb ) ) {
				$thumbs[] = $thumb;
			}
		}
		return $thumbs;
	}

	/**
	 * Creates a single carousel thumb entry.
	 * @param $entry - must have 'title'(image title) and 'type'(image|video) defined
	 * @return array|string
	 */
	private function createCarouselThumb( $entry ) {
		$thumb = '';
		$is = $this->carouselImageServingInstance();
		if ( is_string( $entry['title'] ) ) {
			$media = Title::newFromText( $entry['title'], NS_FILE );
		} else {
			$media = $entry['title'];
		}
		$file = wfFindFile( $media );
		if ( !empty( $file ) ) {
			$url = $is->getUrl( $file, $file->getWidth(), $file->getHeight() );
			$thumb = array(
				'thumbUrl' => $url,
				'type' => $entry['type'],
				'key' => $media->getDBKey(),
				'title' => $media->getText(),
			);
		}
		return $thumb;
	}

	/**
	 * Instance method to treat image serving for carousel thumb as a singleton bound to this controller instance
	 * @return \ImageServing
	 */
	private function carouselImageServingInstance() {
		if ( empty( self::$imageserving ) ) {
			self::$imageserving = new ImageServing( null, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT );
		}
		return self::$imageserving;
	}

	/**
	 * Returns complete details about a single media (file).  JSON only, no associated template to this method.
	 * @requestParam string fileTitle
	 * @requestParam boolean isInline (optional) - Determines whether the media file should show inline
	 * @requestParam int width (optional) - Context width
	 * @requestParam int height (optional) - Context height
	 * @responseParam string mediaType - media type.  either image or video
	 * @responseParam string videoEmbedCode - embed html code if video
	 * @responseParam string imageUrl - thumb image url that is hard scaled
	 * @responseParam string fileUrl - url to file page
	 * @responseParam string caption - video caption
	 * @responseParam string userThumbUrl - user avatar thumbUrl scaled to 30x30
	 * @responseParam string userName - user name
	 * @responseParam string userPageUrl - url to user profile page
	 * @responseParam array articles - array of articles that has title and url
	 * @responseParam string providerName - provider name for videos or '' for others
	 * @responseParam boolean exists - check if the file exists
	 * @responseParam boolean isAdded - check if the file is added to the wiki
	 */
	public function getMediaDetail() {
		$this->response->setFormat( 'json' );

		$fileTitle = urldecode( $this->request->getVal( 'fileTitle', '' ) );
		$isInline = $this->request->getVal( 'isInline', false );

		// BugId:32939
		// There is no sane way to check whether $fileTitle is OK other
		// than an attempt to create a Title object and then a check
		// whether the object has been created.
		$title = Title::newFromText( $fileTitle, NS_FILE );

		// BugId:32939
		// Can't create a valid Title object based on $fileTitle. This method
		// only changes $this's properties. Leave them unchanged.
		if ( !( $title instanceof Title ) ) {
			return;
		}

		if ( !$this->wg->User->isAllowed( 'read' ) ) {
			return;
		}

		$config = [
			'imageMaxWidth'  => 1000,
			'contextWidth'   => $this->request->getVal( 'width', self::CONTEXT_DEFAULT_WIDTH ),
			'contextHeight'  => $this->request->getVal( 'height', self::CONTEXT_DEFAULT_HEIGHT ),
			'userAvatarWidth'=> 16,
			'isInline'       => $isInline,
		];

		// set max height if play in lightbox
		if ( $this->request->getVal( 'width', 0 ) == 0 ) {
			$config['maxHeight'] = self::CONTEXT_DEFAULT_HEIGHT;
		}

		$data = WikiaFileHelper::getMediaDetail( $title, $config );

		$articles = $data['articles'];
		list( $smallerArticleList, $articleListIsSmaller ) = WikiaFileHelper::truncateArticleList( $articles, self::POSTED_IN_ARTICLES );

		// file details
		$this->title = $title->getDBKey();
		$this->fileTitle = $title->getText();
		$this->mediaType = $data['mediaType'];
		$this->videoEmbedCode = $data['videoEmbedCode'];
		$this->imageUrl = $data['imageUrl'];
		$this->fileUrl = $data['fileUrl'];
		$this->rawImageUrl = $data['rawImageUrl'];
		$this->userThumbUrl = $data['userThumbUrl'];
		$this->userName = ( User::isIP($data['userName']) ) ? wfMessage( 'oasis-anon-user' )->plain() : $data['userName'] ;
		$this->userPageUrl = $data['userPageUrl'];
		$this->articles = $articles;
		$this->isPostedIn = !empty( $smallerArticleList ); // Bool to tell mustache to print "posted in" section
		$this->smallerArticleList = $smallerArticleList;
		$this->articleListIsSmaller = $articleListIsSmaller;
		$this->providerName = $data['providerName'];
		$this->exists = $data['exists'];
		$this->isAdded = $data['isAdded'];
		$this->extraHeight = $data['extraHeight'];
		$this->isUserAnon = $this->wg->User->isAnon();
		$parserOptions = new ParserOptions();
		$parserOptions->setEditSection( false );
		$parserOptions->setTidy( true );
		$this->imageDescription = false;
		if ( !empty( $data['description'] ) ) {
			$this->imageDescription = ParserPool::create()->parse( $data['description'], $title, $parserOptions )->getText();

			if ( empty( $this->imageDescription ) ) {
				$this->imageDescription = false;
			}
		}

		// set cache control to 15 minutes
		$this->response->setCacheValidity( 900 );
	}

	/**
	 * Returns pre-formatted social sharing urls and codes
	 * @requestParam string fileTitle
	 * @requestParam string articleTitle	(optional)
	 * @responseParam string url - raw url that is automically determined.  This is determined to be either article url or file page url.
	 * @responseParam string articleUrl - url to article page
	 * @responseParam string fileUrl - url to file page
	 * @responseParam string networks - contains id(facebook, twitter, etc) and urls of external social networks
	 */
	public function getShareCodes() {
		$fileTitle = urldecode( $this->request->getVal( 'fileTitle', '' ) );

		$file = wfFindFile( $fileTitle );

		$shareUrl = '';
		$articleUrl = '';
		$articleNS = '';
		$articleTitleText = '';
		$fileUrl = '';
		$thumbUrl = '';
		$networks = array();

		if ( !empty( $file ) ) {
			$fileTitleObj =  Title::newFromText( $fileTitle, NS_FILE );
			$keys = array();
			Hooks::run( 'FilePages:InsertSurrogateKey', [ $fileTitleObj, &$keys ] );
			Wikia::setSurrogateKeysHeaders( $keys, false );

			$fileTitle = $fileTitleObj->getText();
			$articleTitle = $this->request->getVal( 'articleTitle' );
			$articleTitleObj = Title::newFromText( $articleTitle );

			if ( !empty( $articleTitleObj ) && $articleTitleObj->exists() ) {
				$fileParam = wfUrlencode( $fileTitleObj->getDBKey() );
				$articleUrl = $articleTitleObj->getFullURL( "file=$fileParam" );
				$articleNS = $articleTitleObj->getNamespace();
				$articleTitleText = $articleTitleObj->getText();
			}

			$fileUrl = $fileTitleObj->getFullURL();

			// determine share url
			$sharingNamespaces = array(
				NS_MAIN,
				NS_CATEGORY,
			);
			$shareUrl = ( !empty( $articleUrl ) && in_array( $articleNS, $sharingNamespaces ) ) ? $articleUrl : $fileUrl;

			$anonRedir = FilePageHelper::getFilePageRedirectUrl( $fileTitleObj );

			$mpUrl = wfAppendQuery(Title::newMainPage()->getFullURL() , [
				'file' => $fileTitleObj->getText()
			] );

			if ( $anonRedir && $anonRedir === $mpUrl ) {
				$shareUrl = $anonRedir;
			}

			$thumb = $file->transform( array( 'width' => 300, 'height' => 250 ) );
			$thumbUrl = $thumb->getUrl();

			if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
				$msgSuffix = '-video';
			} else {
				$msgSuffix = '';
			}

			$msgArticleTitle = empty( $articleUrl ) ? $fileTitle : $articleTitleText;
			$linkDescription = wfMessage( 'lightbox-share-description'.$msgSuffix, $msgArticleTitle, $this->wg->Sitename )->text();

			$shareNetworks = SocialSharingService::getInstance()->getNetworks( array(
				'facebook',
				'twitter',
				'reddit',
				'plusone',
			) );
			foreach ( $shareNetworks as $network ) {
				$networks[] = array(
					'id' => $network->getId(),
					'url' => $network->getUrl( $shareUrl, $linkDescription )
				);
			}
		}

		$this->articleUrl = $articleUrl;
		$this->fileUrl = $fileUrl;
		$this->networks = $networks;
		$this->fileTitle = $fileTitle;
		$this->imageUrl = $thumbUrl;
		$this->isUserAnon = $this->wg->User->isAnon();

		// set cache control to 1 day
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
 	 * AJAX function for sending share e-mails
	 * Request params:
	 * - string address - e-mail to share the file with
	 * - string fileName - name of the file being shared
	 * - string shareTarget - article the file is included on
	 * - int shareNamespace - namespace of the article the file is included on
	 * - string type - optional - if 'video', the message is customized for media type video
	 */
	public function shareFileMail() {
		$user = $this->wg->User;

		if ( !$user->isLoggedIn() ) {
			$this->setShareFileMailErrorResponse( 'notloggedin' );
			return;
		}

		$address = $this->request->getVal( 'address' );
		$fileName = $this->request->getVal( 'fileName' );
		$shareTarget = $this->request->getVal( 'shareTarget' );
		$shareNamespace = $this->request->getVal( 'shareNamespace' );

		if ( !$address || $shareNamespace === null || !$shareTarget || $user->isBlockedFromEmailuser() ) {
			$this->setShareFileMailErrorResponse( 'lightbox-share-email-error-noaddress' );
			return;
		}

		$title = Title::makeTitleSafe( $shareNamespace, $shareTarget );

		if ( !$title || $title->isExternal() ) {
			$this->setShareFileMailErrorResponse( 'lightbox-share-email-error-noaddress' );
			return;
		}

		// Check rate limits
		if ( $user->pingLimiter( 'share-email' ) ) {
			$this->setShareFileMailErrorResponse( 'actionthrottledtext' );
			return;
		}

		$shareUrl = $title->inNamespace( NS_FILE ) ?
			FilePageHelper::getFilePageRedirectUrl( $title ) :
			$title->getFullURL( 'file=' . wfUrlencode( $fileName ) );

		$type = $this->request->getVal( 'type', '' );
		$subjectKey = 'lightbox-share-email-subject';
		$bodyKey = 'lightbox-share-email-body';
		if ( $type == 'video' ) {
			$subjectKey = 'lightbox-share-email-subject-video';
			$bodyKey = 'lightbox-share-email-body-video';
		}

		$sent = [];
		$notSent = [];

		$response = F::app()->sendRequest(
			Email\Controller\GenericController::class,
			'handle',
			[
				'salutation' => wfMessage( 'lightbox-share-salutation' )->escaped(),
				'toAddress' => $address,
				'subject' => wfMessage( $subjectKey, $user->getName() )->escaped(),
				'body' => wfMessage( $bodyKey, htmlspecialchars( $shareUrl ) )->text(),
				'category' => 'ImageLightboxShare',
			]
		);

		if ( $response->getData()['result'] == 'ok' ) {
			$sent[] = $address;
		} else {
			$notSent[] = $address;
		}

		$this->response->setData( [
			'errors' => [],
			'sent' => $sent,
			'notsent' => $notSent,
			'successMsg' => wfMessage( 'lightbox-share-email-ok-content', count( $sent ) )->escaped(),
		] );
	}

	protected function setShareFileMailErrorResponse( $errorKey ) {
		$errors = [ htmlspecialchars( wfMessage( $errorKey )->plain() ) ];

		$this->response->setData( [
			'errors' => $errors,
			'sent' => [],
			'notsent' => [],
			'successMsg' => '',
		] );
	}

	/**
	 * Get number of images on the wiki
	 * @requestParam integer count - extra number to be included in total images
	 * @requestParam string inclusive [true/false] - include Latest Photos
	 * @responseParam string msg - contains the number of total images on the wiki
	 * @responseParam string to - timestamp
	 */
	public function getTotalWikiImages() {
		wfProfileIn( __METHOD__ );

		$extra = $this->request->getVal( 'count', 0 );
		$includeLatestPhotos = $this->request->getVal( 'inclusive', '' );

		$helper = $this->getLightboxHelper();

		// add Latest Photos if not exist
		if ( $includeLatestPhotos == 'true' ) {
			$latestPhotos = $helper->getLatestPhotos();
			$extra += count( $latestPhotos );
		}

		$imageInfo = $helper->getTotalImages();

		$totalWikiImages = $imageInfo['totalWikiImages'] + $extra;

		$this->to = $imageInfo['timestamp'];
		$this->msg = wfMessage( 'lightbox-carousel-more-items', $this->wg->Lang->formatNum( $totalWikiImages ) )->parse();

		// set cache control to 1 hour
		$this->response->setCacheValidity( LightboxHelper::CACHE_TTL );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get an instance of the lightbox helper
	 * @return LightboxHelper
	 */
	public function getLightboxHelper() {
		return new \LightboxHelper();
	}
}
