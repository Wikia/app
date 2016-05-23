<?php

class CommunityPageSpecialHelpModel {
	public function getData() {
		return [
			'title' => wfMessage( 'communitypage-help-module-title' )->plain(),
			'link' => $this->getHelpPageLink(),
			'linkText' => wfMessage( 'communitypage-help-module-link-text' )->plain()
		];
	}

	private function getHelpPageLink() {
		return Title::newFromText( wfMessage( 'communitypage-help-module-link-page-name' )->plain() )->getFullURL();
	}
}
