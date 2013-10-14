<?php
class SpecialCssController extends WikiaSpecialPageController {
	protected  $model;

	public function __construct() {
		parent::__construct('CSS', 'editinterface', true);
	}

	/**
	 * Main page for Special:Css page
	 * 
	 * @return boolean
	 */
	public function index() {
		wfProfileIn(__METHOD__);
		
		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			wfProfileOut(__METHOD__);
			return false; // skip rendering
		}

		$model = $this->getModel();
		$this->cssFileInfo = $model->getCssFileInfo();

		if ($this->request->wasPosted()) {
				$content = $this->request->getVal('cssContent', '');
				/** @var $status Status */
				$status = $model->saveCssFileContent(
					$content,
					$this->request->getVal('editSummary', ''),
					$this->request->getVal('minorEdit', '') != '',
					$this->request->getVal('lastEditTimestamp', false),
					$this->wg->user
				);

				if (!$status) {
					NotificationsController::addConfirmation(
						wfMessage('special-css-merge-error')->plain(),
						NotificationsController::CONFIRMATION_ERROR
					);
					$this->diff = $this->app->sendRequest(__CLASS__, 'getDiff', ['wikitext' => $content])->getVal('diff');
				} else if ($status->isOk()) {
					NotificationsController::addConfirmation( wfMessage('special-css-save-message')->plain() );
					$this->wg->Out->redirect($this->specialPage->getTitle()->getLocalURL());
					wfProfileOut(__METHOD__);
					return false; // skip rendering
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

		// get url and number of comments for Talk button
		$service = new PageStatsService($model->getCssFileArticleId());
		$this->cssFileTitle = $model->getCssFileTitle();
		$this->cssFileCommentsCount = $service->getCommentsCount();

		$this->cssUpdates = $model->getCssUpdatesData();
		$this->cssUpdatesUrl = $model->getCssUpdatesUrl();
		$this->dropdown = $this->createButtonLinks();
		$this->handleAssets();
		$this->minorDefault = $model->isMinorEditDefault();
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->plain() );

		$this->wg->SuppressSpotlights = true;

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @desc Method for getting diff between actual Wikia.css file and text given in request parameter
	 * @paramRequest string wikitext - request param in which you can provide text to create a diff
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
		$this->response->addAsset('resources/Ace/ace.js');

		$aceUrl = AssetsManager::getInstance()->getOneCommonURL('/resources/Ace');
		$aceUrlParts = parse_url($aceUrl);
		$this->response->setJsVar('aceScriptsPath', $aceUrlParts['path']);

		JSMessages::enqueuePackage('SpecialCss', JSMessages::EXTERNAL);
	}

	/**
	 * Pass delete, undelete links and information about deletion into view
	 */
	protected function getDeleteLinks() {
		$this->deletedArticle = '';
		$title = $this->getModel()->getCssFileTitle();
		if ( !empty( $title ) ) {
			if ( !$title->isDeleted() || $title->getArticleID() ) {
				$historyUrl = $title->getLocalURL( 'action=history' );
				if ( $title->quickUserCan( 'delete', $this->wg->user ) ) {
					$deleteUrl = $title->getLocalURL( 'action=delete' );
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
					$undeleteUrl = $undelTitle->getLocalURL( array( 'target' => $title->getPrefixedDBkey() ) );
				}
			}
		}

		$out = [
			'historyUrl' => isset($historyUrl) ? $historyUrl : null,
			'deleteUrl' => isset($deleteUrl) ? $deleteUrl : null,
			'undeleteUrl' => isset($undeleteUrl) ? $undeleteUrl : null,
		];
		return $out;
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
		$deleteLinks = $this->getDeleteLinks();

		$dropdown = [];
		if ( isset( $deleteLinks['historyUrl'] ) ) {
			$dropdown[] = array(
				'text' => wfMessage('history')->plain(),
				'href' => $deleteLinks['historyUrl']
			);
		}

		$dropdown[] = array(
			'id' 	=> 'showChanges',
			'href' 	=> '#',
			'text' 	=> wfMessage('special-css-compare-button')->plain()
		);

		if ( isset( $deleteLinks['deleteUrl'] ) ) {
			$dropdown[] = array(
				'href'	=> $deleteLinks['deleteUrl'],
				'text' 	=> wfMessage('delete')->plain()
			);
		}

		if ( isset( $deleteLinks['undeleteUrl'] ) ) {
			$dropdown[] = array(
				'href'	=> $deleteLinks['undeleteUrl'],
				'text'	=> wfMessage('undelete')->plain()
			);
		}
		return $dropdown;
	}
}
