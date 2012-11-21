<?php
class FooterController extends WikiaController {

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
		$items = (array)$params['items'];
		wfRunHooks('BeforeToolbarMenu', array(&$items));

		MenuItemFactory::addSupportedItem('share','shareFeature');
		MenuItemFactory::addSupportedItem('follow','followFeature');
		MenuItemFactory::addSupportedItem('menu','menuFeature');
		MenuItemFactory::addSupportedItem('link','linkFeature');
		MenuItemFactory::addSupportedItem('html','htmlFeature');
		MenuItemFactory::addSupportedItem('customize','customizeFeature');
		MenuItemFactory::addSupportedItem('devinfo','devinfoFeature');
		MenuItemFactory::addSupportedItem('disabled','disabledFeature');

		$itemObjects = array();

		foreach($items as $item) {
			$itemObj = MenuItemFactory::buildItem($item['type']);
			$itemObj->setRawData($item);
			$itemObjects [] = $itemObj;
		}
		$this->items = $itemObjects;
	}
}

class MenuItemFactory {
	protected static $supportedItems = array();

	static function buildItem($itemType) {
		if(!empty(self::$supportedItems[$itemType])) {
			return new self::$supportedItems[$itemType];
		}
	}

	static function addSupportedItem($itemType, $itemClass) {
		self::$supportedItems[$itemType] = $itemClass;
	}
}

abstract class menuItem extends WikiaObject {
	protected $rawData;

	public abstract function render();
	public function setRawData($data) {
		$this->rawData = $data;
	}

}

class shareFeature extends MenuItem {
	public function render() {
		echo '
			<li id="ca-share_feature" class="overflow">
        		<a id="control_share_feature" href="#"
           		data-name="' . $this->rawData['tracker-name'] . '">' . $this->rawData['caption'] . '</a>
    		</li>
    	';
	}
}

class followFeature extends MenuItem {
	public function render() {
		echo '
			<li class="overflow">
				<a accesskey="w" id="' . $this->rawData['link-id'] . '" href="' . $this->rawData['href'] . '"
				   data-name="' . $this->rawData['tracker-name'] . '">' . $this->rawData['caption'] . '</a>
			</li>
    	';
	}
}

class menuFeature extends MenuItem {
	public function render() {
		echo '
			<li class="mytools menu">
				<span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-single"></span></span>
				<a href="#">' .  $this->rawData['caption'] . '</a>
				<ul id="my-tools-menu" class="tools-menu">
					' .  $this->app->renderView('Footer', 'Menu', array('format' => 'html', 'items' => $this->rawData['items'])) . '
				</ul>
			</li>
    	';
	}
}

class linkFeature extends MenuItem {
	public function render() {
		echo '
			<li class="overflow">
				<a href="' .  $this->rawData['href'] . '" data-name="' . $this->rawData['tracker-name'] . '">' . $this->rawData['caption'] . '</a>
			</li>
    	';
	}
}

class htmlFeature extends MenuItem {
	public function render() {
		echo '
			<li>
				' . $this->rawData['html'] . '
			</li>
    	';
	}
}

class customizeFeature extends MenuItem {
	public function render() {
		echo '
			<li>
				<img height="16" width="16" class="sprite gear" src="<?= $wg->BlankImgUrl; ?>">
				<a class="tools-customize" href="#" data-name="customize">' . wfMsg('oasis-toolbar-customize') . '</a>
			</li>
    	';
	}
}

class devinfoFeature extends MenuItem {
	public function render() {
		/* Temporary, BugId:5497; TODO: call getPerformanceStats in DevInfoUserCommand.php rather than here */
		echo '
			<li class="loadtime">
				<span>' . $this->wf->getPerformanceStats() . '</span>
			</li>
    	';
	}
}

class disabledFeature extends MenuItem {
	public function render() {
		echo '
 			<li class="overflow">
	        	<span title="' . $this->rawData['error-message'] . '">' . $this->rawData['caption'] . '</span>
    		</li>
    	';
	}
}
