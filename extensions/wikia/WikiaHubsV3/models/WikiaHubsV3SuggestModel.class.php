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
					'label' => wfMessage('wikiahubs-v3-suggest-article-what-article')->escaped(),
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
					'label' => wfMessage('wikiahubs-v3-suggest-article-reason')->escaped(),
					'value' => '',
					'attributes' => array(
						'maxlength' => self::REASON_MAXLENGTH
					)
				),
				array(
					'class' => 'submit-button',
					'type' => 'custom',
					'output' => '<button class="wikia-button secondary cancel" >'.wfMessage('wikiahubs-v3-button-cancel')->escaped().'</button>'.
						'<button type="submit" class="wikia-button submit" disabled="disabled" >'.wfMessage('wikiahubs-v3-suggest-article-submit-button')->escaped().'</button>',
				),
			),
		);

		$form['isInvalid'] = !empty($result) && !empty($msg);
		$form['errorMsg'] = !empty($msg) ? $msg : '';

		return $form;
	}
}
