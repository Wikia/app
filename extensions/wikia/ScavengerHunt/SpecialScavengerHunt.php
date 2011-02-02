<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class SpecialScavengerHunt extends SpecialPage {
	public function __construct() {
		parent::__construct('ScavengerHunt', 'scavengerhunt');
	}

	public function execute($subpage) {
		global $wgOut, $wgRequest, $wgUser;

		wfProfileIn(__METHOD__);

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('scavengerhunt');

		if ($this->isRestricted() && !$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}

		if ($wgRequest->wasPosted()) {
		}

		$template = new EasyTemplate(dirname(__FILE__) . '/templates');
		$template->set_vars(array(
		));

		$wgOut->addHTML($template->render('form'));
		wfProfileOut(__METHOD__);
	}
}