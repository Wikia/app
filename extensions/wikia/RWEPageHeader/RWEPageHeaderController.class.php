<?php

class RWEPageHeaderController extends WikiaController {

	public function index() {
		$this->discussTabLink = $this->getDiscussTabLink();
	}

	private function getDiscussTabLink() {
		global $wgEnableDiscussionsNavigation, $wgEnableDiscussions, $wgEnableForumExt;

		if ( !empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions ) && empty( $wgEnableForumExt ) ) {
			return '/d';
		} else {
			return '/wiki/Special:Forum';
		}
	}
}
