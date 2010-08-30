<?php
class BlogListingModule extends Module {

	var $wgTitle;

	var $posts;
	var $blogListingClass;

	/**
	 * Modify results from Blogs
	 *
	 * Add likes count and render avatar
	 */
	static function getResults(&$results) {
		wfProfileIn(__METHOD__);

		global $wgLang;

		// get message for "read more" link
		wfLoadExtensionMessages('Blogs');
		$cutSign = wfMsg('blug-cut-sign');

		foreach($results as &$result) {
			$service = new PageStatsService($result['page']);

			$result['likes'] = $service->getLikesCount();
			$result['avatar'] = AvatarService::renderAvatar($result['username'], 48);
			$result['userpage'] = AvatarService::getUrl($result['username']);
			$result['date'] = $wgLang->date(wfTimestamp(TS_MW, $result['timestamp']));

			// "read more" handling
			if (strpos($result['text'], $cutSign) !== false) {
				$result['readmore'] = true;
			}
		}

		//print_pre($results);

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Render blog listing
	 *
	 * Output HTML just for Oasis which will be hidden by default
	 */
	static function renderBlogListing(&$html, $posts, $aOptions) {
		global $wgTitle;
		wfProfileIn(__METHOD__);

		#print_pre(htmlspecialchars($html));	print_pre($posts);

		if ($aOptions['type'] == 'box') {
			$html .= '</p>';
			$html .= wfRenderPartial('BlogListing', 'Index', array('posts' => $posts, 'blogListingClass' => 'WikiaBlogListingBox', 'wgTitle' => $wgTitle));
		} else {
			$html .= '</p>';
			$html .= wfRenderPartial('BlogListing', 'Index', array('posts' => $posts, 'blogListingClass' => 'WikiaBlogListing', 'wgTitle' => $wgTitle));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function executeIndex() {
		//$this->posts = $data['posts'];
	}
}