<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class SopaNoticeTemplate extends MobileFrontendTemplate {

	public function getHTML() {

		$sopaNotice = $this->data['messages']['mobile-frontend-sopa-notice'];

		$noticeHtml = <<<HTML
			<div class='mwm-message mwm-notice'>
				{$sopaNotice}
				<br/>
				<br/>
			</div>
HTML;
		return $noticeHtml;
	}
}
