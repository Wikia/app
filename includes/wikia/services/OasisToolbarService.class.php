<?php

	abstract class ToolbarService {

		const PROMOTIONS_UPDATE_TTL = 1800;

		protected $name = '';

		public function __construct( $name ) {
			$this->name = $name;
		}


		public function buildListItem( $id, $data = array() ) {
			return array(
				'type' => 'item',
				'id' => $id,
				'data' => $data,
			);
		}

		public function buildMenuListItem( $name, $items, $data = array() ) {
			return array(
				'type' => 'menu',
				'id' => 'Menu:' . $name,
				'data' => $data,
				'items' => $items,
			);
		}


		public function jsonToList( $json ) {
			$result = array();
			foreach ($json as $v) {
				$entry = array(
					'type' => 'item',
					'id' => $v['id'],
					'data' => array(),
				);
				if ($v['defaultCaption'] !== $v['caption']) {
					$entry['data']['caption'] = $v['caption'];
				}
				/* FB:42264 - data is corrupt in production, so we have to handle both items list existing condition and isMenu condition*/
				if (!empty($v['isMenu'])) {
					$items = isset($v['items']) ? $v['items'] : array();
					$entry['type'] = 'menu';
					$entry['items'] = $this->jsonToList($items);
				}
				/* end FB:42264 */
				$result[] = $entry;
			}
			return array_values($result);
		}

		public function stringsToList( $data ) {
			foreach ($data as $k => $v) {
				if (!is_array($v)) {
					$data[$k] = $this->buildListItem( $v );
				}
				if (isset($data[$k]['items'])) {
					$data[$k]['items'] = $this->stringsToList($data[$k]['items']);
				}
			}
			return $data;
		}

		public function instanceToJson( $data ) {
			foreach ($data as $k => $v) {
				$v = $v->getInfo();
				if ($v) $data[$k] = $v;
				else unset($data[$k]);
			}
			return array_values($data);
		}

		public function instanceToRenderData( $data ) {
			foreach ($data as $k => $v) {
				$v = $v->getRenderData();
				if ($v) $data[$k] = $v;
				else unset($data[$k]);
			}
			return array_values($data);
		}

		public function listToJson( $data ) {
			$data = $this->stringsToList($data);
			$data = $this->listToInstance($data);
			$data = $this->instanceToJson($data);
			return $data;
		}

		public function listToInstance( $data ) {
			$blacklist = $this->getBlacklist();
			$result = array();
			foreach ($data as $v) {
				switch ($v['type']) {
					case 'item':
						if (!in_array($v['id'],$blacklist)) {
							$result[] = $this->getUserCommandsService()->get($v['id'],isset($v['data'])?$v['data']:array());
						}
						break;
					case 'menu':
						$menu = $this->getUserCommandsService()->createMenu($v['id'],wfMsg('oasis-mytools'),array(
							'imageSprite' => 'mytools',
							'listItemClass' => 'mytools menu',
						));
						$submenu = $this->listToInstance($v['items']);
						foreach ($submenu as $item)
							$menu->addItem($item);
						$result[] = $menu;
						break;
				}
			}
			return $result;
		}

		public function sortJsonByCaption( $data ) {
			$assoc = array();
			foreach ($data as $v)
				$assoc[$v['caption']] = $v;
			ksort($assoc);
			return array_values($assoc);
		}


		public function cleanList( $list ) {
			foreach ($list as $k => $v) {
				if (isset($v['items'])) {
					$list[$k] = $this->cleanList($v['items']);
				}
			}
			return array_values($list);
		}



		static protected $navigationUrls = null;

		protected function getNavigationUrls() {
			if (is_null(self::$navigationUrls)) {
				$context = RequestContext::getMain();
				$skin = $context->getSkin();

				if (!isset($skin->iscontent)) {
					/* safe and slow version - possible side-efectes */
					/*
					global $wgForceSkin, $wgOut;

					$wgForceSkin = 'oasis';
					ob_start();
					$skin->outputPage($wgOut);
					ob_end_clean();
					*/
					/* unsafe but a lot faster version - hard trick */
					$title = $skin->getTitle();

					$skin->iscontent = ( $title->getNamespace() != NS_SPECIAL || 1 == 1);
					$skin->thispage = $title->getPrefixedDBkey();
					$skin->loggedin = $context->getUser()->isLoggedIn();
				}

				self::$navigationUrls = array(
					'content_actions' => $skin->buildContentActionUrls( $skin->buildContentNavigationUrls() ),
					'nav_urls' => $skin->buildNavUrls(),
				);
			}

			return self::$navigationUrls;
		}

		protected $userCommandsService = null;

		protected function getUserCommandsService() {
			if (empty($this->userCommandsService)) {
				$this->userCommandsService = new UserCommandsService($this->getNavigationUrls());
			}
			return $this->userCommandsService;
		}


		public function getToolbarOptionName() {
			return $this->name.'-toolbar-contents';
		}
		protected function getPromotionsOptionName() {
			return $this->name.'-toolbar-promotions';
		}

		protected function getUpdatePromotionsKey() {
			global $wgUser;
			return wfMemcKey($this->name.'-toolbar','update-promotions',$wgUser->getId());
		}

		public function getSeenPromotions() {
			global $wgUser;
			if ($wgUser->isAnon()) {
				return array();
			}

			$seenPromotions = $wgUser->getOption( $this->getPromotionsOptionName(), false );
			$seenPromotions = $seenPromotions ? unserialize($seenPromotions) : array();
			$promotionsDiff = array_intersect( $this->getPromotions(), $seenPromotions );

			return $promotionsDiff;
		}

		protected function setSeenPromotions( $list ) {
			global $wgUser;

			$wgUser->setOption( $this->getPromotionsOptionName(), serialize($list) );
			$wgUser->saveSettings();
			return true;
		}

		protected function updatePromotions( $forceUpdate = false ) {
			global $wgUser, $wgMemc;
			if ($wgUser->isAnon()) {
				return;
			}

			$updated = $wgMemc->get($this->getUpdatePromotionsKey(),false);
			if ($forceUpdate || empty($updated)) {
				$seenPromotions = $this->getSeenPromotions();
				$unseenPromotions = array_diff($this->getPromotions(),$seenPromotions);

				$list = $unseenPromotions;
				$list = $this->stringsToList($list);
				$list = $this->listToInstance($list);
				foreach ($list as $k => $item) {
					if (!$item->isAvailable() || !$item->isEnabled()) {
						unset($list[$k]);
					}
				}

				// User has unseen promoted tools
				if (!empty($list)) {
					$newItems = array();
					foreach ($list as $item) {
						$newItems[] = $item;
						$seenPromotions[] = $item->getId();
					}
					$this->addItemsAndSave($newItems);
					$this->setSeenPromotions($seenPromotions);
				}

				$wgMemc->set($this->getUpdatePromotionsKey(),true,self::PROMOTIONS_UPDATE_TTL);
			}
		}


		protected function addItemsAndSave( $items ) {
			$items = $this->jsonToList( $this->instanceToJson($items) );
			$data = $this->getCurrentList();
			end($data);
			$myToolsId = key($data);
			$data[$myToolsId]['items'] = array_merge($data[$myToolsId]['items'],$items);
			$this->saveToolbarList($data);
		}

		protected function loadToolbarList() {
			global $wgUser;
			if (!$wgUser->isAnon()) {
				$toolbar = $wgUser->getOption($this->getToolbarOptionName(),null);
				if (is_string($toolbar)) {
					$toolbar = @unserialize($toolbar);
					if (is_array($toolbar)) {
						/* FB:42264 Fix bad data by switch my-tools to menu if it is item */
						foreach($toolbar as $k => $v) {
							if($v['type'] === 'item' && strpos($v['id'], 'my-tools')) {
								$v['type'] = 'menu';
								$v['items'] = array();
								$toolbar[$k] = $v;
							}
						}
						/* end FB:42264 */
						return $toolbar;
					}
				}
			}

			return false;
		}

		protected function saveToolbarList( $list ) {
			global $wgUser;
			if ($wgUser->isAnon()) {
				return false;
			}

//			$list = $this->cleanList($list);

			$wgUser->setOption($this->getToolbarOptionName(),serialize($list));
			$wgUser->saveSettings();
			return true;
		}

		public function load() {
			return $this->loadToolbarList();
		}

		public function save( $list ) {
			return $this->saveToolbarList($list);
		}

		public function clear() {
			global $wgUser, $wgMemc;
			$wgUser->setOption( $this->getPromotionsOptionName(), null );
			$wgUser->setOption( $this->getToolbarOptionName(), null );
			$wgUser->saveSettings();;

			$wgMemc->delete( $this->getUpdatePromotionsKey() );
		}




		abstract public function getCurrentList();
		abstract public function getDefaultList();


		abstract public function getPromotions();
		abstract public function getAllOptionNames();
		abstract public function getPopularOptionNames();
		abstract public function getBlacklist();

	}

	class OasisToolbarService extends ToolbarService {

		static protected $recursiveBarrier = 0;

		public function __construct() {
			self::$recursiveBarrier++;
			parent::__construct('oasis');
			if (self::$recursiveBarrier <= 1) {
				$this->updatePromotions();
			}
			self::$recursiveBarrier--;
		}

		public function getVisibleList() {
			$list = $this->getCurrentList();
			$list[] = $this->buildListItem('Action:CustomizeToolbar');
			return $list;
		}

		public function getCurrentList() {
			$data = $this->loadToolbarList();
			if ($data == false) {
				$data = $this->getDefaultList();
				if (isset($data['my-tools'])) {
					$data['my-tools']['items'] = array_merge($this->importMyTools(),$data['my-tools']['items']);
				}
			}

			$data = $this->stringsToList($data);

			return $data;
		}

		public function getDefaultList() {
			global $wgUser;

			$data = array(
				$this->buildListItem( 'PageAction:Follow' ),
			);

			if (!$wgUser->isAnon()) {
				$data['my-tools'] = $this->buildMenuListItem( 'my-tools', array_merge(
					array(
						$this->buildListItem( 'PageAction:History' ),
						$this->buildListItem( 'PageAction:Whatlinkshere' ),
					),
					$this->stringsToList($this->getSeenPromotions())
				));
			}

			$data = $this->stringsToList($data);

			return $data;
		}

		public function getPopularList() {
			return $this->stringsToList(array_merge($this->getPopularOptionNames(),$this->getSeenPromotions()));
		}

		public function getAllList() {
			return $this->stringsToList($this->getAllOptionNames());
		}


		public function getPromotions() {
			return array(
				'SpecialPage:ThemeDesigner',
				'SpecialPage:LayoutBuilder',
			);
		}

		public function getAllOptionNames() {
			return array(
				'PageAction:Follow',
				'PageAction:History',
				'PageAction:Move',
				'PageAction:Delete',
				'PageAction:Edit',
				'PageAction:Protect',
				'PageAction:Whatlinkshere',
				'SpecialPage:AllPages',
				'SpecialPage:PrefixIndex',
				'SpecialPage:Block',
				'SpecialPage:BlockList',
				'SpecialPage:BrokenRedirects',
				'SpecialPage:Categories',
				'SpecialPage:CategoryTree',
				'SpecialPage:Contact',
				'SpecialPage:Contributions',
				'SpecialPage:DeadendPages',
				'SpecialPage:DeletedContributions',
				'SpecialPage:Disambiguations',
				'SpecialPage:DoubleRedirects',
				'SpecialPage:FileDuplicateSearch',
				'SpecialPage:Editcount',
				'SpecialPage:Export',
				'SpecialPage:LinkSearch',
				'SpecialPage:ListFiles',
				'SpecialPage:FilePath',
				'SpecialPage:Import',
				'SpecialPage:Log',
				'SpecialPage:LongPages',
				'SpecialPage:MIMESearch',
				'SpecialPage:MostLinkedCategories',
				'SpecialPage:MostLinkedPages',
				'SpecialPage:MostLinkedFiles',
				'SpecialPage:MostLinkedTemplates',
				'SpecialPage:Mostpopularcategories',
				'SpecialPage:Mostvisitedpages',
				'SpecialPage:NewPages',
				'SpecialPage:NewFiles',
				'SpecialPage:AncientPages',
				'SpecialPage:LonelyPages',
				'SpecialPage:FewestRevisions',
				'SpecialPage:MostCategories',
				'SpecialPage:MostRevisions',
				'SpecialPage:WithoutInterwiki',
				'SpecialPage:ProtectedPages',
				'SpecialPage:ProtectedTitles',
				'SpecialPage:RecentChanges',
				'SpecialPage:ListRedirects',
				'SpecialPage:RecentChangesLinked',
				'SpecialPage:Undelete',
				'SpecialPage:Search',
				'SpecialPage:ShortPages',
				'SpecialPage:SpecialPages',
				'SpecialPage:AllMessages',
				'SpecialPage:TagsReport',
				'SpecialPage:UncategorizedCategories',
				'SpecialPage:UncategorizedFiles',
				'SpecialPage:UncategorizedPages',
				'SpecialPage:UncategorizedTemplates',
				'SpecialPage:UnusedCategories',
				'SpecialPage:UnusedFiles',
				'SpecialPage:UnusedTemplates',
				'SpecialPage:UnwatchedPages',
				'SpecialPage:MultipleUpload',
				'SpecialPage:Upload',
				'SpecialPage:ListGroupRights',
				'SpecialPage:UserRights',
				'SpecialPage:ListUsers',
				'SpecialPage:Version',
				'SpecialPage:WantedCategories',
				'SpecialPage:WantedFiles',
				'SpecialPage:WantedPages',
				'SpecialPage:WantedTemplates',
				'SpecialPage:Watchlist',
				'SpecialPage:Leaderboard',
				'SpecialPage:CreatePage',
				'SpecialPage:Preferences',
				'SpecialPage:Random',
				'SpecialPage:WikiActivity',
				'SpecialPage:ThemeDesigner',
				'SpecialPage:LayoutBuilder',
				'SpecialPage:MyContributions',
				'SpecialPage:Statistics',
				'SpecialPage:WikiFactory',
				'SpecialPage:WikiFeatures',
				'Action:DevInfo' // a.k.a. PerformanceStats, BugId:5497
			);
		}

		public function getPopularOptionNames() {
			return array(
				'SpecialPage:CreatePage',
				'PageAction:Delete',
				'PageAction:Edit',
				'PageAction:Follow',
				'PageAction:History',
				'PageAction:Move',
				'SpecialPage:MyContributions',
				'SpecialPage:Random',
				'SpecialPage:RecentChanges',
				'SpecialPage:Upload',
				'PageAction:Whatlinkshere',
				'SpecialPage:WikiActivity',
			);
		}

		public function getBlacklist() {
			$out = array(
				'PageAction:Share',
				'SpecialPage:WikiaLabs',
			);
			// BugId:5497, blacklist DevInfo if not allowed
			if ( !F::app()->wg->user->isAllowed( 'performancestats' ) ) {
				$out[] = 'Action:DevInfo';
			}
			return $out;
		}

		protected function importMyTools() {
			global $wgUser;

			$list = array();
			$data = $wgUser->getOption('myTools',false);
			if (is_string($data)) {
				$data = json_decode($data,true);
				foreach ($data as $specialPage)
					$list[] = $this->buildListItem("SpecialPage:{$specialPage}");
			}

			return $list;
		}

	}
