<?php
/*
 * @author Inez Korczyński
 * @author Bartek Łapiński
 */

class VideoEmbedTool {

	function loadMain( $error = false ) {
		global $wgContLanguageCode, $wgVETNonEnglishPremiumSearch, $wgUser;


		$showAddVideoBtn = $wgUser->isAllowed('videoupload');

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
				'error'  => $error,
				'vet_premium_videos_search_enabled' => ($wgContLanguageCode == 'en') || $wgVETNonEnglishPremiumSearch,
				'showAddVideoBtn' => $showAddVideoBtn
				)
		);
		return $tmpl->render("main");
	}

	function recentlyUploaded() {
		global $IP, $wmu;
		require_once($IP . '/includes/SpecialPage.php');
		require_once($IP . '/includes/specials/SpecialNewimages.php');
		// this needs to be revritten, since we will not display recently uploaded, but embedded

		$isp = new IncludableSpecialPage('Newimages', '', 1, 'wfSpecialNewimages', $IP . '/includes/specials/SpecialNewimages.php');
		wfSpecialNewimages(8, $isp);
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array('data' => $wmu));
		return $tmpl->render("results_recently");
	}

	function editVideo() {
		global $wgRequest;
		$itemTitle = $wgRequest->getVal('itemTitle');
		$title = Title::newFromText($itemTitle, NS_FILE);
		$file = wfFindFile( $title );

		if ( ! ( $file instanceof LocalFile ) ) {
			header('X-screen-type: error');
			return wfMsg( 'vet-non-existing' );
		}

		$embedCode = $file->getEmbedCode(VIDEO_PREVIEW, false, false, true);

		// Loading this to deal with video descriptions
		$vHelper = new VideoHandlerHelper();

		$props['id'] = $file->getVideoId();
		$props['vname'] = $file->getTitle()->getText();
		$props['code'] = json_encode($embedCode);
		$props['metadata'] = '';
		$props['description'] = $vHelper->getVideoDescription($file, false);
		$props['href'] = $title->getPrefixedText();

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		$tmpl->set_vars(array('props' => $props, 'screenType' => 'edit'));
		return $tmpl->render('details');
	}

	function insertVideo() {
		global $wgRequest, $wgUser, $wgContLang;
		wfProfileIn(__METHOD__);

		if ( $wgUser->isBlocked() ) {
			header('X-screen-type: error');
			wfProfileOut( __METHOD__ );
			return wfMessage( 'videos-error-blocked-user' );
		}

		if ( !$wgUser->isAllowed('videoupload') ) {
			header('X-screen-type: error');
			wfProfileOut( __METHOD__ );
			return wfMessage( 'videos-error-admin-only' )->plain();
		}

		$url = $wgRequest->getVal( 'url' );

		$tempname = 'Temp_video_'.$wgUser->getID().'_'.rand(0, 1000);
		$title = Title::makeTitle( NS_FILE, $tempname );
		$nonPremiumException = null;

		try {
			$awf = ApiWrapperFactory::getInstance(); /* @var $awf ApiWrapperFactory */
			$apiwrapper = $awf->getApiWrapper( $url );
		}
		catch ( Exception $e ) {
			$nonPremiumException = $e;
		}

		if( !empty($apiwrapper) ) { // try ApiWrapper first - is it from a supported 3rd party (non-premium) provider?
			$provider = $apiwrapper->getMimeType();

			$file = new WikiaLocalFile( $title, RepoGroup::singleton()->getLocalRepo() );
			$file->forceMime( $provider );
			$file->setVideoId( $apiwrapper->getVideoId() );
			$file->setProps(array('mime'=>$provider ));

			// Loading this to deal with video descriptions
			$vHelper = new VideoHandlerHelper();

			$props['id'] = $apiwrapper->getVideoId();
			$props['vname'] = $apiwrapper->getTitle();
			$props['metadata'] = '';
			$props['description'] = $vHelper->getVideoDescription($file);
			$props['provider'] = $provider;

			$embed_code = $file->getEmbedCode(VIDEO_PREVIEW, false, false, true);
			$props['code'] = json_encode($embed_code);
		} else { // if not a supported 3rd party (non-premium) video, try to parse link for File:
			$file = null;
			// get the video name
			$nsFileTranslated = $wgContLang->getNsText(NS_FILE);
			// added $nsFileTransladed to fix bugId:#48874
			$pattern = '/(File:|Video:|'.$nsFileTranslated.':)(.+)$/';
			if (preg_match($pattern, $url, $matches)) {
				$file = wfFindFile( $matches[2] );
				if ( !$file ) { // bugID: 26721
					$file = wfFindFile( urldecode($matches[2]) );
				}
			}
			elseif (preg_match($pattern, urldecode($url), $matches)) {
				$file = wfFindFile( $matches[2] );
				if ( !$file ) { // bugID: 26721
					$file = wfFindFile( $matches[2] );
				}
			}
			else {
				header( 'X-screen-type: error' );
				if ( $nonPremiumException ) {
					if ( empty(F::app()->wg->allowNonPremiumVideos) ) {
						wfProfileOut( __METHOD__ );
						return wfMessage( 'videohandler-non-premium' )->parse();
					}

					if ( $nonPremiumException->getMessage() != '' ) {
						wfProfileOut( __METHOD__ );
						return $nonPremiumException->getMessage();
					}
				}

				wfProfileOut( __METHOD__ );
				return wfMsg( 'vet-bad-url' );
			}

			if ( !$file ) {
				header('X-screen-type: error');
				wfProfileOut(__METHOD__);
				return wfMsg( 'vet-non-existing' );
			}

			// Loading this to deal with video descriptions
			$vHelper = new VideoHandlerHelper();

			$embedCode = $file->getEmbedCode(VIDEO_PREVIEW, false, false, true);

			$props['provider'] = 'FILE';
			$props['id'] = $file->getHandler()->getVideoId();
			$props['vname'] = $file->getTitle()->getText();
			$props['code'] = json_encode($embedCode);
			$props['metadata'] = '';
			$props['description'] = $vHelper->getVideoDescription( $file );
			$props['premiumVideo'] = ($wgRequest->getVal( 'searchType' ) == 'premium');
		}

		wfProfileOut(__METHOD__);
		return $this->detailsPage($props);
	}

	function detailsPage($props) {
		global $wgUser;


		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		$showAddVideoBtn = $wgUser->isAllowed('videoupload');

		$tmpl->set_vars(
			array('props' => $props,
			'screenType' => 'details',
			'showAddVideoBtn' => $showAddVideoBtn
		));

		return $tmpl->render('details');
	}

	/*
	 * does the actual uploading.  moves temp file to permanent somehow.
	 */
	function insertFinalVideo() {
		global $wgRequest, $wgContLang;

		$id = $wgRequest->getVal('id');
		$provider = $wgRequest->getVal('provider');
		$ns_file = $wgContLang->getFormattedNsText( NS_FILE );

		$name = urldecode( $wgRequest->getVal('name') );

		$embed_code = '';
		$tag = '';
		$message = '';

		if($provider == 'FILE') { // no need to upload, local reference
			$title = $oTitle = Title::newFromText($name, NS_FILE);
			if (empty($oTitle)) {
				header('X-screen-type: error');
				return wfMsg ( 'vet-name-incorrect' );
			}
			wfRunHooks( 'AddPremiumVideo', array( $title ) );
		} else { // needs to upload
			// sanitize name and init title objects
			$name = VideoFileUploader::sanitizeTitle($name);

			if($name == '') {
				header('X-screen-type: error');
				return wfMsg('vet-warn3');
			}

			$nameFile = VideoFileUploader::sanitizeTitle( $name );
         	$titleFile = VideoFileUploader::getUniqueTitle( $nameFile );
         	if (empty($titleFile)) {
				header('X-screen-type: error');
				return wfMsg ( 'vet-name-incorrect' );
			}
			// by definition, WikiaFileHelper::useVideoHandlersExtForEmbed() == true
			$nameSanitized = $titleFile->getBaseText();
			$title = $titleFile;

			$extra = 0;
			$metadata = array();
			while( '' != $wgRequest->getVal( 'metadata' . $extra ) ) {
				$metadata[] = $wgRequest->getVal( 'metadata' . $extra );
				$extra++;
			}

			$parts = explode('/',$provider);
			$provider = $parts[1];
			$oTitle = null;
			$status = $this->uploadVideoAsFile($provider, $id, $nameSanitized, $oTitle);
			if ( !$status->ok ) {
				header('X-screen-type: error');
				return wfMsg( 'wva-thumbnail-upload-failed' );
			}
		}

		$description = urldecode( $wgRequest->getVal('description') );

		// Set the video descriptions
		$vHelper = new VideoHandlerHelper();
		$vHelper->setVideoDescription($oTitle, $description);

		$message = wfMsg( 'vet-single-success' );
		$ns_file = $wgContLang->getFormattedNsText( $title->getNamespace() );
		$caption = $wgRequest->getVal('caption');

		$size = $wgRequest->getVal('size');
		$width = $wgRequest->getVal('width');
		$width = empty($width) ? 335 : $width;
		$layout = $wgRequest->getVal('layout');

		header('X-screen-type: summary');
		$tag = $ns_file . ":" . $oTitle->getText();
		if(!empty($size))		$tag .= "|$size";
		if(!empty($layout))		$tag .= "|$layout";
		if($width != '')		$tag .= "|$width px";
		if($caption != '')		$tag .= "|".$caption;

		$tag = "[[$tag]]";
		$button_message = wfMessage('vet-return');

		// Adding a video from article view page
		$editingFromArticle = $wgRequest->getVal( 'placeholder' );
		if( $editingFromArticle ) {
			Wikia::setVar('EditFromViewMode', true);

			$article_title = $wgRequest->getVal( 'article' );
			$ns = $wgRequest->getVal( 'ns' );
			$box = $wgRequest->getVal( 'box' );

			$article_title_obj = Title::newFromText( $article_title, $ns );
			$article_obj = new Article( $article_title_obj );
			$text = $article_obj->getContent();

			// match [[File:Placeholder|video]]
			$placeholder = MediaPlaceholderMatch( $text, $box, true );

			$success = false;
			if ( $placeholder ) {

				$placeholder_tag = $placeholder[0];
				$file = wfFindFile( $title );
				$embed_code = $file->transform( array('width'=>$width) )->toHtml();
				$html_params = array(
					'imageHTML' => $embed_code,
					'align' => $layout,
					'width' => $width,
					'showCaption' => !empty($caption),
					'caption' => $caption,
					'showPictureAttribution' => true,
				);

				// Get all html to insert into article view page
				$image_service = F::app()->sendRequest( 'ImageTweaksService', 'getTag', $html_params );
				$image_data = $image_service->getData();
				$embed_code = $image_data['tag'];

				// Make output match what's in a saved article
				if($layout == 'center') {
					$embed_code = '<div class="center">'.$embed_code.'</div>';
				}

				$summary = wfMsg( 'vet-added-from-placeholder' );

				$text = substr_replace( $text, $tag, $placeholder[1], strlen( $placeholder_tag ) );

				$button_message = wfMessage('vet-placeholder-return');
				$success = $article_obj->doEdit( $text, $summary);
			}

			if ( !$success ) {
				header('X-screen-type: error');
				return wfMsg ( 'vet-insert-error' );
			}
		}

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
			'tag' => $tag,
			'message' => $message,
			'code' => $embed_code,
			'button_message' => $button_message,
			));
		return $tmpl->render('summary');
	}

	/**
	 * Upload video using LocalFile framework
	 * @param mixed $provider string or int from $wgVideoMigrationProviderMap
	 * @param string $videoId
	 * @param string $videoName
	 * @param $oTitle
	 * @return mixed FileRepoStatus or FALSE on error
	 */
	private function uploadVideoAsFile( $provider, $videoId, $videoName, &$oTitle ) {
		$oUploader = new VideoFileUploader();
		$oUploader->setProvider( $provider );
		$oUploader->setVideoId( $videoId );
		$oUploader->setTargetTitle( $videoName );
		return $oUploader->upload( $oTitle );

	}
}
