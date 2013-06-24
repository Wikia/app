<?php
class SpecialCssController extends WikiaSpecialPageController {
	protected  $model;

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

		$model = $this->getModel();
		$this->cssContent = $model->getCssFileContent();

		if ($this->request->wasPosted()) {
			$content = $this->request->getVal('cssContent', '');
			$status = $model->saveCssFileContent(
				$content,
				$this->request->getVal('editSummary', ''),
				$this->request->getVal('minorEdit', '') != '',
				$this->wg->user
			);
			
			if ($status->isOk()) {
				NotificationsController::addConfirmation( wfMessage('special-css-save-message')->plain() );
				$this->wg->Out->redirect($this->specialPage->getTitle()->getLocalURL());
				return;
			} else {
				NotificationsController::addConfirmation(
					$status->getMessage(),
					NotificationsController::CONFIRMATION_ERROR
				);
				$this->cssContent = $content;
			}
		}

		if ($this->request->getVal('oldid', null) !== null) {
			NotificationsController::addConfirmation(
				wfMessage('special-css-oldid-message')->plain(),
				NotificationsController::CONFIRMATION_WARN
			);
		}

		$this->createDeleteLinks();
		$this->dropdown = $this->createButtonLinks();
		$this->handleAssets();
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->plain() );
		
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
	
	public function unsupportedSkinIndex() {
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
	}

	protected function handleAssets() {
		$this->response->addAsset('/extensions/wikia/SpecialCss/css/SpecialCss.scss');
		$this->response->addAsset('special_css_js');
		// This shouldn't be moved to asset manager package because of Ace internal autoloader
		$this->response->addAsset('/resources/Ace/ace.js');

		$aceUrl = AssetsManager::getInstance()->getOneCommonURL('/resources/Ace');
		$aceUrlParts = parse_url($aceUrl);
		$this->response->setJsVar('aceScriptsPath', $aceUrlParts['path']);

		(new JSMessages())->enqueuePackage('SpecialCss', JSMessages::EXTERNAL);
	}

	/**
	 * Pass delete, undelete links and information about deletion into view
	 */
	protected function createDeleteLinks() {
		$this->deletedArticle = '';
		$title = $this->getModel()->getCssFileTitle();
		if ( !empty( $title ) ) {
			if ( !$title->isDeleted() || $title->getArticleID() ) {
				$this->historyUrl = $title->getLocalURL( 'action=history' );
				if ( $title->quickUserCan( 'delete', $this->wg->user ) ) {
					$this->deleteUrl = $title->getLocalURL( 'action=delete' );
				}
			} else {
				// get message informing you that article is deleted and how you can restore it
				LogEventsList::showLogExtract(
					$this->deletedArticle,
					array( 'delete', 'move' ),
					$title,
					'',
					[
						'lim' => 10,
						'conds' => array( "log_action != 'revision'" ),
						'showIfEmpty' => false,
						'msgKey' => array( 'recreate-moveddeleted-warn' )
					]
				);
				if ( $this->wg->user->isAllowed( 'deletedhistory' ) ) {
					$undelTitle = SpecialPage::getTitleFor( 'Undelete' );
					$this->undeleteUrl = $undelTitle->getLocalURL( array( 'target' => $title->getPrefixedDBkey() ) );
				}
			}
		}
	}

	/**
	 * Get model
	 * @return SpecialCssModel
	 */
	protected function getModel() {
		if (empty($this->model)) {
			$this->model = new SpecialCssModel();
		}
		return $this->model;
	}

	protected function createButtonLinks() {
		$dropdown = [];
		if ( isset( $this->historyUrl ) ) {
			$dropdown[] = array(
				'text' => wfMessage('special-css-history-button')->plain(),
				'href' => $this->historyUrl
			);
		}

		$dropdown[] = array(
			'id' 	=> 'showChanges',
			'href' 	=> '#',
			'text' 	=> wfMessage('special-css-compare-button')->plain()
		);

		if ( isset( $this->deleteUrl ) ) {
			$dropdown[] = array(
				'href'	=> $this->deleteUrl,
				'text' 	=> wfMessage('special-css-delete-button')->plain()
			);
		}

		if ( isset( $this->undeleteUrl ) ) {
			$dropdown[] = array(
				'href'	=> $this->undeleteUrl,
				'text'	=> wfMessage('special-css-undelete-button')->plain()
			);
		}
		return $dropdown;
	}
}
