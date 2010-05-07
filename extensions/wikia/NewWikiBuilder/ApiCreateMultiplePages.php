<?php
/* 
 * API module that allows for multiple pages to be created at once
 *
 */

class ApiCreateMultiplePages extends ApiBase {
	protected $maxpages = 100;

        public function __construct($main, $action) {
                parent :: __construct($main, $action);
        }

	public function execute() {
                $this->getMain()->requestWriteMode();
		
                $params = $this->extractRequestParams();
		if (empty($params['pagelist'])){
                        $this->dieUsageMsg(array('missingparam', 'pagelist'));
		}

		$r = array();

		$pages = explode('|', $params['pagelist']);
		if (count($pages) > $this->maxpages){
			// Let's not go nuts.
			$this->dieUsageMsg(array("invalidparam", "pagelist")); 
		}

		$createType = 'createPage';
                if ($params['type'] == 'answers') {
                        $createType .= $params['type'];
			$pagetexts = explode( '|', $params['pagetext'] );
                }

		$categories = explode('|', $params['category']);
		for ($i = 0; $i< sizeof($pages); $i++){
			$page = $pages[$i];
			if( 'answers' == $params['type'] ) {
				$create = $this->$createType($page, $categories[$i], $pagetexts[$i]);
			} else {
				$create = $this->$createType($page, $categories[$i], $params['pagetext']);
			}

			if (!empty($create)){
				$r['success'][$page] = $create;
			} else {
				$r['failure'][$page] = $page;
			}
		}

		$this->getResult()->addValue(null, "createmultiplepages", $r);
	}

	private function createPage($title, $category = null, $text = null){
		global $wgUser, $wgContLang;

		// Remove trailing question marks
		$title = preg_replace('/\?+$/', '', $title);
	
		$titleObj = Title::newFromText($title);
		if(!$titleObj) {
			// Invalid title
			return false;
		}

		// Hook for external spam checks, etc.
		if ( ! wfRunHooks( 'ApiCreateMultiplePagesBeforeCreation', array( &$this, $titleObj, $category, $text ) ) ) {
			return false;
		}

		// Does the page already exist?
		if ($titleObj->exists()){
			return false;
		}

                // Now let's check whether we're even allowed to do this
                $errors = $titleObj->getUserPermissionsErrors('createpage', $wgUser);
                if(count($errors)) {
                        $this->dieUsageMsg($errors[0]);
		}

		if (!empty($category)){
			$text .= "[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . $category .  "]]";
		}

		$summary = '';

		$articleObj = new Article($titleObj);
		$status = $articleObj->doEdit($text, $summary, EDIT_NEW);
		if ($status->ok == 1){
			return $status->value['revision']->getTitle()->getText();
		} else {
			return false;
		}
	}

	private function createPageAnswers( $page, $category = null, $text = null ) {
		require_once("$IP/extensions/wikia/NewWikiBuilder/PrefilledDefaultQuestion.php");
		$q = new PrefilledDefaultQuestion( $page );
		if ( !is_object( $q ) ) {
			return false;
		}
		$q->categories = $category;

		$res = $q->create( $text );

		return $res;
	}

	public function mustBePosted() { 
		return true;
	}

	public function getAllowedParams() {
		return array (
			'pagelist' => null, 
			'category' => null,
			'pagetext' => null,
			'type' => null,
		);
	}

	public function getParamDescription() {
		return array (
			'pagelist' => 'The titles of the pages to create. Pipe separated',
			'category' => 'Optional category to assign the newly created pages to, can be a parallel list with pagelist, pipe separated',
			'pagetext' => 'Optional text for the newly created pages to',
			'type' => 'Optional wiki type, modyfing behaviour as needed',
		);
	}

	public function getDescription() {
		return array(
			'Module that allows for multiple pages to be created at once'
		);
	}

	protected function getExamples() {
		return array (
			'api.php?action=createmultiplepages&pagelist=Page1|Page2|Page3',
			'api.php?action=createmultiplepages&pagelist=Page1|Page2|Page3&category=categoryname',
		);
	}

        public function getVersion() { return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $'; }

}
