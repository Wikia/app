<?php
class SpecialCssController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('CSS', 'specialcss', true);
	}

	/**
	 * Main page for Special:Css page
	 *
	 * @return bool
	 */
	public function index() {
		wfProfileIn(__METHOD__);

		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->response->addAsset('/extensions/wikia/SpecialCss/css/SpecialCss.scss');
		$this->response->addAsset('/extensions/wikia/SpecialCss/js/SpecialCss.js');
		// This shouldn't be moved to asset manager package because of Ace internal autoloader
		$this->response->addAsset('/resources/Ace/ace.js');

		$aceUrl = AssetsManager::getInstance()->getOneCommonURL('/resources/Ace');
		$aceUrlParts = parse_url($aceUrl);
		$this->response->setJsVar('aceScriptsPath', $aceUrlParts['path']);

		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
		
		$model = new SpecialCssModel();

		if ($this->request->wasPosted()) {
			$status = $model->saveCssFileContent(
				$this->request->getVal('cssContent', ''),
				$this->request->getVal('editSummary', ''),
				$this->request->getVal('minorEdit', '') != '',
				$this->wg->user
			);
			// TODO handle statuses
			$this->response->redirect($this->specialPage->getTitle()->getLocalURL());
		}

		$this->deletedArticle = '';
		$title = $model->getCssFileTitle();
		$this->dropdown = array();
		if ( !empty( $title ) ) {
			if ( !$title->isDeleted() ) {
			} else
			{
				LogEventsList::showLogExtract( $this->deletedArticle, array( 'delete', 'move' ), $title,
					'', array( 'lim' => 10,
						'conds' => array( "log_action != 'revision'" ),
						'showIfEmpty' => false,
						'msgKey' => array( 'recreate-moveddeleted-warn') )
				);
			}
		}
		$this->cssContent = $model->getCssFileContent();
		F::build('JSMessages')->enqueuePackage('SpecialCss', JSMessages::EXTERNAL);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Method for getting diff between actual Wikia.css file and text given in request parameter
	 * @param string wikitext - request param in which you can provide text to create a diff
	 *
	 */
	public function getDiff() {
		$wikitext = $this->request->getVal('wikitext', '');
		$model = new SpecialCssModel();

		$editPageService = new EditPageService(
			$model->getCssFileTitle()
		);
		$this->diff = $editPageService->getDiff($wikitext);
	}
	
	public function notOasis() {
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
	}
}
