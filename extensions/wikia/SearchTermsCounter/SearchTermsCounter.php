<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgSpecialPages['SearchTermsCounter'] = 'SearchTermsCounter';

class SearchTermsCounter extends SpecialPage {

	public function __construct() {
		global $wgMessageCache;

		parent::__construct('SearchTermsCounter', 'wikifactory');

		$messages = array(
			'searchtermscounter' => 'SearchTermsCounter',
		);

		$wgMessageCache->addMessages($messages);
	}

	public function execute($par) {
		global $wgUser, $wgOut, $wgCityId;

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		$dbr =& wfGetDB(DB_SLAVE);
		$res = $dbr->select(wfSharedTable('search_terms_counter'), 'term, counter', array('city_id' => $wgCityId, 'counter > 2'), '', array('LIMIT' => 100, 'ORDER BY' => 'counter DESC'));
		$wgOut->addHTML('This page lists one hundred of search terms which were called at least three times.<br /><ul>');
		while($row = $dbr->fetchObject($res)) {
			$wgOut->addHTML('<li>'.$row->term.' ('.$row->counter.')</li>');
		}
		$wgOut->addHTML('</ul>');
	}
}
