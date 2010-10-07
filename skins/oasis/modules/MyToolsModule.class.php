<?php
class MyToolsModule extends Module {

	var $defaultTools;
	var $customTools;
	var $wgBlankImgUrl;

	public function executeIndex($params) {
		global $wgUser, $wgOut, $wgStylePath;

		if(isset($params['tools'])) {
			$wgUser->setOption('myTools', json_encode($params['tools']));
			$wgUser->saveSettings();
		}

		$this->defaultTools = $this->getDefaultTools();
		$this->customTools = $this->getCustomTools();

		// Moved to StaticChute.
		//$wgOut->addScript('<script src="'. $wgStylePath .'/oasis/js/MyTools.js"></script>');
	}

	private function getCustomTools() {
		wfProfileIn(__METHOD__);
		global $wgUser;

		$out = array();
		$tools = json_decode($wgUser->getOption('myTools'), true);

		if(is_array($tools)) {
			foreach($tools as $tool) {
				$page = SpecialPage::getPageByAlias($tool);
				if(is_object($page)) {
					$out[] = array(
						'text' => $page->getDescription(),
						'href' => $page->getTitle()->getLocalUrl(),
						'usercan' => $page->userCanExecute($wgUser),
						'name' => strtolower($tool),
					);
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $out;
	}

	private function getDefaultTools() {
		global $wgUser;

		$out = array();

		if(isset(self::$skinTemplateObj->data['content_actions']['edit'])) {

			// history link
			if(isset(self::$skinTemplateObj->data['content_actions']['history'])) {
				$out[] = array(
					'text' => self::$skinTemplateObj->data['content_actions']['history']['text'],
					'href' => self::$skinTemplateObj->data['content_actions']['history']['href'],
					'name' => 'history',
				);
			}

		}

		// what links here link
		if(isset(self::$skinTemplateObj->data['nav_urls']['whatlinkshere'])) {
			$out[] = array(
				'text' => SpecialPage::getPageByAlias('whatlinkshere')->getDescription(),
				'href' => self::$skinTemplateObj->data['nav_urls']['whatlinkshere']['href'],
				'name' => 'whatlinkshere',
			);
		}

		// block user
		if(!empty(self::$skinTemplateObj->data['nav_urls']['blockip'])) {
			$out[] = array(
				'text' => wfMsg('blockip'),
				'href' => self::$skinTemplateObj->data['nav_urls']['blockip']['href'],
				'name' => 'blockip',
			);
		}

		// theme designer
		if($wgUser->isAllowed('themedesigner')) {
			$page = SpecialPage::getPageByAlias('ThemeDesigner');

			$out[] = array(
				'text' => $page->getDescription(),
				'href' => $page->getTitle()->getLocalUrl(),
				'name' => 'themedesigner',
			);
		}

		return $out;
	}

	var $configurationScssUrl;
	var $userCustomTools;
	var $wgScriptPath;
	var $allMyTools;

	public function executeConfiguration() {
		$this->userCustomTools = $this->getUserCustomTools();
	}

	private function getUserCustomTools() {
		global $wgUser;

		$out = array();
		$tools = json_decode($wgUser->getOption('myTools'), true);

		if(is_array($tools)) {
			foreach($tools as $tool) {
				$page = SpecialPage::getPageByAlias($tool);
				if(is_object($page)) {
					$out[] = array('name' => $tool, 'desc' => $page->getDescription());
				}
			}
		}

		return $out;
	}

	var $query;
	var $suggestions;
	var $data;

	public function executeSuggestions() {
		global $wgRequest;

		$this->query = $wgRequest->getText('query');
		$query = strtolower($this->query);

		$this->suggestions = array();
		$this->data = array();

		$toolsNames = $this->getAllToolsNames();

		wfRunHooks('MyTools::getAllToolsNames', array(&$toolsNames));

		$tools = array();

		foreach($toolsNames as $toolName) {
			$page = SpecialPage::getPageByAlias($toolName);
			if(is_object($page)) {
				$toolDesc = $page->getDescription();
				if(strpos(strtolower($toolDesc), $query) === 0 || strpos(strtolower($toolName), $query) === 0) {
					$tools[$toolName] = $toolDesc;
				}
			}
		}


		asort($tools);

		$this->suggestions = array_values($tools);
		$this->data = array_keys($tools);
	}

	private function getAllToolsNames() {
		return array(
			'AllPages',
			'PrefixIndex',
			'Block',
			'BlockList',
			'BrokenRedirects',
			'Categories',
			'CategoryTree',
			'Contact',
			'Contributions',
			'DeadendPages',
			'DeletedContributions',
			'Disambiguations',
			'DoubleRedirects',
			'FileDuplicateSearch',
			'Editcount',
			'Export',
			'LinkSearch',
			'ListFiles',
			'FilePath',
			'Import',
			'Log',
			'LongPages',
			'MIMESearch',
			'MostLinkedCategories',
			'MostLinkedPages',
			'MostLinkedFiles',
			'MostLinkedTemplates',
			'Mostpopularcategories',
			'Mostpopulararticles',
			'Mostvisitedpages',
			'NewPages',
			'NewFiles',
			'AncientPages',
			'LonelyPages',
			'FewestRevisions',
			'MostCategories',
			'MostRevisions',
			'WithoutInterwiki',
			'ProtectedPages',
			'ProtectedTitles',
			'RecentChanges',
			'ListRedirects',
			'RecentChangesLinked',
			'Undelete',
			'Search',
			'ShortPages',
			'SpecialPages',
			'AllMessages',
			'TagsReport',
			'UncategorizedCategories',
			'UncategorizedFiles',
			'UncategorizedPages',
			'UncategorizedTemplates',
			'UnusedCategories',
			'UnusedFiles',
			'UnusedTemplates',
			'UnwatchedPages',
			'MultipleUpload',
			'Upload',
			'ListGroupRights',
			'UserRights',
			'ListUsers',
			'Version',
			'WantedCategories',
			'WantedFiles',
			'WantedPages',
			'WantedTemplates',
			'Watchlist',
			'Leaderboard',
			'CreatePage',
			'Preferences',
			'Random',
			'WikiActivity'
		);
	}
}