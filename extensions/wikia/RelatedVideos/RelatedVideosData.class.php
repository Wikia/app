<?php

class RelatedVideosData {

	protected static $theInstance = null;

	const V_WIKIAVIDEO = 24;
	const DEFAULT_OASIS_VIDEO_WIDTH = 660;
	const MAX_TITLE_LENGTH = 240;

	function __construct() {

	}

	public function getVideoData( $titleText, $thumbnailWidth, $videoWidth = self::DEFAULT_OASIS_VIDEO_WIDTH, $autoplay = true, $useMaster = false, $cityShort='life', $videoHeight='', $useJWPlayer=true, $inAjaxResponse=false ) {

		wfProfileIn( __METHOD__ );

		$data = array();

		$title = Title::newFromText( $titleText, NS_FILE );

		$file = wfFindFile( $title );

		if( !WikiaFileHelper::isVideoFile( $file ) ) {
			$data['error'] = wfMsg( 'related-videos-error-no-video-title' );
		} else {

			$meta = unserialize($file->getMetadata());
			$trans = $file->transform(array('width'=>$thumbnailWidth, 'height'=>-1));

			$thumb = array(
				'width' => $trans->width,
				'height' => $trans->height,
				'thumb' => $trans->url
			);

			$data['external']		= 0; // false means it is not set. Meaningful values: 0 and 1.
			$data['id']				= $titleText;
			$data['fullUrl']		= $title->getFullURL();
			$data['prefixedUrl']	= $title->getPrefixedURL();
			$data['description']	= $file->getDescription();
			$data['duration']		= $meta['duration'];
			$data['embedCode']		= null;
			$data['embedJSON']		= null;
			$data['provider']		= $file->minor_mime;
			$data['thumbnailData']	= $thumb;
			$data['title']			= $file->getTitle()->getText();
			$data['timestamp']		= $file->getTimestamp();
			$data['uniqueId']		= $file->getVideoUniqueId();

		}


		$data['owner'] = '';
		$data['ownerUrl'] = '';

		wfProfileOut( __METHOD__ );
		return $data;
	}

	public function addVideo( $articleId, $url ) {

		wfProfileIn( __METHOD__ );

		if ( empty( $articleId ) ) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-no-article-id');
		}

		/*
		$targetTitle = F::build('Title', array($articleId), 'newFromId');
		if (!$targetTitle->exists()) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-unknown', 876462);
		}

		// check permission
		$permErrors = $targetTitle->getUserPermissionsErrors( 'edit', F::app()->wg->user );
		if ($permErrors) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-permission-article');
		}*/

		$videoService = F::build( 'VideoService' );
		$retval = $videoService->addVideo( $url );
		if ( !is_array($retval) ) {
			wfProfileOut( __METHOD__ );
			return $retval;
		}

		list($videoTitle, $videoPageId, $videoProvider) = $retval;

		// add to article's whitelist
		//$rvn = F::build( 'RelatedVideosNamespaceData', array( $targetTitle ), 'newFromTargetTitle' );
		$rvn = RelatedVideosNamespaceData::newFromGeneralMessage();
		if(empty($rvn)) {
			$rvn = RelatedVideosNamespaceData::createGlobalList();
		}
		$entry = $rvn->createEntry( $videoTitle->getText(), $videoProvider == self::V_WIKIAVIDEO );
		$retval = $rvn->addToList( RelatedVideosNamespaceData::WHITELIST_MARKER, array( $entry ), $articleId );
		if ( is_array( $rvn->entries ) ){
			$entry = end( $rvn->entries );
		}
		if ( is_object( $retval ) ) {
			if ( $retval->ok ) {
				$data = $entry;
				$data['articleId'] = $videoPageId;
				$data['title'] = $videoTitle->getText();
				$data['external'] = $videoProvider == self::V_WIKIAVIDEO;
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

		$name = substr($name, 0, self::MAX_TITLE_LENGTH);	// DB column Image.img_name has size 255

		$title = Title::makeTitleSafe(NS_VIDEO, $name);

		wfProfileOut( __METHOD__ );
		return $title;
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
			return wfMsg('related-videos-error-unknown', 876464);
		}

		// check permission
		$permErrors = $targetTitle->getUserPermissionsErrors( 'edit', F::app()->wg->user );
		if ($permErrors) {
			wfProfileOut( __METHOD__ );
			return wfMsg('related-videos-error-permission-article');
		}

		$rvn = F::build('RelatedVideosNamespaceData', array(), 'newFromGeneralMessage');
		if ( empty($rvn) ) {
			$rvn = F::build('RelatedVideosNamespaceData', array(), 'createGlobalList');
		}

		// standardize format of title
		$titleObj = F::build('Title', array($title), 'newFromText');
		$title = $titleObj->getText();
		$entry = $rvn->createEntry($title, $isExternal);

		// check video exists
		$rvs = F::build('RelatedVideosService');

		$entry['articleId'] = 0;
		$data = $rvs->getRelatedVideoData( $entry );
		if ( empty( $data['title'] ) ) {
			wfProfileOut( __METHOD__ );
			return wfMsg( 'related-videos-remove-video-error-nonexisting' );
		}

		$retval = $rvn->addToList( RelatedVideosNamespaceData::BLACKLIST_MARKER, array($entry), $articleId );
		if (is_object($retval)) {
			if ($retval->ok) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		else {	// error message returned
			wfProfileOut( __METHOD__ );
			return $retval;
		}

		$msg = wfMsg('related-videos-error-unknown', 543886);

		wfProfileOut( __METHOD__ );
		return $msg;
	}
}
