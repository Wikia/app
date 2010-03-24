<?php

class WikiaImageGalleryHelper {

	const thumbnailMaxWidth = 120;
	const thumbnailMaxHeight = 90;

	/**
	 * Used to store wikitext between calls to useDefaultRTEPlaceholder and renderGalleryPlaceholder
	 */
	private static $mWikitextIdx;

	/**
	 * Creates instance of object to be used to render an image gallery by MW parser
	 */
	static public function setup(&$ig, &$text, &$params) {
		wfProfileIn(__METHOD__);

		$ig = new WikiaImageGallery();

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

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiaImageGallery/js/WikiaImageGallery.js?{$wgStyleVersion}\"></script>\n");

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
	 * Return HTML of given image's thumbnail
	 */
	static public function renderThumbnail($title) {
		wfProfileIn(__METHOD__);

		$html = false;

		if ($title instanceof Title) {
			$image = wfFindFile($title);

			if (!empty($image)) {
				$width = min(self::thumbnailMaxWidth, $image->getWidth());
				$height = min(self::thumbnailMaxHeight, $image->getHeight());

				$thumb = $image->getThumbnail($width, $height);
				$html = $thumb->toHtml();
			}
		}

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Render list of images to HTML
	 */
	static public function renderImagesList($images) {
		wfProfileIn(__METHOD__);

		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'images' => $images,
			'perRow' => 4,
		));

		$html = $template->render('imagesList');

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
			$api = new ApiMain(new FauxRequest($params));
			$api->execute();
			$res = $api->getResultData();

			if (!empty($res['query']['logevents'])) {
				foreach($res['query']['logevents'] as $entry) {
					// ignore Video:foo entries from VET
					if ($entry['ns'] == NS_IMAGE) {
						$image = Title::newFromText($entry['title']);

						$thumb = self::renderThumbnail($image);
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

						$thumb = WikiaImageGalleryHelper::renderThumbnail($oImageTitle);
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

}
