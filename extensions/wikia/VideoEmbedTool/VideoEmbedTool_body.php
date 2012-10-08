<?php
/*
 * @author Inez Korczyński
 * @author Bartek Łapiński
 */

class VideoEmbedTool {

	function loadMainFromView( $error = false ) {
		$out = '';

		$out .= '<script type="text/javascript">';
                $out .= 'var vet_back = \'' . wfMsg('vet-back') . '\';';
                $out .= 'var vet_imagebutton = \'' . wfMsg('vet-imagebutton') . '\';';
                $out .= 'var vet_close = \'' . wfMsg('vet-close') . '\';';
                $out .= 'var vet_warn1 = \'' . wfMsg('vet-warn1') . '\';';
                $out .= 'var vet_warn2 = \'' . wfMsg('vet-warn2') . '\';';
                $out .= 'var vet_warn3 = \'' . wfMsg('vet-warn3') . '\';';

                $out .= 'var vet_bad_extension = \'' . wfMsg('vet-bad-extension') . '\';';
                $out .= 'var vet_show_message = \'' . wfMsg('vet-show-message') . '\';';
                $out .= 'var vet_hide_message = \'' . wfMsg('vet-hide-message') . '\';';
                $out .= 'var vet_title = \'' . wfMsg('vet-title') . '\';';
                $out .= 'var vet_max_thumb = \'' . wfMsg('vet-max-thumb') . '\';';

                $out .= '</script>';

		global $wgBlankImgUrl;
		$out = '<div class="reset" id="VideoEmbed">';
                $out .= '<div id="VideoEmbedBorder"></div>';
                $out .= '<div id="VideoEmbedProgress1" class="VideoEmbedProgress"></div>';
		$out .= '<div id="VideoEmbedBack"><img src="'.$wgBlankImgUrl.'" id="fe_vetback_img" class="sprite back" alt="'.wfMsg('vet-back').'" /><a href="#">' . wfMsg( 'vet-back' ) . '</a></div>' ;
		$out .= '<div id="VideoEmbedClose"><img src="'.$wgBlankImgUrl.'" id="fe_vetclose_img" class="sprite close" alt="'.wfMsg('vet-close').'" /><a href="#">' . wfMsg( 'vet-close' ) . '</a></div>';
                $out .= '<div id="VideoEmbedBody">';
                $out .= '<div id="VideoEmbedError"></div>';
                $out .= '<div id="VideoEmbedMain">' . $this->loadMain() . '</div>';
                $out .= '<div id="VideoEmbedDetails" style="display: none;"></div>';
                $out .= '<div id="VideoEmbedConflict" style="display: none;"></div>';
                $out .= '<div id="VideoEmbedSummary" style="display: none;"></div>';
                $out .= '</div>';
                $out .= '</div>';

		return $out;
	}

	function loadMain( $error = false ) {
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
				'result' => '',
				'error'  => $error
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
		$props['oname'] = '';
		$props['vname'] = $file->getTitle()->getText();
		$props['code'] = is_string($embedCode) ? $embedCode : json_encode($embedCode);
		$props['metadata'] = '';
		$props['href'] = $title->getPrefixedText();

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		$tmpl->set_vars(array('props' => $props));
		return $tmpl->render('edit');
	}

	function insertVideo() {
		global $wgRequest, $wgUser, $wgContLang;

		$url = $wgRequest->getVal( 'url' );

		$tempname = 'Temp_video_'.$wgUser->getID().'_'.rand(0, 1000);
		$title = Title::makeTitle( NS_FILE, $tempname );
		$isNonPremium = false;
		try {
			$awf = ApiWrapperFactory::getInstance(); /* @var $awf ApiWrapperFactory */
			$apiwrapper = $awf->getApiWrapper( $url );

		}
		catch (WikiaException $e) {

			$isNonPremium = true;
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
			$props['provider'] = $provider;

			$props['code'] = $file->getEmbedCode(VIDEO_PREVIEW, false, false, true);
			$props['oname'] = '';
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
				if ( $isNonPremium ) {
					header('X-screen-type: error');

					if ( !empty(F::app()->wg->allowNonPremiumVideos) ) {
						return $e->getMessage();
					}

					return wfMsg( 'videohandler-non-premium' );
				}
				header('X-screen-type: error');
				return wfMsg( 'vet-bad-url' );
			}

			if ( !$file ) {
				header('X-screen-type: error');
				return wfMsg( 'vet-non-existing' );
			}

			$embedCode = $file->getEmbedCode(VIDEO_PREVIEW, false, false, true);

			$props['provider'] = 'FILE';
			$props['id'] = $file->getHandler()->getVideoId();
			$props['vname'] = $file->getTitle()->getText();
			$props['code'] = is_string($embedCode) ? $embedCode : json_encode($embedCode);
			$props['metadata'] = '';
			$props['oname'] = '';
		}

		return $this->detailsPage($props);
	}

	function detailsPage($props) {
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		$tmpl->set_vars(array('props' => $props));
		return $tmpl->render('details');
	}

	function insertFinalVideo() {
		global $wgRequest, $wgContLang;

		$id = $wgRequest->getVal('id');
		$provider = $wgRequest->getVal('provider');

		$name = urldecode( $wgRequest->getVal('name') );
		$oname = urldecode( $wgRequest->getVal('oname') );
		if ('' == $name) {
			$name = $oname;
		}

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

			$nameFile = VideoFileUploader::sanitizeTitle($name);
			$titleFile = Title::newFromText($nameFile, NS_FILE);
			if (empty($titleFile)) {
				header('X-screen-type: error');
				return wfMsg ( 'vet-name-incorrect' );
			}
			// by definition, WikiaFileHelper::useVideoHandlersExtForEmbed() == true
			$nameSanitized = $nameFile;
			$title = $titleFile;

			$extra = 0;
			$metadata = array();
			while( '' != $wgRequest->getVal( 'metadata' . $extra ) ) {
				$metadata[] = $wgRequest->getVal( 'metadata' . $extra );
				$extra++;
			}

			if (!empty($titleFile)) {
				$parts = explode('/',$provider);
				$provider = $parts[1];
				$oTitle = null;
				$status = $this->uploadVideoAsFile($provider, $id, $nameSanitized, $oTitle);
				if ( !$status->ok ) {
					header('X-screen-type: error');
					return wfMsg( 'wva-thumbnail-upload-failed' );
				}
				$message = wfMsg( 'vet-single-success' );
			}
		}
		$ns_vid = $wgContLang->getFormattedNsText( $title->getNamespace() );
		$caption = $wgRequest->getVal('caption');

		$size = $wgRequest->getVal('size');
		$width = $wgRequest->getVal('width');
		$layout = $wgRequest->getVal('layout');

		header('X-screen-type: summary');
		$tag = $ns_vid . ":" . $oTitle->getText();
		if(!empty($size))		$tag .= "|$size";
		if(!empty($layout))		$tag .= "|$layout";
		if($width != 'px')		$tag .= "|$width";
		if($caption != '')		$tag .= "|".$caption;

		$tag = "[[$tag]]";


		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
			'tag' => $tag,
			'message' => $message,
			'code' => $embed_code,
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

}
