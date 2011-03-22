<?php

class WikiaLabsModule extends Module {
	var $wgExtensionsPath;

	public function executeStaff() {
		$this->app = WF::build( 'App' );
		$this->user = $this->app->getGlobal('wgUser');

		$out = WF::build( 'WikiaLabsProject')->getList(array( ) );
		$this->projects = $out;
		$this->show = $this->user->isAllowed( 'wikialabsadmin' ) &&  $this->app->getGlobal('wgCityId') == 177;
		return array();
	}

	public function executeGraduates() {

		$this->app = WF::build( 'App' );
		$this->user = $this->app->getGlobal('wgUser');

		$this->show = $this->user->isAllowed( 'wikialabsuser' );

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