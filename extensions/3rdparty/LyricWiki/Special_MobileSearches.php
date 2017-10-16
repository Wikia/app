<?php
/**
 * Author: Sean Colombo
 * Date: 20110305 - copied from Special:Soapfailures
 *
 * Extends the same SearchFailuresPage defined in Special_SoapFailures.
 *
 * This specifically shows the failed requests that come from the old
 * LyricWiki mobile app. Since that app hasn't been updated in several
 * years, the usage is dropping off. The main difference bewteen this
 * and Special_SoapFailures is that these requests were typed by humans
 * or decent music apps on phones, so the hit rate was really high, that
 * these were good, correct titles, to real songs that we were missing.
 * With the high signal/noise ratio, this let us find new songs very quickly
 * and get them on the site before they were popular, so that we'd be ready
 * when that happened.
 */

if(!defined('MEDIAWIKI')) die();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Mobile Searches',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'description' => 'Info on searches from the LyricWiki Android and iPhone apps',
	'version' => '1.2',
);
$wgExtensionMessagesFiles['SpecialMobileSearches'] = dirname(__FILE__).'/Special_MobileSearches.i18n.php';

require_once($IP . '/includes/SpecialPage.php');
$wgSpecialPages['MobileSearches'] = 'MobileSearches';

class MobileSearches extends SearchFailuresPage{

	public function __construct(){
		parent::__construct('MobileSearches');

		global $wgScriptPath;
		$this->PAGE_URL = "$wgScriptPath/Special:MobileSearches";
		$this->CACHE_KEY_PREFIX = "LW_SOAP_FAILURES_MOBILE";
		$this->TABLE_NAME = "lw_soap_failures_mobile";
		$this->I18N_PREFIX = "mobilesearches";
		$this->API_TYPE = LW_API_TYPE_MOBILE;
	}
}
