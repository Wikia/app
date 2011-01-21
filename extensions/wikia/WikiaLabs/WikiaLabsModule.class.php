<?php 

class WikiaLabsModule extends Module {
	public function executeStaff() {
		return array();
	}
	
	public function executeGraduates() {
		$out = WF::build( 'WikiaLabsProject')->getList( array("graduated" => true ) );
		foreach($out as $key => $value) {
			$data = $value->getData();
			$title = Title::newFromURL($data['link']); 
			if(!empty( $title )) { 
				$data['link'] = $title->getFullUrl();
			} else {
				$data['link'] = '#'; 
			}
			
			$out[$key] = $data;
			$out[$key]['name'] = $value->getName();
		}
		
		$this->projects = $out;
	}
}

?>