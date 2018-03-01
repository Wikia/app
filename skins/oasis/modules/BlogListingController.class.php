<?php
class BlogListingController extends WikiaController {

	/**
	 * Modify results from Blogs
	 *
	 * Add likes count and render avatar
	 */
	static function getResults(&$results) {
		wfProfileIn(__METHOD__);

		/* @var $wgLang Language */
		global $wgLang;

		foreach($results as &$result) {
			$result['likes'] = false;
			$result['avatar'] = AvatarService::renderAvatar($result['username'], 48);
			$result['userpage'] = AvatarService::getUrl($result['username']);
			$result['date'] = $wgLang->date(wfTimestamp(TS_MW, $result['timestamp']));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Render blog listing
	 *
	 * Output HTML just for Oasis which will be hidden by default
	 */
	static function renderBlogListing(&$html, $posts, $aOptions, $sPager = null) {
		wfProfileIn(__METHOD__);

		// macbre: prevent PHP warnings and try to find the reason of them
		if (!is_array($posts)) {
			$url = wfGetCurrentUrl();
			Wikia::log(__METHOD__, false, "\$posts is not an array - {$url['url']}", true);

			wfProfileOut(__METHOD__);
			return true;
		}

		$additionalClass = '';
		if (!empty($aOptions['class'])) {
			$additionalClass = ' '.$aOptions['class'];
		}

		$seeMoreUrl = (isset($aOptions['seemore']) ? $aOptions['seemore'] : "");
		if ($aOptions['type'] == 'box') {
			$html .= F::app()->getView( 'BlogListing', 'Index', array('posts' => $posts, 'blogListingClass' => "WikiaBlogListingBox module $additionalClass", 'title' => $aOptions['title'], 'seeMoreUrl' => $seeMoreUrl))->render();
		} else {
			$html .= F::app()->getView( 'BlogListing', 'Index', array('posts' => $posts, 'blogListingClass' => "WikiaBlogListing$additionalClass", 'title' => $aOptions['title'], 'pager' => $sPager, 'seeMoreUrl' => $seeMoreUrl))->render();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function executeIndex() {
		//$this->posts = $data['posts'];
	}
}
