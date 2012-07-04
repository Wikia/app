<?php

/**
 * Lightbox controller
 * @author Hyun
 * @author Liz
 * @author Piotr Bablok
 */
class LightboxController extends WikiaController {
	
	const THUMBNAIL_WIDTH = 90;
	const THUMBNAIL_HEIGHT = 55;
	static $imageserving;
	
	public function __construct() {
	}
	
	public function lightboxModalContent() {
		$this->showAds = false; //$this->wg->User->isAnon() || $this->wg->User->getOption('showAds'); /* TODO: Re-enable once ad ops fixes ads (BugId:32950) and (BugId:33370)
		// set cache control to 1 day 
		$this->response->setCacheValidity(86400, 86400, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH)); 
	}
	
	public function lightboxModalContentError() {
		// set cache control to 1 day
		$this->response->setCacheValidity(86400, 86400, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH)); 
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
	 * @responseParam string userThumbUrl - user avatar thumbUrl scaled to 30x30
	 * @responseParam string userName - user name
	 * @responseParam string userPageUrl - url to user profile page
	 * @responseParam array articles - array of articles that has title and url
	 */
	public function getMediaDetail() {
		$fileTitle = $this->request->getVal('title', '');
		
		$fileTitle = urldecode($fileTitle);
		$title = F::build('Title', array($fileTitle, NS_FILE), 'newFromText');
		
		$data = WikiaFileHelper::getMediaDetail($title, array('imageMaxWidth'  => 1000,
									'contextWidth'   => $this->request->getVal('width', 660),
									'contextHeight'  => $this->request->getVal('height', 360),
									'userAvatarWidth'=> 16,
									'maxHeight'	 => 395
							));

		// create a truncated list, and mark it if necessary (this is mostly for display, because mustache is a logicless templating system)
		// TODO: hyun - maybe move this to JS?
		$articles = $data['articles'];
		$isPostedIn = false; // Bool to tell mustache to print "posted in" section
		$smallerArticleList = array();
		$articleListIsSmaller = 0;
		if(!empty($articles)) {
			$isPostedIn = true;
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
		$this->userThumbUrl = $data['userThumbUrl'];
		$this->userName = $data['userName'];
		$this->userPageUrl = $data['userPageUrl'];
		$this->articles = $data['articles'];
		$this->isPostedIn = $isPostedIn;
		$this->smallerArticleList = $smallerArticleList;
		$this->articleListIsSmaller = $articleListIsSmaller;
		$this->exists = $data['exists'];
		
		// set cache control to 1 hour
		$this->response->setCacheValidity(3600, 3600, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
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
		$articleNS = '';
		$articleTitleText = '';
		$embedMarkup = '';
		$fileUrl = '';
		$thumbUrl = '';
		$networks = array();
		
		if(!empty($file)) {
			$fileTitleObj =  F::build('Title', array($fileTitle, NS_FILE), 'newFromText');
			$articleTitle = $this->request->getVal('articleTitle');
			$articleTitleObj = F::build('Title', array($articleTitle), 'newFromText');

			if(!empty($articleTitleObj) && $articleTitleObj->exists()) {

				$fileParam = $fileTitleObj->getDBKey();
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
			$linkDescription = wfMsg('lightbox-share-description', empty($articleUrl) ? $fileTitleObj->getText() : $articleTitleText, $this->wg->Sitename);
			if(WikiaFileHelper::isFileTypeVideo( $file )) {
				$embedMarkup = $file->getEmbedCode(300, true, false);
			} else {
				$embedMarkup = "<a href=\"$shareUrl\"><img width=\"" . $thumb->getWidth() . "\" height=\"" . $thumb->getHeight() . "\" src=\"$thumbUrl\"/></a>";
			}
			
			$shareNetworks = F::build( 'SocialSharingService' )->getNetworks( array(
				'facebook',
				'twitter',
				'stumbleupon',
				'reddit',
				'plusone',
			) );
			foreach($shareNetworks as $network) {
				$networks[] = array(
					'id' => $network->getId(),
					'url' => $network->getUrl($shareUrl, $linkDescription)
				);
			}
		}

		// Don't show embed code for screenplay b/c it's using JW Player
		if($file->getProviderName() == 'screenplay') {
			$embedMarkup = false;
		}

		// Don't show embed code for screenplay b/c it's using JW Player
		if($file->getProviderName() == 'screenplay') {
			$embedMarkup = false;
		}

		$this->shareUrl = $shareUrl;
		$this->embedMarkup = $embedMarkup;
		$this->articleUrl = $articleUrl;
		$this->fileUrl = $fileUrl;
		$this->networks = $networks;
		$this->fileTitle = $fileTitle;
		$this->imageUrl = $thumbUrl;
	}

	
	/**
 	 * @brief AJAX function for sending share e-mails
	 * @requestParam string addresses - comma-separated list of email addresses
	 * @requestParam string shareUrl - share url being emailed
	 */
	public function shareFileMail() {
		$user = $this->wg->User;
		$errors = array();
		$sent = array();
		$notsent = array();

		if (!$user->isLoggedIn()) {
			$errors[] = 'notloggedin';
		} else {
			$addresses = $this->request->getVal('addresses', '');
			$shareUrl = $this->request->getVal('shareUrl', '');
			if (!empty($addresses) && !empty($shareUrl) && !$user->isBlockedFromEmailuser() ) {
				$addresses = explode(',', $addresses);
	
				//send mails
				$sender = new MailAddress($this->wg->NoReplyAddress, 'Wikia');	//TODO: use some standard variable for 'Wikia'?
				foreach ($addresses as $address) {
					$to = new MailAddress($address);
					$result = UserMailer::send(
						$to,
						$sender,
						wfMsg('lightbox-share-email-subject', array("$1" => $user->getName())),
						wfMsg('lightbox-share-email-body', $shareUrl),
						null,
						null,
						'ImageLightboxShare'
					);
					if (!$result->isOK()) {
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

}