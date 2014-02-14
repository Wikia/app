<?php
class WikiaHubsV3SuggestModel extends WikiaModel {
	const ARTICLEURL_MAXLENGTH = 255;
	const REASON_MAXLENGTH = 140;

	public function getSuggestArticleForm() {
		$form = array(
			'class' => 'WikiaHubs',
			'inputs' => array(
				array(
					'class' => 'articleurl',
					'type' => 'text',
					'name' => 'articleurl',
					'isRequired' => true,
					'label' => wfMsg('wikiahubs-suggest-article-what-article'),
					'value' => '',
					'attributes' => array(
						'maxlength' => self::ARTICLEURL_MAXLENGTH
					)
				),
				array(
					'class' => 'reason',
					'type' => 'textarea',
					'name' => 'reason',
					'isRequired' => true,
					'label' => wfMsg('wikiahubs-suggest-article-reason'),
					'value' => '',
					'attributes' => array(
						'maxlength' => self::REASON_MAXLENGTH
					)
				),
				array(
					'class' => 'submit-button',
					'type' => 'custom',
					'output' => '<button class="wikia-button secondary cancel" >'.wfMsg('wikiahubs-button-cancel').'</button>'.
						'<button type="submit" class="wikia-button submit" disabled="disabled" >'.wfMsg('wikiahubs-suggest-article-submit-button').'</button>',
				),
			),
		);

		$form['isInvalid'] = !empty($result) && !empty($msg);
		$form['errorMsg'] = !empty($msg) ? $msg : '';

		return $form;
	}
}
