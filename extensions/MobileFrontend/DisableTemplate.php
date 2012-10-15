<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class DisableTemplate extends MobileFrontendTemplate {

	public function getHTML() {

		$currentURL = str_replace( '&mobileaction=disable_mobile_site', '', $this->data['currentURL'] ); // TODO: $currentURl is unused
		$mobileRedirectFormAction = $this->data['mobileRedirectFormAction'];

		$disableHtml = <<<HTML
		 <h1>
				  {$this->data['areYouSure']}
				</h1>
				<p>
				  {$this->data['explainDisable']}
				</p>
				<div id='disableButtons'>
				<form action='{$mobileRedirectFormAction}' method='get'>
					<input name='to' type='hidden' value='{$this->data['currentURL']}' />
					<input name='expires_in_days' type='hidden' value='3650' />
					<button id='disableButton' type='submit'>{$this->data['disableButton']}</button>
				</form>
				<form action='/' method='get'>
					<button id='backButton' type='submit'>{$this->data['backButton']}</button>
				</form>
				</div>
HTML;
		return $disableHtml;
	}
}
