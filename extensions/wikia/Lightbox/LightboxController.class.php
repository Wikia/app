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
		$this->response->setCacheValidity(86400, 86400, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
	}

	public function lightboxModalContentError() {
		if ( $this->wg->User->isAllowed( 'read' ) ) {
			$this->error = wfMessage('lightbox-no-media-error', $this->wg->Sitename)->parse();
		} else {
			$this->error = wfMessage('lightbox-no-permission-error')->text();
		}

		// set cache control to 1 day
		$this->response->setCacheValidity(86400, 86400, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
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
		$count = $this->request->getVal('count', 20);
		$to = $this->request->getInt( 'to', 0 );
		$includeLatestPhotos = $this->request->getVal( 'inclusive', '' );

		$thumbs = array();
		$minTimestamp = 0;
		if ( !empty($to) ) {
			// get image list - exclude Latest Photos
			$images = array();
			$imageList = $this->getImageList( $count, $to );
			extract( $imageList );

			// add Latest Photos if not exist
			if ( $includeLatestPhotos == 'true' ) {
				$latestPhotos = $this->getLatestPhotos();
				$images = array_merge( $latestPhotos, $images );
			}

			$thumbs = $this->mediaTableToThumbs( $images );
		}

		$this->thumbs = $thumbs;
		$this->to = $minTimestamp;

		// set cache control to 1 hour
		$this->response->setCacheValidity(3600, 3600, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
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
		foreach ($mediaTable as $entry) {
			$thumb = $this->createCarouselThumb($entry);
			if ( !empty($thumb) ) {
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
	private function createCarouselThumb($entry) {
		$thumb = '';
		$is = $this->carouselImageServingInstance();
		if ( is_string($entry['title']) ) {
			$media = Title::newFromText($entry['title'], NS_FILE);
		} else {
			$media = $entry['title'];
		}
		$file = wfFindFile($media);
		if ( !empty( $file ) ) {
			$url = $is->getUrl( $file, $file->getWidth(), $file->getHeight() );
			$thumb = array(
				'thumbUrl' => $url,
				'type' => $entry['type'],
				'key' => $media->getDBKey(),
				'title' => $media->getText(),
				'playButtonSpan' => $entry['type'] == 'video' ? WikiaFileHelper::videoPlayButtonOverlay(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT) : ''
			);
		}
		return $thumb;
	}

	/**
	 * Instance method to treat image serving for carousel thumb as a singleton bound to this controller instance
	 * @return \ImageServing
	 */
	private function carouselImageServingInstance() {
		if ( empty(self::$imageserving) ) {
			self::$imageserving = new ImageServing(null, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT);
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
	 */
	public function getMediaDetail() {
		$fileTitle = $this->request->getVal('fileTitle', '');
		$fileTitle = urldecode($fileTitle);

		// BugId:32939
		// There is no sane way to check whether $fileTitle is OK other
		// than an attempt to create a Title object and then a check
		// whether the object has been created.
		$title = Title::newFromText($fileTitle, NS_FILE);

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
			'contextWidth'   => $this->request->getVal('width', 750),
			'contextHeight'  => $this->request->getVal('height', 415),
			'userAvatarWidth'=> 16,
		);

		// set max height if play in lightbox
		if ( $this->request->getVal('width', 0) == 0 ) {
			$config['maxHeight'] = 415;
		}

		$data = WikiaFileHelper::getMediaDetail( $title, $config );

		$articles = $data['articles'];
		list( $smallerArticleList, $articleListIsSmaller ) = WikiaFileHelper::truncateArticleList( $articles, self::POSTED_IN_ARTICLES );
		$isPostedIn = empty( $smallerArticleList ) ? false : true;	// Bool to tell mustache to print "posted in" section

		// file details
		$this->views = wfMsg( 'lightbox-video-views', $this->wg->Lang->formatNum($data['videoViews']) );
		$this->title = $title->getDBKey();
		$this->fileTitle = $title->getText();
		$this->mediaType = $data['mediaType'];
		$this->videoEmbedCode = $data['videoEmbedCode'];
		$this->playerAsset = $data['playerAsset'];
		$this->imageUrl = $data['imageUrl'];
		$this->fileUrl = $data['fileUrl'];
		$this->rawImageUrl = $data['rawImageUrl'];
		$this->userThumbUrl = $data['userThumbUrl'];
		$this->userName = ( User::isIP($data['userName']) ) ? wfMsg( 'oasis-anon-user' ) : $data['userName'] ;
		$this->userPageUrl = $data['userPageUrl'];
		$this->articles = $articles;
		$this->isPostedIn = $isPostedIn;
		$this->smallerArticleList = $smallerArticleList;
		$this->articleListIsSmaller = $articleListIsSmaller;
		$this->providerName = $data['providerName'];
		$this->exists = $data['exists'];

		// set cache control to 1 hour
		// Note - we're probably not going to use this going forward.  Saipetch is investigating - Liz
		//$this->response->setCacheValidity(3600, 3600, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
		// Make sure that a request with missing &format=json does not throw a "template not found" exception
		$this->response->setFormat('json');
	}

	/**
	 * Returns pre-formatted social sharing urls and codes
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
		$fileTitle = urldecode($fileTitle);

		$file = wfFindFile($fileTitle);

		$shareUrl = '';
		$articleUrl = '';
		$articleNS = '';
		$articleTitleText = '';
		$embedMarkup = '';
		$fileUrl = '';
		$thumbUrl = '';
		$networks = array();

		if ( !empty($file) ) {
			$fileTitleObj =  Title::newFromText($fileTitle, NS_FILE);
			$fileTitle = $fileTitleObj->getText();
			$articleTitle = $this->request->getVal('articleTitle');
			$articleTitleObj = Title::newFromText($articleTitle);

			if ( !empty($articleTitleObj) && $articleTitleObj->exists() ) {
				$fileParam = wfUrlencode( $fileTitleObj->getDBKey() );
				$articleUrl = $articleTitleObj->getFullURL("file=$fileParam");
				$articleNS = $articleTitleObj->getNamespace();
				$articleTitleText = $articleTitleObj->getText();
			}

			$fileUrl = $fileTitleObj->getFullURL();

			// determine share url
			$sharingNamespaces = array(
				NS_MAIN,
				NS_CATEGORY,
			);
			$shareUrl = !empty($articleUrl) && in_array($articleNS, $sharingNamespaces) ? $articleUrl : $fileUrl;
			$thumb = $file->transform(array('width'=>300, 'height'=>250));
			$thumbUrl = $thumb->getUrl();

			if ( WikiaFileHelper::isFileTypeVideo( $file ) ) {
				$embedMarkup = $file->getEmbedCode(300, true, false);
				$msgSuffix = '-video';
			} else {
				$embedMarkup = "<a href=\"$shareUrl\"><img width=\"" . $thumb->getWidth() . "\" height=\"" . $thumb->getHeight() . "\" src=\"$thumbUrl\"/></a>";
				$msgSuffix = '';
			}

			$linkDescription = wfMsg( 'lightbox-share-description'.$msgSuffix, empty($articleUrl) ? $fileTitle : $articleTitleText, $this->wg->Sitename );

			$shareNetworks = SocialSharingService::getInstance()->getNetworks( array(
				'facebook',
				'twitter',
				'stumbleupon',
				'reddit',
				'plusone',
			) );
			foreach ($shareNetworks as $network) {
				$networks[] = array(
					'id' => $network->getId(),
					'url' => $network->getUrl($shareUrl, $linkDescription)
				);
			}

			// Don't show embed code for screenplay b/c it's using JW Player
			if ( WikiaFileHelper::isFileTypeVideo($file) && $file->getProviderName() == 'screenplay' ) {
				$embedMarkup = false;
			}

		}

		$this->shareUrl = $shareUrl;
		$this->embedMarkup = $embedMarkup;
		$this->articleUrl = $articleUrl;
		$this->fileUrl = $fileUrl;
		$this->networks = $networks;
		$this->fileTitle = $fileTitle;
		$this->imageUrl = $thumbUrl;

		// set cache control to 1 day
		$this->response->setCacheValidity(86400, 86400, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
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

			if ( !empty($addresses) && !empty($shareUrl) && !$user->isBlockedFromEmailuser() ) {
				$addresses = explode(',', $addresses);

				//send mails
				$sender = new MailAddress($this->wg->NoReplyAddress, 'Wikia');	//TODO: use some standard variable for 'Wikia'?
				foreach ($addresses as $address) {
					$to = new MailAddress($address);
					$result = UserMailer::send(
						$to,
						$sender,
						wfMsg( 'lightbox-share-email-subject'.$msgSuffix, array("$1" => $user->getName()) ),
						wfMsg( 'lightbox-share-email-body'.$msgSuffix, $shareUrl ),
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
				$errors[] = wfMsg('lightbox-share-email-error-noaddress');
			}
		}

		$this->errors = $errors;
		$this->sent = $sent;
		$this->notsent = $notsent;
		$this->successMsg = wfMsgExt('lightbox-share-email-ok-content', array('parsemag'), count($sent));
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

		// add Latest Photos if not exist
		if ( $includeLatestPhotos == 'true' ) {
			$latestPhotos = $this->getLatestPhotos();
			$extra += count( $latestPhotos );
		}

		$memKey = wfMemcKey( 'lightbox', 'total_images' );
		$imageInfo = $this->wg->Memc->get( $memKey );
		if ( !is_array($imageInfo) ) {
			$db = wfGetDB( DB_SLAVE );

			$timestamp = $this->getTimestamp();
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

			$this->wg->Memc->set( $memKey, $imageInfo, 60*60 );
		}

		$totalWikiImages = $imageInfo['totalWikiImages'] + $extra;

		$this->to = $imageInfo['timestamp'];
		$this->msg = wfMsg( 'lightbox-carousel-more-items', $this->wg->Lang->formatNum($totalWikiImages) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get list of images
	 * @param integer $limit
	 * @param string $to - timestamp
	 * @return array $imageList - array( 'images' => list of image, 'minTimestamp' => minimum timestamp of the list )
	 */
	protected function getImageList( $limit, $to ) {
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( 'lightbox', 'images', $limit, $to );
		$imageList = $this->wg->Memc->get( $memKey );
		if ( !is_array($imageList) ) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'image' ),
				array( 'img_name, img_timestamp' ),
				array(
					"img_media_type in ('".MEDIATYPE_BITMAP."', '".MEDIATYPE_DRAWING."')",
					"img_timestamp < $to",
				),
				__METHOD__,
				array(
					'ORDER BY' => 'img_timestamp DESC',
					'LIMIT' => $limit,
				)
			);

			$images = array();
			$imageList = array( 'images' => $images, 'minTimestamp' => 0 );
			while( $row = $db->fetchObject($result) ) {
				$minTimestamp = $row->img_timestamp;
				$images[] = array(
					'title' => $row->img_name,
					'type' => 'image',
				);
			}

			if ( !empty($images) ) {
				$imageList = array(
					'images' => $images,
					'minTimestamp' => wfTimestamp( TS_MW, $minTimestamp ),
				);
			}

			$this->wg->Memc->set( $memKey, $imageList, 60*60 );
		}

		wfProfileOut( __METHOD__ );

		return $imageList;
	}

	/**
	 * Get list of images from LatestPhotosController ( image only )
	 * @return array $latestPhotos - array( 'title' => imageName, 'type' => 'image' )
	 */
	protected function getLatestPhotos() {
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( 'lightbox', 'latest_photos' );
		$latestPhotos = $this->wg->Memc->get( $memKey );
		if ( !is_array($latestPhotos) ) {
			$response = $this->sendRequest( 'LatestPhotosController', 'executeIndex' );
			$thumbUrls = $response->getVal( 'thumbUrls', '' );

			$latestPhotos = array();
			if ( !empty($thumbUrls) && is_array($thumbUrls) ) {
				foreach ( $thumbUrls as $thumb ) {
					if ( !$thumb['isVideoThumb'] ) {
						$title = Title::newFromText( $thumb['image_filename'] );
						$latestPhotos[] = array(
							'title' => $title->getDBKey(),
							'type' => 'image',
						);
					}
				}
			}

			$this->wg->Memc->set( $memKey, $latestPhotos, 60*60 );
		}

		wfProfileOut( __METHOD__ );

		return $latestPhotos;
	}

	/**
	 * Get minimum timestamp from LatestPhotosController or current timestamp ( image only )
	 * @return string $timestamp
	 */
	protected function getTimestamp() {
		wfProfileIn( __METHOD__ );

		$response = $this->sendRequest( 'LatestPhotosController', 'executeIndex' );
		$latestPhotos = $response->getVal( 'thumbUrls', '' );

		$timestamp = wfTimestamp( TS_MW );
		if ( !empty($latestPhotos) && is_array($latestPhotos) ) {
			foreach ( $latestPhotos as $photo ) {
				if ( !$photo['isVideoThumb'] ) {
					$photoTimestamp = wfTimestamp( TS_MW, $photo['date'] );
					if ( $photoTimestamp < $timestamp ) {
						$timestamp = $photoTimestamp;
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $timestamp;
	}

	/**
	 * @param array $vars
	 * @return bool
	 */
	static public function onMakeGlobalVariablesScript(&$vars) {
		global $wgShowAdModalInterstitialTimes;
		// How many ads to show while browsing Lightbox
		if ( !$wgShowAdModalInterstitialTimes ) {
			$wgShowAdModalInterstitialTimes = 1; // default: 1
		}

		$vars['wgEnableLightboxExt'] = true;
		$vars['wgShowAdModalInterstitialTimes'] = $wgShowAdModalInterstitialTimes;

		return true;
	}
}
