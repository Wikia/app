<?php
/**
 * Renders page header (title, subtitle, comments chicklet button, history dropdown, top categories)
 *
 * @author Maciej Brencz
 */

class CampfireHeaderController extends WikiaController {

	var $content_actions;
	
	public function init() {
		$this->isMainPage = null;
		$this->likes = null;
		$this->total = null;
		
		$this->action = null;
		$this->actionImage = null;
		$this->actionName = null;
		
		$skinVars = $this->app->getSkinTemplateObj()->data;
		$this->content_actions = $skinVars['content_actions'];
		$this->displaytitle = $skinVars['displaytitle']; // if true - don't encode HTML
		$this->title = $skinVars['title'];
		$this->subtitle = $skinVars['subtitle'];		
	}

	public static function formatTimestamp($stamp) {

		$diff = time() - strtotime($stamp);

		// show time difference if it's 14 or less days
		if ($diff < 15 * 86400) {
			$ret = wfTimeFormatAgo($stamp);
		}
		else {
			$ret = '';
		}
		return $ret;
	}

	/**
	 * Render default page header (with edit dropdown, history dropdown, ...)
	 *
	 * @param: array $params
	 *    key: showSearchBox (default: false)
	 */
	public function executeIndex($params) {
		global $wgTitle, $wgArticle, $wgOut, $wgUser, $wgContLang, $wgSupressPageTitle, $wgSupressPageSubtitle, $wgSuppressNamespacePrefix, $wgCityId, $wgABTests;
		wfProfileIn(__METHOD__);

		// page namespace
		$ns = $wgTitle->getNamespace();

		// currently used skin
		$skin = $wgUser->getSkin();

		// for not existing pages page header is a bit different
		$this->pageExists = !empty($wgTitle) && $wgTitle->exists();

		// render subpage info
		$this->pageSubject = $skin->subPageSubtitle();

		// render MW subtitle (contains old revision data)
		$this->subtitle = $wgOut->getSubtitle();

		// render redirect info (redirected from)
		if (!empty($wgArticle->mRedirectedFrom)) {
			$this->pageRedirect = trim($this->subtitle, '()');
			$this->subtitle = '';
		}

		// render redirect page (redirect to)
		if ($wgTitle->isRedirect()) {
			$this->pageType = $this->subtitle;
			$this->subtitle = '';
		}

		// if page is rendered using one column layout, show search box as a part of page header
		$this->showSearchBox = isset($params['showSearchBox']) ? $params['showSearchBox'] : false ;

		if (!empty($wgSupressPageTitle)) {
			$this->title = '';
			$this->subtitle = '';
		}

		if (!empty($wgSupressPageSubtitle)) {
			$this->subtitle = '';
		}
		else {
			// render pageType, pageSubject and pageSubtitle as one message
			$subtitle = array_filter(array(
				$this->pageType,
				$this->pageTalkSubject,
				$this->pageSubject,
				$this->pageRedirect,
			));

			$pipe = wfMsg('pipe-separator');
			$this->pageSubtitle = implode(" {$pipe} ", $subtitle);
		}

		wfProfileOut(__METHOD__);
	}

}
