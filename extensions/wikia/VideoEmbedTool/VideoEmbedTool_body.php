<?php
/*
 * @author Inez Korczyński
 * @author Bartek Łapiński
 */

class VideoEmbedTool {

	use Wikia\Logger\Loggable;

	function loadMain( $error = false ) {
		global $wgContLanguageCode, $wgVETNonEnglishPremiumSearch, $wgUser;

		$showAddVideoBtn = $wgUser->isAllowed( 'videoupload' );

		$tmpl = new EasyTemplate( dirname( __FILE__ ).'/templates/' );
		$tmpl->set_vars( array(
			'error'  => $error,
			'vet_premium_videos_search_enabled' => ( $wgContLanguageCode == 'en' ) || $wgVETNonEnglishPremiumSearch,
			'showAddVideoBtn' => $showAddVideoBtn
		) );

		return $tmpl->render( "main" );
	}

	function editVideo() {
		global $wgRequest;

		$itemTitle = $wgRequest->getVal( 'itemTitle' );
		$title = Title::newFromText( $itemTitle, NS_FILE );
		$file = wfFindFile( $title );

		if ( !( $file instanceof LocalFile ) ) {
			header( 'X-screen-type: error' );
			return wfMessage( 'vet-non-existing' )->plain();
		}

		$options = [
			'autoplay' => false,
			'isAjax' => false,
		];

		$embedCode = $file->getEmbedCode( VIDEO_PREVIEW, $options );

		// Loading this to deal with video descriptions
		$vHelper = new VideoHandlerHelper();

		$props['id'] = $file->getVideoId();
		$props['vname'] = $file->getTitle()->getText();
		$props['code'] = json_encode( $embedCode );
		$props['metadata'] = '';
		$props['description'] = $vHelper->getVideoDescription( $file, false );
		$props['href'] = $title->getPrefixedText();

		$tmpl = new EasyTemplate( dirname( __FILE__ ).'/templates/' );

		$tmpl->set_vars( array( 'props' => $props, 'screenType' => 'edit' ) );

		return $tmpl->render( 'details' );
	}

	function insertVideo() {
		global $wgRequest, $wgUser;

		wfProfileIn( __METHOD__ );

		if ( $wgUser->isBlocked() ) {
			header( 'X-screen-type: error' );
			wfProfileOut( __METHOD__ );
			return wfMessage( 'videos-error-blocked-user' )->plain();
		}

		if ( !$wgUser->isAllowed( 'videoupload' ) ) {
			header( 'X-screen-type: error' );
			wfProfileOut( __METHOD__ );
			return wfMessage( 'videos-error-admin-only' )->plain();
		}

		$url = $wgRequest->getVal( 'url' );

		$tempname = 'Temp_video_' . $wgUser->getID() . '_' . rand( 0, 1000 );
		$title = Title::makeTitle( NS_FILE, $tempname );
		$nonPremiumException = null;

		try {
			$awf = ApiWrapperFactory::getInstance(); /* @var $awf ApiWrapperFactory */
			$apiwrapper = $awf->getApiWrapper( $url );
		} catch ( Exception $e ) {
			$nonPremiumException = $e;
		}

		$embedOptions = [
			'autoplay' => false,
			'isAjax' => false,
		];

		if ( !empty( $apiwrapper ) ) { // try ApiWrapper first - is it from a supported 3rd party ( non-premium ) provider?
			$provider = $apiwrapper->getMimeType();

			$file = new WikiaLocalFile( $title, RepoGroup::singleton()->getLocalRepo() );
			$file->forceMime( $provider );
			$file->setVideoId( $apiwrapper->getVideoId() );
			$file->setProps( array( 'mime'=>$provider ) );

			// Loading this to deal with video descriptions
			$vHelper = new VideoHandlerHelper();

			$props['id'] = $apiwrapper->getVideoId();
			$props['vname'] = $apiwrapper->getTitle();
			$props['metadata'] = '';
			$props['description'] = $vHelper->getVideoDescription( $file );
			$props['provider'] = $provider;

			$embed_code = $file->getEmbedCode( VIDEO_PREVIEW, $embedOptions );
			$props['code'] = json_encode( $embed_code );
		} else { // if not a supported 3rd party ( non-premium ) video, try to parse link for File:
			// get the video file
			$videoService = new VideoService();
			$file = $videoService->getVideoFileByUrl( $url );

			if ( !$file ) {
				header( 'X-screen-type: error' );
				if ( $nonPremiumException ) {
					if ( empty( F::app()->wg->allowNonPremiumVideos ) ) {
						wfProfileOut( __METHOD__ );
						return wfMessage( 'videohandler-non-premium' )->parse();
					}

					if ( $nonPremiumException->getMessage() != '' ) {
						wfProfileOut( __METHOD__ );
						return $nonPremiumException->getMessage();
					}
				}

				wfProfileOut( __METHOD__ );
				return wfMessage( 'vet-bad-url' )->plain();
			}

			/**
			 * Check if it's a video file - return an error if not and log an error.
			 */
			$handler = $file->getHandler();
			if ( !$handler instanceof VideoHandler ) {
				header( 'X-screen-type: error' );
				$this->error( __CLASS__ . ': Invalid media type supplied.', [
					'mimeType' => $file->getMimeType(),
					'handlerClass' => get_class( $handler ),
					'fileUrl' => $file->getFullUrl(),
				] );
				wfProfileOut( __METHOD__ );
				return wfMessage( 'vet-error-invalid-file-type' )->escaped();
			}

			// Loading this to deal with video descriptions
			$vHelper = new VideoHandlerHelper();

			$embedCode = $file->getEmbedCode( VIDEO_PREVIEW, $embedOptions );

			$props['provider'] = 'FILE';
			$props['id'] = $handler->getVideoId();
			$props['vname'] = $file->getTitle()->getText();
			$props['code'] = json_encode( $embedCode );
			$props['metadata'] = '';
			$props['description'] = $vHelper->getVideoDescription( $file );
			$props['premiumVideo'] = ( !$file->isLocal() );
		}

		wfProfileOut( __METHOD__ );

		return $this->detailsPage( $props );
	}

	function detailsPage( $props ) {
		global $wgUser;

		$tmpl = new EasyTemplate( dirname( __FILE__ ).'/templates/' );

		$showAddVideoBtn = $wgUser->isAllowed( 'videoupload' );

		$tmpl->set_vars( array(
			'props' => $props,
			'screenType' => 'details',
			'showAddVideoBtn' => $showAddVideoBtn
		) );

		return $tmpl->render( 'details' );
	}

	/*
	 * does the actual uploading.  moves temp file to permanent somehow.
	 */
	function insertFinalVideo() {
		global $wgRequest, $wgContLang;

		$this->checkWriteRequest();

		$id = $wgRequest->getVal( 'id' );
		$provider = $wgRequest->getVal( 'provider' );
		$name = urldecode( $wgRequest->getVal( 'name' ) );
		$embed_code = '';

		if ( $provider == 'FILE' ) { // no need to upload, local reference
			$title = $oTitle = Title::newFromText( $name, NS_FILE );
			if ( empty( $oTitle ) ) {
				header( 'X-screen-type: error' );
				return wfMessage( 'vet-name-incorrect' )->plain();
			}
			wfRunHooks( 'AddPremiumVideo', array( $title ) );
		} else { // needs to upload
			// sanitize name and init title objects
			$name = VideoFileUploader::sanitizeTitle( $name );

			if ( $name == '' ) {
				header( 'X-screen-type: error' );
				return wfMessage( 'vet-warn3' )->plain();
			}

			$nameFile = VideoFileUploader::sanitizeTitle( $name );
			$uploader = new VideoFileUploader();
			$titleFile = $uploader->getUniqueTitle( $nameFile );
			if ( empty( $titleFile ) ) {
				header( 'X-screen-type: error' );
				return wfMessage( 'vet-name-incorrect' )->plain();
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

			$parts = explode( '/',$provider );
			$provider = $parts[1];
			$oTitle = null;
			$status = $this->uploadVideoAsFile( $provider, $id, $nameSanitized, $oTitle );
			if ( !$status->ok ) {
				header( 'X-screen-type: error' );
				return wfMessage( 'wva-thumbnail-upload-failed' )->plain();
			}
		}

		$description = trim( urldecode( $wgRequest->getVal( 'description' ) ) );

		// Set the video descriptions
		$vHelper = new VideoHandlerHelper();
		$vHelper->setVideoDescription( $oTitle, $description );

		// SUS-66: let's wait for all slaves to catch up after the above
		wfWaitForSlaves();

		$message = wfMessage( 'vet-single-success' )->plain();
		$ns_file = $wgContLang->getFormattedNsText( $title->getNamespace() );
		$caption = $wgRequest->getVal( 'caption' );

		$width = $wgRequest->getVal( 'width' );
		$width = empty( $width ) ? 335 : $width;
		$layout = $wgRequest->getVal( 'layout' );

		header( 'X-screen-type: summary' );
		$tag = $ns_file . ":" . $oTitle->getText();

		// all videos added via VET will be shown as thumbnails / "framed"
		$tag .= "|thumb";

		if ( !empty( $layout ) ) {
			$tag .= "|$layout";
		}
		if ( $width != '' ) {
			$tag .= "|$width px";
		}
		if ( $caption != '' ) {
			$tag .= "|".$caption;
		}
		$tag = "[[$tag]]";
		$button_message = wfMessage( 'vet-return' )->plain();

		// Adding a video from article view page
		$editFromViewMode = $wgRequest->getVal( 'placeholder' );
		if ( $editFromViewMode ) {
			Wikia::setVar( 'EditFromViewMode', true );

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
				$embed_code = $file->transform( array( 'width'=>$width ) )->toHtml();

				$params = array(
					'alt' => $title->getText(),
					'title' => $title->getText(),
					'img-class' => 'thumbimage',
					'align' => $layout,
					'outerWidth' => $width,
					'file' => $file,
					'url' => $file->getUrl(),
					'html' => $embed_code,
				);

				$embed_code = F::app()->renderView( 'ThumbnailController', 'articleBlock', $params );

				// Make output match what's in a saved article
				if ( $layout == 'center' ) {
					$embed_code = '<div class="center">'.$embed_code.'</div>';
				}

				$summary = wfMessage( 'vet-added-from-placeholder' )->plain();

				$text = substr_replace( $text, $tag, $placeholder[1], strlen( $placeholder_tag ) );

				$button_message = wfMessage( 'vet-placeholder-return' )->plain();
				$success = $article_obj->doEdit( $text, $summary );
			}

			if ( !$success ) {
				header( 'X-screen-type: error' );
				return wfMessage( 'vet-insert-error' )->plain();
			}
		}

		$tmpl = new EasyTemplate( dirname( __FILE__ ).'/templates/' );
		$tmpl->set_vars( array(
			'tag' => $tag,
			'message' => $message,
			'code' => $embed_code,
			'button_message' => $button_message,
		) );

		return $tmpl->render( 'summary' );
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

		// SUS-66: let's wait for all slaves to catch up before uploading a video
		wfWaitForSlaves();

		return $oUploader->upload( $oTitle );
	}

	private function checkWriteRequest() {
		global $wgRequest, $wgUser;

		if ( !$wgRequest->wasPosted()
			|| !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) )
		) {
			throw new BadRequestException( 'Request must be POSTed and provide a valid edit token.' );
		}
	}
}
