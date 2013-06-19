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
		global $wgUser;
		wfProfileIn(__METHOD__);

		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$model = new SpecialCssModel();

		if ($this->request->wasPosted()) {
			$content = $this->request->getVal('cssContent', '');
			$status = $model->saveCssFileContent(
				$content,
				$this->request->getVal('editSummary', ''),
				$this->request->getVal('minorEdit', '') != '',
				$this->wg->user
			);
			
			if ($status->isOk()) {
				NotificationsController::addConfirmation( wfMessage('special-css-save-message')->text() );
			} else {
				NotificationsController::addConfirmation(
					$status->getMessage(),
					NotificationsController::CONFIRMATION_ERROR
				);
				$this->cssContent = $content;
			}
		}

		$this->deletedArticle = '';
		$title = $model->getCssFileTitle();
		if ( !empty( $title ) ) {
			if ( !$title->isDeleted() ) {
				$this->historyUrl = $title->getLocalURL( 'action=history' );
				if ( $title->quickUserCan( 'delete', $wgUser ) ) {
					$this->deleteUrl = $title->getLocalURL( 'action=delete' );
				}
			} else
			{
				LogEventsList::showLogExtract( $this->deletedArticle, array( 'delete', 'move' ), $title,
					'', array( 'lim' => 10,
						'conds' => array( "log_action != 'revision'" ),
						'showIfEmpty' => false,
						'msgKey' => array( 'recreate-moveddeleted-warn' ) )
				);
				if ( $wgUser->isAllowed( 'deletedhistory' ) ) {
					$undelTitle = SpecialPage::getTitleFor( 'Undelete' );
					$this->undeleteUrl = $undelTitle->getLocalURL( array( 'target' => $title->getPrefixedDBkey() ) );
				}
			}
		}
		
		$this->cssContent = $model->getCssFileContent();
		
		$this->response->addAsset('/extensions/wikia/SpecialCss/css/SpecialCss.scss');
		$this->response->addAsset('/extensions/wikia/SpecialCss/js/SpecialCss.js');
		// This shouldn't be moved to asset manager package because of Ace internal autoloader
		$this->response->addAsset('/resources/Ace/ace.js');

		$aceUrl = AssetsManager::getInstance()->getOneCommonURL('/resources/Ace');
		$aceUrlParts = parse_url($aceUrl);
		$this->response->setJsVar('aceScriptsPath', $aceUrlParts['path']);

		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );

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
