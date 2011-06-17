<?php

/**
 * This is an example use of SpecialPage controller
 * @author ADi
 *
 */
class ControlCenterSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('ControlCenter');
		parent::__construct('ControlCenter', '', false);
	}

	/**
	 * @brief Displays the main menu for the control center
	 * 
	 */
	public function index() {
		global $wgRequest;
		$this->response->setVal('tab', $wgRequest->getVal('tab', 'general'));
	}
	
	/**
	 * @brief This returns the HTML output of any SpecialPage::execute function
	 * @details
	 * 	SpecialPage::capturePath will skip SpecialPages which are not "includable" 
	 *	(which is all the interesting ones)  So we need to force it.
	 *  
	 * @requestParam string page the name of the Special page to invoke
	 * @responseParam string output the HTML output of the special page
	 */
	
	public function GetSpecialPage () {

		// Construct title object from request params
		$pageName = $this->request->getVal("page");
		$title = SpecialPage::getTitleFor($pageName);
		
		// Save global variables and initialize context for special page
		global $wgOut, $wgTitle;
		$oldTitle = $wgTitle;
		$oldOut = $wgOut;
		$wgOut = new OutputPage;
		$wgOut->setTitle( $title );
		$wgTitle = $title;
				
		// Construct special page object
		try {
			$sp = new $pageName(); 
		} catch (Exception $e) {
			print_pre("Could not construct special page object");
		}
		if ($sp instanceof SpecialPage) {
			$ret = $sp->execute(false);
		} else {
			print_pre("Object is not a special page.");
		}

		// TODO: check retval of special page call?
		
		$output = $wgOut->getHTML();
		
		// Restore global variables
		$wgTitle = $oldTitle;
		$wgOut = $oldOut;
		
		//print_pre($wgOut->getHTML());
		$this->response->setVal("output", $output);
		
	}

}