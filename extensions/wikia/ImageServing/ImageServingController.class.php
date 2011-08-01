<?php

class ImageServingController extends WikiaController {

	/**
	 * @details Returns an array containing result from Image Serving
	 * 
	 */
	public function index() {
		if(!$this->wg->User->isAllowed('read')) {
			$this->setVal( 'status', 'error' );
			$this->setVal( 'result', 'User is not allowed to read' );
			return true;
		}
		
		$ids = $this->getVal('ids');

		if(!is_array($ids)) {
			$this->setVal( 'status', 'error' );
			$this->setVal( 'result', 'ids list need to be array' );
			return true;
		}
		
		foreach($ids as $key => $val) {
			$ids[$key] = (int) $ids[$key];
		}
		
		$height = (int) $this->getVal('height');
		$width = (int) $this->getVal('width');
		
		$count = (int) $this->getVal('count');
		
		if($height < 1 || $count < 1 || $width < 1) {
			$this->setVal( 'status', 'error' );
			$this->setVal( 'result', 'height, width, count need to be bigest then 0' );
			return true;
		}
		
		$is = new ImageServing($ids, $width, $height);
	
		$this->setVal( 'status', 'ok' );
		$this->setVal( 'result', $is->getImages() );
	}

}