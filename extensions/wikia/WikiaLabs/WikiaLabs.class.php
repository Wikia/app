<?php

class WikiaLabs {
	function __construct() {
		$this->app = WF::build( 'App' );	
		$this->request = $this->app->getGlobal('wgRequest');
	}
	
	function initGetRailModuleList(&$railModuleList) {
		if($this->app->getGlobal('wgTitle')->isSpecial('WikiaLabs')) {
			$railModuleList['1500'] = array('Search', 'Index', null);
			$railModuleList['1400'] = array('WikiaLabs', 'Staff', null);
			$railModuleList['1450'] = array('WikiaLabs', 'Graduates', null);
		}
				
		return true;
	}

	function getProjectModal() {
		$response =  WF::build( 'AjaxResponse' );
		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$oTmpl->set_vars( array() );
		$oTmpl->render("wikialabs-addproject");
		
		$response->addText( $oTmpl->render("wikialabs-addproject") );
		return $response;
	}	
	
	function saveProject() {
		global $wgRequest;
		//TODO: need to refactore remove global
		
		$project = $wgRequest->getArray('project');
		self::validateProjectForm($project);
	}

	public function validateProjectForm($values = array()) {
		//TODO: laod array form fog bugz 
		$areas = array(1,2,3,4,5);
		$status = array(1,2,3,4,5); 
		$projects = array('Project 1', 'Project 2');
		$values['enablewarning'] = isset($values['enablewarning']);
		$values['graduates'] = isset($values['graduates']);
		
		
		//TODO: translate msg
		$mulitvalidator = new WikiaValidatorArray(array(
			'validators'  => array(
				'description' => new WikiaValidatorString(array("min" => 1, "max" => 255)),
				'name' => new WikiaValidatorString(array("min" => 1, "max" => 255)),
				'link' => new WikiaValidatorString(array("min" => 1, "max" => 255)),
				'warning' => new WikiaValidatorString(array("min" => 1, "max" => 255)),
				'status' => new WikiaValidatorInArray(array("allowed" => $status)),
				'area' =>  new WikiaValidatorInArray(array("allowed" => $areas)),
				'project' => new WikiaValidatorInArray(array("allowed" => $projects)),
		)));
		
		var_dump($mulitvalidator->isValid(
			$values
		));
		
		var_dump($mulitvalidator->getErrors());

		exit;
	}
	
	
	public function getUrlImageAjax() {
		global $wgRequest;
		$name = $wgRequest->getVal("name", "");
		
		if(!empty($name)) {
			$file_title = Title::newFromText( $name, NS_FILE );
			$img = wfFindFile( $file_title  );
		}

		$response = new AjaxResponse();
		if(empty($img)) {
			$response->addText(json_encode(array("status" => "error")));
			return $response;
		}

		$response->addText(json_encode(array("status" => "ok",
				"url" => wfReplaceImageServer( $img->getThumbUrl( $img->thumbName( array( 'width' => 150 ) ) ) ),
		)));
		
		return $response;
	}
	
	
}



