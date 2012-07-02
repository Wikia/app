<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class LeaveFeedbackTemplate extends MobileFrontendTemplate {

	public function getHTML() {

		$leaveFeedbackHtml = <<<HTML
		<form action='{$this->data['feedbackPostURL']}' method='post'>
		<input type="hidden" name="edittoken" value="{$this->data['editToken']}"/>
		<div tabindex="-1">
			<div unselectable="on">
				<span unselectable="on"><p>{$this->data['title']}</p></span>
			</div>
			<div>
				<div>
					<div><p><small>{$this->data['notice']}</small>
					</p></div>
					<div><p>{$this->data['subject']}:<br><input type="text" name="subject" maxlength="60" style="width:40%;"></p>
					</div>
					<div><p>{$this->data['message']}:<br><textarea name="message" style="width:40%;" rows="5" cols="60"></textarea></p>
					</div>
				</div>
			</div>
			<div><button onClick="javascript:history.back();" type="button"><span>{$this->data['cancel']}</span></button>
			<input type="submit" value="{$this->data['submit']}"></input>
			</div>
		</div>
		</form>

HTML;
		return $leaveFeedbackHtml;
	}
}
