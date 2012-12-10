<?php
class FooterController extends WikiaController {

	public function __construct() {
		parent::__construct();
		$this->registerDefaultFooterItems();
	}

	public function executeIndex() {
		global $wgShowMyToolsOnly,
			   $wgEnableWikiaBarExt,
			   $wgSuppressToolbar;

		// show for anons as well (BugId:20730)
		$this->showNotifications = empty($wgSuppressToolbar) && empty($wgEnableWikiaBarExt);
		$this->showToolbar = !($this->isAdminToolbarSupressed() || $wgSuppressToolbar) && empty($wgEnableWikiaBarExt);

		if( $this->showToolbar == false ) {
			return;
		}

		// show only "My Tools" dropdown on toolbar
		if (!empty($wgShowMyToolsOnly)) {
			return;
		}
	}

	/**
	 * @desc AdminToolBar isn't displayed in OasisFooter if $wgSupressToolbar variable is set to true (for instance on edit pages), user is an anon or WikiaBar extension is turned on
	 * @return bool
	 */
	protected function isAdminToolbarSupressed() {
		global $wgUser, $wgSuppressToolbar, $wgEnableWikiaBarExt;
		return empty($wgSuppressToolbar) && empty($wgEnableWikiaBarExt) && !$wgUser->isAnon();
	}

	static protected $toolbarService = null;

	/**
	 * @return OasisToolbarService
	 */
	protected function getToolbarService() {
		if (empty(self::$toolbarService)) {
			self::$toolbarService = new OasisToolbarService();
		}
		return self::$toolbarService;
	}


	public function executeToolbar() {
		$service = $this->getToolbarService();
		$toolbar = $service->listToInstance($service->getVisibleList());
		$this->toolbar = $service->instanceToRenderData($toolbar);
	}

	public function executeToolbarConfigurationPopup() {
	}

	public function executeToolbarConfigurationRenameItemPopup() {
	}

	public function executeToolbarConfiguration() {
		$this->configurationHtml = F::app()->renderView('Footer','ToolbarConfigurationPopup',array('format' => 'html'));
		$this->renameItemHtml = F::app()->renderView('Footer','ToolbarConfigurationRenameItemPopup',array('format' => 'html'));

		$service = $this->getToolbarService();
		$this->defaultOptions = $service->listToJson($service->getDefaultList());
		$this->options = $service->listToJson($service->getCurrentList());
		$this->allOptions = $service->sortJsonByCaption($service->listToJson($service->getAllList()));
		$this->popularOptions = $service->sortJsonByCaption($service->listToJson($service->getPopularList()));
	}

	public function executeToolbarSave( $params ) {
		$this->status = false;
		$service = $this->getToolbarService();
		if (isset($params['toolbar']) && is_array($params['toolbar'])) {
			$data = $service->jsonToList($params['toolbar']);
			if (!empty($data)) {
				$this->status = $service->save($data);
			}
		}
		$this->toolbar = F::app()->renderView('Footer','Toolbar',array('format' => 'html'));
	}

	public function executeToolbarGetList() {
		$service = $this->getToolbarService();
		$this->allOptions = $service->listToJson($service->getAllList());
	}

	public function executeDebug() {
		global $wgRequest;
		$service = $this->getToolbarService();
		if ($wgRequest->getVal('clear',false)) {
			$service->clear();
		}
		$this->defaultList = $service->listToJson($service->getDefaultList());
		$this->storedList = $service->load();
		$this->currentList = $service->listToJson($service->getCurrentList());

		$this->seenPromotions = $service->getSeenPromotions();

		global $wgUser;
		$data = $wgUser->getOption('myTools',false);
		$data = $data ? json_decode($data,true) : false;
		$this->myTools = $data;
	}

	public function executeMenu( $params ) {
		$this->wf->profileIn(__METHOD__);
		$items = (array)$params['items'];
		wfRunHooks('BeforeToolbarMenu', array(&$items));

		$itemObjects = array();
		foreach($items as $item) {
			$itemObj = FooterMenuItemFactory::buildItem($item['type']);
			$itemObj->setRawData($item);
			$itemObjects [] = $itemObj;
		}
		$this->items = $itemObjects;

		$this->wf->profileOut(__METHOD__);
	}

	protected function registerDefaultFooterItems() {
		FooterMenuItemFactory::addSupportedItem('share', 'FooterShareItemService');
		FooterMenuItemFactory::addSupportedItem('follow', 'FooterFollowItemService');
		FooterMenuItemFactory::addSupportedItem('menu', 'FooterMenuItemService');
		FooterMenuItemFactory::addSupportedItem('link', 'FooterLinkItemService');
		FooterMenuItemFactory::addSupportedItem('html', 'FooterHtmlItemService');
		FooterMenuItemFactory::addSupportedItem('customize', 'FooterCustomizeItemService');
		FooterMenuItemFactory::addSupportedItem('devinfo', 'FooterDevinfoItemService');
		FooterMenuItemFactory::addSupportedItem('disabled', 'FooterDisabledItemService');
	}
}

