<?php

class WikiaImageGalleryAjax {

	/**
	 * Return HTML and messages for gallery editor
	 */
	static public function getEditorDialog() {
		global $wgScript, $wgStylePath, $wgExtensionMessagesFiles, $wgEnableUploads, $wgUser;

		wfProfileIn(__METHOD__);

		// show upload form?
		$showUpload = $wgUser->isLoggedIn() && $wgUser->isAllowed('upload') && $wgEnableUploads && !wfReadOnly();

		// list of recently uploaded images
		$recentlyUploaded = WikiaImageGalleryHelper::getRecentlyUploaded();

		// render dialog
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'recentlyUploaded' => WikiaImageGalleryHelper::renderImagesList($recentlyUploaded),
			'showUpload' => $showUpload,
			'wgScript' => $wgScript,
			'wgStylePath' => $wgStylePath,
		));
		$html = $template->render('editorDialog');

		// get list of this extension messages
		require($wgExtensionMessagesFiles['WikiaImageGallery']);
		$list = array_keys($messages['en']);

		$list[] = 'save';
		$list[] = 'cancel';

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
		$results = WikiaImageGalleryHelper::getSearchResult($query);

		if (!empty($results)) {
			$html = WikiaImageGalleryHelper::renderImagesList($results);
			$msg = wfMsg('wig-upload-filestitle-post', count($results));
		}
		else {
			$html = false;
			$msg = wfMsg('wig-upload-filestitle-post', 0);
		}

		wfProfileOut(__METHOD__);

		return array(
			'html' => $html,
			'msg' => $msg,
		);
	}
}
