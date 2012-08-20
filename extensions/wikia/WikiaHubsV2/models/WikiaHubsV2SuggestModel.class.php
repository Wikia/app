<?php
class WikiaHubsV2SuggestModel extends WikiaModel {

	public function getSuggestVideoForm() {
		$form = array(
			'class' => 'WikiaHubs',
			'inputs' => array(
				array(
					'class' => 'videourl',
					'type' => 'text',
					'name' => 'videourl',
					'isRequired' => true,
					'label' => wfMsg('wikiahubs-suggest-video-what-video'),
					'attributes' => array(
						'placeholder' => wfMsg('wikiahubs-suggest-video-what-video-default-value')
					)
				),
				array(
					'class' => 'wikiname',
					'type' => 'text',
					'name' => 'wikiname',
					'isRequired' => true,
					'label' => wfMsg('wikiahubs-suggest-video-which-wiki'),
					'attributes' => array(
						'placeholder' => wfMsg('wikiahubs-suggest-video-which-wiki-default-value')
					)
				),
				array(
					'class' => 'submit-button',
					'type' => 'custom',
					'output' => '<button class="wikia-button secondary cancel" >'.wfMsg('wikiahubs-button-cancel').'</button>'.
						'<button class="wikia-button submit" disabled="disabled" >'.wfMsg('wikiahubs-suggest-video-submit-button').'</button>',
				),
			),
		);

		$form['isInvalid'] = !empty($result) && !empty($msg);
		$form['errorMsg'] = !empty($msg) ? $msg : '';

		return $form;
	}

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
				),
				array(
					'type' => 'custom',
					'isRequired' => true,
					'label' => wfMsg('wikiahubs-suggest-article-reason'),
					'output' => '<label>'.wfMsg('wikiahubs-suggest-article-reason').'</label><textarea name="reason" class="reason"></textarea>',
				),
				array(
					'class' => 'submit-button',
					'type' => 'custom',
					'output' => '<button class="wikia-button secondary cancel" >'.wfMsg('wikiahubs-button-cancel').'</button>'.
						'<button class="wikia-button submit" disabled="disabled" >'.wfMsg('wikiahubs-suggest-article-submit-button').'</button>',
				),
			),
		);

		$form['isInvalid'] = !empty($result) && !empty($msg);
		$form['errorMsg'] = !empty($msg) ? $msg : '';

		return $form;
	}
}
