<?php

class InsightsController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('Insights', 'insights', true);
	}

	public function index() {}
} 
