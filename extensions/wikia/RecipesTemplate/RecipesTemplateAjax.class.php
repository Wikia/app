<?php

class RecipesTemplateAjax {

	/**
	 * Generate thumbnail for given image
	 */
	static public function makeThumb() {
		global $wgRequest;

		$imageName = $wgRequest->getVal('imageName');
		$thumb = RecipesTemplate::makeThumb($imageName);

		return array('thumb' => $thumb);
	}

	/**
	 * Check whether given page exists
	 */
	static public function pageExists() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$ret = array();

		$formType = $wgRequest->getVal('formType');
		$pageName = $wgRequest->getVal('pageName');

		// format page title using proper recipe template
		$className = "Special{$formType}";

		if (method_exists($className, 'formatPageTitle')) {
			$instance = new $className();
			$pageName = $instance->formatPageTitle($pageName);
		}

		$title = Title::newFromText($pageName);
		$exists = !empty($title) && $title->exists();

		$ret = array(
			'exists' => $exists,
		);

		if ($exists) {
			$ret['msg'] = Xml::openElement('div', array('class' => 'recipes-template-error plainlinks')).
				wfMsgExt('recipes-template-error-title-exists', array('parseinline'), $pageName).
				Xml::closeElement('div');
		}

		RecipesTemplate::log(__METHOD__, "'{$pageName}' - " . ($exists ? 'yes' : 'no'));

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Backend of categories autosuggest
	 */
	static public function suggest() {
		global $wgContLang, $wgRequest;
		wfProfileIn(__METHOD__);

		$limit = 10;
		$query = $wgRequest->getVal('query');

		$ret = array(
			'query' => $query,
			'suggestions' => array(),
		);

		$results = PrefixSearch::titleSearch($query, $limit, array(NS_CATEGORY));

		$prefixLength = strlen($wgContLang->getNsText(NS_CATEGORY)) + 1;

		foreach($results as $result) {
			$ret['suggestions'][] = substr($result, $prefixLength);
		}

		wfProfileOut(__METHOD__);
		return $ret;

	}
}
