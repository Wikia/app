<?php

class WikiaPhotoGalleryHelper {

	// thumbnails shown in search results / list of recenlty uploaded images
	const resultsThumbnailMaxWidth = 120;
	const resultsThumbnailMaxHeight = 90;

	// thumbnails shown in  gallery preview
	const previewThumbnailMaxWidth = 125;
	const previewThumbnailMaxHeight = 125;

	// thumbnails shown on conflict resolving page / caption/link page
	const thumbnailMaxWidth = 200;
	const thumbnailMaxHeight = 200;

	/**
	 * Used to store wikitext between calls to useDefaultRTEPlaceholder and renderGalleryPlaceholder
	 */
	private static $mWikitextIdx;

	// used when parsing and getting gallery data
	private static $mGalleryHash;
	private static $mGalleryData;

	/**
	 * Creates instance of object to be used to render an image gallery by MW parser
	 */
	static public function setup(&$ig, &$text, &$params) {
		wfProfileIn(__METHOD__);

		$ig = new WikiaPhotoGallery();

		// store content of <gallery> tag
		$ig->setText($text);

		// store attributes of <gallery> tag
		$ig->setParams($params);

		// set captions alignment
		if (isset($params['captionalign'])) {
			$ig->setCaptionsAlign($params['captionalign']);
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Allow this extension to use its own "parser" for <gallery> tag content
	 */
	static public function beforeRenderImageGallery(&$parser, &$ig) {
		$ig->parse();

		// by returning false we're telling MW parser to return gallery's HTML immediatelly
		return false;
	}

	/**
	 * Skip rendering of RTE placeholders for <gallery> and generate our own
	 */
	static public function useDefaultRTEPlaceholder($name, $params, $frame, $wikitextIdx) {
		$name = strtolower($name);

		if ($name == 'gallery') {
			self::$mWikitextIdx = $wikitextIdx;

			// generate custom placeholder for <gallery> tag
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Load extension's JS on edit page
	 */
	static public function setupEditPage($editform) {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;

		wfProfileIn(__METHOD__);

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js?{$wgStyleVersion}\"></script>\n");

		// load message for MW toolbar button tooltip
		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = 'WikiaPhotoGalleryHelper::makeGlobalVariablesScript';

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add message for MW toolbar button tooltip
	 */
	static public function makeGlobalVariablesScript(&$vars) {
		wfProfileIn(__METHOD__);
		wfLoadExtensionMessages('WikiaPhotoGallery');

		$vars['WikiaPhotoGalleryAddGallery'] = wfMsg('wikiaPhotoGallery-add-gallery');

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Render gallery placeholder for RTE
	 */
	static public function renderGalleryPlaceholder($data, $width, $height) {
		wfProfileIn(__METHOD__);

		$attribs = array(
			'src' => 'http://images.wikia.com/common/skins/monobook/blank.gif?1',
			'class' => 'media-placeholder image-gallery',
			'type' => 'image-gallery',
			'height' => $height,
			'width' => $width,
		);

		// render image for media placeholder
		$ret = Xml::element('img', $attribs);

		// store wikitext
		$data['wikitext'] = RTEData::get('wikitext', self::$mWikitextIdx);

		// store data and mark HTML
		$dataIdx = RTEData::put('data', $data);
		$ret = RTEData::addIdxToTag($dataIdx, $ret);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Return HTML of given image's thumbnail with given dimensions (or use default values)
	 */
	static public function renderThumbnail($title, $width = false, $height = false) {
		wfProfileIn(__METHOD__);

		$html = false;

		if ($title instanceof Title) {
			$image = wfFindFile($title);

			if (!empty($image)) {
				if (empty($width))  $width = self::thumbnailMaxWidth;
				if (empty($height)) $height = self::thumbnailMaxHeight;

				$width = min($width, $image->getWidth());
				$height = min($height, $image->getHeight());

				$thumb = $image->getThumbnail($width, $height);
				$html = $thumb->toHtml();
			}
		}

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Return HTML of given image's thumbnail for search results
	 */
	static public function renderResultsThumbnail($title) {
		return self::renderThumbnail($title, self::resultsThumbnailMaxWidth, self::resultsThumbnailMaxHeight);
	}

	/**
	 * Render list of images to HTML
	 */
	static public function renderImagesList($type, $images) {
		wfProfileIn(__METHOD__);

		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'type' => $type,
			'images' => $images,
			'perRow' => 4,
		));

		$html = $template->render('imagesList');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Render gallery preview
	 */
	static public function renderGalleryPreview($gallery) {
		global $wgTitle;
		wfProfileIn(__METHOD__);

		//wfDebug(__METHOD__ . "\n" . print_r($gallery, true));

		// initialize parser
		wfProfileIn(__METHOD__.'::parserInit');

		$parser = new Parser();
		$parser->mOptions = new ParserOptions();
		$parser->setTitle($wgTitle);
		$parser->clearState();

		wfProfileOut(__METHOD__.'::parserInit');

		// render thumbnail and parse caption for each image (default "box" is 120x120)
		$thumbSize = !empty($gallery['params']['widths']) ? $gallery['params']['widths'] : 120;

		foreach($gallery['images'] as &$image) {
			$imageTitle = Title::newFromText($image['name'], NS_FILE);
			$image['thumbnail'] = self::renderThumbnail($imageTitle, $thumbSize, $thumbSize);

			//need to use parse() - see RT#44270
			$image['caption'] = $parser->parse($image['caption'], $wgTitle, $parser->mOptions)->getText();
		}

		//wfDebug(__METHOD__.'::after' . "\n" . print_r($gallery, true));

		// render gallery HTML preview
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'gallery' => $gallery,
			'thumbSize' => $thumbSize,
		));
		$html = $template->render('galleryPreview');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Get list of recently uploaded files
	 */
	static public function getRecentlyUploaded($limit = 50) {
		wfProfileIn(__METHOD__);

		$ret = false;

		// get list of recent log entries (type = 'upload')
		$params = array(
			'action' => 'query',
			'list' => 'logevents',
			'letype' => 'upload',
			'leprop' => 'title',
			'lelimit' => $limit,
		);

		try {
			wfProfileIn(__METHOD__ . '::apiCall');

			$api = new ApiMain(new FauxRequest($params));
			$api->execute();
			$res = $api->getResultData();

			wfProfileOut(__METHOD__ . '::apiCall');

			if (!empty($res['query']['logevents'])) {
				foreach($res['query']['logevents'] as $entry) {
					// ignore Video:foo entries from VET
					if ($entry['ns'] == NS_IMAGE) {
						$image = Title::newFromText($entry['title']);

						$thumb = self::renderResultsThumbnail($image);
						if ($thumb) {
							// use keys to remove duplicates
							$ret[$image->getDBkey()] = array(
								'name' => $image->getText(),
								'thumb' => $thumb,
							);
						}
					}
				}

				// use numeric keys
				$ret = array_values($ret);
			}
		}
		catch(Exception $e) {};

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Return array of HTML with images search result
	 */
	static public function getSearchResult($query) {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgContentNamespaces;

		$images = array();

		if(!empty($query)) {
			$query_select = "SELECT il_to FROM imagelinks JOIN page ON page_id=il_from WHERE page_title = '%s' and page_namespace = %s";
			$query_glue = ' UNION DISTINCT ';
			$articles = $query_arr = array();

			//get search result from API
			$oFauxRequest = new FauxRequest(
				array(
					'action' => 'query',
					'list' => 'search',
					'srnamespace' => implode('|', array_merge($wgContentNamespaces, array(NS_FILE))),
					'srlimit' => '20',
					'srsearch' => $query,
				)
			);
			$oApi = new ApiMain($oFauxRequest);
			$oApi->execute();
			$aResult =& $oApi->GetResultData();

			$dbr = wfGetDB(DB_SLAVE);

			if (count($aResult['query']['search']) > 0) {
				if (!empty($aResult['query']['search'])) {
					foreach ($aResult['query']['search'] as $aResult) {
						$query_arr[] = sprintf($query_select, $dbr->strencode(str_replace(' ', '_', $aResult['title'])), $aResult['ns']);
					}
				}
			}

			if (count($query_arr)) {
				$query_sql = implode($query_glue, $query_arr);
				$res = $dbr->query($query_sql, __METHOD__);

				if($res->numRows() > 0) {
					while( $row = $res->fetchObject() ) {
						$articles[] = $row->il_to;
					}
					$dbr->freeResult($res);

					foreach($articles as $title) {
						$oImageTitle = Title::makeTitleSafe(NS_FILE, $title);

						$thumb = self::renderResultsThumbnail($oImageTitle);
						if ($thumb) {
							$images[] = array(
								'name' => $oImageTitle->getText(),
								'thumb' => $thumb,
							);
						}
					}
				}
			}
		}

		wfProfileOut(__METHOD__);

		return $images;
	}

	/**
	 * AJAX helper called from view mode to save gallery data
	 * @author Marooned
	 */
	static public function saveGalleryDataByHash($hash, $wikitext, $starttime) {
		global $wgHooks, $wgTitle, $wgUser;

		wfProfileIn(__METHOD__);

		//TODO: save changed gallery
		$parser = new Parser();
		$parserOptions = new ParserOptions();

		$rev = Revision::newFromTitle($wgTitle);
		$articleWikitext = $rev->getText();
		$gallery = '';

		preg_match_all('%<gallery[^>]*>(.*?)</gallery>%s', $articleWikitext, $matches, PREG_PATTERN_ORDER);
		for ($i = 0; $i < count($matches[0]); $i++) {
			if (md5($matches[1][$i]) == $hash) {
				$gallery = $matches[0][$i];
				break;
			}
		}

		wfLoadExtensionMessages('WikiaPhotoGallery');
		if (empty($gallery)) {
			$result['info'] = 'conflict';
		} else {
			$articleWikitext = str_replace($gallery, $wikitext, $articleWikitext);

			//saving
			if($wgTitle->userCan('edit') && !$wgUser->isBlocked()) {
				global $wgOut;

				$result = null;
				$article = new Article($wgTitle);
				$editPage = new EditPage($article);
				$editPage->edittime = $article->getTimestamp();
				$editPage->starttime = $starttime;
				$editPage->textbox1 = $articleWikitext;
				$editPage->summary = wfMsgForContent('wikiaPhotoGallery-edit-summary');
				$bot = $wgUser->isAllowed('bot');
				$retval = $editPage->internalAttemptSave( $result, $bot );
				Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );
				if ( $retval == EditPage::AS_SUCCESS_UPDATE || $retval == EditPage::AS_SUCCESS_NEW_ARTICLE ) {
					$wgTitle->invalidateCache();
					Article::onArticleEdit($wgTitle);
					$result['info'] = 'ok';
				} elseif ( $retval == EditPage::AS_SPAM_ERROR ) {
					$result['error'] = wfMsg('spamprotectiontext');
				} else {
					$result['error'] = wfMsg('wikiaPhotoGallery-edit-abort');
				}
			} else {
				$result['error'] = wfMsg('wikiaPhotoGallery-error-user-rights');
			}
			if (isset($result['error'])) {
				$result['errorCaption'] = wfMsg('wikiaPhotoGallery-error-caption');
			}
			//end of saving
		}

		wfProfileOut(__METHOD__);

		return $result;
	}

	/**
	 * AJAX helper called from view mode to get gallery data
	 * @author Marooned
	 */
	static public function getGalleryDataByHash($hash) {
		global $wgHooks, $wgTitle;

		wfProfileIn(__METHOD__);

		//overwrite previous hooks returning `false`
		$wgHooks['BeforeParserrenderImageGallery'] = array('WikiaPhotoGalleryHelper::beforeParserrenderImageGallery');
		self::$mGalleryHash = $hash;

		$parser = new Parser();
		$parserOptions = new ParserOptions();

		$rev = Revision::newFromTitle($wgTitle);
		//should never happen
		if (!is_null($rev)) {
			$wikitext = $rev->getText();
			$parser->parse($wikitext, $wgTitle, $parserOptions)->getText();
		}

		if (empty(self::$mGalleryData)) {
			$result['error'] = wfMsg('wikiaPhotoGallery-error-outdated');
			$result['errorCaption'] = wfMsg('wikiaPhotoGallery-error-caption');
		} else {
			$result['info'] = 'ok';
			$result['gallery'] = self::$mGalleryData;
			$result['gallery']['starttime'] = wfTimestampNow();
		}
		wfProfileOut(__METHOD__);

		return $result;
	}

	/**
	 * Hook handler
	 * @author Marooned
	 */
	static public function beforeParserrenderImageGallery($parser, $ig) {
		wfProfileIn(__METHOD__);

		$ig->parse();
		$data = $ig->getData();
		if ($data['hash'] == self::$mGalleryHash) {
			self::$mGalleryData = $data;
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Hook handler
	 * @author Marooned
	 */
	static public function fetchTemplateAndTitle($text, $finalTitle) {
		if( $text !== false ) {
			$text = str_replace('<gallery ', "<gallery source=\"template\x7f\" ", $text);
		}
		return true;
	}
}
