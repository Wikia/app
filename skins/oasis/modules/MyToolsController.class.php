<?php
class MyToolsController extends WikiaController {

	protected $content_actions;
	protected $nav_urls;

	public function init() {
		$this->content_actions = $this->app->getSkinTemplateObj()->data['content_actions'];
		$this->nav_urls = $this->app->getSkinTemplateObj()->data['nav_urls'];
	}

	public function executeIndex($params) {
		global $wgUser;

		if(isset($params['tools'])) {
			$wgUser->setGlobalPreference('myTools', json_encode($params['tools']));
			$wgUser->saveSettings();
		}

		$this->defaultTools = $this->getDefaultTools();
		$this->customTools = $this->getCustomTools();
	}

	private function getCustomTools() {
		wfProfileIn(__METHOD__);
		global $wgUser;

		$out = array();
		$tools = json_decode($wgUser->getGlobalPreference('myTools'), true);

		if(is_array($tools)) {
			foreach($tools as $tool) {
				$page = SpecialPageFactory::getPage($tool);
				if(is_object($page)) {
					$href = $page->getTitle()->getLocalUrl();

					switch ( $tool ) {
						case 'RecentChangesLinked':
							global $wgTitle;
							$href .= '/' . $wgTitle->getPartialUrl();
							break;

						case 'Contributions':
							$href .= '/' . $wgUser->getTitleKey();
							break;
					}
					$out[] = array(
						'text' => $page->getDescription(),
						'href' => $href,
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

		// history link
		if(isset($this->content_actions['history'])) {
			$out[] = array(
				'text' => $this->content_actions['history']['text'],
				'href' => $this->content_actions['history']['href'],
				'name' => 'history',
			);
		}

		// what links here link
		if(isset($this->nav_urls['whatlinkshere'])) {
			$out[] = array(
				'text' => SpecialPageFactory::getPage('whatlinkshere')->getDescription(),
				'href' => $this->nav_urls['whatlinkshere']['href'],
				'name' => 'whatlinkshere',
			);
		}

		// block user
		if(!empty($this->nav_urls['blockip'])) {
			$out[] = array(
				'text' => wfMsg('blockip'),
				'href' => $this->nav_urls['blockip']['href'],
				'name' => 'blockip',
			);
		}

		// theme designer
		if($wgUser->isAllowed('themedesigner')) {
			$page = SpecialPageFactory::getPage('ThemeDesigner');

			$out[] = array(
				'text' => $page->getDescription(),
				'href' => $page->getTitle()->getLocalUrl(),
				'name' => 'themedesigner',
			);
		}

		wfRunHooks('MyTools::getDefaultTools', array(&$out));

		return $out;
	}

	public function executeConfiguration() {
		$this->userCustomTools = $this->getUserCustomTools();
	}

	private function getUserCustomTools() {
		global $wgUser;

		$out = array();
		$tools = json_decode($wgUser->getGlobalPreference('myTools'), true);

		if(is_array($tools)) {
			foreach($tools as $tool) {
				$page = SpecialPageFactory::getPage($tool);
				if(is_object($page)) {
					$out[] = array('name' => $tool, 'desc' => $page->getDescription());
				}
			}
		}

		return $out;
	}

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
			$page = SpecialPageFactory::getPage($toolName);
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
			'WikiActivity',
			'Statistics'
		);
	}
}
