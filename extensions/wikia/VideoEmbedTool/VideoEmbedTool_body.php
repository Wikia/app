<?php
/*
 * @author Inez Korczyński
 * @author Bartek Łapiński
 */

class VideoEmbedTool {

	function getMsgVars() {


		$vars = array(
			'vet-back',
			'vet-imagebutton',
			'vet-close',
			'vet-warn1',
			'vet-warn2',
			'vet-warn3',
		);

		$ret = array();

		foreach($vars as $var) {
			$ret[$var] = wfMsg($var);
		}

		return json_encode($ret);
	}

	function loadMain( $error = false ) {
		global $wgContLanguageCode, $wgVETNonEnglishPremiumSearch;

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
				'error'  => $error,
				'vet_premium_videos_search_enabled' => ($wgContLanguageCode == 'en') || $wgVETNonEnglishPremiumSearch
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

		$props['id'] = $file->getVideoId();
		$props['vname'] = $file->getTitle()->getText();
		$props['code'] = is_string($embedCode) ? $embedCode : json_encode($embedCode);
		$props['metadata'] = '';
		$props['description'] = $this->getVideoDescription($file, false);
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

		if( !empty($apiwrapper) ) { // try ApiWrapper first - is it from partners?
			$provider = $apiwrapper->getMimeType();

			$file = new WikiaLocalFile( $title, RepoGroup::singleton()->getLocalRepo() );
			$file->forceMime( $provider );
			$file->setVideoId( $apiwrapper->getVideoId() );
			$file->setProps(array('mime'=>$provider ));

			$props['id'] = $apiwrapper->getVideoId();
			$props['vname'] = $apiwrapper->getTitle();
			$props['metadata'] = '';
			$props['description'] = $this->getVideoDescription($file);
			$props['provider'] = $provider;

			$props['code'] = $file->getEmbedCode(VIDEO_PREVIEW, false, false, true);
		} else { // if not a partner video try to parse link for File:
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

			$embedCode = $file->getEmbedCode(VIDEO_PREVIEW, false, false, true);
			$props['provider'] = 'FILE';
			$props['id'] = $file->getHandler()->getVideoId();
			$props['vname'] = $file->getTitle()->getText();
			$props['code'] = is_string($embedCode) ? $embedCode : json_encode($embedCode);
			$props['metadata'] = '';

			$props['description'] = $this->getVideoDescription($file);
			$props['premiumVideo'] = ($wgRequest->getVal( 'searchType' ) == 'premium');
		}

		wfProfileOut(__METHOD__);
		return $this->detailsPage($props);
	}

	function detailsPage($props) {
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		$tmpl->set_vars(array('props' => $props, 'screenType' => 'details'));
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
		$this->setVideoDescription($oTitle, $description);

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
	 * @return mixed FileRepoStatus or FALSE on error
	 */

	private function uploadVideoAsFile( $provider, $videoId, $videoName, &$oTitle ) {
		$oUploader = new VideoFileUploader();
		$oUploader->setProvider( $provider );
		$oUploader->setVideoId( $videoId );
		$oUploader->setTargetTitle( $videoName );
		return $oUploader->upload( $oTitle );

	}

	/**
	 * Get video description, which is the content of the file page minus the category wiki tags
	 * @param File $file - The file object for this video
	 * @param bool $fillFromMeta - Whether or not to use the video meta description if the current
	 *                             description is blank
	 * @return string $text
	 */
	private function getVideoDescription( $file, $fillFromMeta = true ) {
		// Get the file page for this file
		$page = WikiPage::factory( $file->getTitle() );

		// remove description header
		$videoHandlerHelper = new VideoHandlerHelper();
		$text = $videoHandlerHelper->removeDescriptionHeader( $page->getText() );

		// Strip out the category tags so they aren't shown to the user
		$text = FilePageHelper::stripCategoriesFromDescription( $text );

		// If we have an empty string or a bunch of whitespace, and we're asked to do so,
		// use the default description from the file metadata
		if ( $fillFromMeta && preg_match('/^\s*$/ms', $text) ) {
			$text = $file->getMetaDescription();
		}

		return $text;
	}

	public function setVideoDescription( $title, $description ) {
		// Get the file page for this file
		$page = WikiPage::factory( $title );

		$text = $page->getText();

		// Insert description header
		$videoHandlerHelper = new VideoHandlerHelper();
		$text = $videoHandlerHelper->replaceDescriptionSection( $text, $description );

		$summary = 'Adding video description';
		$status = $page->doEdit( $text, $summary );

		if ( $status->isOK() ) {
			return 1;
		} else {
			return 0;
		}
	}
}
