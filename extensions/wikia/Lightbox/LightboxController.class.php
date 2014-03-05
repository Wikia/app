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
	const POSTED_IN_ARTICLES = 7;

	static $imageserving;

	/**
	 * get lightbox modal content mustache template
	 */
	public function lightboxModalContent() {
		// TODO: refactor this to AdEngine2Controller.php
		$showAds = $this->wg->ShowAds;
		$this->showAdModalInterstitial = $showAds && $this->wg->ShowAdModalInterstitial;
		$this->showAdModalRectangle = $showAds && $this->wg->ShowAdModalRectangle;

		// set cache control to 1 day
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	public function lightboxModalContentError() {
		if ( $this->wg->User->isAllowed( 'read' ) ) {
			$this->error = wfMessage( 'lightbox-no-media-error', $this->wg->Sitename )->parse();
		} else {
			$this->error = htmlspecialchars( wfMessage( 'lightbox-no-permission-error' )->plain() );
		}

		// set cache control to 1 day
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
		$count = $this->request->getVal( 'count', 20 );
		$to = $this->request->getInt( 'to', 0 );
		$includeLatestPhotos = $this->request->getVal( 'inclusive', '' );

		$thumbs = array();
		$minTimestamp = 0;
		if ( !empty( $to ) ) {
			// get image list - exclude Latest Photos
			$images = array();
			$helper = new LightboxHelper();
			$imageList = $helper->getImageList( $count, $to );
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
	 * into array that includes thumburl and playbutton and title is always text
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
	 * Creates a single carousel thumb entry
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
				'playButtonSpan' => $entry['type'] == 'video' ? WikiaFileHelper::videoPlayButtonOverlay( self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT ) : ''
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
	 * @requestParam string sourceArticleId (optional) - article id that the file belongs to
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
		$fileTitle = urldecode( $this->request->getVal( 'fileTitle', '' ) );

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

		$config = array(
			'imageMaxWidth'  => 1000,
			'contextWidth'   => $this->request->getVal( 'width', 750 ),
			'contextHeight'  => $this->request->getVal( 'height', 415 ),
			'userAvatarWidth'=> 16,
		);

		// set max height if play in lightbox
		if ( $this->request->getVal( 'width', 0 ) == 0 ) {
			$config['maxHeight'] = 415;
		}

		$data = WikiaFileHelper::getMediaDetail( $title, $config );

		$articles = $data['articles'];
		list( $smallerArticleList, $articleListIsSmaller ) = WikiaFileHelper::truncateArticleList( $articles, self::POSTED_IN_ARTICLES );
		$isPostedIn = empty( $smallerArticleList ) ? false : true;	// Bool to tell mustache to print "posted in" section

		// file details
		$this->views = wfMessage( 'lightbox-video-views', $this->wg->Lang->formatNum( $data['videoViews'] ) )->parse();
		$this->title = $title->getDBKey();
		$this->fileTitle = $title->getText();
		$this->mediaType = $data['mediaType'];
		$this->videoEmbedCode = $data['videoEmbedCode'];
		$this->playerAsset = $data['playerAsset'];
		$this->imageUrl = $data['imageUrl'];
		$this->fileUrl = $data['fileUrl'];
		$this->rawImageUrl = $data['rawImageUrl'];
		$this->userThumbUrl = $data['userThumbUrl'];
		$this->userName = ( User::isIP($data['userName']) ) ? wfMessage( 'oasis-anon-user' )->plain() : $data['userName'] ;
		$this->userPageUrl = $data['userPageUrl'];
		$this->articles = $articles;
		$this->isPostedIn = $isPostedIn;
		$this->smallerArticleList = $smallerArticleList;
		$this->articleListIsSmaller = $articleListIsSmaller;
		$this->providerName = $data['providerName'];
		$this->exists = $data['exists'];
		$this->isAdded = $data['isAdded'];

		// Make sure that a request with missing &format=json does not throw a "template not found" exception
		$this->response->setFormat( 'json' );
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
			$fileTitle = $fileTitleObj->getText();
			$articleTitle = $this->request->getVal( 'articleTitle' );
			$articleTitleObj = Title::newFromText( $articleTitle );

			if ( !empty( $articleTitleObj ) && $articleTitleObj->exists() ) {
				$fileParam = wfUrlencode( $fileTitleObj->getDBKey() );
				$articleUrl = $articleTitleObj->getFullURL( "file=$fileParam" );
				$articleNS = $articleTitleObj->getNamespace();
				$articleTitleText = $articleTitleObj->getText();
			}

			// check if the file is added to the wiki
			if ( WikiaFileHelper::isAdded( $file ) ) {
				$fileUrl = $fileTitleObj->getFullURL();
			} else {
				$fileUrl = WikiaFileHelper::getFullUrlPremiumVideo( $fileTitleObj->getDBkey() );
			}

			// determine share url
			$sharingNamespaces = array(
				NS_MAIN,
				NS_CATEGORY,
			);
			$shareUrl = ( !empty( $articleUrl ) && in_array( $articleNS, $sharingNamespaces ) ) ? $articleUrl : $fileUrl;
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
				'stumbleupon',
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

		$this->shareUrl = $shareUrl;
		$this->articleUrl = $articleUrl;
		$this->fileUrl = $fileUrl;
		$this->networks = $networks;
		$this->fileTitle = $fileTitle;
		$this->imageUrl = $thumbUrl;

		// set cache control to 1 day
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
 	 * AJAX function for sending share e-mails
	 * @requestParam string addresses - comma-separated list of email addresses
	 * @requestParam string shareUrl - share url being emailed
	 */
	public function shareFileMail() {
		$user = $this->wg->User;
		$errors = array();
		$sent = array();
		$notsent = array();

		if ( !$user->isLoggedIn() ) {
			$errors[] = 'notloggedin';
		} else {
			$addresses = $this->request->getVal( 'addresses', '' );
			$shareUrl = $this->request->getVal( 'shareUrl', '' );
			$type = $this->request->getVal( 'type', '' );

			$msgSuffix = ( $type == 'video' ) ? '-video' : '';

			if ( !empty( $addresses ) && !empty( $shareUrl ) && !$user->isBlockedFromEmailuser() ) {
				$addresses = explode( ',', $addresses );

				//send mails
				$sender = new MailAddress( $this->wg->NoReplyAddress, 'Wikia' );	//TODO: use some standard variable for 'Wikia'?
				foreach ( $addresses as $address ) {
					$to = new MailAddress( $address );
					$result = UserMailer::send(
						$to,
						$sender,
						wfMessage( 'lightbox-share-email-subject'.$msgSuffix, $user->getName() )->text(),
						wfMessage( 'lightbox-share-email-body'.$msgSuffix, $shareUrl )->text(),
						null,
						null,
						'ImageLightboxShare'
					);
					if ( !$result->isOK() ) {
						$notsent[] = $address;
					}else {
						$sent[] = $address;
					}
				}
			} else {
				$errors[] = htmlspecialchars( wfMessage( 'lightbox-share-email-error-noaddress' )->plain() );
			}
		}

		$this->errors = $errors;
		$this->sent = $sent;
		$this->notsent = $notsent;
		$this->successMsg = wfMessage( 'lightbox-share-email-ok-content', count( $sent ) )->escaped();
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

		$helper = new LightboxHelper();

		// add Latest Photos if not exist
		if ( $includeLatestPhotos == 'true' ) {
			$latestPhotos = $helper->getLatestPhotos();
			$extra += count( $latestPhotos );
		}

		$memKey = wfMemcKey( 'lightbox', 'total_images' );
		$imageInfo = $this->wg->Memc->get( $memKey );
		if ( !is_array( $imageInfo ) ) {
			$db = wfGetDB( DB_SLAVE );

			$timestamp = $helper->getTimestamp();
			$totalWikiImages = $db->selectField(
				array( 'image' ),
				array( 'count(*) cnt' ),
				array(
					"img_media_type in ('".MEDIATYPE_BITMAP."', '".MEDIATYPE_DRAWING."')",
					"img_timestamp < $timestamp",
				),
				__METHOD__
			);

			$imageInfo = array(
				'totalWikiImages' => intval( $totalWikiImages ),
				'timestamp' => $timestamp,
			);

			$this->wg->Memc->set( $memKey, $imageInfo, LightboxHelper::CACHE_TTL );
		}

		$totalWikiImages = $imageInfo['totalWikiImages'] + $extra;

		$this->to = $imageInfo['timestamp'];
		$this->msg = wfMessage( 'lightbox-carousel-more-items', $this->wg->Lang->formatNum( $totalWikiImages ) )->parse();

		// set cache control to 1 hour
		$this->response->setCacheValidity( LightboxHelper::CACHE_TTL );

		wfProfileOut( __METHOD__ );
	}

}
