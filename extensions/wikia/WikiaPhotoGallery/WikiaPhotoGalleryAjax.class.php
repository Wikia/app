<?php

class WikiaPhotoGalleryAjax {

	/**
	 * Ovewrite existing image with uploaded photo
	 */
	static public function conflictOverwrite() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$imageName = $wgRequest->getVal('imageName');
		$tempId = $wgRequest->getInt('tempId');

		// ovewrite provided image with uploaded one
		$resolved = WikiaPhotoGalleryUpload::conflictOverwrite($imageName, $tempId);

		$res = array(
			'resolved' => $resolved,
		);

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Try to rename uploaded conflicting photo
	 */
	static public function conflictRename() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$newName = $wgRequest->getVal('newName');
		$tempId = $wgRequest->getInt('tempId');

		// try to resolve the conflict
		if (WikiaPhotoGalleryUpload::conflictRename($newName, $tempId)) {
			$res = array(
				'resolved' => true,
			);
		}
		else {
			$res = array(
				'resolved' => false,
				'msg' => wfMsg('wikiaPhotoGallery-upload-error-conflict-intro'),
			);
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Return HTML and messages for gallery editor
	 */
	static public function getEditorDialog() {
		global $wgExtensionMessagesFiles, $wgTitle;

		wfProfileIn(__METHOD__);

		// show upload form?
		$showUploadForm = WikiaPhotoGalleryHelper::isUploadAllowed();

		// list of recently uploaded images
		$recentlyUploaded = WikiaPhotoGalleryHelper::getRecentlyUploadedThumbs();

		// list of images on current article
		$imagesOnPage = WikiaPhotoGalleryHelper::getImagesFromPageThumbs($wgTitle);

		// render dialog
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'alignments' => array('left', 'center', 'right'),
			'imagesOnPage' => WikiaPhotoGalleryHelper::renderImagesList('images', $imagesOnPage),
			'recentlyUploaded' => WikiaPhotoGalleryHelper::renderImagesList('uploaded', $recentlyUploaded),
			'showUploadForm' => $showUploadForm,
		));
		$html = $template->render('editorDialog');

		// get list of this extension messages
		require($wgExtensionMessagesFiles['WikiaPhotoGallery']);
		$list = array_keys($messages['en']);

		// additional messages
		$list[] = 'save';
		$list[] = 'ok';
		$list[] = 'cancel';

		// toolbar buttons tooltips
		$list[] = 'bold_tip';
		$list[] = 'italic_tip';
		$list[] = 'link_tip';

		$msg = array();
		foreach($list as $key) {
			$msg[$key] = wfMsg($key);
		}

		// get list of gallery parameters default values
		$ig = new WikiaPhotoGallery();
		$defaultParamValues = $ig->getDefaultParamValues();

		$res = array(
			'html' => $html,
			'msg' => $msg,
			'defaultParamValues' => $defaultParamValues,
		);

		wfProfileOut(__METHOD__);

		return $res;
	}

	/**
	 * Return HTML with search results
	 */
	static public function getSearchResult() {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgContentNamespaces;

		$query = $wgRequest->getVal('query');
		$results = WikiaPhotoGalleryHelper::getSearchResultThumbs($query);

		if (!empty($results)) {
			$html = WikiaPhotoGalleryHelper::renderImagesList('results', $results);
			$msg = wfMsgExt( 'wikiaPhotoGallery-upload-filestitle-post', array( 'parsemag' ), count($results) );
		}
		else {
			$html = false;
			$msg = wfMsgExt( 'wikiaPhotoGallery-upload-filestitle-post', array( 'parsemag' ), 0 );
		}

		wfProfileOut(__METHOD__);

		return array(
			'html' => $html,
			'msg' => $msg,
		);
	}

	/**
	 * Return of thumbnail of given image
	 */
	static public function getThumbnail() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$name = $wgRequest->getVal('imageName');
		$image = Title::newFromText($name, NS_FILE);

		// fit thumbnail inside 200x200 box
		$thumbnail = WikiaPhotoGalleryHelper::renderThumbnail($image);

		wfProfileOut(__METHOD__);
		return array(
			'thumbnail' => $thumbnail,
		);
	}

	/**
	 * Render gallery preview
	 */
	static public function renderGalleryPreview() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		// decode JSON-encoded gallery data
		$gallery = Wikia::json_decode($wgRequest->getVal('gallery'), true);

		if (empty($gallery['params']['rssfeed'])) {
			$html = WikiaPhotoGalleryHelper::renderGalleryPreview($gallery);
		} else {
			$html = WikiaPhotoGalleryHelper::renderFeedGalleryPreview($gallery);
		}

		wfProfileOut(__METHOD__);
		return array(
			'html' => $html,
		);
	}

	/**
	 * Render slideshow preview
	 */
	static public function renderSlideshowPreview() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		// decode JSON-encoded slideshow data
		$gallery = Wikia::json_decode($wgRequest->getVal('gallery'), true);

		if (empty($gallery['params']['rssfeed'])) {
			$html = WikiaPhotoGalleryHelper::renderSlideshowPreview($gallery);
		} else {
			$html = WikiaPhotoGalleryHelper::renderFeedSlideshowPreview($gallery);
		}

		wfProfileOut(__METHOD__);
		return array(
			'html' => $html,
		);
	}

	/**
	 * Return HTML for slideshow pop out dialog
	 */
	static public function getSlideshowPopOut() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$hash = $wgRequest->getVal('hash');
		$maxWidth = $wgRequest->getInt('maxwidth', 650) - 20;
		$maxHeight = $wgRequest->getInt('maxheight', 1200) - 320;

		// used on pages with oldid URL param
		$revisionId = $wgRequest->getInt('revid', 0);

		$slideshow = WikiaPhotoGalleryHelper::getGalleryDataByHash($hash, $revisionId, WikiaPhotoGallery::WIKIA_PHOTO_SLIDESHOW);

		if (isset($slideshow['info']) && $slideshow['info'] == 'ok') {
			if (empty($slideshow['gallery']['params']->rssfeed)) {
				$ret = WikiaPhotoGalleryHelper::renderSlideshowPopOut($slideshow['gallery'], $maxWidth, $maxHeight);
			} else {
				$ret = WikiaPhotoGalleryHelper::renderFeedSlideshowPopOut($slideshow['gallery'], $maxWidth, $maxHeight);
			}
		} else {
			$ret = $slideshow;
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Handle uploads
	 */
	static public function upload() {
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . "\n");

		// handle upload and security checks
		$result = WikiaPhotoGalleryUpload::uploadImage();

		wfProfileOut(__METHOD__);

		// return JSON as HTML - decode it JS-side
		//in Chrome/safari an empty div is appended to the JSON data in case of upload issues (e.g. already existing image)
		//the solution was to append a new line at the end of the JSON string and split it in Javascript.
		return Wikia::json_encode($result) . "\n";
	}

	/**
	 * picking right gallery and returning JSON data
	 * @author Marooned
	 */
	static public function getGalleryData() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$hash = $wgRequest->getVal('hash');

		$result = WikiaPhotoGalleryHelper::getGalleryDataByHash($hash);

		wfProfileOut(__METHOD__);

		// return JSON as HTML - decode it JS-side
		return Wikia::json_encode($result);
	}

	/**
	 * replacing gallery in wikitext (saving changes)
	 * @author Marooned
	 */
	static public function saveGalleryData() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$hash = $wgRequest->getVal('hash');
		$wikitext = $wgRequest->getVal('wikitext');
		$starttime = $wgRequest->getVal('starttime');

		$result = WikiaPhotoGalleryHelper::saveGalleryDataByHash($hash, $wikitext, $starttime);

		wfProfileOut(__METHOD__);

		// return JSON as HTML - decode it JS-side
		return Wikia::json_encode($result);
	}
}
