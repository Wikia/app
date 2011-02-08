<?php
class TestController extends WikiaController {
    public function init() {
	$this->allowedRequests['jsonOnly'] = array('json');
    }

    /**
     * This method does nothing and is available in json context only
     */
    public function jsonOnly() {
    }
}