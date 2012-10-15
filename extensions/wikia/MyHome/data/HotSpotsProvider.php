<?php

class HotSpotsProvider {

	public static function sort($a, $b) {
		if($a['count'] == $b['count']) {
	        return 0;
	    }
	    return ($a['count'] < $b['count']) ? 1 : -1;
	}

	private function getHot($interval) {
		wfProfileIn(__METHOD__);
		global $wgContentNamespaces;

		// prepare list of namespaces
		$namespaces = array(NS_PROJECT_TALK);
		foreach(array_values($wgContentNamespaces) as $ns) {
			$namespaces[] = $ns;
			$namespaces[] = $ns + 1;
		}

		// we want to exclude main page from results
		$mainpage = Title::newMainPage();

		$dbr = wfGetDB(DB_SLAVE);

		$rc_id = $dbr->selectField('recentchanges', 'rc_id', array('rc_timestamp > date_sub(now(), interval '.$interval.' day)'), __METHOD__);
		if(empty($rc_id)) {
			wfProfileOut(__METHOD__);
			return null;
		}

		$res = $dbr->select(
			'recentchanges',
			'rc_title, count(distinct(rc_user)) as cnt, rc_namespace',
			array(
				'rc_id > '.intval($rc_id),
				'rc_namespace IN ('.implode(',', $namespaces).')'
			),
			__METHOD__,
			array('GROUP BY' => '1,3', 'ORDER BY' => 'cnt DESC, rc_title DESC', 'LIMIT' => 6, 'HAVING' => 'cnt > 1')
		);

		$results = array();
		while($row = $dbr->fetchObject($res)) {
			if($row->rc_namespace == $mainpage->getNamespace() && $row->rc_title == $mainpage->getDBkey()) {
				continue;
			}
			$title = Title::newFromText($row->rc_title, $row->rc_namespace);
			if($title && $title->exists()) {
				$results[] = array('title' => $title->getPrefixedText(), 'url' => $title->getLocalUrl(), 'count' => $row->cnt);
			}
		}

		$results2 = array();
		$res = $dbr->query("select rc1.rc_title, rc2.rc_user_text from recentchanges rc2, recentchanges rc1 where substring_index(rc2.rc_title, '/', 2) = rc1.rc_title and rc1.rc_namespace = 500 and rc2.rc_namespace = 501 and rc1.rc_id >= $rc_id and rc2.rc_id >= $rc_id group by rc2.rc_title");
		while($row = $dbr->fetchObject($res)) {
			if(isset($results2[$row->rc_title])) {
				if(!isset($results2[$row->rc_title][$row->rc_user_text])) {
					$results2[$row->rc_title][$row->rc_user_text] = 1;
				} else {
					$results2[$row->rc_title][$row->rc_user_text]++;
				}
			} else {
				$results2[$row->rc_title] = array();
				$results2[$row->rc_title][$row->rc_user_text] = 1;
			}
		}
		$results3 = array();
		foreach($results2 as $key => $val) {
			$title = Title::newFromText($key, 500 /* NS_BLOG_ARTICLE */);
			if($title && $title->exists() && count($val) > 1) {
				$results3[] = array(
					'title' => end(explode('/', $title->getPrefixedText(), 2)),
					'url' => $title->getLocalUrl(),
					'count' => count($val),
				);
			}
		}

		usort($results3, "HotSpotsProvider::sort");
		$results3 = array_slice($results3, 0, 2);
		$results = array_merge($results, $results3);
		usort($results, "HotSpotsProvider::sort");
		$results = array_slice($results, 0, 5);
		wfProfileOut(__METHOD__);
		return array('interval' => $interval, 'results' => $results);
	}

	public function get() {
		wfProfileIn(__METHOD__);
		$data = $this->getHot(3);
		if(empty($data) || count($data['results']) < 5) {
			$data = $this->getHot(7);
			if(empty($data) || count($data['results']) < 5) {
				$data = $this->getHot(30);
			}
		}

		if(!empty($data) && count($data['results']) == 5) {
			wfProfileOut(__METHOD__);
			return $data;
		}

		global $wgContentNamespaces;

		// prepare list of namespaces
		$namespaces = array(NS_PROJECT_TALK);
		foreach(array_values($wgContentNamespaces) as $ns) {
			$namespaces[] = $ns;
		}

		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->query("SELECT page_title, page_namespace FROM page WHERE page_namespace IN (".implode(',', $namespaces).")ORDER by page_id DESC LIMIT 5");
		$data = array();
		while($row = $dbr->fetchObject($res)) {
			$title = Title::newFromText($row->page_title, $row->page_namespace);
			if($title && $title->exists()) {
				$data[] = array(
					'title' => $title->getPrefixedText(),
					'url' => $title->getLocalUrl()
				);
			}
		}

		if($data && count($data) == 5) {
			wfProfileOut(__METHOD__);
			return $data;
		}

		wfProfileOut(__METHOD__);
	}

}
