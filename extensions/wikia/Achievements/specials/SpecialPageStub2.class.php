<?php

class SpecialPageStub2 extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('Achievements');
		parent::__construct('PageStub2', '' /* no restriction */, true /* listed */);
	}

	function execute($par) {
		wfProfileIn(__METHOD__);

		global $wgOut;

		$this->setHeaders();

		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array('one' => 1, 'two' => 2, 'three' => 3));

		$wgOut->addHTML($template->render('Profile2'));

		wfProfileOut(__METHOD__);
	}
}