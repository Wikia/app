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
		global $wgScript, $wgStylePath, $wgExtensionMessagesFiles, $wgEnableUploads, $wgUser;

		wfProfileIn(__METHOD__);

		// show upload form?
		$showUpload = $wgUser->isLoggedIn() && $wgUser->isAllowed('upload') && $wgEnableUploads && !wfReadOnly();

		// list of recently uploaded images
		$recentlyUploaded = WikiaPhotoGalleryHelper::getRecentlyUploaded();

		// render dialog
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'recentlyUploaded' => WikiaPhotoGalleryHelper::renderImagesList('uploaded', $recentlyUploaded),
			'showUpload' => $showUpload,
			'wgScript' => $wgScript,
			'wgStylePath' => $wgStylePath,
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

		$res = array(
			'html' => $html,
			'msg' => $msg,
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
		$results = WikiaPhotoGalleryHelper::getSearchResult($query);

		if (!empty($results)) {
			$html = WikiaPhotoGalleryHelper::renderImagesList('results', $results);
			$msg = wfMsg('wikiaPhotoGallery-upload-filestitle-post', count($results));
		}
		else {
			$html = false;
			$msg = wfMsg('wikiaPhotoGallery-upload-filestitle-post', 0);
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

		$html = WikiaPhotoGalleryHelper::renderGalleryPreview($gallery);

		wfProfileOut(__METHOD__);
		return array(
			'html' => $html,
		);
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
		return Wikia::json_encode($result);
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
