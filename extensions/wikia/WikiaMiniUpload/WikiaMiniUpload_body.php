<?php
/**
 * @author Inez Korczyński
 * @author Bartek Łapiński
 */

class WikiaMiniUpload {
	const USER_PERMISSION_ERROR = -1;

	/**
	 * This is the function that wraps up the WMU loaded from view, because otherwise
	 * there would be a problem loading the messages.  Messages themselves are sent in json
	 *
	 * @param bool $error
	 * @return string
	 */
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

		$script_a['user_blocked'] = $wgUser->isBlocked();

		$title = Title::newFromText($wgRequest->getVal( 'article' ), $wgRequest->getVal( 'ns' ) );
		// if the page is protected
		$script_a['user_protected'] = $title->isProtected();
		$script_a['user_disallowed'] = $wgUser->isLoggedIn() && !$title->userCan( 'edit' );

		// for disabled anonymous editing
		$script_a['wmu_init_login'] = !$wgUser->isLoggedIn() && !$title->userCan( 'edit' );

		global $wgBlankImgUrl;
		$out = '<div class="reset" id="ImageUpload">';
		$out .= '<div id="ImageUploadBorder"></div>';
		$out .= '<div id="ImageUploadProgress1" class="ImageUploadProgress"></div>';
		$out .= '<div id="ImageUploadBack"><img src="'.$wgBlankImgUrl.'" id="fe_wmuback_img" class="sprite back" alt="'.wfMsg('wmu-back').'" /><a href="#">' . wfMsg( 'wmu-back' ) . '</a></div>' ;
		$out .= '<div id="ImageUploadBody" class="nope">';
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

	/**
	 * Normal (e.g. loaded from view) main screen
	 *
	 * @param bool $error
	 * @return string
	 */
	function loadMain( $error = false ) {
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array(
				'result' => $this->recentlyUploaded(),
				'error'  => $error
				)
		);
		return $tmpl->render("main");
	}

	/**
	 * Recently uploaded images on that wiki
	 *
	 * @return string
	 */
	function recentlyUploaded() {
		global $wgRequest;

		$limit = 8;
		$offset = $wgRequest->getVal('offset');

		$constrain = array();
		$exactHeight = $wgRequest->getVal('exactHeight');
		if ( $exactHeight ) {
			$exactHeight = intval($exactHeight);
			$constrain[] = "img_height = $exactHeight";
		}

		$exactWidth = $wgRequest->getVal('exactWidth');
		if ( $exactWidth ) {
			$exactWidth = intval($exactWidth);
			$constrain[] = "img_width = $exactWidth";
		}

		$info = $this->getImages($limit, $offset, $constrain);

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
		$tmpl->set_vars(array('data' => $info));
		return $tmpl->render("results_recently");
	}

     function query() {
        global $wgRequest, $wgFlickrAPIKey;

        $query = $wgRequest->getText('query');
        $page = $wgRequest->getVal('page', 1);
        $sourceId = $wgRequest->getVal('sourceId');

        if ( $sourceId == 1 ) {

            $flickrAPI = new phpFlickr($wgFlickrAPIKey);
            $flickrResult = $flickrAPI->photos_search(array('tags' => $query, 'tag_mode' => 'all', 'page' => $page, 'per_page' => 8, 'license' => '4,5', 'sort' => 'interestingness-desc'));

			$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
            $tmpl->set_vars(array('results' => $flickrResult, 'query' => addslashes($query)));

            return $tmpl->render('results_flickr');

        } else if ( $sourceId == 0 ) {

			if ( (int)$page == 0 ) $page = 1;

			$mediaService = new MediaQueryService();
			$results = $mediaService->searchInTitle( $query, $page, 8 );

			$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');
			$tmpl->set_vars(array('results' => $results, 'query' => addslashes($query)));
			return $tmpl->render('results_thiswiki');
        }
    }


	function tempFileName( $user ) {
		return 'Temp_file_'. $user->getID(). '_' . time();
	}

	/**
	 * Store info in the db to enable the script to pick it up later during
	 * the day (via an automated cleaning routine)
	 *
	 * @param string|$filename
	 * @return int
	 */
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

	/**
	 * Remove the data about this file from the db, so it won't clutter it
	 *
	 * @param $id
	 */
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

	/**
	 * This function loads the image details page
	 *
	 * @return string
	 */
	function chooseImage() {
		global $wgRequest, $wgUser;
		$itemId = $wgRequest->getVal('itemId');
		$sourceId = $wgRequest->getInt('sourceId');

		$this->assertValidRequest();

		if ( $sourceId == 0 ) {
			$file = wfFindFile(Title::newFromText($itemId, 6));
			$props = array();
			$props['file'] = $file;
			$props['mwname'] = $itemId;
			$props['default_caption'] = !empty($file) ? Wikia::getProps($file->getTitle()->getArticleID(), 'default_caption') : '';
		} else if ( $sourceId == 1 ) {

			$flickrResult = $this->getFlickrPhotoInfo( $itemId );

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
			$props['name'] = preg_replace("/[^".Title::legalChars()."]|:/", '-', trim($flickrResult['title']['_content']).'.jpg');
			$props['mwname'] = $tempname;
			$props['extraId'] = $itemId;
			$props['tempid'] = $tempid;
		}
		return $this->detailsPage($props);
	}

	/**
	 * Perform image check
	 *
	 * @return array|int
	 */
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

		if ( !wfRunHooks('WikiaMiniUpload:BeforeProcessing', array($mSrcName)) ) {
			wfDebug( "Hook 'WikiaMiniUpload:BeforeProcessing' broke processing the file." );
			return UploadBase::VERIFICATION_ERROR;
		}

		if ( is_array($ret) ) {
			return $ret['status'];
		} else {
			return $ret;
		}
	}

	function translateError ( $error ) {
		switch ( $error ) {
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
		if ( UploadBase::SUCCESS == $check_result ) {
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

	/**
	 * Generate details page
	 *
	 * @param $props
	 * @return string
	 */
	function detailsPage( $props ) {

		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		if ( isset($props['name']) ) {
			list( $partname, $ext ) = UploadBase::splitExtensions( $props['name'] );

			if ( count( $ext ) ) {
				$finalExt = $ext[count( $ext ) - 1];
			} else {
				$finalExt = '';
			}

			// for more than one "extension"
			if ( count( $ext ) > 1 ) {
				for( $i = 0; $i < count( $ext ) - 1; $i++ )
					$partname .= '.' . $ext[$i];
			}

			$props['partname'] = $partname;
			$props['extension'] = strtolower( $finalExt );
		}

		// a guard
		if ( !is_object( $props['file'] ) ) {
			return $this->loadMain( $this->translateError( UploadBase::EMPTY_FILE ) );
		}

		$tmpl->set_vars(array('props' => $props));
		return $tmpl->render('details');
	}

	/**
	 * This function generates the image for replacing the placeholder after adding the image
	 *
	 * @param $file
	 * @param $name
	 * @param $title
	 * @param bool $thumbnail
	 * @param int $width
	 * @param string $layout
	 * @param string $caption
	 * @return mixed
	 */
	function generateImage( $file, $name, $title, $thumbnail = false, $width = 0, $layout = '', $caption = '' ) {
		global $wgStylePath;
		$page = $name;

		if ( $page ) {
			$query = isset($query) ? '&page=' . urlencode( $page ) : 'page=' . urlencode( $page );
		}
		$file = wfFindFile( $name );
		$url = $title->getLocalURL( $query );

		$orig = $file->getWidth( $page );

		if ( !$width || ( $orig < $width ) ) {
			$width = $orig;
		}
		if ( !$layout ) {
			$layout = 'right';
		}

		$hp = array(
			'width' => $width
		);

		$thumb =  $file->transform( $hp );
		$more = wfMessage( 'thumbnail-more' )->escaped();

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
			$s .= '  <div class="thumbcaption">'.$zoomicon. htmlspecialchars( $caption ) ."</div></div></div>";
		}
		return str_replace("\n", ' ', $s);
	}

	/**
	 * This functions handle the third step of the WMU, image insertion
	 *
	 * @return bool|String
	 */
	function insertImage() {
		global $wgRequest, $wgUser, $wgContLang;

		$this->assertValidRequest();

		$type = $wgRequest->getVal('type');
		$name = $wgRequest->getVal('name');
		$mwname = $wgRequest->getVal('mwname');
		$tempid = $wgRequest->getVal('tempid');

		$gallery = $wgRequest->getVal( 'gallery', '' );
		$title_main = urldecode( $wgRequest->getVal( 'article', '' ) );
		$ns = $wgRequest->getVal( 'ns', '' );
		$link = urldecode( $wgRequest->getVal( 'link', '' ) );

		// Are we in the ck editor?
		$ck = $wgRequest->getVal( 'ck' );

		$extraId = $wgRequest->getVal('extraId');
		$newFile =  true;
		$file = null;
		if ( $name !== NULL ) {
			$name = urldecode( $name );
			if ( $name == '' ) {
				header('X-screen-type: error');
				return WfMsg( 'wmu-warn3' );
			} else {
				$name = preg_replace("/[^".Title::legalChars()."]|:/", '-', $name);
				// did they give no extension at all when they changed the name?
				$ext = explode( '.', $name );
				array_shift( $ext );
				if ( count( $ext ) ) {
					$finalExt = $ext[count( $ext ) - 1];
				} else {
					$finalExt = '';
				}

				if ( '' == $finalExt ) {
					header('X-screen-type: error');
					return wfMsg( 'wmu-filetype-missing' );
				}

				$title = Title::makeTitleSafe(NS_IMAGE, $name);
				if ( is_null($title) ) {
					header('X-screen-type: error');
					return wfMsg ( 'wmu-filetype-incorrect' );
				}
				if ( $title->exists() ) {
					if ( $type == 'overwrite' ) {
						$title = Title::newFromText($name, 6);
						// is the target protected?
						$permErrors = $title->getUserPermissionsErrors( 'edit', $wgUser );
						$permErrorsUpload = $title->getUserPermissionsErrors( 'upload', $wgUser );
						$permErrorsCreate = ( $title->exists() ? array() : $title->getUserPermissionsErrors( 'create', $wgUser ) );

						if ( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
							header('X-screen-type: error');
							return wfMsg( 'wmu-file-protected' );
						}

						$file_name = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());
						$file_mwname = new FakeLocalFile(Title::newFromText($mwname, 6), RepoGroup::singleton()->getLocalRepo());

						if ( !empty($extraId) ) {
							$flickrResult = $this->getFlickrPhotoInfo( $extraId );

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
					} else if ( $type == 'existing' ) {
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

						if ( count( $ext ) ) {
							$finalExt = $ext[count( $ext ) - 1];
						} else {
							$finalExt = '';
						}

						// for more than one "extension"
						if ( count( $ext ) > 1 ) {
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

					if ( $permErrors || $permErrorsUpload || $permErrorsCreate ) {
						header('X-screen-type: error');
						return wfMsg( 'wmu-file-protected' );
					}

					$temp_file = new FakeLocalFile(Title::newFromText($mwname, 6), RepoGroup::singleton()->getLocalRepo());
					$file = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());

					if ( !empty($extraId) ) {
						$flickrResult = $this->getFlickrPhotoInfo( $extraId );

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

				if ( $wgUser->getGLobalPreference( 'watchdefault' ) || ( $newFile && $wgUser->getGlobalPreference( 'watchcreations' ) ) ) {
					$wgUser->addWatch($title);
				}
				$db =& wfGetDB(DB_MASTER);
				$db->commit();
			}
		} else {
			$title = Title::newFromText($mwname, 6);
		}

		if ( is_null($file) ) {
			$file = wfFindFile( $title );
		}

		if ( !is_object($file) ) {
			header('X-screen-type: error');
			return wfMessage('wmu-file-not-found')->plain();
		}

		// Test if this violates the size requirements we've been given
		if ( $msg = $this->invalidSize($file) ) {
			header('X-screen-type: error');
			return $msg;
		}

		$ns_img = $wgContLang->getFormattedNsText( NS_IMAGE );

		if ( ( -2 == $gallery ) && !$ck ) {
			// this went in from the single placeholder...
			$name = $title->getText();
			$size = $wgRequest->getVal('size');
			$width = $wgRequest->getVal('width');
			$layout = $wgRequest->getVal('layout');

			// clear the old caption for upload
			$caption = $wgRequest->getVal('caption');
			$slider = $wgRequest->getVal('slider');

			$title_obj = Title::newFromText( $title_main, $ns );
			$article_obj = new Article( $title_obj );
			$text = $article_obj->getContent();

			wfRunHooks( 'WikiaMiniUpload::fetchTextForImagePlaceholder', array( &$title_obj, &$text ) );

			$box = $wgRequest->getVal( 'box', '' );

			$placeholder = MediaPlaceholderMatch( $text, $box );

			$success = false;
			if ( $placeholder ) {
				$our_gallery = $placeholder[0];
				$gallery_split = explode( ':', $our_gallery );
				$thumb = false;

				$tag = $gallery_split[0] . ":" . $name;

				if ( $size != 'full' ) {
					$tag .= '|thumb';
					$thumb = true;
				}

				if ( isset( $width ) ) {
					$tag .= '|'.$width;
				}
				$tag .= '|'.$layout;

				if ( $link != '' ) {
					$tag .= '|link=' . $link;
				}
				if ( $caption != '' ) {
					$tag .= '|' . $caption;
				}


				$tag .= "]]";

				$text = substr_replace( $text, $tag, $placeholder[1], strlen( $our_gallery ) );
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
				header('X-screen-type: error');
				return;
			}
		} else {
			header('X-screen-type: summary');

			$size = $wgRequest->getVal('size');
			$width = $wgRequest->getVal('width');
			$layout = $wgRequest->getVal('layout');
			$caption = $wgRequest->getVal('caption');
			$slider = $wgRequest->getVal('slider');

			$tag = '[[' . $ns_img . ':'.$title->getDBkey();
			if ( $size != 'full' && ($file->getMediaType() == 'BITMAP' || $file->getMediaType() == 'DRAWING') ) {
				$tag .= '|thumb';
				if ( $layout != 'right' ) {
					$tag .= '|'.$layout;
				}
				if ( $slider == 'true' ) {
					$tag .= '|'.$width;
				}
			}
			if ( $link != '' && $size == 'full' ) {
				$tag .= '|link=' . $link;
			}
			if ( $caption != '' ) {
				if ( $size == 'full' ) {
					$tag .= '|frame';
					if ( $layout != 'right' ) {
						$tag .= '|'.$layout;
					}
				}
				$tag .= '|'.$caption.']]';
			} else {
				if ( $size == 'full' ) {
					$tag .= '|'.$layout;
				}
				$tag .= ']]';
			}
		}
		$message = wfMsg( 'wmu-success' );

		if ( $wgRequest->getVal ( 'update_caption' ) == 'on' ) {
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

	/**
	 * Check the file object passed to make sure it passes any optional size checks passed to this
	 * controller.  Note that this method is a negative assertion.  That is, if it fails a value will
	 * be returned but if the size is correct, it will return FALSE (e.g., "no its not invalid")
	 * Currently, this check uses these request parameters:
	 *
	 *   exactHeight   => Minimum pixel height of the image
	 *   exactWidth    => Minimum pixel width of the image
	 *   aspectRatio => Exact aspect ratio the image should have
	 *
	 * @param File|$file A file object
	 * @return bool|String Returns an error string if there is a problem, false otherwise
	 */
	function invalidSize( $file ) {
		global $wgRequest;
		$exactHeight = $wgRequest->getVal('exactHeight');
		$exactWidth = $wgRequest->getVal('exactWidth');

		// Skip this check if we don't have any constraints
		if (empty($exactHeight) && empty($exactWidth)) {
			return false;
		}

		$fileHeight = $file->getHeight();
		$fileWidth = $file->getWidth();

		// Possible messages generated here:
		//   wmu-error-exact-width
		//   wmu-error-exact-height
		//   wmu-error-exact-width-height
		$msgString = 'wmu-error-exact';
		$params = array();
		if ( !empty($exactWidth) && ($fileWidth != $exactWidth) ) {
			$msgString .= '-width';
			$params[] = $exactWidth;
			$params[] = $fileWidth;
		}
		if ( !empty($exactHeight) && ($fileHeight != $exactHeight) ) {
			$msgString .= '-height';
			$params[] = $exactHeight;
			$params[] = $fileHeight;
		}

		// Check if the minimum sizes failed before moving on
		if (count($params)) {
			return wfMessage($msgString, $params)->plain();
		}

		return false;
	}

	function clean() {
		global $wgRequest;
		$file = new FakeLocalFile(Title::newFromText($wgRequest->getVal('mwname'), 6), RepoGroup::singleton()->getLocalRepo());
		$file->delete('');
		$this->tempFileClearInfo( $wgRequest->getVal('tempid') );
	}

	function getFlickrPhotoInfo( $itemId ) {
		global $wgFlickrAPIKey;

		$flickrAPI = new phpFlickr( $wgFlickrAPIKey );
		$flickrResult = $flickrAPI->photos_getInfo( $itemId );

		// phpFlickr 3.x has different response structure than previous version
		return $flickrResult['photo'];
	}

	/**
	 * Retrieve recently uploaded images from this wiki.  This will filter out video files
	 * and images uploaded by bots if necessary.  Additionally, arbitrary constraints can
	 * be passed in to filter out additional images.  These constraints can be either of:
	 *
	 *   $constrain[] = "img_name = 'bar'"
	 *   $constrain['img_minor_mime'] = 'youtube'
	 *
	 * @param int $limit Limit the number of images to return
	 * @param int $offset Grab images after an offset.  Used with $limit to page the results
	 * @param array $constrain An array of constraint/value that will be used in the query
	 * @return array An array of images
	 */
	function getImages( $limit, $offset = 0, $constrain = array() ) {

		// Load the next set of images, eliminating images uploaded by bots as
		// well as eliminating any video files
		$dbr = wfGetDB( DB_SLAVE );
		$image = $dbr->tableName( 'image' );
		$sql = 'SELECT img_size, img_name, img_user, img_user_text, img_description, img_timestamp '.
				"FROM $image";

		$botconds = array();
		foreach ( User::getGroupsWithPermission( 'bot' ) as $groupname ) {
			$botconds[] = 'ug_group = ' . $dbr->addQuotes( $groupname );
		}

		$where = array();
		if ( count($botconds) ) {
			$isbotmember = $dbr->makeList( $botconds, LIST_OR );

			// LEFT join to the user_groups table on being a bot and then make sure
			// we get null rows back (i.e. we're not a bot)
			$ug = $dbr->tableName( 'user_groups' );

			$sql .= " LEFT JOIN $ug ON img_user=ug_user AND ($isbotmember)";
			$where[] = 'ug_group IS NULL';
		}

		// Eliminate videos from this listing
		$where[] = 'img_media_type != \'VIDEO\'';
		$where[] = 'img_major_mime != \'video\'';
		$where[] = 'img_media_type != \'swf\'';

		// Add any additional constraints
		if ( $constrain ) {
			foreach ( $constrain as $cond ) {
				$where[] = $cond;
			}
		}

		$sql .= ' WHERE ' . $dbr->makeList( $where, LIST_AND );
		$sql .= ' ORDER BY img_timestamp DESC ';
		$sql .= ' LIMIT ' . ( $limit + 1 );
		if ( $offset ) {
			$sql .= " OFFSET $offset";
		}
		$res = $dbr->query( $sql, __FUNCTION__ );

		$images = array();
		while ( $s = $dbr->fetchObject( $res ) ) {
			$images[] = $s;
		}
		$dbr->freeResult( $res );

		// Load the images into a new gallery
		$gallery = new WikiaPhotoGallery();
		$gallery->parseParams( array(
			"rowdivider"   => true,
			"hideoverflow" => true
			) );

		$gallery->setWidths( 212 );

		$foundImages = 0;
		foreach ( $images as $s ) {
			$foundImages++;
			if ( $foundImages > $limit ) {
				// One extra just to test for whether to show a page link;
				// don't actually show it.
				break;
			}

			$nt = Title::newFromText( $s->img_name, NS_FILE );
			$gallery->add( $nt );
		}

		$info = array("gallery" => $gallery);

		// Set pagination information
		if ( $offset > 0 ) {
			$info['prev'] = $offset - $limit;
		}

		if ( $foundImages > $limit ) {
			$info['next'] = $offset + $limit;
		}

		return $info;
	}

	/**
	 * @throws BadRequestException
	 * @see PLATFORM-1531
	 */
	function assertValidRequest() {
		global $wgRequest, $wgUser;

		if ( !$wgRequest->wasPosted() ||  !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
			throw new BadRequestException( 'Request must be POSTed and provide a valid edit token.' );
		}
	}
}
