<?php
/**
 * SpecialAutomaticWikiAdoption
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Special page for adoption process
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

class SpecialAutomaticWikiAdoption extends UnlistedSpecialPage {

	//1000 articles - maximum amount of articles for wiki to allow adoption
	const MAX_ARTICLE_COUNT = 1000;
	//10 edits - minimum edits for user to allow adoption
	const MIN_EDIT_COUNT = 10;
	//60 days - delay between consecutive adoption (const can't have operators): (24 * 60 * 60) * 60
	const ADOPTION_DELAY = 5184000;
	//used for memcache as true/false/null causes problems
	const USER_ALLOWED = 1;
	const USER_NOT_ALLOWED = 2;

	/**
	 * ctor
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	function __construct() {
		wfLoadExtensionMessages('AutomaticWikiAdoption');
		parent::__construct('AutomaticWikiAdoption');
	}

	/**
	 * entry point
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	function execute($par) {
		global $wgCityId, $wgOut, $wgExtensionsPath, $wgJsMimeType, $wgStyleVersion, $wgRequest, $wgUser, $wgTitle;
		wfProfileIn(__METHOD__);

		$this->setHeaders();

		$wgOut->addStyle(wfGetSassUrl('extensions/wikia/AutomaticWikiAdoption/css/AutomaticWikiAdoption.scss'));

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AutomaticWikiAdoption/js/AutomaticWikiAdoption.js?{$wgStyleVersion}\"></script>\n");

		if (AutomaticWikiAdoptionHelper::isAllowedToAdopt($wgCityId, $wgUser)) {
			//allowed to adopt
			if ($wgRequest->wasPosted()) {
				//user clicked button to adopt a wiki
				if (AutomaticWikiAdoptionHelper::adoptWiki($wgUser)) {
					$wgOut->addHTML(wfMsgExt('automaticwikiadoption-adoption-successed', array('parseinline')));
				} else {
					$wgOut->addHTML(wfMsgExt('automaticwikiadoption-adoption-failed', array('parseinline')));
				}
			} else {
				//render HTML
				$template = new EasyTemplate(dirname(__FILE__).'/templates');
				$template->set_vars(array(
					'formAction' => $wgTitle->getFullURL(),
				));

				$wgOut->addHTML($template->render('main'));
			}
		} else {
			//not allowed to adopt
			$wgOut->addHTML(wfMsgExt('automaticwikiadoption-not-allowed', array('parseinline')));
		}

		wfProfileOut(__METHOD__);
	}
}