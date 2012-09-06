<?php
/*
 * @author Inez Korczyński
 * @author Bartek Łapiński
 */

class WikiaMiniUpload {
	const USER_PERMISSION_ERROR = -1;

	// this is the function that wraps up the WMU loaded from view, because otherwise
	// there would be a problem loading the messages
	// messages themselves are sent in json
        function loadMainFromView( $error = false ) {
		global $wgFileExtensions, $wgFileBlacklist, $wgCheckFileExtensions, $wgStrictFileExtensions, $wgUser;
		global $wgRequest;

		$script_a = array();

		$script_a['wmu_back'] = htmlspecialchars( wfMsg('wmu-back') );
		$script_a['wmu_imagebutton'] = htmlspecialchars( wfMsg('wmu-imagebutton') );
		$script_a['wmu_close'] = htmlspecialchars( wfMsg('wmu-close') );
		$script_a['wmu_warn1'] = htmlspecialchars( wfMsg('wmu-warn1') );
		$script_a['wmu_warn2'] = htmlspecialchars( wfMsg('wmu-warn2') );
		$script_a['wmu_warn3'] = htmlspecialchars( wfMsg('wmu-warn3') );

		$script_a['wmu_bad_extension'] = htmlspecialchars( wfMsg('wmu-bad-extension') );
		$script_a['wmu_title'] = htmlspecialchars( wfMsg('wmu-title') );
		$script_a['wmu_max_thumb'] = htmlspecialchars( wfMsg('wmu-max-thumb') );
		$script_a['wmu_no_protect'] = htmlspecialchars( wfMsg('wmu-no-protect') );
		$script_a['wmu_no_rights'] = htmlspecialchars( wfMsg('wmu-no-rights') );
		$script_a['badfilename'] = htmlspecialchars( wfMsg('badfilename') );

		$script_a['file_extensions'] = $wgFileExtensions;
		$script_a['file_blacklist'] = $wgFileBlacklist;
		$script_a['check_file_extensions'] = htmlspecialchars( $wgCheckFileExtensions );
		$script_a['strict_file_extensions'] = htmlspecialchars( $wgStrictFileExtensions );

		( $wgUser->isBlocked() ) ? $script_a['user_blocked'] = true : $script_a['user_blocked'] = false;

		$title = Title::newFromText($wgRequest->getVal( 'article' ), $wgRequest->getVal( 'ns' ) );
		// if the page is protected
		( $title->isProtected() ) ? $script_a['user_protected'] = true : $script_a['user_protected'] = false;

		( $wgUser->isLoggedIn() && !$title->userCan( 'edit' ) ) ? $script_a['user_disallowed'] = true : $script_a['user_disallowed'] = false;

		// for disabled anonymous editing
		( !$wgUser->isLoggedIn() && !$title->userCan( 'edit' ) ) ? $script_a['wmu_init_login'] = true : $script_a['wmu_init_login'] = false;

		global $wgBlankImgUrl;
		$out = '<div class="reset" id="ImageUpload">';
		$out .= '<div id="ImageUploadBorder"></div>';
		$out .= '<div id="ImageUploadProgress1" class="ImageUploadProgress"></div>';
		$out .= '<div id="ImageUploadBack"><img src="'.$wgBlankImgUrl.'" id="fe_wmuback_img" class="sprite back" alt="'.wfMsg('wmu-back').'" /><a href="#">' . wfMsg( 'wmu-back' ) . '</a></div>' ;
		$out .= '<div id="ImageUploadClose"><img src="'.$wgBlankImgUrl.'" id="fe_wmuclose_img" class="sprite close" alt="'.wfMsg('wmu-close').'" /><a href="#">' . wfMsg( 'wmu-close' ) . '</a></div>';
		$out .= '<div id="ImageUploadBody">';
		$out .= '<div id="ImageUploadError"></div>';
		$out .= '<div id="ImageUploadMain">' . $this->loadMain() . '</div>';
		$out .= '<div id="ImageUploadDetails" style="display: none;"></div>';
		$out .= '<div id="ImageUploadConflict" style="display: none;"></div>';
		$out .= '<div id="ImageUploadSummary" style="display: none;"></div>';
		$out .= '</div>';
		$out .= '</div>';

		$script_a['html'] = $out;

		// jsonify
                return json_encode( $script_a );
        }

	// normal, that is loaded from view, main screen
	function loadMain( $error = false ) {
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
				'result' => $this->recentlyUploaded(),
				'error'  => $error
				)
		);
		return $tmpl->render("main");
	}

	// recently uploaded images on that wiki
	function recentlyUploaded() {
		global $IP, $wmu;
		require_once($IP . '/extensions/wikia/WikiaNewFiles/SpecialNewFiles.php');

		$isp = new IncludableSpecialPage('Newimages', '', 1, 'wfSpecialWikiaNewFiles', $IP . '/extensions/wikia/WikiaNewFiles/SpecialNewFiles.php');
		wfSpecialWikiaNewFiles(8, $isp);
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array('data' => $wmu));
		return $tmpl->render("results_recently");
	}

     function query() {
        global $wgRequest, $wgHTTPProxy;

        $query = $wgRequest->getText('query');
        $page = $wgRequest->getVal('page', 1);
        $sourceId = $wgRequest->getVal('sourceId');

        if($sourceId == 1) {

            $flickrAPI = new phpFlickr('bac0bd138f5d0819982149f67c0ca734');
            $proxyArr = explode(':', $wgHTTPProxy);
            $flickrAPI->setProxy($proxyArr[0], $proxyArr[1]);
            $flickrResult = $flickrAPI->photos_search(array('tags' => $query, 'tag_mode' => 'all', 'page' => $page, 'per_page' => 8, 'license' => '4,5', 'sort' => 'interestingness-desc'));

			$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
            $tmpl->set_vars(array('results' => $flickrResult, 'query' => addslashes($query)));

            return $tmpl->render('results_flickr');

        } else if($sourceId == 0) {

			if ( (int)$page == 0 ) $page = 1;

			$results = MediaQueryService::searchInTitle($query, $page, 8);

			$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
			$tmpl->set_vars(array('results' => $results, 'query' => addslashes($query)));
			return $tmpl->render('results_thiswiki');
        }
    }


	function tempFileName( $user ) {
		return 'Temp_file_'. $user->getID(). '_' . time();
	}

	// store info in the db to enable the script to pick it up later during the day (via an automated cleaning routine)
	function tempFileStoreInfo( $filename ) {
		global $wgExternalSharedDB, $wgCityId;

		$path = LocalFile::newFromTitle(
			Title::makeTitle( NS_FILE, $filename ),
			RepoGroup::singleton()->getLocalRepo()
		)->getPath( );


		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->insert(
			'garbage_collector',
			array(
				'gc_filename'	=>	$path,
				'gc_timestamp'	=>	$dbw->timestamp(),
				'gc_wiki_id'	=>	$wgCityId,
			),
			__METHOD__
		);
		$dbw->commit();
		return $dbw->insertId();
	}

	// remove the data about this file from the db, so it won't clutter it
	function tempFileClearInfo( $id ) {
		global $wgExternalSharedDB;

		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->delete(
			'garbage_collector',
			array(
				'gc_id'	=>	$id,
			),
			__METHOD__
		);
		$dbw->commit();
	}

	// this function loads the image details page
	function chooseImage() {
		global $wgRequest, $wgUser, $wgHTTPProxy;
		$itemId = $wgRequest->getVal('itemId');
		$sourceId = $wgRequest->getInt('sourceId');

		if($sourceId == 0) {
			$file = wfFindFile(Title::newFromText($itemId, 6));
			$props = array();
			$props['file'] = $file;
			$props['mwname'] = $itemId;
			$props['default_caption'] = !empty($file) ? Wikia::getProps($file->getTitle()->getArticleID(), 'default_caption') : '';
		} else if($sourceId == 1) {
                    $flickrAPI = new phpFlickr('bac0bd138f5d0819982149f67c0ca734');
                    $proxyArr = explode(':', $wgHTTPProxy);
                    $flickrAPI->setProxy($proxyArr[0], $proxyArr[1]);
                    $flickrResult = $flickrAPI->photos_getInfo($itemId);

					// phpFlickr 3.x has different response structure than previous version
					$flickrResult = $flickrResult['photo'];

                    $url = "http://farm{$flickrResult['farm']}.static.flickr.com/{$flickrResult['server']}/{$flickrResult['id']}_{$flickrResult['secret']}.jpg";
                    $data = array('wpUpload' => 1, 'wpSourceType' => 'web', 'wpUploadFileURL' => $url);
					$upload = new UploadFromUrl();
					$upload->initializeFromRequest(new FauxRequest($data, true));
					$upload->fetchFile();
                    $tempname = $this->tempFileName( $wgUser );
                    $file = new FakeLocalFile(Title::newFromText($tempname, 6), RepoGroup::singleton()->getLocalRepo());
                    $file->upload($upload->getTempPath(), '', '');
                    $tempid = $this->tempFileStoreInfo( $tempname );
                    $props = array();
                    $props['file'] = $file;
                    $props['name'] = preg_replace("/[^".Title::legalChars()."]|:/", '-', trim($flickrResult['title']).'.jpg');
                    $props['mwname'] = $tempname;
                    $props['extraId'] = $itemId;
                    $props['tempid'] = $tempid;
		}
		return $this->detailsPage($props);
	}

	// perform image check
	function checkImage() {
		global $wgRequest, $wgUser;

		$mSrcName = stripslashes($wgRequest->getFileName( 'wpUploadFile' ));

		$upload = new UploadFromFile();
		$upload->initializeFromRequest($wgRequest);
		$permErrors = $upload->verifyPermissions( $wgUser );

		if ( $permErrors !== true ) {
			return self::USER_PERMISSION_ERROR;
		}

		$ret = $upload->verifyUpload();

		if(!wfRunHooks('WikiaMiniUpload:BeforeProcessing', array($mSrcName))) {
			wfDebug( "Hook 'WikiaMiniUpload:BeforeProcessing' broke processing the file." );
			return UploadBase::VERIFICATION_ERROR;
		}

		if(is_array($ret)) {
			return $ret['status'];
		} else {
			return $ret;
		}
	}

	function translateError ( $error ) {
		switch( $error ) {
			case UploadBase::SUCCESS:
				return false;
			case UploadBase::EMPTY_FILE:
				return wfMsg( 'emptyfile' );
			case UploadBase::MIN_LENGTH_PARTNAME:
				return wfMsg( 'minlength1' );
			case UploadBase::ILLEGAL_FILENAME:
				return wfMsg( 'illegalfilename' );
			case UploadBase::FILETYPE_MISSING:
				return wfMsg( 'filetype-missing' );
			case UploadBase::FILETYPE_BADTYPE:
				return wfMsg( 'filetype-bad-extension' );
			case UploadBase::VERIFICATION_ERROR:
				return "File type verification error!" ;
			case self::USER_PERMISSION_ERROR:
				return wfMsg( 'badaccess' );
			default:
				return false;
		}
	}

	function uploadImage() {
		global $wgRequest, $wgUser;

		$check_result = $this->checkImage() ;
		if (UploadBase::SUCCESS == $check_result) {
			$tempname = $this->tempFileName( $wgUser );
			$file = new FakeLocalFile(Title::newFromText($tempname, 6), RepoGroup::singleton()->getLocalRepo());
			$file->upload($wgRequest->getFileTempName('wpUploadFile'), '', '');
			$tempid = $this->tempFileStoreInfo( $tempname );
			$props = array();
			$props['file'] = $file;
			$props['name'] = stripslashes($wgRequest->getFileName('wpUploadFile'));
			$props['mwname'] = $tempname;
			$props['tempid'] = $tempid;
			$props['upload'] = true;
			$props['default_caption'] = Wikia::getProps($file->getTitle()->getArticleID(), 'default_caption');
			return $this->detailsPage($props);
		} else {
			return $this->loadMain( $this->translateError( $check_result ) );
		}
	}

	// generate details page
	function detailsPage($props) {

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		if (isset($props['name'])) {
			list( $partname, $ext ) = UploadBase::splitExtensions( $props['name'] );

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

			$props['partname'] = $partname;
			$props['extension'] = strtolower( $finalExt );
		}

		// a guard
		if( !is_object( $props['file'] ) ) {
			return $this->loadMain( $this->translateError( UploadBase::EMPTY_FILE ) );
		}

		$tmpl->set_vars(array('props' => $props));
		return $tmpl->render('details');
	}

	// this function generates the image for replacing the placeholder after adding the image
	function generateImage( $file, $name, $title, $thumbnail = false, $width = 0, $layout = '', $caption = '' ) {
		global $wgStylePath;
		$page = $name;

		if( $page ) {
			$query = isset($query) ? '&page=' . urlencode( $page ) : 'page=' . urlencode( $page );
		}
		$file = wfFindFile( $name );
		$url = $title->getLocalURL( $query );

		$orig = $file->getWidth( $page );

		if( !$width || ( $orig < $width ) ) {
			$width = $orig;
		}
		if( !$layout ) {
			$layout = 'right';
		}

		$hp = array(
			'width' => $width
		);

		$thumb =  $file->transform( $hp );
		$more = htmlspecialchars( wfMsg( 'thumbnail-more' ) );

		if ( !$thumbnail ) {
			// cater for full size here
			$s = "<div class=\"t{$layout}\">";
			$s = $thumb->toHtml( array(
						'alt' => $name,
						'title' => $name,
						'img-class' => 'thumbimage',
						'desc-link' => true,
						'desc-query' => '') );

			$zoomicon = '';
			$s .= "</div>";
		} else {
			$s = "<div class=\"thumb t{$layout}\"><div class=\"thumbinner\" style=\"width:{$width};\">";
			$s .= $thumb->toHtml( array(
						'alt' => $name,
						'title' => $name,
						'img-class' => 'thumbimage',
						'desc-link' => true,
						'desc-query' => '') );
				$zoomicon =  '<div class="magnify">'.
					'<a href="'.$url.'" class="internal" title="'.$more.'">'.
					'<img src="'.$wgStylePath.'/common/images/magnify-clip.png" ' .
					'width="15" height="11" alt="" /></a></div>';
			$s .= '  <div class="thumbcaption">'.$zoomicon.$caption."</div></div></div>";
		}
		return str_replace("\n", ' ', $s);
	}

	// this functions handle the third step of the WMU, image insertion
	function insertImage() {
		global $wgRequest, $wgUser, $wgContLang, $wgHTTPProxy;
		$type = $wgRequest->getVal('type');
		$name = $wgRequest->getVal('name');
		$mwname = $wgRequest->getVal('mwname');
		$tempid = $wgRequest->getVal('tempid');

		( '' != $wgRequest->getVal( 'gallery' ) ) ? $gallery = $wgRequest->getVal( 'gallery' ) : $gallery = '' ;
		( '' != $wgRequest->getVal( 'article' ) ) ? $title_main = urldecode( $wgRequest->getVal( 'article' ) ) : $title_main = '' ;
		( '' != $wgRequest->getCheck( 'fck' ) ) ? $fck = $wgRequest->getCheck( 'ns' ) : $fck = false ;
		( '' != $wgRequest->getVal( 'ns' ) ) ? $ns = $wgRequest->getVal( 'ns' ) : $ns = '' ;
		( '' != $wgRequest->getVal( 'link' ) ) ? $link = urldecode( $wgRequest->getVal( 'link' ) ) : $link = '' ;

		$extraId = $wgRequest->getVal('extraId');
		$newFile =  true;

		if($name !== NULL) {
			$name = urldecode( $name );
			if($name == '') {
				header('X-screen-type: error');
				return WfMsg( 'wmu-warn3' );
			} else {
				$name = preg_replace("/[^".Title::legalChars()."]|:/", '-', $name);
				// did they give no extension at all when they changed the name?
				$ext = explode( '.', $name );
				array_shift( $ext );
				if( count( $ext ) ) {
					$finalExt = $ext[count( $ext ) - 1];
				} else {
					$finalExt = '';
				}

				if( '' == $finalExt ) {
					header('X-screen-type: error');
					return wfMsg( 'wmu-filetype-missing' );
				}

				$title = Title::makeTitleSafe(NS_IMAGE, $name);
				if(is_null($title)) {
					header('X-screen-type: error');
					return wfMsg ( 'wmu-filetype-incorrect' );
				}
				if($title->exists()) {
					if($type == 'overwrite') {
						$title = Title::newFromText($name, 6);
						// is the target protected?
						$permErrors = $title->getUserPermissionsErrors( 'edit', $wgUser );
						$permErrorsUpload = $title->getUserPermissionsErrors( 'upload', $wgUser );
						$permErrorsCreate = ( $title->exists() ? array() : $title->getUserPermissionsErrors( 'create', $wgUser ) );

						if( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
							header('X-screen-type: error');
							return wfMsg( 'wmu-file-protected' );
						}

						$file_name = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());
						$file_mwname = new FakeLocalFile(Title::newFromText($mwname, 6), RepoGroup::singleton()->getLocalRepo());

						if(!empty($extraId)) {
							$flickrAPI = new phpFlickr('bac0bd138f5d0819982149f67c0ca734');
							$proxyArr = explode(':', $wgHTTPProxy);
                                                        $flickrAPI->setProxy($proxyArr[0], $proxyArr[1]);

                                                        $flickrResult = $flickrAPI->photos_getInfo($extraId);

							$nsid = $flickrResult['owner']['nsid']; // e.g. 49127042@N00
							$username = $flickrResult['owner']['username']; // e.g. bossa67
							$license = $flickrResult['license'];

							$caption = '{{MediaWiki:Flickr'.intval($license).'|1='.wfEscapeWikiText($extraId).'|2='.wfEscapeWikiText($nsid).'|3='.wfEscapeWikiText($username).'}}';
						} else {
							$caption = '';
						}

						$file_name->upload($file_mwname->getPath(), '', $caption);
						$file_mwname->delete('');
						$this->tempFileClearInfo( $tempid );
						$newFile = false;
					} else if($type == 'existing') {
						$file = wfFindFile( Title::newFromText( $name, 6 ) );

						if ( !empty( $file ) ) {
							header('X-screen-type: existing');
							$props = array();
							$props['file'] = $file;
							$props['mwname'] = $name;
							$props['default_caption'] = Wikia::getProps($file->getTitle()->getArticleID(), 'default_caption');
							return $this->detailsPage($props);
						} else {
							header('X-screen-type: error');
							return wfMsg( 'wmu-file-error' );
						}
					} else {
						header('X-screen-type: conflict');
						$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

						// extensions check
						list( $partname, $ext ) = UploadBase::splitExtensions( $name );

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

						$tmpl->set_vars(array(
									'partname' => $partname,
									'extension' => strtolower( $finalExt ),
									'mwname' => $mwname,
									'extraId' => $extraId
								     ));
						return $tmpl->render('conflict');
					}
				} else {
					// is the target protected?
					$permErrors = $title->getUserPermissionsErrors( 'edit', $wgUser );
					$permErrorsUpload = $title->getUserPermissionsErrors( 'upload', $wgUser );
					$permErrorsCreate = ( $title->exists() ? array() : $title->getUserPermissionsErrors( 'create', $wgUser ) );

					if( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
						header('X-screen-type: error');
						wfMsg( 'wmu-file-protected' );
					}

					$temp_file = new LocalFile(Title::newFromText($mwname, 6), RepoGroup::singleton()->getLocalRepo());
					$file = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());

					if(!empty($extraId)) {
						$flickrAPI = new phpFlickr('bac0bd138f5d0819982149f67c0ca734');

                                                $proxyArr = explode(':', $wgHTTPProxy);
                                                $flickrAPI->setProxy($proxyArr[0], $proxyArr[1]);
						$flickrResult = $flickrAPI->photos_getInfo($extraId);

						$nsid = $flickrResult['owner']['nsid']; // e.g. 49127042@N00
						$username = $flickrResult['owner']['username']; // e.g. bossa67
						$license = $flickrResult['license'];

						$caption = '{{MediaWiki:Flickr'.intval($license).'|1='.wfEscapeWikiText($extraId).'|2='.wfEscapeWikiText($nsid).'|3='.wfEscapeWikiText($username).'}}';
					} else {
						// get the supplied license value
						$license = $wgRequest->getVal( 'ImageUploadLicense' );

						if ( $license != '' ) {
							$caption = '== ' . wfMsgForContent( 'license' ) . " ==\n" . '{{' . $license . '}}' . "\n";
						} else {
							$caption = "";
						}
					}

					$file->upload($temp_file->getPath(), '', $caption);
					$temp_file->delete('');
					$this->tempFileClearInfo( $tempid );
				}

				if( $wgUser->getOption( 'watchdefault' ) || ( $newFile && $wgUser->getOption( 'watchcreations' ) ) ) {
					$wgUser->addWatch($title);
				}
				$db =& wfGetDB(DB_MASTER);
				$db->commit();
			}
		} else {
			$title = Title::newFromText($mwname, 6);
		}

		$file = wfFindFile($title);
		if (!is_object($file)) {
			header('X-screen-type: error');
			return 'File was not found!';
		}

		if( ( -2 == $gallery ) && !$fck ) {
			// this went in from the single placeholder...
			$name = $title->getText();
			$size = $wgRequest->getVal('size');
			$width = $wgRequest->getVal('width');
			$layout = $wgRequest->getVal('layout');
			// clear the old caption for upload
			$caption = $wgRequest->getVal('caption');
			$slider = $wgRequest->getVal('slider');
			$ns_vid = $wgContLang->getFormattedNsText( NS_FILE );
			$ns_img = ImagePlaceholderTranslateNsImage();

			$title_obj = Title::newFromText( $title_main, $ns );
			$article_obj = new Article( $title_obj );
			$text = $article_obj->getContent();

			wfRunHooks( 'WikiaMiniUpload::fetchTextForImagePlaceholder', array( &$title_obj, &$text ) );

			( '' != $wgRequest->getVal( 'box' ) ) ? $box = $wgRequest->getVal( 'box' ) : $box = '' ;

			$placeholder_msg = wfMsgForContent( 'imgplc-placeholder' );

			$transl_v_t = '\[\[' . $ns_vid . ':' . $placeholder_msg . '[^\]]*\]\]';
			$transl_i_t = '\[\[' . $ns_img . ':' . $placeholder_msg . '[^\]]*\]\]';

			$success = false;

			preg_match_all( '/' . $transl_v_t . '|' . $transl_i_t . '/si', $text, $matches, PREG_OFFSET_CAPTURE );

			if( is_array( $matches ) && $box < count($matches[0]) ) {
				$our_gallery = $matches[0][$box][0];
				$gallery_split = explode( ':', $our_gallery );
				$thumb = false;

				$tag = $gallery_split[0] . ":" . $name;

				if($size != 'full') {
					$tag .= '|thumb';
					$thumb = true;
				}

				if( isset( $width ) ) {
					$tag .= '|'.$width;
				}
				$tag .= '|'.$layout;

				if( $link != '' ) {
					$tag .= '|link=' . $link;
				}
				if( $caption != '' ) {
					$tag .= '|' . $caption;
				}


				$tag .= "]]";

				$text = substr_replace( $text, $tag, $matches[0][$box][1], strlen( $our_gallery ) );
				// return the proper embed code with all fancies around it
				$embed_code = $this->generateImage( $file, $name, $title_obj, $thumb, (int)str_replace( 'px', '', $width ), $layout, $caption );
				$message = wfMsg( 'wmu-success' );

				Wikia::setVar('EditFromViewMode', true);

				$summary = wfMsg( 'wmu-added-from-plc' ) ;
				$success = $article_obj->doEdit( $text, $summary);
			}

			if ( $success ) {
				header('X-screen-type: summary');
			} else {
				// failure signal opens js alert (BugId:4935)
				// header('X-screen-type: error');
			}
		} else {
			header('X-screen-type: summary');

			$size = $wgRequest->getVal('size');
			$width = $wgRequest->getVal('width');
			$layout = $wgRequest->getVal('layout');
			$caption = $wgRequest->getVal('caption');
			$slider = $wgRequest->getVal('slider');

			$ns_img = $wgContLang->getFormattedNsText( NS_IMAGE );

			$tag = '[[' . $ns_img . ':'.$title->getDBkey();
			if($size != 'full' && ($file->getMediaType() == 'BITMAP' || $file->getMediaType() == 'DRAWING')) {
				$tag .= '|thumb';
				if($layout != 'right') {
					$tag .= '|'.$layout;
				}
				if($slider == 'true') {
					$tag .= '|'.$width;
				}
			}
			if( $link != '' && $size == 'full' ) {
				$tag .= '|link=' . $link;
			}
			if($caption != '') {
				if($size == 'full') {
					$tag .= '|frame';
				}
				$tag .= '|'.$caption.']]';
			} else {
				$tag .= ']]';
			}
		}
		$message = wfMsg( 'wmu-success' );

		if ($wgRequest->getVal ( 'update_caption' ) == 'on') {
			Wikia::setProps($title->getArticleID(), array('default_caption' => $caption));
		}

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
						'tag' => $tag,
						'filename' => $ns_img . ':'.$title->getDBkey(),
						'message' => $message,
						'code' => isset($embed_code) ? $embed_code : '',
					 ));
		return $tmpl->render('summary');
	}

	function clean() {
		global $wgRequest;
		$file = new FakeLocalFile(Title::newFromText($wgRequest->getVal('mwname'), 6), RepoGroup::singleton()->getLocalRepo());
		$file->delete('');
		$this->tempFileClearInfo( $wgRequest->getVal('tempid') );
	}
}
