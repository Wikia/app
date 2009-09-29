<?php

class MagCloudAjax {

	/*
	 * Return HTML of popup with introduction to magazines
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function renderIntroPopup() {
		global $wgUser;

		// start session for anon user
		MagCloud::startAnonSession();

		// TODO: fetch preview image and URL
		global $wgExtensionsPath;
		$preview = array(
			'src' => "{$wgExtensionsPath}/wikia/WidgetFramework/Widgets/WidgetMagCloud/images/MagCloudPreview.png",
			'href' =>  'http://magcloud.com',
		);

		// render HTML
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'preview' => $preview,
			'isAnon' => $wgUser->isAnon(),
		));

		return $template->render('intro');
	}

	/*
	 * Return HTML of popup with list of saved magazines
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function renderSavedMagazines() {
		global $wgUser;

		$magazines = MagCloudCollection::getInstance()->getMagazinesByUserId($wgUser->getID());

		// render HTML
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
			'magazines' => $magazines,
		));

		return $template->render('savedMagazines');
	}

	/*
	 * Return HTML of popup showing up when closing the toolbar
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function renderDiscardMagazine() {
		// render HTML
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		return $template->render('discardMagazine');
	}

	/*
	 * Show MagCloud toolbar and return its HTML
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function showToolbar() {
		MagCloudCollection::getInstance()->setToolbarVisibleState(true);

		// render toolbar
		return array('html' => MagCloud::renderToolbar());
	}

	/*
	 * Hide MagCloud toolbar and clear current collection
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function hideToolbar() {
		$magCloud =  MagCloudCollection::getInstance();

		// hide toolbar
		$magCloud->setToolbarVisibleState(false);

		// TODO: clear collection
		$magCloud->removeArticles();

		// ack
		return array('ok' => true);
	}

	/*
	 * Add given article to collection
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function addArticle() {
		global $wgTitle, $wgRequest;

		// get revision ID
		$revId = $wgRequest->getInt('revid');

		$collection = MagCloudCollection::getInstance();
		$success = $collection->addArticle($wgTitle);

		$count = $collection->countArticles();

		// generate message
		$title = htmlspecialchars( MagCloud::getAbbreviatedTitle($wgTitle) );
		if($success) {
			$msg = wfMsgExt('magcloud-add-article-success', array('parseinline'), $title);
		}
		else {
			$msg = wfMsgExt('magcloud-add-article-already', array('parseinline'), $title);
		}

		// message saying "<big>3</big> articles"
		$articlesMsg = wfMsgExt('magcloud-toolbar-articles-count', array('parsemag'), $count);

		// return message and updated articles count
		return array(
			'msg' => $msg,
			'count' => $count,
			'articlesMsg' => $articlesMsg,
		);
	}

	static public function removeArticle() {
		global $wgRequest;

		// get article index
		$index = $wgRequest->getInt('index');

		$collection = MagCloudCollection::getInstance();
		$result = $collection->removeArticle($index);

		$count =  $collection->countArticles();

		return array(
			'count' => $count,
			'html' => wfMsgExt('magcloud-special-collection-review-list-info', array('parsemag'), $count),
		);
	}

	static public function reorderArticle() {
		global $wgRequest;

		// get indexes
		$oldIndex = $wgRequest->getInt('oldIndex');
		$newIndex = $wgRequest->getInt('newIndex');

		$collection = MagCloudCollection::getInstance();
		$result = $collection->reorderArticle($oldIndex, $newIndex);

		return array(
			'success' => is_array($result),
		);
	}

	/*
	 * Save cover's settings for current collection
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function saveCover() {
		global $wgRequest;

		$params = array(
			'layout' => $wgRequest->getInt('coverLayout'),
			'theme' =>  $wgRequest->getVal('coverTheme'),
			'title' =>  $wgRequest->getVal('magazineTitle'),
			'subtitle' =>  $wgRequest->getVal('magazineSubtitle'),
			'image' => $wgRequest->getVal('image'),
		);

		$collection = MagCloudCollection::getInstance()->saveCoverData($params);

		return array(
			'success' => true,
		);
	}

	/*
	 * Save current collection as subpage of user page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function saveCollection() {
		global $wgUser;

		$collection = MagCloudCollection::getInstance();

		if($wgUser->isLoggedIn()) {
			$collection->save();

			return array(
				'success' => true,
				'msg' => '<p>Your collection has been saved as <strong>' . $collection->getTitle() . '</stromg></p>',
				'shortMsg' => 'Saved!',
			);
		}
		else {
			return array(
				'success' => false,
				'msg' => 'Saving collection failed',
				'shortMsg' => 'Failed!'
			);
		}
	}

	/*
	 * Load selected collection
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function loadCollection() {
		global $wgRequest;

		$collection = MagCloudCollection::getInstance();

		$collectionHash = $wgRequest->getVal('hash');

		// load collection into session
		$collection->restore($collectionHash);

		// and let's show the toolbar
		$collection->setToolbarVisibleState(true);

		return array(
			'success' => true,
		);
	}

	/*
	 * Render given collection (by hash) to PDF
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function renderPdf() {
		global $wgRequest;

		$hash = $wgRequest->getVal('hash');
		$timestamp = $wgRequest->getInt('timestamp');

		$result = MagCloud::renderPdf($hash, $timestamp);
		return $result;
	}

	/*
	 * Render given collection page to PNG file
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function renderPreviewPage() {
		global $wgRequest;

		$hash = $wgRequest->getVal('hash');
		$timestamp = $wgRequest->getInt('timestamp');
		$page = $wgRequest->getInt('page');

		$result = MagCloud::renderPreviewPage($hash, $timestamp, $page);
		return $result;
	}

	/*
	 * Render given image and return HTML and height info
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function renderImage() {
		global $wgRequest;

		$imageName = $wgRequest->getVal('image');
		$width = $wgRequest->getInt('width');

		$image = wfFindFile( Title::newFromText($imageName, NS_FILE) );

		if (empty($image)) {
			return false;
		}

		$thumb = $image->getThumbnail($width);

		return array(
			'img' => $thumb->toHtml(),
			'height' => $thumb->getHeight(),
		);
	}

	/*
	 * Publish given collection PDF in MagCloud
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function publish() {
		global $wgRequest;

		$hash = $wgRequest->getVal('hash');
		$timestamp = $wgRequest->getInt('timestamp');
		$token = $wgRequest->getVal('token');

		$result = MagCloud::publish($hash, $timestamp, $token);

		// show nice error message
		if (isset($result['code'])) {
			$result['internalMsg'] = $result['msg'];
			$result['msg'] = wfMsg('magcloud-publish-error');
		}

		return $result;
	}
}
