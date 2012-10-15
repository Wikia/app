<?php
if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'AdServer',
	'author' => 'Inez Korczyński'
);

class AdServer {

	private $adsConfig;

	private $skinName;

	public $adsDisplayed = array();

	protected static $instance = false;

	protected function __construct() {
		$this->loadAdsConfig();
	}

	/**
	 * @static
	 * @return AdServer instance
	 */
	public static function getInstance() {
		if (self::$instance === false) {
			self::$instance = new AdServer();
		}

		// New instance if skin changed
		$skin = RequestContext::getMain()->getSkin()->getSkinName();
		if ($skin != '' && $skin != self::$instance->skinName) {
			self::$instance = new AdServer();
		}

		return self::$instance;
	}

	private function loadAdsConfig() {
		global $wgUser, $wgForceSkin, $wgAdServingType, $wgMemc, $wgRequest;

		$skin = RequestContext::getMain()->getSkin()->getSkinName();
		$this->skinName = $skin;

		if (!empty($wgForceSkin)) {
			$skin = $wgForceSkin;
		}

		$key = wfMemcKey('Dadlist', $skin, $wgAdServingType);

		if ($wgRequest->getVal('action') !== 'purge') {
			$this->adsConfig = $wgMemc->get($key);
		}

		if (empty($this->adsConfig) && !is_array($this->adsConfig)) {
			global $wgCityId, $wgExternalSharedDB, $wgDBname, $wgAdServerPath, $wgServer, $wgGoogleAnalyticsID;

			$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			$this->adsConfig = array();


			$cityID = $wgCityId;
			if(empty($cityID)) {
				$row = $db->selectRow("city_list", "city_id", "city_dbname='{$wgDBname}'", 'AdServer::loadAdsConfig');
				$cityID = !empty($row->city_id) ? $row->city_id : 0;
			}

			$res = $db->select(
				"city_ads",
				array('ad_zone', 'ad_pos', 'ad_keywords', 'domain', 'ad_server'),
				"(city_id={$cityID} OR (city_id=0 AND ((ad_lang=(SELECT SUBSTRING(city_lang,1,2) FROM city_list WHERE city_id={$cityID}) AND ad_cat=(SELECT ad_cat FROM city_list WHERE city_id={$cityID})) OR (ad_lang=(SELECT SUBSTRING(city_lang,1,2) FROM city_list WHERE city_id={$cityID}) AND ad_cat='') OR (ad_lang='' AND ad_cat=(SELECT ad_cat FROM city_list WHERE city_id={$cityID})) OR (ad_lang='' AND ad_cat='')))) AND city_ads.ad_skin='{$skin}'",
				'AdServer::loadAdsConfig',
				array('ORDER BY' => 'city_id, ad_lang, ad_cat')
			);

			while($row = $db->fetchObject($res)) {
				if($row->ad_server == 'L' || $row->ad_server == 'H') {
					$this->adsConfig[$row->ad_pos] = array('zone' => $row->ad_zone, 'server' => $row->ad_server);
				} else {
					$source = '';
					// Don't know yet if it's ok to include phpadsnew just one time or not
					// that same about variables $phpAds_raw, $source and $userType
					if(@include($wgAdServerPath.'phpadsnew.inc.php')) {
						if(!isset($phpAds_context)) { $phpAds_context = array(); }
						$userType = ($wgUser->isLoggedIn()) ? 'USER' : 'VISITOR';
						$html = "\n<!-- adserver={$row->ad_server} {$row->ad_pos} {$row->ad_zone} -->\n";
						$html = str_replace("ADSERVER_KW_PLACEHOLDER", $row->ad_keywords, $html);
						$html = str_replace("ADSERVER_URL_PLACEHOLDER", "$wgServer/wiki/" . wfMsgForContent('mainpage'), $html);
						if($wgGoogleAnalyticsID) {
							$html = str_replace("ADSERVER_ANALYTICSID_PLACEHOLDER", $wgGoogleAnalyticsID, $html);
						}
						//$html = preg_replace("/google_page_url(.*)\;/i", "", $html);
						$this->adsConfig[$row->ad_pos] = $html;
					}
				}
			}

			$wgMemc->set($key, $this->adsConfig, 60 * 30 /* 30 minutes */);
		}
	}

	public function getAd($ad_pos) {
		global $wgAdServingType, $wgShowAds, $wgUseAdServer, $wgUseDARTOnMainPage;

		//$wgUseDARTOnMainPAge = true;

		if(empty($wgUseDARTOnMainPage)) {
			if($ad_pos == 'HOME_TOP_LEADERBOARD') {
				$ad_pos = 'FAST_HOME1';
			}
			if($ad_pos == 'HOME_TOP_RIGHT_BOXAD') {
				$ad_pos = 'FAST_HOME2';
			}
		}

		if(substr($ad_pos,0,4) == 'HOME') {
			$this->adsDisplayed[] = array($ad_pos, AdEngine::getInstance()->getAd($ad_pos));
			return "<!-- {$ad_pos} -->".'<div id="adSpace'.(count($this->adsDisplayed) - 1).'"'.(($ad_pos == 'HOME_TOP_LEADERBOARD' || $ad_pos == 'HOME_TOP_RIGHT_BOXAD') ? ' class="'.$ad_pos.'"' : '').'>&nbsp;</div>';
		}

		if(isset($this->adsConfig[$ad_pos]) && !empty($wgShowAds) && !empty($wgUseAdServer)) {
			$ad = $this->adsConfig[$ad_pos];
			if(is_array($ad)) {
				if($ad['server'] == 'L') {
					return "<!-- adserver={$ad['server']} {$ad_pos} {$ad['zone']} -->
<script type='text/javascript'><!--//<![CDATA[
var m3_u = 'http://wikia-ads.wikia.com/www/delivery/ajs.php';
var m3_r = Math.floor(Math.random()*99999999999);
if(!document.MAX_used) document.MAX_used = ',';
document.write(\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
document.write(\"?zoneid={$ad['zone']}\");
document.write('&amp;cb=' + m3_r);
if (document.MAX_used != ',') document.write(\"&amp;exclude=\" + document.MAX_used);
document.write(\"&amp;loc=\" + escape(window.location));
if(document.referrer) document.write(\"&amp;referer=\" + escape(document.referrer));
if(document.context) document.write(\"&context=\" + escape(document.context));
if(document.mmm_fo) document.write(\"&amp;mmm_fo=1\");
document.write(\"'><\/scr\"+\"ipt>\");
//]]>--></script>";
				} else if($ad['server'] == 'H') {
					return "<!-- adserver={$ad['server']} {$ad_pos} {$ad['zone']} -->
<script type='text/javascript'><!--//<![CDATA[
var m3_u = 'http://d.openx.org/ajs.php';
var m3_r = Math.floor(Math.random()*99999999999);
if(!document.MAX_used) document.MAX_used = ',';
document.write(\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
document.write(\"?zoneid={$ad['zone']}\");
document.write('&amp;cb=' + m3_r);
if(document.MAX_used != ',') document.write(\"&amp;exclude=\" + document.MAX_used);
document.write (\"&amp;loc=\" + escape(window.location));
if(document.referrer) document.write(\"&amp;referer=\" + escape(document.referrer));
if(document.context) document.write(\"&context=\" + escape(document.context));
if(document.mmm_fo) document.write(\"&amp;mmm_fo=1\");
document.write (\"'><\/scr\"+\"ipt>\");
//]]>--></script>";
				}
			} else {
				return $ad;
			}
		}
	}
}
