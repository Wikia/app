<?php

class RelatedVideosData {

	protected static $theInstance = null;
	protected static $memcKeyPrefix = 'RelatedVideosData';
	protected static $memcTtl = 86400;
	protected static $memcVer = 11;
	protected $memcKey;
	
	function __construct() {
		
	}
	
	public function getVideoData( $title, $thumbnailWidth, $videoWidth = VideoPage::DEFAULT_OASIS_VIDEO_WIDTH, $autoplay = true, $useMaster = false, $cityShort='life' ) {

		wfProfileIn( __METHOD__ );

		$data = array();
		if ( empty( $title ) || !is_object( $title ) || !( $title instanceof Title ) || !$title->exists() ){
			$data['error'] = wfMsg('related-videos-error-no-video-title');
		} else {
			$videoPage = F::build( 'VideoPage', array( $title ) );
			$videoPage->load($useMaster);
			$data['external'] = false; // false means it is not set. Meaning values are 0 and 1.
			$data['id'] = $title->getArticleID();
			$data['description'] = $videoPage->getDescription();
			$data['duration'] = $videoPage->getDuration();
			$data['embedCode'] = $videoPage->getEmbedCode( $videoWidth, $autoplay, true, false, $cityShort );
			$data['embedJSON'] = $videoPage->getJWPlayerJSON( $videoWidth, $autoplay, $cityShort );
			$data['fullUrl'] = $title->getFullURL();
			$data['prefixedUrl'] = $title->getPrefixedURL();
			$data['provider'] = $videoPage->getProvider();
			$data['thumbnailData'] = $videoPage->getThumbnailParams( $thumbnailWidth );
			$data['title'] = $videoPage->getTitle()->getText();
			$data['timestamp'] = $videoPage->getTimestamp();	//@todo for premium video, eventually use date published given by provider

			$owner = '';
			$ownerUrl = '';
			$oArticle = F::build( 'Article', array( $title->getArticleID() ), 'newFromID' );
			if( !empty( $oArticle ) ){
				$owner = $oArticle->getUserText();
				if (!empty($owner)) {
					$oOwner = F::build( 'User', array( $owner ), 'newFromName' );
					if (is_object($oOwner)) {
						$ownerUrl = $oOwner->getUserPage()->getFullURL();
					}
				}
			}
			$data['owner'] = $owner;
			$data['ownerUrl'] = $ownerUrl;
		}
		wfProfileOut( __METHOD__ );
		return $data;
	}
	
	public function addVideo($articleId, $url) {

		wfProfileIn( __METHOD__ );
		if ( empty( $articleId ) ){
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-no-article-id');
		}

		if ( empty( $url ) ){
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-no-video-url');
		}

		$targetTitle = F::build('Title', array($articleId), 'newFromId');
		if (!$targetTitle->exists()) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-unknown', 876463);
		}
		
		// check permission
		$permErrors = $targetTitle->getUserPermissionsErrors( 'edit', F::app()->wg->user );
		if ($permErrors) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-permission-article');
		}
		
		// create temp VideoPage to parse URL
		$tempname = 'Temp_video_' . F::app()->wg->user->getID() . '_'.rand(0, 1000);
		$temptitle = Title::makeTitle( NS_VIDEO, $tempname );
		$video = new VideoPage( $temptitle );
		if( !$video->parseUrl( $url ) ) {
			wfProfileOut( __METHOD__ );
			return wfMsg( 'related-videos-add-video-error-bad-url' );
		}

		if( !$video->checkIfVideoExists() ) {
			wfProfileOut( __METHOD__ );
			return wfMsg( 'related-videos-add-video-error-nonexisting' );
		}

		$videoName = $video->getVideoName();
		$videoProvider = $video->getProvider();
		$videoId = $video->getVideoId();
		$videoMetadata = $video->getData();

		// check if video already exists on this wiki. If not, create 
		// new VideoPage
		$videoTitle = $this->sanitizeTitle($videoName);
		if(is_null($videoTitle)) {
			wfProfileOut( __METHOD__ );
			return wfMsg ( 'related-videos-add-video-error-bad-name' );
		}
		if($videoTitle->exists()) {
			$videoPageId = $videoTitle->getArticleID();
			// no need to create video page
		} else {
			// is the target protected?
			$permErrors = $videoTitle->getUserPermissionsErrors( 'edit', F::app()->wg->user );
			$permErrorsUpload = $videoTitle->getUserPermissionsErrors( 'upload', F::app()->wg->user );
			$permErrorsCreate = ( $videoTitle->exists() ? array() : $videoTitle->getUserPermissionsErrors( 'create', F::app()->wg->user ) );

			if( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
				return wfMsg( 'related-videos-add-video-error-permission-video' );
			}

			$video = new VideoPage( $videoTitle );
			$video->loadFromPars( $videoProvider, $videoId, $videoMetadata );
			$video->setName( $videoName );
			$video->save();
			$videoPageId = $video->getTitle()->getArticleID();
		}
		
		// add to article's whitelist
		$rvn = F::build('RelatedVideosNamespaceData', array($targetTitle), 'newFromTargetTitle');
		$entry = $rvn->createEntry($videoTitle->getText(), $videoProvider == VideoPage::V_WIKIAVIDEO);
		$retval = $rvn->addToList( RelatedVideosNamespaceData::WHITELIST_MARKER, array($entry), $articleId );
		if (is_object($retval)) {
			if ($retval->ok) {
				$data['articleId'] = $videoPageId;
				$data['title'] = $videoTitle->getText();
				$data['external'] = $videoProvider == VideoPage::V_WIKIAVIDEO;
				wfProfileOut( __METHOD__ );
				return $data;
			}
			else {
				
			}
		}
		wfProfileOut( __METHOD__ );
		return $retval;		
	}
	
	protected function sanitizeTitle($name) {
		
		wfProfileIn( __METHOD__ );
		// sanitize title
		$name = preg_replace(Title::getTitleInvalidRegex(), ' ', $name);
		// get rid of slashes. these are technically allowed in article
		// titles, but they refer to subpages, which videos don't have
		$name = str_replace('/', ' ', $name);
		$name = str_replace('  ', ' ', $name);
		
		wfProfileOut( __METHOD__ );
		return Title::makeTitleSafe(NS_VIDEO, $name);		
	}
	
	public function removeVideo($articleId, $title, $isExternal) {

		wfProfileIn( __METHOD__ );
		// general validation
		if ( empty( $title ) ) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-add-video-error-bad-url');
		}

		if ( empty( $articleId ) ) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-unknown', 876463);
		}

		$targetTitle = F::build('Title', array($articleId), 'newFromId');
		if (!$targetTitle->exists()) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-unknown', 876463);
		}
		
		// check permission
		$permErrors = $targetTitle->getUserPermissionsErrors( 'edit', F::app()->wg->user );
		if ($permErrors) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-permission-article');
		}
		
		$rvn = F::build('RelatedVideosNamespaceData', array($targetTitle), 'newFromTargetTitle');

		// standardize format of title
		$titleObj = F::build('Title', array($title), 'newFromText');
		$title = $titleObj->getText();
		$entry = $rvn->createEntry($title, $isExternal);

		// check video exists
		$rvs = F::build('RelatedVideosService');
		$data = $rvs->getRelatedVideoData( 0, $entry['title'], $entry['source'] );
		if (empty($data['title'])) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-remove-video-error-nonexisting');
		}

		$retval = $rvn->addToList( RelatedVideosNamespaceData::BLACKLIST_MARKER, array($entry) );
		if (is_object($retval)) {
			if ($retval->ok) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		else {	// error message returned
			return $retval;
		}
		
		wfProfileOut( __METHOD__ );
		return wfMsg('related-videos-error-unknown', 543886);
	}
}