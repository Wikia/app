<?php

/**
 * VideoPageTool
 * @author Garth Webb
 * @author Kenneth Kouot
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class VideoPageToolSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'VideoPageTool', '', false );
	}

	public function init() {
		$this->response->addAsset('videopagetool_js');
		$this->response->addAsset('videopagetool_css');
	}

	/**
	 * VideoPageTool page
	 * on GET, calendar template will render
	 * on POST, form template will render
	 * @requestParam string region (on POST)
	 * @requestParam string section [featured/trending/fan] (on POST)
	 * @responseParam array regions - list of regions
	 */
	public function index() {
		if ( !$this->getUser()->isAllowed( 'videopagetool' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->wg->SupressPageSubtitle = true;

		JSMessages::enqueuePackage( 'VideoToolPage', JSMessages::EXTERNAL );

		// Change the <title> attribute and the <h1> for the page
		$this->getContext()->getOutput()->setPageTitle( wfMessage( 'videopagetool-page-title' )->plain() );

	}


}

