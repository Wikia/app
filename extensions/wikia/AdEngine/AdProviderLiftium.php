<?php

class AdProviderLiftium extends AdProviderIframeFiller implements iAdProvider {

	protected static $instance = false;

	private $slotsToCall = array();

	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}

	public function batchCallAllowed(){
		return false;
	}

	public function getBatchCallHtml(){
		return false;
	}

	public function getSetupHtml($params=null){
		static $called = false;

		if ($called) {
			return false;
		}
		$called = true;

		wfProfileIn(__METHOD__);

		global $wgDBname, $wgLang, $wgTitle, $wgLiftiumDevHosts, $wgDevelEnvironment;
		global $wgDartCustomKeyValues, $wgLoadAdDriverOnLiftiumInit;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = '/__varnish_liftium/';
		$options['kv_wgDBname'] = $wgDBname;
                if (is_object($wgTitle)){
                       $options['kv_article_id'] = $wgTitle->getArticleID();
                       $options['kv_wpage'] = $wgTitle->getPartialURL();
		}
		$cat = AdEngine::getCachedCategory();
		$options['kv_Hub'] = $cat['name'];
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
		if (!empty($params)) {
			if (isset($params['isCalledAfterOnload'])) {
				$options['isCalledAfterOnload'] = $params['isCalledAfterOnload'];
			}

			if (isset($params['hasMoreCalls'])) {
				$options['hasMoreCalls'] = $params['hasMoreCalls'];
			}

			if (isset($params['maxLoadDelay'])) {
				$options['maxLoadDelay'] = $params['maxLoadDelay'];
			}
		}

		// LiftiumOptions as json
		$out = '<script type="text/javascript">' . "\n";
		$out .= "LiftiumOptions = " . json_encode($options) . ";\n";
		$out .= '</script>';

		// Call the script
		global $wgDevelEnvironment;
		if (!empty($_GET['liftium_dev_hosts']) || !empty($wgLiftiumDevHosts)){
			$base = "http://nick.dev.liftium.com/";
			$version = '?' . mt_rand();
			$out .= "<script type=\"text/javascript\">var liftium_dev_hosts = 1;</script>";
		} else if ($wgDevelEnvironment){
			$base = "http://liftium.wikia.com/";
			$version = '?' . mt_rand();
		} else {
			$base = "/__varnish_liftium/";
			$version = "";
		}
		
		if ($options['kv_skin'] != 'oasis') {
			foreach (AssetsManager::getInstance()->getGroupCommonURL('liftium_ads_js') as $src) {
				$out .= '<script type="text/javascript" src="'. htmlspecialchars($src) . '"></script>' . "\n";
			}
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderLiftium();
		}
		return self::$instance;
	}

	public function getAd($slotname, $slot, $params = null){
		wfProfileIn(__METHOD__);

		$out = $this->getSetupHtml();
		$out .= '<script type="text/javascript">' . "\n" .
			'LiftiumOptions.placement = "' . $slotname . '";' . "\n" . 
			'LiftiumDART.placement = "' . $slotname . '";' . "\n";
		if ($params['ghostwriter']) {
			$out .= <<<EOT
			var slot = document.getElementById('$slotname');
			ghostwriter(
				slot,
				{
					insertType: "append",
					script: { text: "Liftium.callAd(\"{$slot['size']}\");" },
					done: function() {
						ghostwriter.flushloadhandlers();
					}
				}
			);
EOT;
		}
		else {
			$out .= 'Liftium.callAd("' . $slot['size'] . '");';
		}

		$out .= '</script>' . "\n";

		wfProfileOut(__METHOD__);

		return $out;
	}

	protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot) {
		wfProfileIn(__METHOD__);

		global $wgEnableTandemAds, $wgEnableTandemAds_slave, $wgEnableTandemAds_delay;

                $out = '';
		if (!empty($wgEnableTandemAds) && !empty($wgEnableTandemAds_slave) && in_array($slotname, explode(",", str_replace(" ", "", $wgEnableTandemAds_slave))) && !empty($wgEnableTandemAds_delay)) {
                    // FIXME get rid of c&p
                    $out .= '<script type="text/javascript">' .
                            'function ' . $function_name . '() { ' .
				'if(typeof(AdEngine) != "undefined") { ' .
					'if(AdEngine.hiddenSlotOnShortPage("' . addslashes($slotname) .'")) { return; }' .
				'} ' .
                            'window.setTimeout(\'' .
                            'LiftiumOptions.placement = "' . $slotname . '";' .
                            'Liftium.callInjectedIframeAd("' . addslashes($slot['size']) .
                            '", document.getElementById("' . addslashes($slotname) .'_iframe"))' .
                            '\', ' . $wgEnableTandemAds_delay . ')' .
                            '; }</script>';
		}
                else {
                    $out .= '<script type="text/javascript">' .
                            'function ' . $function_name . '() { ' .
				'if(typeof(AdEngine) != "undefined") { ' .
					'if(AdEngine.hiddenSlotOnShortPage("' . addslashes($slotname) .'")) { return; }' .
				'} ' .
                            'LiftiumOptions.placement = "' . $slotname . '";' . "\n" .
                            'Liftium.callInjectedIframeAd("' . addslashes($slot['size']) .
                            '", document.getElementById("' . addslashes($slotname) .'_iframe")); }</script>';
                }

		wfProfileOut(__METHOD__);

                return $out;
	}

	function getProviderValues($slot) {
		wfProfileIn(__METHOD__);

		global $wgLanguageCode;
		$out = "lang=" . preg_replace("/-.*/", "", $wgLanguageCode);

		global $wgDartCustomKeyValues;
		if (!empty($wgDartCustomKeyValues)) {
			$out .= ";" . $wgDartCustomKeyValues;
		}

		wfProfileOut(__METHOD__);

		return $out;
	}
}
