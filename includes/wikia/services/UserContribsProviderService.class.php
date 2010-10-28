<?php
class UserContribsProviderService extends Service {

	public function get( $limit = 10, User $user = null ) {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgExternalSharedDB;

		if( !($user instanceof User) ) {
			$user = $wgUser;
		}

		$result = array();
		$params = array();
		$params['action'] = 'query';
		$params['list'] = 'usercontribs';
		$params['ucuser'] = $user->getName();
		$params['ucprop'] = 'ids|title|timestamp|flags|comment|wikiamode';
		$params['uclimit'] = $limit;

		$api = new ApiMain(new FauxRequest($params));
		$api->execute();
		$res = &$api->GetResultData();
		$i = -1;
		foreach ($res['query']['usercontribs'] as &$entry) {
			$titleObj = Title::newFromText($entry['title']);
			$result[++$i] = array(
				'url' => $titleObj->getLocalURL(),
				'title' => $titleObj->getText(),
				'timestamp' => $entry['timestamp'],
				'namespace' => $entry['ns'],
				'type' => 'edit',
				'new' => $entry['rev_parent_id'] == 0 ? '1' : '0',
				'diff' => empty($entry['rev_parent_id']) ? '' : $titleObj->getLocalURL('diff=' . $entry['revid'] . '&oldid=' . $entry['rev_parent_id'])
			);

			if (MWNamespace::isTalk($entry['ns']) || in_array($entry['ns'], array(400 /* video */, NS_USER, NS_TEMPLATE, NS_MEDIAWIKI))) {
				$title = $titleObj->getPrefixedText();
				if (defined('ARTICLECOMMENT_PREFIX') && strpos($title, '/') !== false && strpos(end(explode('/', $title)), ARTICLECOMMENT_PREFIX) === 0) {
					$result[$i]['title'] = end(explode(':', reset(explode('/', $title, 2)), 2));
				} else {
					$result[$i]['title'] = $title;
				}
			}

			if (defined('NS_BLOG_ARTICLE_TALK') && $entry['ns'] == NS_BLOG_ARTICLE_TALK) {
				$result[$i]['title'] = wfMsg('myhome-namespace-blog') . ':' . $result[$i]['title'];
			}

			if ($entry['ns'] == NS_FILE) {
				list(, $title) = explode(':', $entry['title'], 2);
				$title = str_replace(' ', '_', $title);
				$tsUnix = wfTimestamp(TS_UNIX, $entry['timestamp']);
				$tsMin = wfTimestamp(TS_MW, $tsUnix - 5);
				$tsMax = wfTimestamp(TS_MW, $tsUnix + 5);

				//get type of file operations
				$dbr = wfGetDB(DB_SLAVE);
				$type = $dbr->selectField(
					array( 'logging' ),
					array( 'log_type' ),
					array( 'log_type' => 'upload', 'log_namespace' => $entry['ns'], 'log_title' => $title, "log_timestamp BETWEEN $tsMin AND $tsMax" ),
					__METHOD__
				);
				if ($type !== false) {
					$result[$i]['type'] = 'upload';
					$result[$i]['diff'] = '';
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $result;
	}
}
