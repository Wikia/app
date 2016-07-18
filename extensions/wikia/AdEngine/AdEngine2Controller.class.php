<?php

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public static function getLiftiumOptionsScript() {
		wfProfileIn(__METHOD__);

		global $wgDBname, $wgTitle, $wgLang, $wgDartCustomKeyValues, $wgCityId;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = '/__varnish_liftium/';
		$options['kv_wgDBname'] = $wgDBname;
		if (is_object($wgTitle)){
			$options['kv_article_id'] = $wgTitle->getArticleID();
			$options['kv_wpage'] = $wgTitle->getPartialURL();
		}

		$hub = WikiFactoryHub::getInstance();
		$options['kv_Hub'] = $hub->getCategoryName( $wgCityId );
		$options['kv_skin'] = RequestContext::getMain()->getSkin()->getSkinName();
		$options['kv_user_lang'] = $wgLang->getCode();
		$options['kv_cont_lang'] = $GLOBALS['wgLanguageCode'];
		$options['kv_isMainPage'] = WikiaPageType::isMainPage();
		$options['kv_page_type'] = WikiaPageType::getPageType();
		$options['geoUrl'] = "http://geoiplookup.wikia.com/";
		if (!empty($wgDartCustomKeyValues)) {
			$options['kv_dart'] = $wgDartCustomKeyValues;
		}

		$options['kv_domain'] = $_SERVER['HTTP_HOST'];
		$options['hasMoreCalls'] = true;
		$options['isCalledAfterOnload'] = true;
		$options['maxLoadDelay'] = 6000;

		$js = "LiftiumOptions = " . json_encode($options) . ";\n";

		$out = "\n<!-- Liftium options -->\n";
		$out .= Html::inlineScript( $js )."\n";

		wfProfileOut(__METHOD__);

		return $out;
	}

	/**
	 * Action to display an ad (or not)
	 */
	public function ad() {
		$pageTypes = $this->request->getVal( 'pageTypes' );
		$slotName = $this->request->getVal( 'slotName' );

		$this->response->setValues( [
			'includeLabel' => $this->request->getVal( 'includeLabel' ),
			'onLoad' => $this->request->getVal( 'onLoad' ),
			'addToAdQueue' => $this->request->getVal( 'addToAdQueue', true ),
			'pageTypesJson' => json_encode( $pageTypes ),
			'slotName' => $slotName,
			'slotNameJson' => json_encode( [ $slotName ] ),
			'showAd' => AdEngine2Service::shouldShowAd( $pageTypes ),
			'msg-adengine-advertisement' => wfMessage( 'adengine-advertisement' )->text(),
		] );
	}

	/**
	 * Action to display a recoverable ad product (or not)
	 *
	 * It differs with AdEngine2Controller::ad():
	 * - no .wikia-ad class added to the element
	 */
	public function adEmptyContainer() {
		$pageTypes = $this->request->getVal( 'pageTypes' );
		$slotName = $this->request->getVal( 'slotName' );

		$this->response->setValues( [
			'pageTypesJson' => json_encode( $pageTypes ),
			'slotName' => $slotName,
			'slotNameJson' => json_encode( [ $slotName ] ),
			'showAd' => AdEngine2Service::shouldShowAd( $pageTypes ),
		] );
	}
}
