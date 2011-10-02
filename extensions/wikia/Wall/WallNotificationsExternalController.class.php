<?php

class WallNotificationsExternalController extends WikiaController {
	var $helper;
	public function __construct() {
		$this->app = F::app();
	}
	
	public function init() {
		$this->helper = F::build('WallHelper', array());
	}
	
	public function getUpdate() {
		$wn = F::build('WallNotifications', array());
		$this->getUpdateInternal($wn);
		return true;
	}

	public function markAllAsRead() {
		$wn = F::build('WallNotifications', array());
		$wn->markRead( $this->wg->User->getId(), $this->wg->CityId );
		$this->getUpdateInternal($wn);
		return true;
	}
	
	private function getUpdateInternal($wn) {
		$all = $wn->getNotifications( $this->wg->User->getId(), $this->wg->CityId );
		//$this->response->setVal('abc',print_r($all,1));
		//$all = array_slice($all, 0, 5);
		//error_log(print_r($all,1));
		
		//wfRenderModule('WallNotifications')
		$this->response->setVal('html', $this->app->renderView( 'WallNotifications', 'Update', array('notifications'=>$all) ));
		$this->response->setVal('count', $all['unread_count'] );
		
		$this->response->setVal('status', true);
	}

}
