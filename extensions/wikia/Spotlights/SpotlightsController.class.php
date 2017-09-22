<?php
class SpotlightsController extends WikiaController {
	public function index() {
		if (SpotlightsHelper::isEnglishWiki()) {
			return false;
		}
	}
}
