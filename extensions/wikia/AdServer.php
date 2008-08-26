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

	public static function getInstance() {
		global $wgUser;
		if(self::$instance == false) {
			self::$instance = new AdServer();
		}
		if(($wgUser->getSkin()->getSkinName() != '') && ($wgUser->getSkin()->getSkinName() != self::$instance->skinName)) {
			self::$instance = new AdServer();
		}
		return self::$instance;
	}

	private function loadAdsConfig() {
		global $wgUser, $wgCurse, $wgForceSkin, $wgAdServingType, $wgMemc, $wgRequest;

		$skin = $wgUser->getSkin()->getSkinName();
		if(empty($skin)) { $skin = 'monaco'; }
		$this->skinName = $skin;
		if($skin == 'quartz') { $skin = 'quartzslate'; }
		if(!empty($wgCurse)) { $skin = 'curse'; }
		if(!empty($wgForceSkin)) { $skin = $wgForceSkin; }

		$key = wfMemcKey('Dadlist', $skin, $wgAdServingType);

		if($wgRequest->getVal('action') != 'purge') {
			$this->adsConfig = $wgMemc->get($key);
		}

		if(empty($this->adsConfig) && !is_array($this->adsConfig)) {
			global $wgCityId, $wgSharedDB, $wgDBname, $wgAdServerPath, $wgServer, $wgGoogleAnalyticsID;

			$db =& wfGetDB(DB_SLAVE);
			$this->adsConfig = array();

			$sharedDB = $wgSharedDB;
			if(!isset($wgSharedDB)) { $sharedDB = 'wikicities'; }

			$cityID = $wgCityId;
			if(empty($cityID)) {
				$row = $db->selectRow("`{$sharedDB}`.`city_list`", "city_id", "city_dbname='{$wgDBname}'", 'AdServer::loadAdsConfig');
				$cityID = !empty($row->city_id) ? $row->city_id : 0;
			}

			$res = $db->select(
				"`{$sharedDB}`.`city_ads`",
				array('ad_zone', 'ad_pos', 'ad_keywords', 'domain', 'ad_server'),
				"(city_id={$cityID} OR (city_id=0 AND ((ad_lang=(SELECT SUBSTRING(city_lang,1,2) FROM $sharedDB.city_list WHERE city_id={$cityID}) AND ad_cat=(SELECT ad_cat FROM $sharedDB.city_list WHERE city_id={$cityID})) OR (ad_lang=(SELECT SUBSTRING(city_lang,1,2) FROM $sharedDB.city_list WHERE city_id={$cityID}) AND ad_cat='') OR (ad_lang='' AND ad_cat=(SELECT ad_cat FROM $sharedDB.city_list WHERE city_id={$cityID})) OR (ad_lang='' AND ad_cat='')))) AND city_ads.ad_skin='{$skin}'",
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
						$phpAds_raw = view_raw ("zone:{$row->ad_zone}", 0, '', $source, '0', $phpAds_context, true, array($userType));
						$html = "\n<!-- adserver={$row->ad_server} {$row->ad_pos} {$row->ad_zone} -->\n";
						$html.= $phpAds_raw['html'];
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

		if($this->skinName == 'monaco') {
			if($ad_pos == 'b' && !isset($this->adsConfig[$ad_pos])) {
				$ad_pos = 'bb';
			} else if($ad_pos == 'bb2' && !isset($this->adsConfig[$ad_pos])) {
				$ad_pos = 'bb3';
			} else if($ad_pos == 'bb4' && !isset($this->adsConfig[$ad_pos])) {
				$ad_pos = 'bb5';
			} else if($ad_pos == 'r' && !isset($this->adsConfig[$ad_pos])) {
				$ad_pos = 'bl';
			}
		}

		if(isset($this->adsConfig[$ad_pos]) && !empty($wgShowAds) && !empty($wgUseAdServer)) {
			$ad = $this->adsConfig[$ad_pos];
			if(is_array($ad)) {
				if($ad['server'] == 'L') {
					if($this->skinName == 'monaco' && $wgAdServingType == 1) {
						$this->adsDisplayed[] = array($ad['zone'], $ad_pos);
						return "<!-- adserver={$ad['server']} {$ad_pos} {$ad['zone']} -->".'<div id="adSpace'.(count($this->adsDisplayed) - 1).'"'.(($ad_pos == 'FAST_HOME1' || $ad_pos == 'FAST_HOME2') ? ' class="'.$ad_pos.'"' : '').'>&nbsp;</div>';
					} else {
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
					}
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
