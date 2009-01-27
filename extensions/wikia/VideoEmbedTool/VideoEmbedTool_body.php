<?php
/*
 * @author Inez Korczyński
 * @author Bartek Łapiński
 */

class VideoEmbedTool {

	function loadMain( $error = false ) {
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
				'result' => '',
				'error'  => $error
				)
		);
		return $tmpl->execute("main");
	}

	function loadLicense() {
		global $wgRequest, $IP;
		$license = $wgRequest->getText('license');
		require_once($IP . '/includes/specials/SpecialUpload.php');
		return preg_replace( '/(<a[^>]+)/', '$1 target="_new" ', UploadForm::ajaxGetLicensePreview( $license ) );		
	}

	function recentlyUploaded() {
		global $IP, $wmu;
		require_once($IP . '/includes/SpecialPage.php');
		require_once($IP . '/includes/specials/SpecialNewimages.php');
		$isp = new IncludableSpecialPage('Newimages', '', 1, 'wfSpecialNewimages', $IP . '/includes/specials/SpecialNewimages.php');
		wfSpecialNewimages(8, $isp);
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array('data' => $wmu));
		return $tmpl->execute("results_recently");
	}

	function query() {
		global $wgRequest, $IP;

		$query = $wgRequest->getText('query');
		$page = $wgRequest->getVal('page');
		$sourceId = $wgRequest->getVal('sourceId');

		if($sourceId == 1) {
			require_once($IP.'/extensions/3rdparty/ImportFreeImages/phpFlickr-2.2.0/phpFlickr.php');
			$flickrAPI = new phpFlickr('bac0bd138f5d0819982149f67c0ca734');
			$flickrResult = $flickrAPI->photos_search(array('tags' => $query, 'tag_mode' => 'all', 'page' => $page, 'per_page' => 8, 'license' => '4,5', 'sort' => 'interestingness-desc'));
			$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
			$tmpl->set_vars(array('results' => $flickrResult, 'query' => addslashes($query)));
			return $tmpl->execute('results_flickr');
		} else if($sourceId == 0) {
			$db =& wfGetDB(DB_SLAVE);
			$res = $db->query("SELECT count(*) as count FROM `page` WHERE lower(page_title) LIKE '%".strtolower($db->escapeLike($query))."%' AND page_namespace = 6 ORDER BY page_title ASC LIMIT 8");
			$row = $db->fetchRow($res);
			$results = array();
			$results['total'] = $row['count'];
			$results['pages'] = ceil($row['count']/8);
			$results['page'] = $page;
			$res = $db->query("SELECT page_title FROM `page` WHERE lower(page_title) LIKE '%".strtolower($db->escapeLike($query))."%' AND page_namespace = 6 ORDER BY page_title ASC LIMIT 8 OFFSET ".($page*8-8));
			while($row = $db->fetchObject($res)) {
				$results['images'][] = array('title' => $row->page_title);
			}
			$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
			$tmpl->set_vars(array('results' => $results, 'query' => addslashes($query)));
			return $tmpl->execute('results_thiswiki');
		}
	}

	function chooseImage() {

		global $wgRequest, $wgUser, $IP;
		$itemId = $wgRequest->getVal('itemId');
		$sourceId = $wgRequest->getInt('sourceId');

		// todo this is unused now, since there is currently now search
		// to be applied later

		return $this->detailsPage($props);
	}

	function checkImage() {
		global $IP, $wgRequest;

		$mFileSize = $wgRequest->getFileSize( 'wpUploadFile' );
		$mSrcName = stripslashes($wgRequest->getFileName( 'wpUploadFile' ));
		$filtered = wfStripIllegalFilenameChars( $mSrcName );
		$form = new UploadForm( $wgRequest, '' );

		// no filename or zero size
		if( trim( $mSrcName ) == '' || empty( $mFileSize ) ) {
			return UploadForm::EMPTY_FILE;
		}

		//illegal filename
		$nt = Title::makeTitleSafe( NS_IMAGE, $filtered );
		if( is_null( $nt ) ) {
			return UploadForm::ILLEGAL_FILENAME;
		}

		// extensions check
		list( $partname, $ext ) = $form->splitExtensions( $filtered );

		if( count( $ext ) ) {
			$finalExt = $ext[count( $ext ) - 1];
		} else {
			$finalExt = '';
		}

		// for more than one "extension"
		if( count( $ext ) > 1 ) {
			for( $i = 0; $i < count( $ext ) - 1; $i++ )
				$partname .= '.' . $ext[$i];
		}

		if( strlen( $partname ) < 1 ) {
			return UploadForm::MIN_LENGHT_PARTNAME;
		}

		$form->mFileProps = File::getPropsFromPath( $form->mTempPath, $finalExt );
		$form->checkMacBinary();
		$veri = $form->verify( $form->mTempPath, $finalExt );

		if( $veri !== true ) { //it's a wiki error...
//			$resultDetails = array( 'veri' => $veri );
			return UploadForm::VERIFICATION_ERROR;
		}

		global $wgCheckFileExtensions, $wgStrictFileExtensions;
		global $wgFileExtensions, $wgFileBlacklist;
		if ($finalExt == '') {
			return UploadForm::FILETYPE_MISSING;
		} elseif ( $form->checkFileExtensionList( $ext, $wgFileBlacklist ) ||
				($wgCheckFileExtensions && $wgStrictFileExtensions &&
					!$form->checkFileExtension( $finalExt, $wgFileExtensions ) ) ) {
			return UploadForm::FILETYPE_BADTYPE;
		}

		if(!wfRunHooks('WikiaMiniUpload:BeforeProcessing', $mSrcName)) {
			wfDebug( "Hook 'WikiaMiniUpload:BeforeProcessing' broke processing the file." );
			return UploadForm::VERIFICATION_ERROR;
		}

		return UploadForm::SUCCESS;
	}

	function translateError ( $error ) {
		switch( $error ) {
			case UploadForm::SUCCESS:
				return false;
			case UploadForm::EMPTY_FILE:
				return wfMsg( 'emptyfile' );
			case UploadForm::MIN_LENGHT_PARTNAME:
				return wfMsg( 'minlength1' );
			case UploadForm::ILLEGAL_FILENAME:
				return wfMsg( 'illegalfilename' );
			case UploadForm::FILETYPE_MISSING:
				return wfMsg( 'filetype-missing' );
			case UploadForm::FILETYPE_BADTYPE:
				return wfMsg( 'filetype-bad-extension' );
			case UploadForm::VERIFICATION_ERROR:
				return "File type verification error!" ;
			default:
				return false;
		}
	}

	function insertVideo() {
		global $IP, $wgRequest, $wgUser;
		require_once( "$IP/extensions/wikia/WikiaVideo/VideoPage.php" );
		$url = $wgRequest->getVal( 'wpVideoEmbedUrl' );			
		$tempname = 'Temp_video_'.$wgUser->getID().'_'.rand(0, 1000);
		$title = Title::makeTitle( NS_VIDEO, $tempname );
		$video = new VideoPage( $title );

		// todo some safeguard here to take care of bad urls
		if( !$video->parseUrl( $url ) ) {
			header('X-screen-type: error');
			return $this->loadMain( wfMsg( 'vet-bad-url' ) );
		}
			
		$props['provider'] = $video->getProvider();
		$props['id'] = $video->getVideoId();
		$data = $video->getData();
		if (is_array( $data ) ) {
			$props['metadata'] = implode( ",", $video->getData() );
		} else {
			$props['metadata'] = '';		
		}
		$props['code'] = $video->getEmbedCode( VIDEO_PREVIEW );

		return $this->detailsPage($props);
	}

	function getVideoFromName() {
                global $wgRequest, $wgUser, $wgContLang, $IP;
                require_once( "$IP/extensions/wikia/WikiaVideo/VideoPage.php" );

                $name = $wgRequest->getVal('name');		
		$title = Title::makeTitle( NS_VIDEO, $name );
		$video = new VideoPage( $title );
		$video->load();
		return $video->getEmbedCode();
	}

	function detailsPage($props) {
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		$tmpl->set_vars(array('props' => $props));	
		return $tmpl->execute('details');
	}

	function insertFinalVideo() {
		global $wgRequest, $wgUser, $wgContLang, $IP;
		require_once( "$IP/extensions/wikia/WikiaVideo/VideoPage.php" );

		$type = $wgRequest->getVal('type');
		$id = $wgRequest->getVal('id');
		$provider = $wgRequest->getVal('provider');
		$name = $wgRequest->getVal('name');

		$title = Title::makeTitle( NS_VIDEO, $name );
					
		$extra = 0;
		$metadata = array();
		while( '' != $wgRequest->getVal( 'metadata' . $extra ) ) {
			$metadata[] = $wgRequest->getVal( 'metadata' . $extra );
			$extra++;
		}

		if($name !== NULL) {
			if($name == '') {
				header('X-screen-type: error');
				// todo messagize
				return 'You need to specify file name first!';
			} else {

				$title = Title::makeTitleSafe(NS_VIDEO, $name);
				if(is_null($title)) {
					header('X-screen-type: error');
					return wfMsg ( 'wmu-filetype-incorrect' ); 
				}
				if($title->exists()) {
					if($type == 'overwrite') {
						// is the target protected?
						$permErrors = $title->getUserPermissionsErrors( 'edit', $wgUser );
						$permErrorsUpload = $title->getUserPermissionsErrors( 'upload', $wgUser );
						$permErrorsCreate = ( $title->exists() ? array() : $title->getUserPermissionsErrors( 'create', $wgUser ) );

						if( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
							header('X-screen-type: error');
							// todo messagize
							return 'This image is protected';
						}

						$video = new VideoPage( $title );
						if ($video instanceof VideoPage) {
							$video->loadFromPars( $provider, $id, $metadata );					
							$video->setName( $name );
							$video->save();					
						}
					} else if($type == 'existing') {
						header('X-screen-type: existing');
						$title = Title::makeTitle( NS_VIDEO, $name );						
						$video = new VideoPage( $title );
						
						$props = array();
						$video->load();
						$props['provider'] = $video->getProvider();
						$props['id'] = $video->getVideoId();
						$data = $video->getData();
						if (is_array( $data ) ) {
							$props['metadata'] = implode( ",", $video->getData() );
						} else {
							$props['metadata'] = '';
						}
						$props['code'] = $video->getEmbedCode( VIDEO_PREVIEW );

						return $this->detailsPage($props);
					} else {
						header('X-screen-type: conflict');
						$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
						$tmpl->set_vars( array(
							'name' => $name,
							'id' => $id,
							'provider' => $provider,
							'metadata' => $metadata,	
							)
						);
						return $tmpl->execute('conflict');
					}
				} else {
					// is the target protected?
					$permErrors = $title->getUserPermissionsErrors( 'edit', $wgUser );
					$permErrorsUpload = $title->getUserPermissionsErrors( 'upload', $wgUser );
					$permErrorsCreate = ( $title->exists() ? array() : $title->getUserPermissionsErrors( 'create', $wgUser ) );

					if( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
						header('X-screen-type: error');
						// todo messagize
						return 'This video is protected';
					}

					$video = new VideoPage( $title );
					if ($video instanceof VideoPage) {
						$video->loadFromPars( $provider, $id, $metadata );
						$video->setName( $name );
						$video->save();					
					}
				}
			}
		} else {
			$title = Title::newFromText($mwname, 6);
		}


		header('X-screen-type: summary');

		$size = $wgRequest->getVal('size');
		$width = $wgRequest->getVal('width');
		$layout = $wgRequest->getVal('layout');
		$caption = $wgRequest->getVal('caption');
		$slider = $wgRequest->getVal('slider');

		$ns_img = $wgContLang->getFormattedNsText( NS_VIDEO );

		$tag = '[[' . $ns_img . ':'.$name;

		if($size != 'full') {
			$tag .= '|thumb';
		}

		$tag .= '|'.$width;
		$tag .= '|'.$layout;
		if($caption != '') {
			$tag .= '|'.$caption.']]';
		} else {
			$tag .= ']]';
		}

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array('tag' => $tag));
		return $tmpl->execute('summary');
	}

	function clean() {
		global $wgRequest;
		$file = new FakeLocalFile(Title::newFromText($wgRequest->getVal('mwname'), 6), RepoGroup::singleton()->getLocalRepo());
		$file->delete('');
	}
}

