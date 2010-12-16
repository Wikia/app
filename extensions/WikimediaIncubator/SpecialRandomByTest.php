<?php
/**
* Special page to go to a random page in your test wiki
 * @file
 */

class SpecialRandomByTest extends RandomPage
{
	public function __construct() {
		global $wgUser, $wmincPref;
		if(IncubatorTest::isNormalPrefix()) {
			$this->extra[] = 'page_title like "W'.$wgUser->getOption($wmincPref . '-project').'/'.$wgUser->getOption($wmincPref . '-code').'/%%"';
		} elseif($wgUser->getOption($wmincPref . '-project') == 'inc') {
			$this->extra[] = 'page_title not like "W_/%%" OR "W_/%%/%%"';
		}
		parent::__construct( 'RandomByTest' );
	}
}
