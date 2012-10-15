<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class OptInTemplate extends MobileFrontendTemplate {

	public function getHTML() {

		$optInHtml = <<<HTML
		 <h1>
					{$this->data['optInMessage']}
				</h1>
				<p>
					{$this->data['explainOptIn']}
				</p>
				<div id='disableButtons'>
				  <form action='{$this->data['formAction']}' method='get'>
					<input name='mobileaction' type='hidden' value='opt_in_cookie' />
					<input name='useformat' type='hidden' value='mobile' />
					<button id='disableButton' type='submit'>{$this->data['yesButton']}</button>
				</form>
				<form action='/' method='get'>
					<button id='backButton' type='submit'>{$this->data['noButton']}</button>
				  </form>
				</div>
HTML;
		return $optInHtml;
	}
}
