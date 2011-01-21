<?php

class WikiaLabs {
	function __construct() {
		$this->app = WF::build( 'App' );	
		$this->request = $this->app->getGlobal('wgRequest');
	}
	
	function onGetRailModuleSpecialPageList(&$railModuleList) {
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
				
		$wikiaLabsProject = WF::build( 'WikiaLabsProject' );

		$oTmpl->set_vars( array( 
			'status' => $wikiaLabsProject->getStatusDict(),
			'extensions' => $wikiaLabsProject->getExtensionsDict()
		));
		
		$oTmpl->render("wikialabs-addproject");
		
		$response->addText( $oTmpl->render("wikialabs-addproject") );
		return $response;
	}	
	
	function saveProject() {
		global $wgRequest;
		//TODO: need to refactore remove global
		
		$response = new AjaxResponse();

		$out = array();
		
		$project = $wgRequest->getArray('project');
		
		$project['enablewarning'] = isset($project['enablewarning']);
		$project['graduates'] = isset($project['graduates']);
		
		$validateResult = self::validateProjectForm($project);
		if( !$validateResult->isValid($project) ) {
			$out['status'] = "error";
			$out['errors'] = array();
			$errors = $validateResult->getErrors();
			foreach($errors as  $val1) {
				foreach($val1 as $val2) {
					$out['errors'][] = $val2; 
				} 	
			}
			$response->addText(json_encode($out));
			return $response;
		} else {
			
			if( isset($project['id']) && isInt($project['id'])) {
				$wlp = WF::build( 'WikiaLabsProject', array($project['id']) );	
			} else {
				$wlp = WF::build( 'WikiaLabsProject', array() );
			}
			
			$wlp->setName($project['name']);
			$wlp->setFogbugzProject($project['area']);
			
			
			if(!empty($project['prjscreen'])) {
				$file_title = Title::newFromText( $project['prjscreen'], NS_FILE );
				$img = wfFindFile( $file_title  );
			}
			
			//TODO: 
			$data = array( 
				'description' => $project['description'],
				'link' => $project['link'],
				'prjscreen' => $project['prjscreen'],
				'prjscreenurl' => wfReplaceImageServer( $img->getThumbUrl( $img->thumbName( array( 'width' => 150 ) ) ) ),
				'warning' =>  $project['warning'],
				'enablewarning' => $project['enablewarning']
			);
			
			$wlp->setData($data);
			$wlp->setGraduated( $project['graduates'] );
			$wlp->setActive($project['status'] == 1); 
			$wlp->setExtension($project['extension']);
			$wlp->update();
			
			$out['status'] = 'ok';
			$response->addText(json_encode($out));
			return $response;
		}
	}

	public function validateProjectForm($values = array()) {
		//TODO: laod array form fog bugz 
		$wikiaLabsProject = WF::build( 'WikiaLabsProject' );
		
		$areas = array(1,2,3,4,5);
		$status = array_keys($wikiaLabsProject->getStatusDict());
		$projects = $wikiaLabsProject->getExtensionsDict();
		
		//TODO: translate msg
		$mulitvalidator = new WikiaValidatorArray(array(
			'validators'  => array(
				'description' => new WikiaValidatorString(array("min" => 1)),
				'name' => new WikiaValidatorString(array("min" => 1)),
				'link' => new WikiaValidatorString(array("min" => 1)),
				'prjscreen' => new WikiaValidatorString(array("min" => 3)),
				'warning' => new WikiaValidatorString(array("min" => 1)),
				'status' => new WikiaValidatorInArray(array("allowed" => $status)),
				'area' =>  new WikiaValidatorInArray(array("allowed" => $areas)),
				'extension' => new WikiaValidatorInArray(array("allowed" => $projects)),
		)));
		
		return $mulitvalidator;
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



