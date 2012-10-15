<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class OptOutTemplate extends MobileFrontendTemplate {

	public function getHTML() {
		$optOutHtml = <<<HTML
		 <h1>
				  {$this->data['optOutMessage']}
				</h1>
				<p>
					{$this->data['explainOptOut']}
				</p>
				<div id='disableButtons'>
				<form action='{$this->data['formAction']}' method='get'>
					<input name='mobileaction' type='hidden' value='opt_out_cookie' />
					<input name='useformat' type='hidden' value='mobile' />
					<button id='disableButton' type='submit'>{$this->data['yesButton']}</button>
				</form>
				<form action='/' method='get'>
					<button id='backButton' type='submit'>{$this->data['noButton']}</button>
				</form>
				</div>
HTML;
		return $optOutHtml;
	}
}
