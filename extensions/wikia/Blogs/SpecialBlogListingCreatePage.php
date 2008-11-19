<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class BlogListingCreatePage extends SpecialPage {

	public function __construct() {
		global $wgExtensionMessagesFiles;

		// initialise messages
		$wgExtensionMessagesFiles['BlogListingCreatePage'] = dirname(__FILE__) . '/Blogs.i18n.php';
		wfLoadExtensionMessages('BlogListingCreatePage');

		parent::__construct( 'BlogListingCreatePage' /*class*/, 'bloglistingcreatepage' /*restriction*/, true);
	}

	public function execute() {
		global $wgOut, $wgUser, $wgRequest;

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'BlogListingCreatePage' );

		$wgOut->setPageTitle( wfMsg('create-blog-listing-title') );

	}

}
