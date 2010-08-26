<?php
/**
 * Monaco skin
 *
 * @package MediaWiki
 * @subpackage Skins
 *
 * @author Inez Korczynski <inez@wikia.com>
 * @author Christian Williams
 */
if(!defined('MEDIAWIKI')) {
	die(-1);
}

define('STAR_RATINGS_WIDTH_MULTIPLIER', 17);

############################## MonacoSidebar ##############################
global $wgHooks;
$wgHooks['MessageCacheReplace'][] = 'MonacoSidebar::invalidateCache';

class MonacoSidebar {

	const version = '0.04';

	static function invalidateCache() {
		global $wgMemc;
		$wgMemc->delete(wfMemcKey('mMonacoSidebar', self::version));
		return true;
	}

	public $editUrl = false;

	public function getCode() {
		global $wgUser, $wgTitle, $wgRequest, $wgMemc, $wgLang, $wgContLang;
		if($wgUser->isLoggedIn()) {
			if(empty($wgUser->mMonacoSidebar) || ($wgTitle->getNamespace() == NS_USER && $wgRequest->getText('action') == 'delete')) {
				$wgUser->mMonacoSidebar = $this->getMenu($this->getUserLines(), true);
				if(empty($wgUser->mMonacoSidebar)) {
					$wgUser->mMonacoSidebar = -1;
				}
				$wgUser->saveToCache();
			}
			if($wgUser->mMonacoSidebar != -1) {
				return $wgUser->mMonacoSidebar;
			}
		}

		$cache = $wgLang->getCode() == $wgContLang->getCode();
		if($cache) {
			$key = wfMemcKey('mMonacoSidebar', self::version);
			$menu = $wgMemc->get($key);
		}
		if(empty($menu)) {
			$menu = $this->getMenu($this->getMenuLines());
			if($cache) {
				$wgMemc->set($key, $menu, 60 * 60 * 8);
			}
		}
		return $menu;
	}

	public function getUserLines() {
		global $wgUser,  $wgParser, $wgMessageCache;
		$revision = Revision::newFromTitle(Title::newFromText('User:'.$wgUser->getName().'/Monaco-sidebar'));
		if(is_object($revision)) {
			$text = $revision->getText();
			if(!empty($text)) {
				$ret = explode("\n", $wgParser->transformMsg($text, $wgMessageCache->getParserOptions()));
				return $ret;
			}
		}
		return null;
	}

	public function getMenuLines() {
		global $wgCat;

		$revision = Revision::newFromTitle(Title::newFromText('Monaco-sidebar', NS_MEDIAWIKI));
		if(is_object($revision) && trim($revision->getText()) != '') {
			$lines = getMessageAsArray('Monaco-sidebar');
		}

		if(empty($lines)) {
			if(isset($wgCat['id'])) {
				$lines = getMessageAsArray('shared-Monaco-sidebar-' . $wgCat['id']);
			}
		}

		if(empty($lines)) {
			$lines = getMessageAsArray('Monaco-sidebar');
		}

		return $lines;
	}

	public function getMenu($lines, $userMenu = false) {
		global $wgMemc, $wgScript;

		$nodes = $this->parse($lines);

		if(count($nodes) > 0) {
			$menu = '<div id="navigation"'.($userMenu ? ' class="userMenu"' : '').'>';
			$mainMenu = array();
			foreach($nodes[0]['children'] as $key => $val) {
				if(isset($nodes[$val]['children'])) {
					$mainMenu[$val] = $nodes[$val]['children'];
				}
				if(isset($nodes[$val]['magic'])) {
					$mainMenu[$val] = $nodes[$val]['magic'];
				}
				if(isset($nodes[$val]['href']) && $nodes[$val]['href'] == 'editthispage') $menu .= '<!--b-->';
				$menu .= '<div id="menu-item_'.$val.'" class="menu-item">';
				$menu .= '<a id="a-menu-item_'.$val.'" href="'.(!empty($nodes[$val]['href']) ? htmlspecialchars($nodes[$val]['href']) : '#').'" rel="nofollow">'.htmlspecialchars($nodes[$val]['text']).((!empty($nodes[$val]['children']) || !empty($nodes[$val]['magic'])) ? '<em>&rsaquo;</em>' : '').'</a>';
				$menu .= '</div>';
				if(isset($nodes[$val]['href']) && $nodes[$val]['href'] == 'editthispage') $menu .= '<!--e-->';
			}
			$menu .= '</div>';

			if($this->editUrl) {
				$menu = str_replace('href="editthispage"', 'href="'.$this->editUrl.'"', $menu);
			} else {
				$menu = preg_replace('/<!--b-->(.*)<!--e-->/U', '', $menu);
			}

			if(isset($nodes[0]['magicWords'])) {
				$magicWords = $nodes[0]['magicWords'];
				$magicWords = array_unique($magicWords);
				sort($magicWords);
			}

			$menuHash = hash('md5', serialize($nodes));

			foreach($nodes as $key => $val) {
				if(!isset($val['depth']) || $val['depth'] == 1) {
					unset($nodes[$key]);
				}
				unset($nodes[$key]['parentIndex']);
				unset($nodes[$key]['depth']);
				unset($nodes[$key]['original']);
			}

			$nodes['mainMenu'] = $mainMenu;
			if(!empty($magicWords)) {
				$nodes['magicWords'] = $magicWords;
			}

			$wgMemc->set($menuHash, $nodes, 60 * 60 * 24 * 3); // three days

			$menu .= '<script type="text/javascript" src="'.$wgScript.'?action=ajax&amp;v='.self::version.'&amp;rs=getMenu&amp;id='.$menuHash.'"></script>';

			return $menu;
		}
	}

	public function parse($lines) {
		$nodes = array();
		$lastDepth = 0;
		$i = 0;
		if(is_array($lines) && count($lines) > 0) {
			foreach($lines as $line) {
				if(trim($line) === '') {
					continue; // ignore empty lines
				}

				$node = $this->parseLine($line);
				$node['depth'] = strrpos($line, '*') + 1;

				if($node['depth'] == $lastDepth) {
					$node['parentIndex'] = $nodes[$i]['parentIndex'];
				} else if ($node['depth'] == $lastDepth + 1) {
					$node['parentIndex'] = $i;
				} else {
					for($x = $i; $x >= 0; $x--) {
						if($x == 0) {
							$node['parentIndex'] = 0;
							break;
						}
						if($nodes[$x]['depth'] == $node['depth'] - 1) {
							$node['parentIndex'] = $x;
							break;
						}
					}
				}

				if($node['original'] == 'editthispage') {
					$node['href'] = 'editthispage';
					if($node['depth'] == 1) {
						$nodes[0]['editthispage'] = true; // we have to know later if there is editthispage special word used in first level
					}
				} else if($node['original']{0} == '#') {
					if($this->handleMagicWord($node)) {
						$nodes[0]['magicWords'][] = $node['magic'];
						if($node['depth'] == 1) {
							$nodes[0]['magicWord'] = true; // we have to know later if there is any magic word used if first level
						}
					} else {
						continue;
					}
				}

				$nodes[$i+1] = $node;
				$nodes[$node['parentIndex']]['children'][] = $i+1;
				$lastDepth = $node['depth'];
				$i++;
			}
		}
		return $nodes;
	}

	public function parseLine($line) {
		$lineTmp = explode('|', trim($line, '* '), 2);
		$lineTmp[0] = trim($lineTmp[0], '[]'); // for external links defined as [http://www.wikia.com] instead of just http://www.wikia.com

		if(count($lineTmp) == 2 && $lineTmp[1] != '') {
			$link = trim(wfMsgForContent($lineTmp[0]));
			$line = trim($lineTmp[1]);
		} else {
			$link = trim($lineTmp[0]);
			$line = trim($lineTmp[0]);
		}

		if(wfEmptyMsg($line, $text = wfMsg($line))) {
			$text = $line;
		}

		if(wfEmptyMsg($lineTmp[0], $link)) {
			$link = $lineTmp[0];
		}

		if(preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link )) {
			$href = $link;
		} else {
			if(empty($link)) {
				$href = '#';
			} else if($link{0} == '#') {
				$href = '#';
			} else {
				$title = Title::newFromText($link);
				if(is_object($title)) {
					$href = $title->fixSpecialName()->getLocalURL();
				} else {
					$href = '#';
				}
			}
		}

		$ret = array('original' => $lineTmp[0], 'text' => $text);
		$ret['href'] = $href;
		return $ret;
	}

	public function handleMagicWord(&$node) {
		$original_lower = strtolower($node['original']);
		if(in_array($original_lower, array('#voted#', '#popular#', '#visited#', '#newlychanged#', '#topusers#'))) {
			if($node['text']{0} == '#') {
				$node['text'] = wfMsg(trim($node['original'], ' *')); // TODO: That doesn't make sense to me
			}
			$node['magic'] = trim($original_lower, '#');
			return true;
		} else if(substr($original_lower, 1, 8) == 'category') {
			$param = trim(substr($node['original'], 9), '#');
			if(is_numeric($param)) {
				$category = $this->getBiggestCategory($param);
				$name = $category['name'];
			} else {
				$name = substr($param, 1);
			}
			if($name) {
				$node['href'] = Title::makeTitle(NS_CATEGORY, $name)->getLocalURL();
				if($node['text']{0} == '#') {
					$node['text'] = str_replace('_', ' ', $name);
				}
				$node['magic'] = 'category'.$name;
				return true;
			}
		}
		return false;
	}

	private $biggestCategories;

	public function getBiggestCategory($index) {
		global $wgMemc, $wgBiggestCategoriesBlacklist;
		$limit = max($index, 15);
		if($limit > count($this->biggestCategories)) {
			$key = wfMemcKey('biggest', $limit);
			$data = $wgMemc->get($key);
			if(empty($data)) {
				$filterWordsA = array();
				foreach($wgBiggestCategoriesBlacklist as $word) {
					$filterWordsA[] = '(cl_to not like "%'.$word.'%")';
				}
				$dbr =& wfGetDB( DB_SLAVE );
				$tables = array("categorylinks");
				$fields = array("cl_to, COUNT(*) AS cnt");
				$where = count($filterWordsA) > 0 ? array(implode(' AND ', $filterWordsA)) : array();
				$options = array("ORDER BY" => "cnt DESC", "GROUP BY" => "cl_to", "LIMIT" => $limit);
				$res = $dbr->select($tables, $fields, $where, __METHOD__, $options);
				$categories = array();
				while ($row = $dbr->fetchObject($res)) {
					$this->biggestCategories[] = array('name' => $row->cl_to, 'count' => $row->cnt);
				}
				$wgMemc->set($key, $this->biggestCategories, 60 * 60 * 24 * 7);
			} else {
				$this->biggestCategories = $data;
			}
		}
		return isset($this->biggestCategories[$index-1]) ? $this->biggestCategories[$index-1] : null;
	}

}
############################## MonacoSidebar ##############################

$wgAdCalled = array();

require_once dirname(__FILE__) . "/../extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";
require_once dirname(__FILE__) . "/../extensions/wikia/AdsenseForSearch/AdsenseForSearch.php";

class SkinMonaco extends SkinTemplate {

	/**
	 * Overwrite few SkinTemplate methods which we don't need in Monaco
	 */
	function buildSidebar() {}
	function getCopyrightIcon() {}
	function getPoweredBy() {}
	function disclaimerLink() {}
	function privacyLink() {}
	function aboutLink() {}
	function getHostedBy() {}
	function diggsLink() {}
	function deliciousLink() {}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	public function initPage(&$out) {

		wfDebugLog('monaco', '##### SkinMonaco initPage #####');

		wfProfileIn(__METHOD__);
		global $wgHooks, $wgCityId, $wgCat;

		SkinTemplate::initPage($out);

		$this->skinname  = 'monaco';
		$this->stylename = 'monaco';
		$this->template  = 'MonacoTemplate';

		// Get category information (id, name, url)
		$cats = wfGetBreadCrumb();
		$idx = count($cats)-2;
		if(isset($cats[$idx])) {
			$wgCat = $cats[$idx];
			wfDebugLog('monaco', 'There is category info');
		} else {
			$wgCat = array('id' => -1);
			wfDebugLog('monaco', 'No category info');
		}

		// Function addVariables will be called to populate all needed data to render skin
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array(&$this, 'addVariables');
		wfProfileOut(__METHOD__);
	}

	/**
	 * Add specific styles for this skin
	 *
	 * Don't add common/shared.css as it's kept in allinone.css
	 *
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ){
		$out->addStyle( 'common/commonPrint.css', 'print' );
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	public function addVariables(&$obj, &$tpl) {
		wfProfileIn(__METHOD__);
		global $wgDBname, $wgLang, $wgContLang, $wgMemc, $wgUser, $wgRequest, $wgTitle, $parserMemc;

		// We want to cache populated data only if user language is same with wiki language
		$cache = $wgLang->getCode() == $wgContLang->getCode();

		wfDebugLog('monaco', sprintf('Cache: %s, wgLang: %s, wgContLang %s', (int) $cache, $wgLang->getCode(), $wgContLang->getCode()));

		if($cache) {
			$key = wfMemcKey('MonacoDataOld');
			$data_array = $parserMemc->get($key);
		}

		if(empty($data_array)) {
			wfDebugLog('monaco', 'There is no cached $data_array, let\'s populate');
			wfProfileIn(__METHOD__ . ' - DATA ARRAY');
			$data_array['footerlinks'] = $this->getFooterLinks();
			$data_array['wikiafooterlinks'] = $this->getWikiaFooterLinks();
			$data_array['categorylist'] = $this->getCategoryList();
			$data_array['toolboxlinks'] = $this->getToolboxLinks();
			//$data_array['sidebarmenu'] = $this->getSidebarLinks();
			$data_array['relatedcommunities'] = $this->getRelatedCommunitiesLinks();
			$data_array['magicfooterlinks'] = $this->getMagicFooterLinks();
			wfProfileOut(__METHOD__ . ' - DATA ARRAY');
			if($cache) {
				$parserMemc->set($key, $data_array, 4 * 60 * 60 /* 4 hours */);
			}
		}

		if($wgUser->isLoggedIn()) {
			if(empty($wgUser->mMonacoData) || ($wgTitle->getNamespace() == NS_USER && $wgRequest->getText('action') == 'delete')) {

				wfDebugLog('monaco', 'mMonacoData for user is empty');

				$wgUser->mMonacoData = array();

				wfProfileIn(__METHOD__ . ' - DATA ARRAY');
				/*
				$text = $this->getTransformedArticle('User:'.$wgUser->getName().'/Monaco-sidebar', true);
				if(empty($text)) {
					$wgUser->mMonacoData['sidebarmenu'] = false;
				} else {
					$wgUser->mMonacoData['sidebarmenu'] = $this->parseSidebarMenu($text);
				}
				*/

				$text = $this->getTransformedArticle('User:'.$wgUser->getName().'/Monaco-toolbox', true);
				if(empty($text)) {
					$wgUser->mMonacoData['toolboxlinks'] = false;
				} else {
					$wgUser->mMonacoData['toolboxlinks'] = $this->parseToolboxLinks($text);
				}
				wfProfileOut(__METHOD__ . ' - DATA ARRAY');

				$wgUser->saveToCache();
			}

			/*
			if($wgUser->mMonacoData['sidebarmenu'] !== false && is_array($wgUser->mMonacoData['sidebarmenu'])) {
				wfDebugLog('monaco', 'There is user data for sidebarmenu');
				$data_array['sidebarmenu'] = $wgUser->mMonacoData['sidebarmenu'];
			}
			*/

			if($wgUser->mMonacoData['toolboxlinks'] !== false && is_array($wgUser->mMonacoData['toolboxlinks'])) {
				wfDebugLog('monaco', 'There is user data for toolboxlinks');
				$data_array['toolboxlinks'] = $wgUser->mMonacoData['toolboxlinks'];
			}
		}

		# Used for page load time tracking
		$tpl->data['headlinks'] .= <<<EOS
		<script type="text/javascript">/*<![CDATA[*/
		var wgNow = new Date();
		/*]]>*/</script>
EOS;

		foreach($data_array['toolboxlinks'] as $key => $val) {
			if(isset($val['org']) && $val['org'] == 'whatlinkshere') {
				if(isset($tpl->data['nav_urls']['whatlinkshere'])) {
					$data_array['toolboxlinks'][$key]['href'] = $tpl->data['nav_urls']['whatlinkshere']['href'];
				} else {
					unset($data_array['toolboxlinks'][$key]);
				}
			}
			if(isset($val['org']) && $val['org'] == 'permalink') {
				if(isset($tpl->data['nav_urls']['permalink'])) {
					$data_array['toolboxlinks'][$key]['href'] = $tpl->data['nav_urls']['permalink']['href'];
				} else {
					unset($data_array['toolboxlinks'][$key]);
				}
			}
		}

		/*
		foreach($data_array['sidebarmenu'] as $key => $val) {
			if(isset($val['org']) && $val['org'] == 'editthispage') {
				if(isset($tpl->data['content_actions']['edit'])) {
					$data_array['sidebarmenu'][$key]['href'] = $tpl->data['content_actions']['edit']['href'];
				} else {
					unset($data_array['sidebarmenu'][$key]);
					foreach($data_array['sidebarmenu'] as $key1 => $val1) {
						if(isset($val1['children'])) {
							foreach($val1['children'] as $key2 => $val2) {
								if($key == $val2) {
									unset($data_array['sidebarmenu'][$key1]['children'][$key2]);
								}
							}
						}
					}
				}
			}
		}

		if( $wgUser->isAllowed( 'editinterface' ) ) {
			if(isset($data_array['sidebarmenu'])) {
				$monacoSidebarUrl = Title::makeTitle(NS_MEDIAWIKI, 'Monaco-sidebar')->getLocalUrl('action=edit');
				foreach($data_array['sidebarmenu'] as $nodeKey => $nodeVal) {
					if(empty($nodeVal['magic']) && isset($nodeVal['children']) && isset($nodeVal['depth']) && $nodeVal['depth'] === 1) {
						$data_array['sidebarmenu'][$nodeKey]['children'][] = $this->lastExtraIndex;
						$data_array['sidebarmenu'][$this->lastExtraIndex] = array(
							'text' => wfMsg('monaco-edit-this-menu'),
							'href' => $monacoSidebarUrl,
							'class' => 'Monaco-sidebar_edit'
						);
					}
				}
			}
		}
		*/

		// This is for WidgetRelatedCommunities
		$this->relatedcommunities = $data_array['relatedcommunities'];
		unset($data_array['relatedcommunities']);

		$tpl->set('data', $data_array);

		// This is for WidgetLanguages
		$this->language_urls = $tpl->data['language_urls'];

		// JS and CSS references
		$tpl->set('references', $this->getReferencesLinks($tpl));

		// Article content links (View, Edit, Delete, Move, etc.)
		$tpl->set('articlelinks', $this->getArticleLinks($tpl));

		// User actions links
		$tpl->set('userlinks', $this->getUserLinks($tpl));

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getFooterLinks() {
		wfProfileIn( __METHOD__ );
		global $wgCat;

		$message_key = 'shared-Monaco-footer-links';
		$nodes = array();

		if(!isset($wgCat['id']) || null == ($lines = getMessageAsArray($message_key.'-'.$wgCat['id']))) {
			wfDebugLog('monaco', $message_key.'-'.$wgCat['id'] . ' - seems to be empty');
			if(null == ($lines = getMessageAsArray($message_key))) {
				wfDebugLog('monaco', $message_key . ' - seems to be empty');
				wfProfileOut( __METHOD__ );
				return $nodes;
			}
		}

		$i = $j = 0;
		foreach($lines as $line) {
			$node = parseItem($line);
			$depth = strrpos($line, '*');
			if($depth === 0) {
				if($j != $i) {
					$i++;
				}
				$nodes[$i] = $node;
			} else if($depth === 1) {
				$nodes[$i]['childs'][] = $node;
			}
			$j++;
		}
		wfProfileOut( __METHOD__ );
		return $nodes;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	 private function getWikiaFooterLinks() {
		wfProfileIn( __METHOD__ );
		global $wgCat;

		$message_key = 'shared-Monaco-footer-wikia-links';
		$nodes = array();

		if(!isset($wgCat['id']) || null == ($lines = getMessageAsArray($message_key.'-'.$wgCat['id']))) {
			wfDebugLog('monaco', $message_key.'-'.$wgCat['id'] . ' - seems to be empty');
			if(null == ($lines = getMessageAsArray($message_key))) {
				wfDebugLog('monaco', $message_key . ' - seems to be empty');
				wfProfileOut( __METHOD__ );
				return $nodes;
			}
		}
		foreach($lines as $line) {
			$depth = strrpos($line, '*');
			if($depth === 0) {
				$nodes[] = parseItem($line);
			}
		}
		wfProfileOut( __METHOD__ );
		return $nodes;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	 private function getCategoryList() {
		wfProfileIn(__METHOD__);
		global $wgCat;
		$cat['text'] = isset($wgCat['name']) ? $wgCat['name'] : '';
		$cat['href'] = isset($wgCat['url']) ? $wgCat['url'] : '';
		$message_key = 'shared-Monaco-category-list';
		$nodes = array();

		if(!isset($wgCat['id']) || null == ($lines = getMessageAsArray($message_key.'-'.$wgCat['id']))) {
			wfDebugLog('monaco', $message_key.'-'.$wgCat['id'] . ' - seems to be empty');
			if(null == ($lines = getMessageAsArray($message_key))) {
				wfDebugLog('monaco', $message_key . ' - seems to be empty');
				wfProfileOut( __METHOD__ );
				return $nodes;
			}
		}

		foreach($lines as $line) {
			$depth = strrpos($line, '*');
			if($depth === 0) {
				$cat = parseItem($line);
			} else if($depth === 1) {
				$nodes[] = parseItem($line);
			}
		}
		wfProfileOut( __METHOD__ );
		return array('nodes' => $nodes, 'cat' => $cat);
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function parseToolboxLinks($lines) {
		$nodes = array();
		if(is_array($lines)) {
			foreach($lines as $line) {
				$item = parseItem(trim($line, ' *'));

				$tracker = $item['org'];
				$tracker = preg_replace('/-url$/', '', $tracker);
				if (empty($tracker)) $tracker = $item['href'];
				$tracker = preg_replace('/[^a-z0-9.]/i', '_', $tracker);
				$item['tracker'] = $tracker;

				$nodes[] = $item;
			}
		}
		return $nodes;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getLines($message_key) {
		global $wgCat;

		$revision = Revision::newFromTitle(Title::newFromText($message_key, NS_MEDIAWIKI));
		if(is_object($revision)) {
			if(trim($revision->getText()) != '') {
				$temp = getMessageAsArray($message_key);
				if(count($temp) > 0) {
					wfDebugLog('monaco', sprintf('Get LOCAL %s, which contains %s lines', $message_key, count($temp)));
					$lines = $temp;
				}
			}
		}

		if(empty($lines)) {
			if(isset($wgCat['id'])) {
				$temp = getMessageAsArray('shared-' . $message_key . '-' . $wgCat['id']);
				if(count($temp) > 0) {
					wfDebugLog('monaco', sprintf('Get %s, which contains %s lines', 'shared-' . $message_key . '-' . $wgCat['id'], count($temp)));
					$lines = $temp;
				}
			}
		}

		if(empty($lines)) {
			$lines = getMessageAsArray($message_key);
			wfDebugLog('monaco', sprintf('Get %s, which contains %s lines', $message_key, count($lines)));
		}

		return $lines;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getToolboxLinks() {
		return $this->parseToolboxLinks($this->getLines('Monaco-toolbox'));
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getRelatedCommunitiesLinks() {
		$lines = $this->getLines('Monaco-related-communities');
		$nodes = array();
		if(is_array($lines) && count($lines) > 0) {
			foreach($lines as $line) {
				$depth = strrpos($line, '*');
				if($depth === 0) {
					$nodes[] = parseItem($line);
				}
			}
		}
		return $nodes;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getMagicFooterLinks() {
		global $wgDBname, $wgTitle, $wgExternalSharedDB;
		$results = array();

		$tmpParser = new Parser();
		$tmpParser->setOutputType(OT_HTML);
		$tmpParserOptions = new ParserOptions();

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$res = $dbr->select('magic_footer_links', 'page, links', array('dbname' => $wgDBname));
		while($row = $dbr->fetchObject($res)) {
			$results[$row->page] = $tmpParser->parse($row->links, $wgTitle, $tmpParserOptions, false)->getText();
		}
		$dbr->freeResult($res);

		return $results;
	}

	var $lastExtraIndex = 1000;

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function addExtraItemsToSidebarMenu(&$node, &$nodes) {
		wfProfileIn( __METHOD__ );

		$extraWords = array(
					'#voted#' => array('highest_ratings', 'GetTopVotedArticles'),
					'#popular#' => array('most_popular', 'GetMostPopularArticles'),
					'#visited#' => array('most_visited', 'GetMostVisitedArticles'),
					'#newlychanged#' => array('newly_changed', 'GetNewlyChangedArticles'),
					'#topusers#' => array('community', 'GetTopFiveUsers'));

		if(isset($extraWords[strtolower($node['org'])])) {
			if(substr($node['org'],0,1) == '#') {
				if(strtolower($node['org']) == strtolower($node['text'])) {
					$node['text'] = wfMsg(trim(strtolower($node['org']), ' *'));
				}
				$node['magic'] = true;
			}
			$results = DataProvider::$extraWords[strtolower($node['org'])][1]();
			$results[] = array('url' => Title::makeTitle(NS_SPECIAL, 'Top/'.$extraWords[strtolower($node['org'])][0])->getLocalURL(), 'text' => strtolower(wfMsg('moredotdotdot')), 'class' => 'Monaco-sidebar_more');
			global $wgUser;
			if( $wgUser->isAllowed( 'editinterface' ) ) {
				if(strtolower($node['org']) == '#popular#') {
					$results[] = array('url' => Title::makeTitle(NS_MEDIAWIKI, 'Most popular articles')->getLocalUrl(), 'text' => wfMsg('monaco-edit-this-menu'), 'class' => 'Monaco-sidebar_edit');
				}
			}
			foreach($results as $key => $val) {
				$node['children'][] = $this->lastExtraIndex;
				$nodes[$this->lastExtraIndex]['text'] = $val['text'];
				$nodes[$this->lastExtraIndex]['href'] = $val['url'];
				if(!empty($val['class'])) {
					$nodes[$this->lastExtraIndex]['class'] = $val['class'];
				}
				$this->lastExtraIndex++;
			}
		} else if(strpos(strtolower($node['org']), '#category') === 0) {
			$param = trim(substr($node['org'], 9), '#');
			if(is_numeric($param)) {
				$cat = $this->getBiggestCategory($param);
				$name = $cat['name'];
			} else {
				$name = substr($param, 1);
			}
			$articles = $this->getMostVisitedArticlesForCategory($name);
			if(count($articles) == 0) {
                                $node ['magic'] = true ;
                                $node['href'] = Title::makeTitle(NS_CATEGORY, $name)->getLocalURL();
                                $node ['text'] = $name ;
                                $node['text'] = str_replace('_', ' ', $node['text']);
			} else {
				$node['magic'] = true;
				$node['href'] = Title::makeTitle(NS_CATEGORY, $name)->getLocalURL();
				if(strpos($node['text'], '#') === 0) {
					$node['text'] = str_replace('_', ' ', $name);
				}
				foreach($articles as $key => $val) {
					$title = Title::newFromId($val);
					if(is_object($title)) {
						$node['children'][] = $this->lastExtraIndex;
						$nodes[$this->lastExtraIndex]['text'] = $title->getText();
						$nodes[$this->lastExtraIndex]['href'] = $title->getLocalUrl();
						$this->lastExtraIndex++;
					}
				}
				$node['children'][] = $this->lastExtraIndex;
				$nodes[$this->lastExtraIndex]['text'] = strtolower(wfMsg('moredotdotdot'));
				$nodes[$this->lastExtraIndex]['href'] = $node['href'];
				$nodes[$this->lastExtraIndex]['class'] = 'Monaco-sidebar_more';
				$this->lastExtraIndex++;
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function parseSidebarMenu($lines) {
		wfProfileIn(__METHOD__);
		$nodes = array();
		$nodes[] = array();
		$lastDepth = 0;
		$i = 0;
		if(is_array($lines)) {
			foreach($lines as $line) {
				if (strlen($line) == 0) { # ignore empty lines
					continue;
				}
				$node = parseItem($line);
				$node['depth'] = strrpos($line, '*') + 1;
				if($node['depth'] == $lastDepth) {
					$node['parentIndex'] = $nodes[$i]['parentIndex'];
				} else if ($node['depth'] == $lastDepth + 1) {
					$node['parentIndex'] = $i;
				} else {
					for($x = $i; $x >= 0; $x--) {
						if($x == 0) {
							$node['parentIndex'] = 0;
							break;
						}
						if($nodes[$x]['depth'] == $node['depth'] - 1) {
							$node['parentIndex'] = $x;
							break;
						}
					}
				}
				if(substr($node['org'],0,1) == '#') {
					$this->addExtraItemsToSidebarMenu($node, $nodes);
				}
				$nodes[$i+1] = $node;
				$nodes[$node['parentIndex']]['children'][] = $i+1;
				$lastDepth = $node['depth'];
				$i++;
			}
		}
		wfProfileOut(__METHOD__);
		return $nodes;
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getSidebarLinks() {
		return $this->parseSidebarMenu($this->getLines('Monaco-sidebar'));
	}

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getTransformedArticle($name, $asArray = false) {
		wfProfileIn(__METHOD__);
		global $wgParser, $wgMessageCache;
		$revision = Revision::newFromTitle(Title::newFromText($name));
		if(is_object($revision)) {
			$text = $revision->getText();
			if(!empty($text)) {
				$ret = $wgParser->transformMsg($text, $wgMessageCache->getParserOptions());
				if($asArray) {
					$ret = explode("\n", $ret);
				}
				wfProfileOut(__METHOD__);
				return $ret;
			}
		}
		wfProfileOut(__METHOD__);
		return null;
	}

	var $biggestCategories = array();

	/**
	 * @author Inez Korczynski <inez@wikia.com>
	 * @author Piotr Molski
	 * @return array
	 */
	private function getBiggestCategory($index) {
		wfProfileIn( __METHOD__ );
		global $wgMemc, $wgBiggestCategoriesBlacklist;

		$limit = max($index, 15);

		if($limit > count($this->biggestCategories)) {
			$key = wfMemcKey('biggest', $limit);
			$data = $wgMemc->get($key);
			if(empty($data)) {
				$filterWordsA = array();
				foreach($wgBiggestCategoriesBlacklist as $word) {
					$filterWordsA[] = '(cl_to not like "%'.$word.'%")';
				}
				$dbr =& wfGetDB( DB_SLAVE );
				$tables = array("categorylinks");
				$fields = array("cl_to, COUNT(*) AS cnt");
				$where = count($filterWordsA) > 0 ? array(implode(' AND ', $filterWordsA)) : array();
				$options = array(
					"ORDER BY" => "cnt DESC",
					"GROUP BY" => "cl_to",
					"LIMIT" => $limit);
				$res = $dbr->select($tables, $fields, $where, __METHOD__, $options);
				$categories = array();
				while ($row = $dbr->fetchObject($res)) {
	       			$this->biggestCategories[] = array('name' => $row->cl_to, 'count' => $row->cnt);
				}
				$wgMemc->set($key, $this->biggestCategories, 60 * 60 * 24 * 7);
			} else {
				$this->biggestCategories = $data;
			}
		}
		wfProfileOut( __METHOD__ );
		return isset($this->biggestCategories[$index-1]) ? $this->biggestCategories[$index-1] : null;
	}

	/**
	 * @author Piotr Molski
	 * @author Inez Korczynski <inez@wikia.com>
	 * @return array
	 */
	private function getMostVisitedArticlesForCategory($name, $limit = 7) {
		wfProfileIn(__METHOD__);

		global $wgMemc;
		$key = wfMemcKey('popular-art');
		$data = $wgMemc->get($key);

		if(!empty($data) && isset($data[$name])) {
			wfProfileOut(__METHOD__);
			return $data[$name];
		}

		$dbr =& wfGetDB( DB_SLAVE );
		$query = "SELECT cl_from FROM categorylinks USE INDEX (cl_from), page_visited USE INDEX (page_visited_cnt_inx) WHERE article_id = cl_from AND cl_to = '".addslashes($name)."' ORDER BY COUNT DESC LIMIT $limit";
		$res = $dbr->query($query);
		$result = array();
		while($row = $dbr->fetchObject($res)) {
			$result[] = $row->cl_from;
		}
		if(count($result) < $limit) {
			$query = "SELECT cl_from FROM categorylinks WHERE cl_to = '".addslashes($name)."' ".(count($result) > 0 ? " AND cl_from NOT IN (".implode(',', $result).") " : "")." LIMIT ".($limit - count($result));
			$res = $dbr->query($query);
			while($row = $dbr->fetchObject($res)) {
				$result[] = $row->cl_from;
			}
		}

		if(empty($data) || !is_array($data)) {
			$data = array($data);
		}
		$data[$name] = $result;
		$wgMemc->set($key, $data, 60 * 60 * 3);
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Create arrays containing refereces to JS and CSS files used in skin
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getReferencesLinks(&$tpl) {
		wfProfileIn( __METHOD__ );
		global $wgStylePath, $wgStyleVersion, $wgMergeStyleVersionCSS, $wgExtensionsPath, $wgContLang;
		$js = $css = $cssstyle = $allinoneCSS = array();

		// CSS - begin
		$cssTemp = GetReferences('monaco_css', true);
		foreach($cssTemp as $cssFile) {
			$allinoneCSS[] = array('url' => $wgStylePath.'/'.$cssFile.'?'.$wgMergeStyleVersionCSS);
		}

		if(isset($this->themename)) {
			if($this->themename == 'custom') {
				// ...do nothing - CSS will be added by MW core
			} else if($this->themename == 'sapphire') {
				 // ...do nothing
			} else if($this->themename != '') {
				$css[] = array('url' => $wgStylePath.'/monaco/'.$this->themename.'/css/main.css?'.$wgStyleVersion);
			}
		}

		$css[] = array('url' => $wgStylePath.'/monaco/css/monaco_ltie7.css?'.$wgStyleVersion, 'cond' => 'if lt IE 7');
		$css[] = array('url' => $wgStylePath.'/monaco/css/monaco_ie7.css?'.$wgStyleVersion, 'cond' => 'if IE 7');
		$css[] = array('url' => $wgStylePath.'/monaco/css/monaco_ie8.css?'.$wgStyleVersion, 'cond' => 'if IE 8');

		$css[] = array('url' => $wgStylePath.'/monaco/css/print.css?'.$wgStyleVersion, 'param' => empty($tpl->data['printable']) ? 'media="print" ' : '');

		// RTL support
		if ($wgContLang->isRTL()) {
			$css[] = array('url' => $wgStylePath.'/monaco/rtl.css?'.$wgStyleVersion);
		}

		// CSS - end

		// CSS style - begin
		if($tpl->data['pagecss']) {
			$cssstyle[] = array('content' => $tpl->data['pagecss']);
		}
		if($tpl->data['usercss']) {
			$cssstyle[] = array('content' => $tpl->data['usercss']);
		}
		// CSS style - end

		// JS - begin
		if($tpl->data['jsvarurl']) {
			if(!isMsgEmpty('Common.js') ||  !isMsgEmpty('Monaco.js')) {
				$js[] = array('url' => $tpl->data['jsvarurl'], 'mime' => 'text/javascript');
			}
		}
		if($tpl->data['userjs']) {
			$js[] = array('url' => $tpl->data['userjs'], 'mime' => 'text/javascript');
		}
		if($tpl->data['userjsprev']) {
			$js[] = array('content' => $tpl->data['userjsprev'], 'mime' => 'text/javascript');
		}
		// JS - end

		wfProfileOut( __METHOD__ );
		return array('js' => $js, 'css' => $css, 'cssstyle' => $cssstyle, 'allinone_css' => $allinoneCSS);
	}

	/**
	 * Create arrays containing articles links (separated arrays for left and right part)
	 * Based on data['content_actions']
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getArticleLinks($tpl) {
		wfProfileIn( __METHOD__ );
		$links = array();

		# @todo: might actually be useful to move this to a global var and handle this in extension files --TOR
		$force_right = array( 'userprofile', 'talk', 'TheoryTab' );

		foreach($tpl->data['content_actions'] as $key => $val) {
			if($key == 'report-problem') {
				// Do nothing
			} else if( strpos($key, 'nstab-') === 0 || in_array($key, $force_right) ) {
				$links['right'][$key] = $val;
			} else {
				$links['left'][$key] = $val;
			}
		}
		wfProfileOut( __METHOD__ );
		return $links;
	}

	/**
	 * This is helper function for getNavigationMenu and it's responsible for support special tags like #TOPVOTED
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function addExtraItemsToNavigationMenu(&$node, &$nodes) {
		wfProfileIn( __METHOD__ );

		$extraWords = array(
					'#voted#' => array('highest_ratings', 'GetTopVotedArticles'),
					'#popular#' => array('most_popular', 'GetMostPopularArticles'),
					'#visited#' => array('most_visited', 'GetMostVisitedArticles'),
					'#newlychanged#' => array('newly_changed', 'GetNewlyChangedArticles'),
					'#topusers#' => array('community', 'GetTopFiveUsers'));

		if(isset($extraWords[strtolower($node['org'])])) {
			if(substr($node['org'],0,1) == '#') {
				if(strtolower($node['org']) == strtolower($node['text'])) {
					$node['text'] = wfMsg(trim(strtolower($node['org']), ' *'));
				}
				$node['magic'] = true;
			}
			$results = DataProvider::$extraWords[strtolower($node['org'])][1]();
			$results[] = array('url' => Title::makeTitle(NS_SPECIAL, 'Top/'.$extraWords[strtolower($node['org'])][0])->getLocalURL(), 'text' => strtolower(wfMsg('moredotdotdot')), 'class' => 'Monaco-sidebar_more');
			global $wgUser;
			if( $wgUser->isAllowed( 'editinterface' ) ) {
				if(strtolower($node['org']) == '#popular#') {
					$results[] = array('url' => Title::makeTitle(NS_MEDIAWIKI, 'Most popular articles')->getLocalUrl(), 'text' => wfMsg('monaco-edit-this-menu'), 'class' => 'Monaco-sidebar_edit');
				}
			}
			foreach($results as $key => $val) {
				$node['children'][] = $this->lastExtraIndex;
				$nodes[$this->lastExtraIndex]['text'] = $val['text'];
				$nodes[$this->lastExtraIndex]['href'] = $val['url'];
				if(!empty($val['class'])) {
					$nodes[$this->lastExtraIndex]['class'] = $val['class'];
				}
				$this->lastExtraIndex++;
			}
		} else if(strpos(strtolower($node['org']), '#category') === 0) {
			$param = trim(substr($node['org'], 9), '#');
			if(is_numeric($param)) {
				$cat = $this->getBiggestCategory($param);
				$name = $cat['name'];
			} else {
				$name = substr($param, 1);
			}
			$articles = $this->getMostVisitedArticlesForCategory($name);
			if(count($articles) == 0) {
				$node = null;
			} else {
				$node['magic'] = true;
				$node['href'] = Title::makeTitle(NS_CATEGORY, $name)->getLocalURL();
				if(strpos($node['text'], '#') === 0) {
					$node['text'] = str_replace('_', ' ', $name);
				}
				foreach($articles as $key => $val) {
					$title = Title::newFromId($val);
					if(is_object($title)) {
						$node['children'][] = $this->lastExtraIndex;
						$nodes[$this->lastExtraIndex]['text'] = $title->getText();
						$nodes[$this->lastExtraIndex]['href'] = $title->getLocalUrl();
						$this->lastExtraIndex++;
					}
				}
				$node['children'][] = $this->lastExtraIndex;
				$nodes[$this->lastExtraIndex]['text'] = strtolower(wfMsg('moredotdotdot'));
				$nodes[$this->lastExtraIndex]['href'] = $node['href'];
				$nodes[$this->lastExtraIndex]['class'] = 'yuimenuitemmore';
				$this->lastExtraIndex++;
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Generate links for user menu - depends on if user is logged in or not
	 *
	 * @return array
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	private function getUserLinks($tpl) {
		wfProfileIn( __METHOD__ );
		global $wgUser, $wgTitle;

		$data = array();

		if(!$wgUser->isLoggedIn()) {

			$data['login'] = array(
				'text' => wfMsg('login'),
				'href' => Skin::makeSpecialUrl( 'Userlogin', 'returnto=' . $wgTitle->getPrefixedURL() )
				);

			$data['register'] = array(
				'text' => wfMsg('nologinlink'),
				'href' => Skin::makeSpecialUrl( 'Userlogin', 'type=signup' )
				);

		} else {

			$data['userpage'] = array(
				'text' => $wgUser->getName(),
				'href' => $tpl->data['personal_urls']['userpage']['href']
				);

			$data['mytalk'] = array(
				'text' => $tpl->data['personal_urls']['mytalk']['text'],
				'href' => $tpl->data['personal_urls']['mytalk']['href']
				);

			$data['watchlist'] = array(
				/*'text' => $tpl->data['personal_urls']['watchlist']['text'],*/
				'text' => wfMsg('prefs-watchlist'),
				'href' => $tpl->data['personal_urls']['watchlist']['href']
				);

			$data['logout'] = array(
				'text' => $tpl->data['personal_urls']['logout']['text'],
				'href' => $tpl->data['personal_urls']['logout']['href']
				);


			$data['more']['userpage'] = array(
				'text' => wfMsg('mypage'),
				'href' => $tpl->data['personal_urls']['userpage']['href']
				);

			if(isset($tpl->data['personal_urls']['userprofile'])) {
				$data['more']['userprofile'] = array(
					'text' => $tpl->data['personal_urls']['userprofile']['text'],
					'href' => $tpl->data['personal_urls']['userprofile']['href']
					);
			}

			$data['more']['mycontris'] = array(
				'text' => wfMsg('mycontris'),
				'href' => $tpl->data['personal_urls']['mycontris']['href']
				);

			$data['more']['widgets'] = array(
				'text' => wfMsg('manage_widgets'),
				'href' => '#'
				);

			$data['more']['preferences'] = array(
				'text' => $tpl->data['personal_urls']['preferences']['text'],
				'href' => $tpl->data['personal_urls']['preferences']['href']
				);

		}

		wfProfileOut( __METHOD__ );
		return $data;
	}
}

class MonacoTemplate extends QuickTemplate {

	private function printMenu($id, $last_count='', $level=0) {
		global $wgUploadPath, $wgArticlePath, $wgCityId;
		$menu_output = "";
		$script_output = "";
		$count = 1;

		$fixed_art_path = str_replace ('$1', "", $wgArticlePath);

		$output = '';
		if(isset($this->navmenu[$id]['children'])) {
			$script_output .= '<script type="text/javascript">/*<![CDATA[*/';
			if ($level) {
				$menu_output .= '<div class="sub-menu widget" id="sub-menu' . $last_count . '" style="display:none" >';
				$script_output .= 'submenu_array["sub-menu' . $last_count . '"] = "' . $last_count . '";';
				$script_output .= '$("navigation_widget").onmouseout = clearMenu;';
				$script_output .= '$("sub-menu' . $last_count . '").onmouseout = clearMenu;if($("sub-menu' . $last_count . '").captureEvents) $("sub-menu' . $last_count .'").captureEvents(Event.MOUSEOUT);';
			}
			$extraAttributes = ' rel="nofollow"';
			foreach($this->navmenu[$id]['children'] as $child) {
				//$mouseover = ' onmouseover="' . ($level ? 'sub_' : '') . 'menuItemAction(\'' .
				($level ? $last_count . '_' : '_') .$count . '\');"';
				//$mouseout = ' onmouseout="clearBackground(\'_' . $count . '\')"';
				$menu_output .='<div class="menu-item" id="' . ($level ? 'sub-' : '') . 'menu-item' . ($level ? $last_count . '_' :'_') .$count . '">';
				$menu_output .= '<a id="' . ($level ? 'a-sub-' : 'a-') . 'menu-item' . ($level ? $last_count . '_' : '_') .$count . '" href="'.(!empty($this->navmenu[$child]['href']) ? htmlspecialchars($this->navmenu[$child]['href']) : '#').'" class="'.(!empty($this->navmenu[$child]['class']) ? htmlspecialchars($this->navmenu[$child]['class']) : '').'"' . $extraAttributes . '>';

				if (($fixed_art_path) == $this->navmenu[$child]['href']) {
					$prevent_blank = '.onclick = YAHOO.util.Event.preventDefault ; ' ;
				} else {
					$prevent_blank = '' ;
				}

				if(!$level) {
					$script_output .= 'menuitem_array["menu-item' . $last_count . '_' .$count .'"]= "' . $last_count . '_' .$count . '";';
/*
					$script_output .= '$("menu-item' . $last_count . '_' .$count .'").onmouseover = menuItemAction;if ($("menu-item' . $last_count . '_' .$count.'").captureEvents) $("menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';
					$script_output .= '$("menu-item' . $last_count . '_' .$count .'").onmouseout = clearBackground;if ($("menu-item' . $last_count . '_' .$count.'").captureEvents) $("menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOUT);';
*/
					$script_output .= '$("a-menu-item' . $last_count . '_' .$count .'").onmouseover = menuItemAction;if ($("a-menu-item' . $last_count . '_' .$count.'").captureEvents) $("a-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';

					$script_output .= '$("a-menu-item' . $last_count . '_' .$count .'").onmouseout = clearBackground;if ($("a-menu-item' . $last_count . '_' .$count.'").captureEvents) $("a-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOUT);';

				}
				else {
					$script_output .= 'submenuitem_array["sub-menu-item' . $last_count . '_'.$count .'"] = "' . $last_count . '_' .$count . '";';
/*
					$script_output .= '$("sub-menu-item' . $last_count . '_' .$count.'").onmouseover = sub_menuItemAction;if ($("sub-menu-item' . $last_count . '_'.$count .'").captureEvents) $("sub-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';
*/
					$script_output .= '$("a-sub-menu-item' . $last_count . '_' .$count.'").onmouseover = sub_menuItemAction;if ($("a-sub-menu-item' . $last_count . '_'.$count .'").captureEvents) $("a-sub-menu-item' . $last_count . '_' .$count.'").captureEvents(Event.MOUSEOVER);';
					if ('' != $prevent_blank) {
						$script_output .= '$("a-sub-menu-item' . $last_count . '_' .$count.'")' . $prevent_blank ;
					}
				}
				$menu_output .= htmlspecialchars($this->navmenu[$child]['text']);
				if ( !empty( $this->navmenu[$child]['children'] ) ) {
					//$menu_output .= '<img src="' . $wgUploadPath . '/common/new/right_arrow.gif?1"
					$menu_output .= '<em>&rsaquo;</em>';
				}
				$menu_output .= '</a>';
				$menu_output .= $this->printMenu($child, $last_count . '_' . $count, $level+1);
				$menu_output .= '</div>';
				$count++;
			}
			if ($level) {
				$menu_output .= '</div>';
			}
			$script_output .= '/*]]>*/</script>';
		}

		if ($menu_output.$script_output!="") {
			$output .= "<div id=\"navigation{$last_count}\">";
			$output .= $menu_output . $script_output;
			$output .= "</div>";
		}
		return $output;
	}


	function execute() {
		wfProfileIn( __METHOD__ );
		global $wgArticle, $wgUser, $wgLogo, $wgStylePath, $wgRequest, $wgTitle, $wgSitename, $wgEnableFAST_HOME2, $wgExtensionsPath, $wgContentNamespaces;
		$skin = $wgUser->getSkin();
		$namespace = $wgTitle->getNamespace();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php $this->text('xhtmldefaultnamespace') ?>" <?php
	foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
		?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
	} ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
<?php		wfProfileIn( __METHOD__ . '-head'); ?>
<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
                <!-- Skin = <?php echo basename(__FILE__) ?> -->
		<?php $this->html('headlinks') ?>

		<title><?php $this->text('pagetitle') ?></title>
		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>
		<style type="text/css">/*<![CDATA[*/
<?php
	/* macbre: #3432 */
	foreach($this->data['references']['allinone_css'] as $css) {
?>
			@import "<?= $css['url'] ?>";
<?php
	}
?>
		/*]]>*/</style>
<?php
	foreach($this->data['references']['css'] as $css) {
?>
		<?= isset($css['cond']) ? '<!--['.$css['cond'].']>' : '' ?><link rel="stylesheet" type="text/css" <?= isset($css['param']) ? $css['param'] : '' ?>href="<?= htmlspecialchars($css['url']) ?>" /><?= isset($css['cond']) ? '<![endif]-->' : '' ?>

<?php
	}
?>
		<noscript><link rel="stylesheet" type="text/css" href="<?= $wgStylePath ?>/monaco/css/noscript.css" /></noscript>
<?php
	foreach($this->data['references']['cssstyle'] as $cssstyle) {
?>
		<style type="text/css"><?= $cssstyle['content'] ?></style>
<?php
	}

	echo "\t\t";
	// Note this one is safe at the top because it's an image call, so it's not blocking like GA or Quantserve
	echo AnalyticsEngine::track('Comscore', AnalyticsEngine::EVENT_PAGEVIEW);
	$this->html('csslinks');

	if($wgRequest->getVal('action') != '' || $namespace == NS_SPECIAL) {
		echo $wgUser->isLoggedIn() ? GetReferences("monaco_loggedin_js") : GetReferences("monaco_non_loggedin_js");
		foreach($this->data['references']['js'] as $script) {
			if (!empty($script['url'])) {
?>
		<script type="<?= $script['mime'] ?>" src="<?= htmlspecialchars($script['url']) ?>"></script>
<?php
			}
			else if (!empty($script['content'])) {
?>
		<script type="<?= $script['mime'] ?>"><?= $script['content'] ?></script>
<?php
			}
		}
		$this->html('headscripts');
	}

?>
	</head>
<?php		wfProfileOut( __METHOD__ . '-head'); ?>
<?php		wfProfileIn( __METHOD__ . '-body'); ?>

<?php
	if (ArticleAdLogic::isMainPage()){
		$isMainpage = ' mainpage';
	} else {
		$isMainpage = null;
	}

	$action = $wgRequest->getVal('action');
	if (in_array($action, array('edit', 'history', 'diff', 'delete', 'protect', 'unprotect'))) {
		$body_css_action = 'action_' . $action;
	} else if (empty($action) || in_array($action, array('view', 'purge'))) {
		$body_css_action = 'action_view';
	} else {
		$body_css_action = '';
	}
?>

	<body<?php if($this->data['body_onload'    ]) { ?> onload="<?php     $this->text('body_onload')     ?>"<?php } ?>
 class="mediawiki <?php $this->text('dir') ?> <?php $this->text('pageclass') ?><?php if(!empty($this->data['printable']) ) { ?> printable<?php } ?><?php if (!$wgUser->isLoggedIn()) { ?> loggedout<?php } ?> color2 wikiaSkinMonaco<?=$isMainpage?> <?= $body_css_action ?>" id="body">
<?php

// Sometimes we need an ad delivered at the very top of the page (like for a skin)
// This sucks to have a blocking call at the top of the page, but they promised
// to only do it if they needed. Only use DART or Google (fast Ad Providers with good infrastructure)
global $wgEnableAdInvisibleTop, $wgEnableAdInvisibleHomeTop, $wgOut;
if (!empty($wgEnableAdInvisibleHomeTop) && ArticleAdLogic::isMainPage()){
	echo '<script src="/extensions/wikia/AdEngine/AdEngine.js"></script>' . "\n";
	echo AdEngine::getInstance()->getAd('HOME_INVISIBLE_TOP');
} else if (!empty($wgEnableAdInvisibleTop) && $wgOut->isArticle() && ArticleAdLogic::isContentPage()){
	echo '<script src="/extensions/wikia/AdEngine/AdEngine.js"></script>' . "\n";
	echo AdEngine::getInstance()->getAd('INVISIBLE_TOP');
}
?>
			<div id="widget_cockpit" class="color1">
				<div id="carousel-prev" class="widget_cockpit_controls">&laquo;</div>
				<div id="carousel-next" class="widget_cockpit_controls"><div id="cockpit1_close"></div>&raquo;</div>
				<div class="carousel-clip-region">
					<ul id="widget_cockpit_list" class="carousel-list clearfix"></ul>
				</div>
			</div>
			<div id="ghost"></div>

<?php
	// this hook allows adding extra HTML just after <body> opening tag
	// append your content to $html variable instead of echoing
	$html = '';
	wfRunHooks('GetHTMLAfterBody', array ($this, &$html));
	echo $html;
?>

		<div style="font-size: 1px; position: absolute;">
			<a href="/wiki/Special:Recentchanges" accesskey="r">Recent changes</a>
			<a href="/wiki/Special:Random" accesskey="x">Random page</a>
		</div>

		<!-- HEADER -->
<?php

// curse like cobranding
$this->printCustomHeader();


wfProfileIn( __METHOD__ . '-header'); ?>
		<div id="wikia_header" class="reset color2">
			<div class="monaco_shrinkwrap">
			<div id="wikiaBranding">
<?php
global $wgLangToCentralMap, $wgContLang;
$central_url = !empty($wgLangToCentralMap[$wgContLang->getCode()]) ? $wgLangToCentralMap[$wgContLang->getCode()] : 'http://www.wikia.com/';
?>
				<div id="wikia_logo"><a rel="nofollow" href="<?= $central_url ?>">Wikia</a></div>

<?php
$categorylist = $this->data['data']['categorylist'];
if(isset($categorylist['nodes']) && count($categorylist['nodes']) > 0 ) {
?>
				<div style="background: #F00; margin: 0 auto; display: inline; padding-right: 20px; position: relative; display: none;">
					<div style="height: 10px; width: 10px; background: #FF0; position: absolute; top: 0; right: 0;"></div>
					GAMING
				</div>

				<div style="position: absolute; left: 50%;">
				<dl id="headerButtonHub" class="headerMenuButton">
					<dt><?= isset($categorylist['cat']['text']) ? $categorylist['cat']['text'] : '' ?></dt><dd>&nbsp;</dd>
				</dl>
				</div>

<?php
}
			wfRunHooks('MonacoAdLink');

			if ($wgUser->isLoggedIn()) {
				echo '<a rel="nofollow" href="http://www.wikia.com/wiki/Special:CreateWiki" id="request_wiki" class="loggedin">'. wfMsg('createwikipagetitle') .'</a>';
			}
?>
			</div>
			<ul id="userData">
<?php

$custom_user_data = "";
if( !wfRunHooks( 'CustomUserData', array( &$this, &$tpl, &$custom_user_data ) ) ){
	wfDebug( __METHOD__ . ": CustomUserData messed up skin!\n" );
}

if( $custom_user_data ) {
	echo $custom_user_data;
} else {
	global $wgUser;
	if ($wgUser->isLoggedIn()) {
	?>
				<li id="header_username"><a href="<?= htmlspecialchars($this->data['userlinks']['userpage']['href']) ?>" <?= $skin->tooltipAndAccesskey('pt-userpage') ?>><?= htmlspecialchars($this->data['userlinks']['userpage']['text']) ?></a></li>
<?php
		if (isset($this->data['userlinks']['myhome'])) {
?>
				<li id="header_myhome"><a href="<?= htmlspecialchars($this->data['userlinks']['myhome']['href']) ?>" rel="nofollow"<?= $skin->tooltipAndAccesskey('pt-myhome') ?>><?= htmlspecialchars($this->data['userlinks']['myhome']['text']) ?></a></li>
<?php
		}
 ?>
				<li id="header_mytalk"><a href="<?= htmlspecialchars($this->data['userlinks']['mytalk']['href']) ?>" <?= $skin->tooltipAndAccesskey('pt-mytalk') ?>><?= htmlspecialchars($this->data['userlinks']['mytalk']['text']) ?></a></li>
				<li id="header_watchlist"><a href="<?= htmlspecialchars($this->data['userlinks']['watchlist']['href']) ?>"  <?= $skin->tooltipAndAccesskey('pt-watchlist') ?>><?= htmlspecialchars($this->data['userlinks']['watchlist']['text']) ?></a></li>
				<li>
					<dl id="headerButtonUser" class="headerMenuButton">
						<dt><?= trim(wfMsg('moredotdotdot'), ' .') ?></dt>
						<dd>&nbsp;</dd>
					</dl>
				</li>
				<li><a rel="nofollow" href="<?= htmlspecialchars($this->data['userlinks']['logout']['href']) ?>"  <?= $skin->tooltipAndAccesskey('pt-logout') ?>><?= htmlspecialchars($this->data['userlinks']['logout']['text']) ?></a></li>
	<?php
	} else {
?>
				<li>
					<a rel="nofollow" href="http://www.wikia.com/wiki/Special:CreateWiki" id="request_wiki"><?=wfMsg('createwikipagetitle')?></a>
				</li>
				<li id="userLogin">
					<a rel="nofollow" class="bigButton" id="login" href="<?= htmlspecialchars($this->data['userlinks']['login']['href']) ?>">
						<big><?= htmlspecialchars($this->data['userlinks']['login']['text']) ?></big>
						<small>&nbsp;</small>
					</a>
				</li>
				<li>
					<a rel="nofollow" class="bigButton" id="register" href="<?= htmlspecialchars($this->data['userlinks']['register']['href']) ?>">
						<big><?= htmlspecialchars($this->data['userlinks']['register']['text']) ?></big>
						<small>&nbsp;</small>
					</a>
				</li>
<?php
	}
}
?>
			</ul>

		</div>
	</div>

	<div class="monaco_shrinkwrap" style="position: absolute; top: 0; z-index: 20">
<?php
	if(!empty($categorylist)) {
?>

			<div id="headerMenuHub" class="headerMenu color1 reset">
				<table cellspacing="0">
				<tr>
					<td>
<?php
		for($i = 0; $i < ceil(count($categorylist['nodes']) / 2); $i++) {
?>
						<a rel="nofollow" href="<?= htmlspecialchars($categorylist['nodes'][$i]['href']) ?>" id="headerMenuHub-<?= $i ?>"><?= $categorylist['nodes'][$i]['text'] ?></a><br />
<?php
		}
?>
					</td>
					<td>
<?php
		for($i = ceil(count($categorylist['nodes']) / 2); $i < count($categorylist['nodes']); $i++) {
?>
						<a rel="nofollow" href="<?= htmlspecialchars($categorylist['nodes'][$i]['href']) ?>" id="headerMenuHub-<?= $i ?>"><?= $categorylist['nodes'][$i]['text'] ?></a><br />
<?php
		}
?>
					</td>
				</tr>
				</table>
<?php
		if($categorylist['cat']['text']) {
?>
				<a rel="nofollow" href="<?= htmlspecialchars($categorylist['cat']['href']) ?>" id="goToHub"><?= wfMsg('seemoredotdotdot') ?></a>
<?php
		}
?>
			</div>
<?php
	}

	if(isset($this->data['userlinks']['more'])) {
?>
			<div id="headerMenuUser" class="headerMenu color1 reset">
					<ul>
<?php
		foreach($this->data['userlinks']['more'] as $itemKey => $itemVal) {
?>
						<li <?= ($itemKey == 'widgets') ? 'id="cockpit1" ' : '' ?>class="yuimenuitem"><a rel="nofollow" href="<?= htmlspecialchars($itemVal['href']) ?>" class="yuimenuitemlabel" <?= $skin->tooltipAndAccesskey('pt-'.$itemKey) ?>><?= htmlspecialchars($itemVal['text']) ?></a></li>
<?php
		}
?>
					</ul>
			</div>
<?php
	}
?>
	</div>
	<div class="monaco_shrinkwrap"><div id="background_accent1"></div></div>
	<div style="position: relative;"><div id="background_accent2"></div></div>

<?php if (wfRunHooks('AlternateNavLinks')): ?>
		<div id="background_strip" class="reset">
			<div class="monaco_shrinkwrap">

			<div id="accent_graphic1"></div>
			<div id="accent_graphic2"></div>
			<div id="wiki_logo" style="background-image: url(<?= $wgLogo ?>);"><a href="<?= htmlspecialchars($this->data['nav_urls']['mainpage']['href'])?>" accesskey="z"><?= $wgSitename ?></a></div>
			<!--[if lt IE 7]>
			<style type="text/css">
				#wiki_logo {
					background-image: none !important;
					filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?= $wgLogo ?>', sizingMethod='image');
				}
			</style>
			<![endif]-->
			</div>
		</div>
<?php endif; ?>
		<!-- /HEADER -->
<?php		wfProfileOut( __METHOD__ . '-header'); ?>

		<!-- PAGE -->
<?php		wfProfileIn( __METHOD__ . '-page'); ?>

	<div class="monaco_shrinkwrap" id="monaco_shrinkwrap_main">
		<div id="wikia_page">
			<?php wfRunHooks('MonacoBeforePageBar'); ?>
			<div id="page_bar" class="reset color1 clearfix">
				<ul id="page_controls">
<?php
if(isset($this->data['articlelinks']['left'])) {
	foreach($this->data['articlelinks']['left'] as $key => $val) {
?>
					<li id="control_<?= $key ?>" class="<?= $val['class'] ?>"><div>&nbsp;</div><a rel="nofollow" id="ca-<?= $key ?>" href="<?= htmlspecialchars($val['href']) ?>" <?= $skin->tooltipAndAccesskey('ca-'.$key) ?>><?= htmlspecialchars(ucfirst($val['text'])) ?></a></li>
<?php
	}
	wfRunHooks( 'MonacoAfterArticleLinks' );
}
?>
				</ul>
				<ul id="page_tabs">
<?php
$showright = true;
if( defined( "NS_BLOG_ARTICLE" ) && $namespace == NS_BLOG_ARTICLE ) {
	$showright = false;
}
global $wgMastheadVisible;
if (!empty($wgMastheadVisible)) {
	$showright = false;
}
if(isset($this->data['articlelinks']['right']) && $showright ) {
	foreach($this->data['articlelinks']['right'] as $key => $val) {
?>
					<li class="<?= $val['class'] ?>"><a href="<?= htmlspecialchars($val['href']) ?>" id="ca-<?= $key ?>" <?= $skin->tooltipAndAccesskey('ca-'.$key) ?> class="<?= $val['class'] ?>"><?= htmlspecialchars(ucfirst($val['text'])) ?></a></li>
<?php
	}
}
?>
				</ul>
			</div>

			<!-- ARTICLE -->
<?php
echo AdEngine::getInstance()->getSetupHtml();
global $wgOut, $wgAdsForceLeaderboards, $wgEnableTandemAds;
$topAdCode = '';
$topAdCodeDisplayed = false;
if ($wgOut->isArticle()){
	if (ArticleAdLogic::isMainPage()){
		$topAdCode .= AdEngine::getInstance()->getPlaceHolderDiv('HOME_TOP_LEADERBOARD');
		if ($wgEnableFAST_HOME2) {
			$topAdCode .= AdEngine::getInstance()->getPlaceHolderDiv('HOME_TOP_RIGHT_BOXAD');
		}
	} else if ( ArticleAdLogic::isContentPage()){

		if (!empty($wgAdsForceLeaderboards)) {
			$topAdCode = AdEngine::getInstance()->getPlaceHolderDiv('TOP_LEADERBOARD');
			if (!empty($wgEnableTandemAds) && ArticleAdLogic::isBoxAdArticle($this->data['bodytext'])) {
				$topAdCode .= AdEngine::getInstance()->getPlaceHolderDiv('TOP_RIGHT_BOXAD', false);
			}
		} else {
			if ( ArticleAdLogic::isStubArticle($this->data['bodytext'])){
				$topAdCode = AdEngine::getInstance()->getPlaceHolderDiv('TOP_LEADERBOARD');
			} else if (ArticleAdLogic::isBoxAdArticle($this->data['bodytext'])) {
				$topAdCode = AdEngine::getInstance()->getPlaceHolderDiv('TOP_RIGHT_BOXAD');
			} else {
				// Long article, but a collision
				$topAdCode = AdEngine::getInstance()->getPlaceHolderDiv('TOP_LEADERBOARD');
			}
		}
	}
}
?>
<?php		wfProfileIn( __METHOD__ . '-article'); ?>
			<div id="article" <?php if($this->data['body_ondblclick']) { ?>ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>>
				<a name="top" id="top"></a>
				<?php
				global $wgSupressSiteNotice;
				if( empty( $wgSupressSiteNotice ) && $this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
				<?php
				global $wgSupressPageTitle;
				if( empty( $wgSupressPageTitle ) ){ ?><h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1><?php } ?>

				<?php
				if ($wgRequest->getVal('action') == 'edit') {
					//echo '<br /><a href="#" id="editTipsLink" onclick="editTips(); return false;">Show Editing Tips</a>';
				}
				?>
				<div id="bodyContent">
					<h3 id="siteSub"><?php $this->msg('tagline') ?></h3>
					<div id="contentSub"><?php $this->html('subtitle') ?></div>
					<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
					<?php if($this->data['newtalk'] ) { ?><div class="usermessage noprint"><?php $this->html('newtalk')  ?></div><?php } ?>
					<?php if(!empty($skin->newuemsg)) { echo $skin->newuemsg; } ?>
					<?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>
					<?php
					// Print out call to top leaderboard or box ad, if it's a main page, or not in the bucket test
					if (ArticleAdLogic::isMainPage() || !$topAdCodeDisplayed){
						echo $topAdCode;
					}
					?>
					<?
					// Adsense for search
					global $wgAFSEnabled;
					if ($wgAFSEnabled && $wgTitle->getLocalURL() == $this->data['searchaction'] && !$wgUser->isLoggedIn() ) {
						renderAdsenseForSearch('w2n8', '2226605464');
					}
					?>

					<!-- start content -->
					<?php
					// Display content
					$this->html('bodytext');

		                        // Display additional ads before categories and footer on long pages
					global $wgEnableAdsPrefooter, $wgDBname;
					if ( !empty( $wgEnableAdsPrefooter ) &&
					$wgOut->isArticle() &&
					ArticleAdLogic::isContentPage() &&
					ArticleAdLogic::isLongArticle($this->data['bodytext'])) {
						echo  '<table style="margin-top: 1em; width: 100%; clear: both"><tr>' .
						'<td style="text-align: center">' .
						AdEngine::getInstance()->getPlaceHolderDiv("PREFOOTER_LEFT_BOXAD", false) .
						'</td><td style="text-align: center">' .
						AdEngine::getInstance()->getPlaceHolderDiv("PREFOOTER_RIGHT_BOXAD", false) .
						"</td></tr>\n</table>";
					}

					// Display categories
					if($this->data['catlinks'])
						$this->html('catlinks');
					?>
					<!-- end content -->
					<?php if($this->data['dataAfterContent']) { $this->html ('dataAfterContent'); } ?>
					<div class="visualClear"></div>
				</div>

				<!--google_ad_section_end-->
				<!--contextual_targeting_end-->

			</div>
			<!-- /ARTICLE -->
			<?php // Check to see if it is a super long article, if so, show bottom left nav skyscraper
			global $wgContLang;
			if ($wgOut->isArticle() &&
			    !$wgContLang->isRTL() && // Since this is in the left nav, not suitable for right-to-left languages
		            !ArticleAdLogic::isMainPage() &&
			     ArticleAdLogic::isContentPage() &&
			     ArticleAdLogic::isSuperLongArticle($this->data['bodytext'])) {
				echo '<div style="position: absolute; height: 600px; width: 160px; margin-top: -600px; left: -190px;">' .
					AdEngine::getInstance()->getPlaceHolderDiv('LEFT_SKYSCRAPER_3', true) .
				     '</div>' . "\n";
			}

		wfProfileOut( __METHOD__ . '-article'); ?>

			<!-- ARTICLE FOOTER -->
<?php		wfProfileIn( __METHOD__ . '-articlefooter'); ?>
<?php
global $wgTitle, $wgOut;
$custom_article_footer = '';
$namespaceType = '';
wfRunHooks( 'CustomArticleFooter', array( &$this, &$tpl, &$custom_article_footer ));
if ($custom_article_footer !== '') {
	echo $custom_article_footer;
} else {
	//default footer
	if ($wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $wgOut->isArticle()) {
		$namespaceType = 'content';
	}
	//talk footer
	elseif ($wgTitle->isTalkPage()) {
		$namespaceType = 'talk';
	}
	//Blog, User_Blog namespaces
	elseif (defined('NS_BLOG_ARTICLE') && defined('NS_BLOG_LISTING') && in_array($namespace, array(NS_BLOG_ARTICLE, NS_BLOG_LISTING))) {
		$namespaceType = 'blog';
	}
	//disable footer on some namespaces
	elseif ($namespace == NS_SPECIAL) {
		$namespaceType = 'none';
	}

	$action = $wgRequest->getVal('action', 'view');
	if ($namespaceType != 'none' && in_array($action, array('view', 'purge'))) {
		$nav_urls = $this->data['nav_urls'];

		$actions = '';
		if (!empty($this->data['content_actions']['history']) || !empty($nav_urls['recentchangeslinked'])) {
			$actions =
								'<ul id="articleFooterActions3" class="actions clearfix">' .
								(!empty($this->data['content_actions']['history']) ? ('
								<li id="fe_history"><a rel="nofollow" id="fe_history_icon" href="' . htmlspecialchars($this->data['content_actions']['history']['href']) . '"><img src="' . $wgStylePath . '/monobook/blank.gif" id="fe_history_img" class="sprite" alt="' . wfMsg('history_short') . '" /></a> <div><a id="fe_history_link" rel="nofollow" href="' . htmlspecialchars($this->data['content_actions']['history']['href']) . '">' . $this->data['content_actions']['history']['text'] . '</a></div></li>') : '') .

								(!empty($nav_urls['recentchangeslinked']) ? ('
								<li id="fe_recent"><a rel="nofollow" id="fe_recent_icon" href="' . htmlspecialchars($nav_urls['recentchangeslinked']['href']) . '"><img src="' . $wgStylePath . '/monobook/blank.gif" id="fe_recent_img" class="sprite" alt="' . wfMsg('recentchangeslinked') . '" /></a> <div><a id="fe_recent_link" rel="nofollow" href="' . htmlspecialchars($nav_urls['recentchangeslinked']['href']) . '">' . wfMsg('recentchangeslinked') . '</a></div></li>') : '') .

								'</ul>';
		}
		if (!empty($nav_urls['permalink']) || !empty($nav_urls['whatlinkshere'])) {
			$actions .=
								'<ul id="articleFooterActions4" class="actions clearfix">' .

								(!empty($nav_urls['permalink']) ? ('
								<li id="fe_permalink"><a rel="nofollow" id="fe_permalink_icon" href="' . htmlspecialchars($nav_urls['permalink']['href']) . '"><img src="' . $wgStylePath . '/monobook/blank.gif" id="fe_permalink_img" class="sprite" alt="' . wfMsg('permalink') . '" /></a> <div><a id="fe_permalink_link" rel="nofollow" href="' . htmlspecialchars($nav_urls['permalink']['href']) . '">' . $nav_urls['permalink']['text'] . '</a></div></li>') : '') .

								(!empty($nav_urls['whatlinkshere']) ? ('
								<li id="fe_whatlinkshere"><a rel="nofollow" id="fe_whatlinkshere_icon" href="' . htmlspecialchars($nav_urls['whatlinkshere']['href']) . '"><img src="' . $wgStylePath . '/monobook/blank.gif" id="fe_whatlinkshere_img" class="sprite" alt="' . wfMsg('whatlinkshere') . '" /></a> <div><a id="fe_whatlinkshere_link" rel="nofollow" href="' . htmlspecialchars($nav_urls['whatlinkshere']['href']) . '">' . wfMsg('whatlinkshere') . '</a></div></li>') : '') . '</ul>';
		}

		global $wgArticle, $wgLang, $wgSitename;
?>
			<div id="articleFooter" class="reset">
				<table cellspacing="0">
					<tr>
						<td class="col1">
							<ul class="actions" id="articleFooterActions">
<?php
		if ($namespaceType == 'talk') {
			$custom_article_footer = '';
			wfRunHooks('AddNewTalkSection', array( &$this, &$tpl, &$custom_article_footer ));
			if ($custom_article_footer != '')
				echo $custom_article_footer;
		} elseif ($namespaceType == 'blog') {
			$href = htmlspecialchars(Title::makeTitle(NS_SPECIAL, 'CreateBlogPage')->getLocalURL());
?>
								<li><a rel="nofollow" id="fe_edit_icon" href="<?= $href ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_edit_img" class="sprite" alt="<?= wfMsg('edit') ?>" /></a> <div><a id="fe_edit_link" rel="nofollow" href="<?= $href ?>"><?= wfMsg('blog-create-next-label') ?></a></div></li>
<?php
		} else {
?>
								<li><a rel="nofollow" id="fe_edit_icon" href="<?= htmlspecialchars($wgTitle->getEditURL()) ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_edit_img" class="sprite" alt="<?= wfMsg('edit') ?>" /></a> <div><?= wfMsg('footer_1', $wgSitename) ?> <a id="fe_edit_link" rel="nofollow" href="<?= htmlspecialchars($wgTitle->getEditURL()) ?>"><?= wfMsg('footer_1.5') ?></a></div></li>
<?php
		}
		$timestamp = $wgArticle->getTimestamp();
		$lastUpdate = $wgLang->date($timestamp);
		$userId = $wgArticle->getUser();
		if($userId > 0) {
			$userText = $wgArticle->getUserText();
			$userPageTitle = Title::makeTitle(NS_USER, $userText);
			$userPageLink = $userPageTitle->getLocalUrl();
			$userPageExists = $userPageTitle->exists();
?>
								<li><?= $userPageExists ? '<a id="fe_user_icon" rel="nofollow" href="'.$userPageLink.'">' : '' ?><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_user_img" class="sprite" alt="<?= wfMsg('userpage') ?>" /><?= $userPageExists ? '</a>' : '' ?> <div><?= wfMsg('footer_5', '<a id="fe_user_link" rel="nofollow" '.($userPageExists ? '' : ' class="new" ').'href="'.$userPageLink.'">'.$userText.'</a>', $lastUpdate) ?></div></li>
<?php
		}
?>
							</ul>
							<?= $namespaceType == 'content' ? $actions : '' ?>
							</div>
						</td>
						<td class="col2">
<?php
		if ($namespaceType != 'content') {
?>
							<?= $actions ?>
<?php
		} else {
?>
							<ul class="actions" id="articleFooterActions2">
								<li><a rel="nofollow" id="fe_random_icon" href="<?= Skin::makeSpecialUrl( 'Randompage' ) ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_random_img" class="sprite" alt="<?= wfMsg('randompage') ?>" /></a> <div><a rel="nofollow" id="fe_random_link" href="<?= Skin::makeSpecialUrl( 'Randompage' ) ?>"><?= wfMsg('footer_6') ?></a></div></li>
<?php
			global $wgProblemReportsEnable;

			if ( !empty($wgProblemReportsEnable) ) {
?>
								<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_report_img" class="sprite" alt="<?= wfMsg('reportproblem') ?>" /> <div><a style="cursor:pointer" id="fe_report_link"><?= wfMsg('reportproblem'); ?></a></div></li>
<?php
			}

			if(!empty($wgNotificationEnableSend)) {
?>
								<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_email_img" class="sprite" alt="email" /> <div><a href="#" id="shareEmail_a"><?= wfMsg('footer_7') ?></a></div></li>
<?php
			}
?>
							</ul>
							<div class="clearfix">
								<strong><?= wfMsg('footer_8') ?>:</strong>
<?php
			$url = htmlspecialchars($wgTitle->getFullURL());
			$title = htmlspecialchars($wgTitle->getText());
?>
								<div id="share">
								<dl id="shareDelicious" class="share">
									<dt>del.icio.us</dt>
									<dd><a rel="nofollow" href="http://del.icio.us/post?v=4&amp;noui&amp;jump=close&amp;url=<?=$url?>&amp;title=<?=$title?>" id="shareDelicious_a"></a></dd>
								</dl>
								<dl id="shareStumble" class="share">
									<dt>StumbleUpon</dt>
									<dd><a rel="nofollow" href="http://www.stumbleupon.com/submit?url=<?=$url?>&amp;title=<?=$title?>" id="shareStumble_a"></a></dd>
								</dl>
								<dl id="shareDigg" class="share">
									<dt>Digg</dt>
									<dd><a rel="nofollow" href="http://digg.com/submit?phase=2&amp;url=<?=$url?>&amp;title=<?=$title?>" id="shareDigg_a"></a></dd>
								</dl>
								<dl id="shareFacebook" class="share">
									<dt>Facebook</dt>
									<dd><a rel="nofollow" href="http://www.facebook.com/share.php?u=<?=$url?>" id="shareFacebook_a"></a></dd>
								</dl>
								</div>
							</div>
							<div class="clearfix">
								<strong><?= wfMsgHtml('rate_it') ?></strong>
<?php
			$FauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $this->data['articleid'], "wkuservote" => true ));
			$oApi = new ApiMain($FauxRequest);
			try { $oApi->execute(); } catch (Exception $e) {};
			$aResult =& $oApi->GetResultData();

			if( !empty( $aResult['query']['wkvoteart'] ) ) {
				if(!empty($aResult['query']['wkvoteart'][$this->data['articleid']]['uservote'])) {
					$voted = true;
				} else {
					$voted = false;
				}
				if (!empty($aResult['query']['wkvoteart'][$this->data['articleid']]['votesavg'])) {
					$rating = $aResult['query']['wkvoteart'][$this->data['articleid']]['votesavg'];
				} else {
					$rating = 0;
				}
			} else {
				$voted = false;
				$rating = 0;
			}

			$hidden_star = $voted ? ' style="display: none;"' : '';
			$ratingPx = round($rating * STAR_RATINGS_WIDTH_MULTIPLIER);
?>
								<div id="star-rating-wrapper">
									<ul id="star-rating" class="star-rating" rel="<?=STAR_RATINGS_WIDTH_MULTIPLIER;?>">
										<li style="width: <?= $ratingPx ?>px;" id="current-rating" class="current-rating"><span><?= $rating ?>/5</span></li>
										<li><a rel="nofollow" class="one-star" id="star1" title="1/5"<?=$hidden_star?>><span>1</span></a></li>
										<li><a rel="nofollow" class="two-stars" id="star2" title="2/5"<?=$hidden_star?>><span>2</span></a></li>
										<li><a rel="nofollow" class="three-stars" id="star3" title="3/5"<?=$hidden_star?>><span>3</span></a></li>
										<li><a rel="nofollow" class="four-stars" id="star4" title="4/5"<?=$hidden_star?>><span>4</span></a></li>
										<li><a rel="nofollow" class="five-stars" id="star5" title="5/5"<?=$hidden_star?>><span>5</span></a></li>
									</ul>
									<span style="<?= ($voted ? '' : 'display: none;') ?>" id="unrateLink"><a rel="nofollow" id="unrate" href="#"><?= wfMsg( 'unrate_it' ) ?></a></span>
								</div>
							</div>
<?php
		}
?>
						</td>
					</tr>
				</table>
			</div>
<?php
	} //end $namespaceType != 'none'
} //end else from CustomArticleFooter hook
?>
			<!-- /ARTICLE FOOTER -->
<?php		wfProfileOut( __METHOD__ . '-articlefooter'); ?>

		</div>
		<!-- /PAGE -->
<?php		wfProfileOut( __METHOD__ . '-page'); ?>

<?php
	if(!($wgRequest->getVal('action') != '' || $namespace == NS_SPECIAL)) {
		echo $wgUser->isLoggedIn() ? GetReferences("monaco_loggedin_js") : GetReferences("monaco_non_loggedin_js");
		foreach($this->data['references']['js'] as $script) {
?>
		<script type="<?= $script['mime'] ?>" src="<?= htmlspecialchars($script['url']) ?>"></script>
<?php
		}
		$this->html('headscripts');
	}
	echo '<script type="text/javascript">for(var i=0;i<wgAfterContentAndJS.length;i++){wgAfterContentAndJS[i]();}</script>' . "\n";

if (array_key_exists("TOP_RIGHT_BOXAD", AdEngine::getInstance()->getPlaceholders())){
	// Reset elements with a "clear:none" to "clear:right" when the box ad is displayed
        // Fixes pages like this: http://en.dcdatabaseproject.com/Fang_Zhifu_(New_Earth)
	echo '<script type="text/javascript">AdEngine.resetCssClear("right");</script>' . "\n";
}

?>
<?php		wfProfileIn( __METHOD__ . '-monacofooter'); ?>
		<div id="monaco_footer" class="reset">

<?php
if ( $wgRequest->getVal('action') != 'edit' ) {
?>
		<div id="spotlight_footer">
		<table>
		<tr>
			<td>
				<?php echo AdEngine::getInstance()->getPlaceHolderDiv('FOOTER_SPOTLIGHT_LEFT'); ?>
			</td>
			<td>
				<?php echo AdEngine::getInstance()->getPlaceHolderDiv('FOOTER_SPOTLIGHT_MIDDLE'); ?>
			</td>
			<td>
				<?php echo AdEngine::getInstance()->getPlaceHolderDiv('FOOTER_SPOTLIGHT_RIGHT'); ?>
			</td>
		</tr>
		</table>
		</div>
<?php
}

	// macbre: BEGIN
	//
	global $wgCityId;

	$GPcities = array(
		490,  // wow
		1657, // ffxi
	);

	$GPmainPage = Title::newMainPage();

	$GPshow = ( in_array($wgCityId, $GPcities) && $GPmainPage->getPrefixedText() == $wgTitle->getPrefixedText() );

	if ( $GPshow ) {
		$GPcontent = '<img src="' . $wgStylePath . '/home/images/gp_media.png" width="128" height="22" alt="GamePro Media" />';
		// on WoW add link to the image
		if ($wgCityId == 490) {
			$GPcontent = '<a href="http://www.idgentertainment.com">' . $GPcontent . '</a>';
		}
	}
	//
	// macbre: END
?>
		<table id="wikia_footer">
<?php
		$footerlinks = $this->data['data']['footerlinks'];
		if((is_array($footerlinks)) && (!empty($footerlinks))) {
            foreach($footerlinks as $key => $val) {
                $links = array();
                if(isset($val['childs'])) {
                    foreach($val['childs'] as $childKey => $childVal){
                        $links[] = '<a href="'.htmlspecialchars($childVal['href']).'">'.$childVal['text'].'</a>';
                    }
?>
                <tr>
                    <th><?= $val['text'] ?></th>
                    <td><?= implode(' | ', $links) ?><?php if ($GPshow && $key == 2) echo '<span style="margin-left:50px">' . $GPcontent . '</span>'; ?></td>
                </tr>
<?php
                }
            }
        }
        if(!empty($this->data['data']['magicfooterlinks']) && isset($this->data['data']['magicfooterlinks'][$wgTitle->getPrefixedText()])) {
?>
                <tr>
                    <th><?= wfMsg('magicfooterlinks') ?></th>
                    <td><?= $this->data['data']['magicfooterlinks'][$wgTitle->getPrefixedText()] ?></td>
                </tr>
<?php
        }


$wikiafooterlinks = $this->data['data']['wikiafooterlinks'];
if(count($wikiafooterlinks) > 0) {
	$wikiafooterlinksA = array();
?>
		<tr>
			<td colspan="2" id="wikia_corporate_footer">
<?php
		foreach($wikiafooterlinks as $key => $val) {
			// Very primitive way to actually have copyright WF variable, not MediaWiki:msg constant.
			// This is only shown when there is copyright data available. It is not shown on special pages for example.
			if ( 'GFDL' == $val['text'] ) {
				if (!empty($this->data['copyright'])) {
					$wikiafooterlinksA[] = $this->data['copyright'];
				}
			} else {
				$wikiafooterlinksA[] = '<a rel="nofollow" href="'.htmlspecialchars($val['href']).'">'.$val['text'].'</a>';
			}
		}
		echo implode(' | ', $wikiafooterlinksA);
?>
			</td>
		</tr>
<?php
}
?>
		</table>
		<?php wfRunHooks('SpecialFooterAfterWikia'); ?>
		</div>
<?php		wfProfileOut( __METHOD__ . '-monacofooter'); ?>
		<!-- WIDGETS -->
<?php		wfProfileIn( __METHOD__ . '-navigation'); ?>
		<div id="widget_sidebar" class="reset widget_sidebar">

			<!-- SEARCH/NAVIGATION -->
<?php
	global $wgSitename;
	$msgSearchLabel = wfMsg('Tooltip-search');
	$searchLabel = wfEmptyMsg('Tooltip-search', $msgSearchLabel) ? (wfMsg('ilsubmit').' '.$wgSitename.'...') : $msgSearchLabel;
?>
			<div class="widget" id="navigation_widget">
				<div id="search_box" class="color1">
					<form action="<?php $this->text('searchaction') ?>" id="searchform">
						<input id="search_field" name="search" type="text" title="<?= htmlspecialchars($searchLabel) ?>" value="" maxlength="200"<?= $skin->tooltipAndAccesskey('search'); ?> />
						<input type="hidden" name="fulltext" value="1" />
						<input type="submit" id="search_button" value="" title="<?= wfMsgHtml('searchbutton') ?>" />
					</form>
					<div id="searchSuggestContainer" class="yui-ac-container"></div>
				</div>
<?php
	$monacoSidebar = new MonacoSidebar();
	if(isset($this->data['content_actions']['edit'])) {
		$monacoSidebar->editUrl = $this->data['content_actions']['edit']['href'];
	}
	echo $monacoSidebar->getCode();

	//BEGIN: create dynamic box
	$dynamicLinksArray = array();
	//Blog, User_Blog namespaces
	if (defined('NS_BLOG_ARTICLE') && defined('NS_BLOG_LISTING') && in_array($namespace, array(NS_BLOG_ARTICLE, NS_BLOG_LISTING))) {
		$dynamicLinksArray[] = array(
			'url' => Title::makeTitle(NS_SPECIAL, 'CreateBlogPage')->getLocalURL(),
			'text' => wfMsg('dynamic-links-write-blog'),
			'id' => 'dynamic-links-write-blog',
			'tracker' => 'CreateBlogPage'
		);
		$dynamicLinksArray[] = array(
			'url' => Title::makeTitle(NS_SPECIAL, 'CreateBlogListingPage')->getLocalURL(),
			'text' => wfMsg('dynamic-links-blog-listing'),
			'id' => 'dynamic-links-blog-listing',
			'tracker' => 'CreateBlogListingPage'
		);
	}
	//all other namespaces
	else {
		$dynamicLinksArray[] = array(
			'url' => Title::makeTitle(NS_SPECIAL, 'CreatePage')->getLocalURL(),
			'text' => wfMsg('dynamic-links-write-article'),
			'id' => 'dynamic-links-write-article',
			'tracker' => 'CreatePage'
		);
		$dynamicLinksArray[] = array(
			'url' => Title::makeTitle(NS_SPECIAL, 'Upload')->getLocalURL(),
			'text' => wfMsg('dynamic-links-add-image'),
			'id' => 'dynamic-links-add-image',
			'tracker' => 'Upload'
		);
	}

	if (count($dynamicLinksArray) > 0) {
?>
	<div id="link_box_dynamic" class="clearfix linkbox_dynamic">
		<ul id="dynamic-links-list">
<?php
	foreach ($dynamicLinksArray as $link) {
		$tracker = " onclick=\"WET.byStr('toolbox/dynamic/{$link['tracker']}')\"";
		echo '
			<li id="' . $link['id'] . '-li"><a rel="nofollow" id="' . $link['id'] . '-icon" href="' . htmlspecialchars($link['url']) . '"' . $tracker . '><img src="' . $wgStylePath  . '/monobook/blank.gif" id="' . $link['id'] . '-img" class="sprite" alt="' . $link['text'] . '" /></a> <div><a id="' . $link['id'] . '-link" rel="nofollow" href="' . htmlspecialchars($link['url']) . '"' . $tracker . '>' . $link['text'] . '</a></div></li>';
	}
?>
		</ul>
	</div>
<?php
	}
	//END: create dynamic box

	//BEGIN: create static box
	$linksArrayL = $linksArrayR = array();
	$linksArray = $this->data['data']['toolboxlinks'];

	//add user specific links
	if(!empty($nav_urls['contributions'])) {
		$linksArray[] = array('href' => $nav_urls['contributions']['href'], 'text' => wfMsg('contributions'), 'tracker' => 'contributions');
	}
	if(!empty($nav_urls['blockip'])) {
		$linksArray[] = array('href' => $nav_urls['blockip']['href'], 'text' => wfMsg('blockip'), 'tracker' => 'blockip');
	}
	if(!empty($nav_urls['emailuser'])) {
		$linksArray[] = array('href' => $nav_urls['emailuser']['href'], 'text' => wfMsg('emailuser'), 'tracker' => 'emailuser');
	}

	if(is_array($linksArray) && count($linksArray) > 0) {
		for ($i = 0, $len = count($linksArray); $i < $len; $i++) {
			$i & 1 ? $linksArrayR[] = $linksArray[$i] : $linksArrayL[] = $linksArray[$i];
		}
	}

	if(count($linksArrayL) > 0 || count($linksArrayR) > 0) {
?>
				<div id="link_box" class="color2 clearfix linkbox_static">
					<table cellspacing="0">
					<tr>
						<td>
							<ul>
<?php
		if(is_array($linksArrayL) && count($linksArrayL) > 0) {
			foreach($linksArrayL as $key => $val) {
				$tracker = !empty($val['tracker']) ? $val['tracker'] : 'unknown';
?>
						<li><a rel="nofollow" href="<?= htmlspecialchars($val['href']) ?>" onclick="WET.byStr('toolbox/<?= $tracker ?>')"><?= htmlspecialchars($val['text']) ?></a></li>
<?php
			}
		}
?>
							</ul>
						</td>
						<td>
							<ul>
<?php
		if(is_array($linksArrayR) && count($linksArrayR) > 0) {
		    foreach($linksArrayR as $key => $val) {
				$tracker = !empty($val['tracker']) ? $val['tracker'] : 'unknown';
?>
						<li><a rel="nofollow" href="<?= htmlspecialchars($val['href']) ?>" onclick="WET.byStr('toolbox/<?= $tracker ?>')"><?= htmlspecialchars($val['text']) ?></a></li>
<?php
			}
		}
?>
							</ul>
						</td>
					</tr>
					</table>
				</div>
<?php
	}
	//END: create static box
?>
			</div>
			<!-- /SEARCH/NAVIGATION -->
<?php		wfProfileOut( __METHOD__ . '-navigation'); ?>

			<?php
				// Logic for skyscrapers defined here: http://staff.wikia-inc.com/wiki/DART_Implementation/Skyscrapers
				global $wgOut;
				echo AdEngine::getInstance()->getPlaceHolderDiv('LEFT_NAVBOX_1', false);
				if ($wgOut->isArticle() ){
					if (ArticleAdLogic::isMainPage()) { //main page
						echo '<div style="text-align: center; margin-bottom: 10px;">'. AdEngine::getInstance()->getPlaceHolderDiv('HOME_LEFT_SKYSCRAPER_1', false) .'</div>';
					} else if ( ArticleAdLogic::isContentPage() &&
							!ArticleAdLogic::isShortArticle($this->data['bodytext'])) { //valid article
						echo '<div style="text-align: center; margin-bottom: 10px;">'. AdEngine::getInstance()->getPlaceHolderDiv('LEFT_SKYSCRAPER_1', false) .'</div>';
					}
				}
			?>

<?php		wfProfileIn( __METHOD__ . '-widgets'); ?>

			<div id="sidebar_1" class="sidebar">
			<?= WidgetFramework::getInstance()->Draw(1) ?>

			<?php
				echo AdEngine::getInstance()->getPlaceHolderDiv('LEFT_SLIMBOX_1', false);
				echo AdEngine::getInstance()->getPlaceHolderDiv('LEFT_NAVBOX_2', false);
				if ($wgOut->isArticle() ){
					if (ArticleAdLogic::isMainPage()) { //main page
						echo '<div style="text-align: center; margin-bottom: 10px;">'. AdEngine::getInstance()->getPlaceHolderDiv('HOME_LEFT_SKYSCRAPER_2', false) .'</div>';
					} else if ( ArticleAdLogic::isContentPage() &&
							!ArticleAdLogic::isShortArticle($this->data['bodytext'])) { //valid article
						echo '<div style="text-align: center; margin-bottom: 10px;">'. AdEngine::getInstance()->getPlaceHolderDiv('LEFT_SKYSCRAPER_2', false) .'</div>';
					}
				}
			?>

			</div>
		</div>
		<!-- /WIDGETS -->
	<!--/div-->
<?php
wfProfileOut( __METHOD__ . '-widgets');

// curse like cobranding
$this->printCustomFooter();
?>

<!-- Begin Analytics -->
<?php
// Note, these were placed above the Ad calls intentionally because ad code screws with analytics
echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
echo AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory());
global $wgCityId;
echo AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));
echo AnalyticsEngine::track('GA_Urchin', 'pagetime', array('fat_monaco'));
?>
<!-- End Analytics -->

<?php
/* Put two "invisible" ad slots here. These are for loading ads that just load javascript,
but it isn't positioned at any particular part of a page, such as a slider or a interstitial */
if ($wgOut->isArticle() && ArticleAdLogic::isContentPage()){
echo AdEngine::getInstance()->getPlaceHolderDiv('INVISIBLE_1', false);
echo AdEngine::getInstance()->getPlaceHolderDiv('INVISIBLE_2', false);
}
?>

<?
echo AdEngine::getInstance()->getDelayedLoadingCode();


echo '</div>';
// Quant serve moved *after* the ads because it depends on Athena/Provider values.
echo AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
$this->html('bottomscripts'); /* JS call to runBodyOnloadHook */
$this->html('reporttime');
wfRunHooks('SpecialFooter');
wfProfileOut( __METHOD__ . '-body');
?>
		<div id="positioned_elements" class="reset"></div>
	</body>
</html>
<?php
		wfProfileOut( __METHOD__ );
	}

	// curse like cobranding
	function printCustomHeader() {}
	function printCustomFooter() {}
}
